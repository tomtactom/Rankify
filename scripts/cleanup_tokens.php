<?php
require_once __DIR__.'/../inc/config.php';
$dir = __DIR__.'/../data/contact';
$ttl = 24*3600; // 1 day
if (!is_dir($dir)) exit;
foreach (glob($dir.'/*.json') as $file) {
    $data = json_decode(@file_get_contents($file), true);
    $time = $data['time'] ?? filemtime($file);
    if (time() - $time > $ttl) {
        @unlink($file);
    }
}
