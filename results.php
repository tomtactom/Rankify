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

// Score-Berechnung (Punktewertung)
$scores = array_fill_keys($ids, 0);
foreach($antworten as $a) {
    if ($a['bewertung'] == 1)      $scores[$a['id1']] += 2;
    elseif ($a['bewertung'] == 2)  $scores[$a['id1']] += 1;
    elseif ($a['bewertung'] == 3)  $scores[$a['id2']] += 1;
    elseif ($a['bewertung'] == 4)  $scores[$a['id2']] += 2;
}
arsort($scores);
$maxScore = max($scores);

// Figuren
$figuren = [0=>"🦁", 1=>"🦉", 2=>"🐧", 3=>"🐢", 4=>"🐱", 5=>"🦊", 6=>"🐼"];
function getFigur($rank) { global $figuren; return $figuren[$rank] ?? "🎲"; }

// Meta-Auswertung (Konsistenz etc.)
$totalVergleiche = count($antworten);
$gesamtPaare = count(alleVergleichspaare($ids, 2));
$konsistenz = 0;
$konsistenz_paare = 0;
$konflikte = [];

// Konsistenz: Prüfe, ob Paare widersprüchlich bewertet wurden
$pairVotes = [];
foreach($antworten as $a) {
    $pair = [$a['id1'],$a['id2']];
    sort($pair);
    $key = implode("_",$pair);
    $pairVotes[$key][] = $a['bewertung'];
}
foreach($pairVotes as $key => $votes) {
    if (count($votes) > 1) {
        $counts = array_count_values($votes);
        if (count($counts) > 1) {
            $konflikte[$key] = $counts;
        } else {
            $konsistenz_paare++;
        }
    } else {
        $konsistenz_paare++;
    }
}
$konsistenz = $gesamtPaare > 0 ? round(100 * $konsistenz_paare / $gesamtPaare) : 100;

// Antwortzeit (sofern getrackt)
$zeiten = array_filter(array_map(function($a){
    if (isset($a['zeit_start']) && isset($a['zeit_ende']) && $a['zeit_ende'] > $a['zeit_start']) {
        return ($a['zeit_ende'] - $a['zeit_start'])/1000;
    }
    return null;
}, $antworten));
$avgTime = count($zeiten) > 0 ? round(array_sum($zeiten)/count($zeiten),2) : null;

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
        .summary-box { background:#fff9e6; border-radius: 1.2rem; padding: 1.3rem 1.2rem; margin-bottom: 2.2rem; font-size:1.08em; box-shadow: 0 2px 10px rgba(240,190,80,0.04);}
        .summary-box b { font-size:1.14em;}
        .rank-card { border-radius: 1.2rem; box-shadow: 0 2px 14px rgba(60,140,90,0.08); background: #fff; margin-bottom: 1.2rem; display:flex; align-items:center; gap:1rem;}
        .rank-medal { font-size:2.1rem; margin-right:1.1rem; display:flex; align-items:center;}
        .rank-info { flex-grow:1; min-width:0;}
        .rank-title { font-size:1.12rem; font-weight:800; color:#124154;}
        .rank-subtitle { font-size:1.01rem; color:#407183;}
        .rank-bar-bg {width:100%;background:#e9f4fa;height:24px; border-radius:1.5em; position:relative;}
        .rank-bar { position:absolute; left:0; top:0; height:100%; border-radius:1.5em; background: linear-gradient(90deg,#28d7ae 0%,#82d9f7 100%);}
        .rank-score { font-size:1.13rem; color:#319497; font-weight:700; min-width: 28px; text-align: right;}
        .results-btns { margin-top:2.5rem; display:flex; gap:1rem; flex-wrap:wrap;}
        .reset-btn {background:#eb485b;color:#fff;}
        .reset-btn:hover {background:#ce3442;color:#fff;}
        .conflict-box { background: #ffeae6; border:1px dashed #fd9b89; border-radius:1.1em; padding:1em; margin-top:2.5em;}
        .conflict-title { font-weight:bold; color:#ce3442;}
        .conflict-pair { margin-bottom:.7em;}
        @media (max-width: 700px) {
            .results-hero { flex-direction:column; gap:.8rem;}
            .results-hero-logo { width:40px;height:40px; font-size:1.3rem;}
            .rank-medal {font-size:1.4rem; margin-right:.6rem;}
            .summary-box { font-size:1em;}
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-3">

    <!-- Zusammenfassung oben -->
    <div class="summary-box">
        <b><?=t('summary') ?? "Zusammenfassung"?>:</b><br>
        <?=t('total_comparisons') ?? "Vergleiche insgesamt"?>: <b><?=$totalVergleiche?></b>
        &nbsp; | &nbsp;<?=t('consistency')?>: <span style="background:#ffd55b;padding:0 .4em;border-radius:.3em;"><?=$konsistenz?> %</span>
        &nbsp; | &nbsp;<?=t('avg_time')?>: <span style="background:#b7e5f6;padding:0 .4em;border-radius:.3em;"><?=($avgTime !== null ? $avgTime."s" : "-")?></span>
    </div>

    <!-- Hero-Section -->
    <div class="results-hero">
        <div class="results-hero-logo" aria-label="Logo">R</div>
        <div>
            <div class="results-hero-title"><?=t('results') ?: "Ergebnisse"?></div>
            <div class="results-hero-text"><?=t('results_subtitle') ?: "Deine individuelle Rangfolge aus deinen Vergleichen."?></div>
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
        <div class="rank-card">
            <span class="rank-medal"><?=getFigur($rank)?></span>
            <div class="rank-info">
                <div class="rank-title"><?=htmlspecialchars($karte['title'])?></div>
                <div class="rank-subtitle"><?=htmlspecialchars($karte['subtitle'])?></div>
                <div class="rank-bar-bg mt-2 mb-2">
                    <div class="rank-bar" style="width:<?=$barWidth?>%; background:linear-gradient(90deg,#28d7ae 0%,#82d9f7 100%)"></div>
                </div>
            </div>
            <span class="rank-score"><?=$score?></span>
        </div>
    <?php $rank++; endforeach; ?>
    </div>

    <!-- BUTTONS -->
    <div class="results-btns">
        <a href="compare.php?set=<?=urlencode($kartensetPfad)?>&reset=1" class="btn reset-btn"><?=t('restart_set') ?: "Set neustarten"?></a>
        <a href="index.php" class="btn btn-secondary"><?=t('back_to_sets') ?: "Zurück zur Übersicht"?></a>
        <a href="results.php?set=<?=urlencode($kartensetPfad)?>&export_json=1" class="btn btn-info"><?=t('export_results') ?: "Ergebnisse exportieren"?></a>
    </div>

    <!-- KONFLIKTE -->
    <?php if(count($konflikte) > 0): ?>
    <div class="conflict-box mt-5">
        <div class="conflict-title">Widersprüchliche Paare:</div>
        <?php foreach($konflikte as $key => $counts):
            $parts = explode('_',$key);
            $n1 = $karten[$parts[0]]['title'] ?? $parts[0];
            $n2 = $karten[$parts[1]]['title'] ?? $parts[1];
            ?>
            <div class="conflict-pair">
                <b><?=htmlspecialchars($n1)?> ↔ <?=htmlspecialchars($n2)?></b>
                &nbsp; Abstimmungen:
                <?php foreach($counts as $wert=>$anz): ?>
                    <span><?=htmlspecialchars($wert)?> × <?=htmlspecialchars($anz)?></span>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

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
