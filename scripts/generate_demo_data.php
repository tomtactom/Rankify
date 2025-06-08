<?php
// Only run from the command line to avoid web timeouts
if (php_sapi_name() !== 'cli') {
    header('HTTP/1.1 403 Forbidden');
    echo "This script must be executed from the command line.";
    exit;
}

require_once __DIR__.'/../inc/db.php';
require_once __DIR__.'/../inc/kartenset_loader.php';

$sets = getKartensets(__DIR__ . '/../data');
$pdo = get_db();
$pdo->beginTransaction();

// Demographic categories used for generating example norms
$genders = ['w', 'm', 'd'];
$educations = ['kein','hs','re','abi','beruf','stud','phd','sonst'];
$ageGroups = [10,20,30,40,50,60];

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
    foreach ($ageGroups as $ageGroup) {
        foreach ($genders as $gender) {
            foreach ($educations as $edu) {
                for ($i = 0; $i < NORM_MIN_COUNT; $i++) {
                    $scores = [];
                    foreach ($ids as $id) {
                        $scores[$id] = mt_rand(1, 100);
                    }
                    $demo = [
                        'alter' => $ageGroup + mt_rand(0, 9),
                        'geschlecht' => $gender,
                        'abschluss' => $edu
                    ];
                    save_result_db($set['path'], $scores, $demo, false);
                }
            }
        }
    }
}

$pdo->commit();
echo "Demo data generated in " . DB_FILE . "\n";
