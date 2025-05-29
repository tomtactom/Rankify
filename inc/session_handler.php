<?php
function getSessionKey($kartenset) {
    return "rkf_".md5($kartenset);
}

function loadProgress($kartenset) {
    $key = getSessionKey($kartenset);
    if (!empty($_COOKIE[$key])) {
        $data = json_decode($_COOKIE[$key], true);
        return is_array($data) ? $data : [];
    }
    return [];
}

function saveProgress($kartenset, $data) {
    $key = getSessionKey($kartenset);
    setcookie($key, json_encode($data), time() + 365*24*60*60, "/");
}
?>
