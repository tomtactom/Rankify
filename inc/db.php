<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/log.php';

function get_db() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO('sqlite:' . DB_FILE);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('CREATE TABLE IF NOT EXISTS results (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                set_path TEXT NOT NULL,
                scores TEXT NOT NULL,
                age INTEGER,
                age_group INTEGER,
                gender TEXT,
                education TEXT,
                skipped INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )');
            // Indexes to speed up normative queries
            $pdo->exec('CREATE INDEX IF NOT EXISTS idx_results_set ON results(set_path)');
            $pdo->exec('CREATE INDEX IF NOT EXISTS idx_results_demo ON results(set_path, age_group, gender, education, skipped)');
            debug_log('Database initialized at '.DB_FILE);
        } catch (Exception $e) {
            debug_log('DB error: '.$e->getMessage());
            throw $e;
        }
    }
    return $pdo;
}

function save_result_db($setPath, $scores, $demo=null, $skipped=false) {
    $pdo = get_db();
    $age = $demo['alter'] ?? null;
    $ageGroup = $age !== null ? (int)(floor($age/10)*10) : null;
    $gender = $demo['geschlecht'] ?? null;
    $edu = $demo['abschluss'] ?? null;
    $stmt = $pdo->prepare('INSERT INTO results (set_path,scores,age,age_group,gender,education,skipped) VALUES (?,?,?,?,?,?,?)');
    $stmt->execute([$setPath, json_encode($scores), $age, $ageGroup, $gender, $edu, $skipped ? 1 : 0]);
    debug_log('Saved result for '.$setPath.' age='.$age.' gender='.$gender.' edu='.$edu.' skipped='.(int)$skipped);
}

function fetch_normative($setPath, $demo=null) {
    $pdo = get_db();
    $where = 'set_path = :set AND skipped=0';
    $params = [':set' => $setPath];
    if ($demo && isset($demo['alter'],$demo['geschlecht'],$demo['abschluss'])) {
        $ageGroup = (int)(floor($demo['alter']/10)*10);
        $where .= ' AND age_group = :ageg AND gender = :gender AND education = :edu';
        $params[':ageg'] = $ageGroup;
        $params[':gender'] = $demo['geschlecht'];
        $params[':edu'] = $demo['abschluss'];
    }
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM results WHERE $where");
    $countStmt->execute($params);
    $count = (int)$countStmt->fetchColumn();
    if ($count < NORM_MIN_COUNT) return null;

    $query = "SELECT key, AVG(value) as avg_score
              FROM results, json_each(scores)
              WHERE $where
              GROUP BY key";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) return null;
    $scores = [];
    foreach ($rows as $row) {
        $scores[$row['key']] = (float)$row['avg_score'];
    }
    arsort($scores);
    return ['scores'=>$scores, 'n'=>$count];
}
