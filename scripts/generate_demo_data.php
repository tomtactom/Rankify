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

    // Determine whether we can flush the request using fastcgi_finish_request
    $hasFastcgiFinish = function_exists('fastcgi_finish_request');

    header('Content-Type: text/plain; charset=utf-8');
    if (!$hasFastcgiFinish) {
        // Ensure the connection is closed before spawning the background process
        header('Connection: close');
    }

    echo "Starting demo data generation. This may take a while...\n";
    if (function_exists('ob_implicit_flush')) {
        ob_implicit_flush(true);
    }

    // finish the HTTP request so the browser doesn't time out
    if ($hasFastcgiFinish) {
        debug_log('Calling fastcgi_finish_request');
        fastcgi_finish_request();
    } else {
        // If the function is unavailable (e.g. on shared hosting), run the
        // script again via CLI in the background so the HTTP request can finish
        $cmd = 'php '.escapeshellarg(__FILE__).' cli > /dev/null 2>&1 &';
        debug_log('fastcgi_finish_request not available, launching background process: '.$cmd);
        pclose(popen($cmd, 'r'));
        flush();
        exit;
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
                    // Ensure the stored path matches the format used by the
                    // application when saving real user results. Use realpath
                    // to normalize the file path before stripping the data
                    // directory prefix.
                    $dataRoot = realpath(__DIR__.'/../data');
                    $relPath = str_replace($dataRoot.'/', '', realpath($set['path']));
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
