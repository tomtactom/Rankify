<?php
function getLanguage() {
    // Sprache aus GET, dann Cookie, sonst Standard
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        setcookie('rkf_lang', $lang, time()+365*24*60*60, '/');
    } elseif (isset($_COOKIE['rkf_lang'])) {
        $lang = $_COOKIE['rkf_lang'];
    } else {
        $lang = 'de';
    }
    return in_array($lang, ['de','en']) ? $lang : 'de';
}

function t($key) {
    static $dict = null;
    if ($dict === null) {
        $lang = getLanguage();
        $file = "assets/lang/$lang.json";
        if (file_exists($file)) {
            $dict = json_decode(file_get_contents($file), true);
        } else {
            $dict = [];
        }
    }
    return $dict[$key] ?? $key;
}
?>
