<?php
$kartensetPfad = $_GET['set'] ?? '';
include 'inc/lang.php';
include 'inc/kartenset_loader.php';
include 'inc/session_handler.php';
include 'inc/vergleichslogik.php';

// Fortschritt laden
$progress = loadProgress($kartensetPfad);
$antworten = isset($progress['antworten']) && is_array($progress['antworten']) ? $progress['antworten'] : [];
$paare = isset($progress['paare']) && is_array($progress['paare']) ? $progress['paare'] : null;

// Wenn keine Antworten und noch Paare übrig, zum Vergleich zurück
if ((empty($antworten) && is_array($paare) && count($paare) > 0) || $paare === null) {
    header("Location: compare.php?set=" . urlencode($kartensetPfad));
    exit;
}

// Karten laden
if (!$kartensetPfad || !file_exists('data/'.$kartensetPfad)) {
    header("Location: index.php?error=no_set");
    exit;
}
$daten = array_map(function($line){ return str_getcsv($line, ';'); }, file('data/'.$kartensetPfad));
$kopf = array_shift($daten);
$karten = [];
foreach($daten as $zeile) {
    if (count($zeile) < 3) continue;
    $karten[$zeile[0]] = ['id'=>$zeile[0],'title'=>$zeile[1],'subtitle'=>$zeile[2]];
}
$ids = array_keys($karten);

if (count($ids) < 2) {
    ?>
    <!DOCTYPE html>
    <html lang="<?=getLanguage()?>">
    <head>
        <meta charset="UTF-8">
        <title><?=t('error_not_found')?> – Rankifmy</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    </head>
    <body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="alert alert-warning mt-5">
            <?=t('error_no_set')?> (<?=t('error_too_few_cards') ?? "Zu wenig Karten im Set."?>) <br>
            <a href="index.php" class="btn btn-secondary mt-3"><?=t('back_to_sets')?></a>
        </div>
    </div>
    </body>
    </html>
    <?php
    exit;
}

// Score-Berechnung: Einfache Punktewertung
// (Erweitern für andere Modelle nach Bedarf)
$scores = array_fill_keys($ids, 0);
foreach($antworten as $a) {
    // 1: links viel wichtiger; 2: links etwas wichtiger; 3: rechts etwas wichtiger; 4: rechts viel wichtiger
    if ($a['bewertung'] == 1)      $scores[$a['id1']] += 2;
    elseif ($a['bewertung'] == 2)  $scores[$a['id1']] += 1;
    elseif ($a['bewertung'] == 3)  $scores[$a['id2']] += 1;
    elseif ($a['bewertung'] == 4)  $scores[$a['id2']] += 2;
}
arsort($scores);

// Für Balkenlänge
$maxScore = max($scores);

// Kleine Figuren (Gamification), du kannst PNGs nutzen!
$figuren = [
    0 => "🦁", // Erster Platz
    1 => "🦉",
    2 => "🐧",
    3 => "🐢",
    4 => "🐱",
    5 => "🦊",
    6 => "🐼"
];
function getFigur($rank) {
    global $figuren;
    return $figuren[$rank] ?? "🎲";
}

?>
<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
    <meta charset="UTF-8">
    <title><?=t('results')?> – Rankifmy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body { background: linear-gradient(130deg,#fafdfe 0%,#e5f4fb 100%); min-height: 100vh;}
        .results-hero { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2.5rem;}
        .results-hero-logo { width: 62px; height: 62px; border-radius: 14px; background: #fff; display: flex; align-items: center; justify-content: center; font-size: 2.1rem; font-weight: bold; color: #20bfa9; box-shadow: 0 2px 10px rgba(60,170,200,0.09); border: 2px solid #e0faf7;}
        .results-hero-title { font-size: 1.6rem; font-weight: 900; color: #175a66; margin-bottom: .4rem;}
        .results-hero-text { color: #25727e; font-size: 1.12rem;}
        .rank-card { border-radius: 1.2rem; box-shadow: 0 2px 14px rgba(60,140,90,0.08); background: #fff; margin-bottom: 1.2rem;}
        .rank-medal { font-size:2.1rem; padding-right:1.1rem; display:inline-block; vertical-align:middle;}
        .rank-bar { min-width:40px; height: 30px; border-radius: 2rem; background: linear-gradient(90deg,#28d7ae 0%,#8ed9f9 90%); transition: width .3s;}
        .rank-score { font-size:1.15rem; color:#319497; font-weight:700; padding-left:1.4rem;}
        .rank-title { font-size:1.12rem; font-weight:800; color:#124154;}
        .rank-subtitle { font-size:1.01rem; color:#407183;}
        .results-btns { margin-top:2.5rem; display:flex; gap:1rem; flex-wrap:wrap;}
        .reset-btn {background:#eb485b;color:#fff;}
        .reset-btn:hover {background:#ce3442;color:#fff;}
        @media (max-width: 700px) {
            .results-hero { flex-direction:column; gap:.8rem;}
            .results-hero-logo { width:40px;height:40px; font-size:1.3rem;}
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-3">

    <!-- Hero-Section -->
    <div class="results-hero">
        <div class="results-hero-logo" aria-label="Logo">R</div>
        <div>
            <div class="results-hero-title"><?=t('results') ?? "Dein Ergebnis"?></div>
            <div class="results-hero-text"><?=t('results_subtitle') ?? "Deine individuelle Rangfolge aus deinen Vergleichen."?></div>
        </div>
    </div>

    <!-- RANGLISTE -->
    <div class="mb-5">
    <?php
    $rank = 0;
    foreach ($scores as $id => $score):
        $karte = $karten[$id];
        $barWidth = $maxScore > 0 ? (round($score / $maxScore * 100)) : 0;
        ?>
        <div class="rank-card p-3 d-flex align-items-center">
            <span class="rank-medal"><?=getFigur($rank)?></span>
            <div class="flex-grow-1">
                <div class="rank-title"><?=htmlspecialchars($karte['title'])?></div>
                <div class="rank-subtitle"><?=htmlspecialchars($karte['subtitle'])?></div>
                <div class="rank-bar mt-2 mb-2" style="width:<?=$barWidth?>%"></div>
            </div>
            <span class="rank-score"><?=$score?></span>
        </div>
    <?php $rank++; endforeach; ?>
    </div>

    <!-- BUTTONS -->
    <div class="results-btns">
        <a href="compare.php?set=<?=urlencode($kartensetPfad)?>&reset=1" class="btn reset-btn"><?=t('restart_set') ?? "Set neustarten"?></a>
        <a href="index.php" class="btn btn-secondary"><?=t('back_to_sets')?></a>
        <a href="results.php?set=<?=urlencode($kartensetPfad)?>&export_json=1" class="btn btn-info"><?=t('export_results') ?? "Ergebnisse exportieren"?></a>
    </div>
</div>
</body>
</html>
<?php
// Export-Funktionalität (JSON)
if (isset($_GET['export_json'])) {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="rankifmy_results.json"');
    echo json_encode([
        'kartenset' => $kartensetPfad,
        'scores' => $scores,
        'antworten' => $antworten,
        'zeitpunkt' => date('c'),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}
?>
