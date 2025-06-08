<?php
require_once __DIR__.'/../inc/db.php';
require_once __DIR__.'/../inc/kartenset_loader.php';
require_once __DIR__.'/../inc/log.php';
debug_log('generate_demo_data.php called via '.PHP_SAPI);

// Allow the script to run via web server without timing out
if (PHP_SAPI !== 'cli') {
    // keep running even if the client disconnects
    if (function_exists('ignore_user_abort')) {
        ignore_user_abort(true);
    }
    if (function_exists('set_time_limit')) {
        set_time_limit(0);
    }
    header('Content-Type: text/plain; charset=utf-8');
    echo "Starting demo data generation. This may take a while...\n";
    if (function_exists('ob_implicit_flush')) {
        ob_implicit_flush(true);
    }
    // finish the HTTP request so the browser doesn't time out
    if (function_exists('fastcgi_finish_request')) {
        debug_log('Calling fastcgi_finish_request');
        fastcgi_finish_request();
    } else {
        debug_log('fastcgi_finish_request not available, flushing output');
        flush();
    }
}

$sets = getKartensets(__DIR__ . '/../data');
debug_log('Found '.count($sets).' sets');

// Demographic categories used for generating example norms
$genders = ['w', 'm', 'd'];
$educations = ['kein','hs','re','abi','beruf','stud','phd','sonst'];
$ageGroups = [10,20,30,40,50,60];

foreach ($sets as $set) {
    $file = $set['path'];
    if (!file_exists($file)) continue;
    echo "Generating data for {$set['filename']}...\n";
    debug_log('Generating demo data for '.$set['filename']);
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
                    $dataRoot = realpath(__DIR__.'/../data');
                    $relPath = str_replace($dataRoot.'/', '', $set['path']);
                    save_result_db($relPath, $scores, $demo, false);
                }
            }
        }
    }
    echo "done\n";
    if (PHP_SAPI !== 'cli') {
        flush();
    }
    debug_log('Finished set '.$set['filename']);
}

echo "Demo data generated in " . DB_FILE . "\n";
debug_log('Demo data generation finished');
if (PHP_SAPI !== 'cli') {
    error_log('[Rankify] Demo data generation finished at '.date('c'));
}
