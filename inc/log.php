<?php
require_once __DIR__.'/config.php';

function debug_log($msg) {
    $dir = dirname(DEBUG_LOG_FILE);
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    if (is_array($msg) || is_object($msg)) {
        $msg = print_r($msg, true);
    }
    $line = '['.date('c').'] '.trim($msg)."\n";
    @file_put_contents(DEBUG_LOG_FILE, $line, FILE_APPEND);
}
?>
