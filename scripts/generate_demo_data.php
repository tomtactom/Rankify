<?php
require_once __DIR__.'/../inc/db.php';
require_once __DIR__.'/../inc/kartenset_loader.php';

$sets = getKartensets(__DIR__ . '/../data');

foreach ($sets as $set) {
    $file = $set['path'];
    if (!file_exists($file)) continue;
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    array_shift($lines); // header
    $ids = [];
    foreach ($lines as $line) {
        $parts = str_getcsv($line, ';');
        if (count($parts) >= 3) $ids[] = $parts[0];
    }
    for ($i = 0; $i < NORM_MIN_COUNT; $i++) {
        $scores = [];
        foreach ($ids as $id) {
            $scores[$id] = mt_rand(1, 100);
        }
        $demo = [
            'alter' => mt_rand(18, 60),
            'geschlecht' => (mt_rand(0,1) ? 'm' : 'w'),
            'abschluss' => 'Bachelor'
        ];
        save_result_db($set['path'], $scores, $demo, false);
    }
}

echo "Demo data generated in " . DB_FILE . "\n";
