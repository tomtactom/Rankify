<?php
$kartensetPfad = $_GET['set'] ?? '';
include 'inc/lang.php';
include 'inc/kartenset_loader.php';
include 'inc/session_handler.php';
include 'inc/vergleichslogik.php';

// Kartenset laden
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

// Session laden
$progress = loadProgress($kartensetPfad);
$antworten = $progress['antworten'] ?? [];

// Statistiken und Konsistenzanalyse
$totalVergleiche = count($antworten);
$konsistenzPaare = [];
$seitenPräferenz = ['normal'=>0, 'swapped'=>0];
$antwortzeiten = [];

// Konsistenz/Mehrfachpaare prüfen
foreach($antworten as $antw) {
    $key = $antw['id1'].'_'.$antw['id2'];
    if (!isset($konsistenzPaare[$key])) $konsistenzPaare[$key] = [];
    $konsistenzPaare[$key][] = $antw['bewertung'];
    $seitenPräferenz[$antw['show_left']] = ($seitenPräferenz[$antw['show_left']] ?? 0) + 1;
    if (isset($antw['zeit_start'], $antw['zeit_ende']) && $antw['zeit_ende'] > $antw['zeit_start'])
        $antwortzeiten[] = $antw['zeit_ende'] - $antw['zeit_start'];
}
// Konsistenzrate berechnen
$konsistent = 0;
$paare_gesamt = 0;
$widerspruechlich = [];
foreach ($konsistenzPaare as $paar => $bewertungen) {
    $paare_gesamt++;
    if (count(array_unique($bewertungen)) === 1) {
        $konsistent++;
    } else {
        $widerspruechlich[$paar] = $bewertungen;
    }
}
$konsistenz_rate = $paare_gesamt ? round(100 * $konsistent / $paare_gesamt) : 100;

// Bias: Seitenpräferenz
$seitenBias = '';
if (($seitenPräferenz['normal']+$seitenPräferenz['swapped']) > 0) {
    $rel_normal = round(100 * $seitenPräferenz['normal'] / ($seitenPräferenz['normal']+$seitenPräferenz['swapped']));
    $rel_swapped = 100 - $rel_normal;
    $seitenBias = ($rel_normal > 60) ? t('bias_left') : (($rel_swapped > 60) ? t('bias_right') : '');
}

// Punktewertung: Jeder "Sieg" zählt (Likert 1,2: links gewinnt, 3,4: rechts gewinnt)
$punkte = array_fill_keys($ids, 0);
foreach($antworten as $antw) {
    if ($antw['bewertung'] == 1 || $antw['bewertung'] == 2)
        $punkte[$antw['id1']]++;
    elseif ($antw['bewertung'] == 3 || $antw['bewertung'] == 4)
        $punkte[$antw['id2']]++;
}
// Ranking
arsort($punkte);

// Durchschnittliche Antwortzeit
$avg_time = $antwortzeiten ? round(array_sum($antwortzeiten)/count($antwortzeiten)/1000,2) : null;

?>
<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
    <meta charset="UTF-8">
    <title>Rankifmy – <?=t('results')?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { background: linear-gradient(120deg,#e6ecf7 0%,#fafdfe 100%); min-height: 100vh;}
<<<<<<< HEAD
        .lab-summary { background: #fffbe9; border-radius: 1em; box-shadow:0 1px 10px rgba(180,180,120,.07); padding:1.5em; }
        .ranking-list { margin-top:2em; }
        .fancy-rank { background:linear-gradient(90deg,#f8f9fe 0,#fafdff 100%); border-radius:1.1em; box-shadow:0 2px 14px rgba(120,160,200,0.09);}
        .avatar-badge { border-radius:50%; width:60px;height:60px;display:flex;flex-direction:column;align-items:center;justify-content:center; font-size:1.6em; font-weight:800; box-shadow:0 2px 9px rgba(120,160,200,.11); position:relative;}
        .avatar-badge .platz { position:absolute;bottom:4px;right:7px;font-size:0.7em;color:#fff;opacity:.88; }
        .ranking-title { font-size:1.2em;font-weight:700;color:#22407c; }
        .ranking-desc { color:#4d6789;font-size:.99em; }
        .score-badge { font-size:1.23em;min-width:68px;text-align:right;font-family:monospace;}
        .conflicts-box { background:#fff6f3;border:1.5px dashed #e89182;border-radius:.9em;padding:1.2em; }
        .conflicts-title { font-weight:700; color:#d05454;}
        .conflict-card { background:#ffe9e6; border-radius:.6em; padding:.7em .8em; margin-bottom:.3em; display:flex;align-items:center;gap:1em;}
        .conflict-card .votes {font-size:0.97em;color:#9e4d36;}
        .conflict-card .info {margin-left:auto;font-size:1.15em;opacity:.7;cursor:help;}
        @media (max-width:650px){
            .avatar-badge { width:44px;height:44px;font-size:1em;}
            .lab-summary { padding:0.7em; }
        }
=======
        .ranking-card { border-radius: 1rem; box-shadow: 0 2px 10px rgba(70,90,130,0.07); background: #fff; margin-bottom:1.5rem;}
        .ranking-title { font-weight: bold; color: #2b3472;}
        .ranking-badge { background:#6281e3;color:#fff; border-radius:1rem;padding:.3em 1em;font-weight:bold;font-size:1.2em;}
        .statblock {background:#fffde3;padding:1em;border-radius:.8em;}
        .widerspruch {background:#fbeee8;padding:.7em;border-radius:.7em;border:1px dashed #ebac7c;}
>>>>>>> parent of 360ffdf (Update results.php)
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-3">

    <h2 class="mb-4"><?=t('results')?></h2>

    <div class="statblock mb-4">
        <b><?=t('summary')??'Zusammenfassung'?>:</b><br>
        <?=t('total_pairs')?>: <b><?=count($antworten)?></b> <br>
        <?=t('consistency')?>: <b><?=$konsistenz_rate?> %</b> (<?=$konsistent?>/<?=$paare_gesamt?> <?=t('consistent_pairs')?>)
        <?php if($konsistenz_rate < 80): ?>
            <span class="text-danger">&nbsp;<?=t('consistency_warning')??'Viele widersprüchliche Urteile.'?></span>
        <?php endif; ?>
        <br>
        <?=t('bias')?>: <?php
            if($seitenBias) echo "<span class='text-warning'>$seitenBias</span>";
            else echo "<span class='text-success'>".(t('no_bias')??'Keine Seitenpräferenz.')."</span>";
        ?><br>
        <?=t('avg_time')?>: <?= $avg_time ? $avg_time.'s' : '-' ?>
        <br>
        <a href="compare.php?set=<?=urlencode($kartensetPfad)?>&export_json=1" class="btn btn-sm btn-outline-secondary mt-2"><?=t('export_data')??'Export (JSON)'?></a>
        <a href="index.php" class="btn btn-sm btn-secondary mt-2"><?=t('back_to_sets')?></a>
    </div>

    <h3><?=t('final_ranking')??'Deine Rangfolge'?></h3>
    <?php $platz = 1; foreach($punkte as $id=>$score): ?>
        <div class="ranking-card p-3 mb-3">
            <div class="d-flex align-items-center gap-3">
                <div class="ranking-badge"><?=$platz++?></div>
                <div>
                    <div class="ranking-title"><?=htmlspecialchars($karten[$id]['title'])?></div>
                    <div><?=htmlspecialchars($karten[$id]['subtitle'])?></div>
                    <div class="small"><?=t('points')?>: <b><?=$score?></b></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if(count($widerspruechlich)): ?>
        <div class="mt-4">
            <h5><?=t('inconsistent_pairs')??'Widersprüchliche Paare'?>:</h5>
            <?php foreach($widerspruechlich as $paar=>$bewertungen):
                [$id1, $id2] = explode('_', $paar);
            ?>
                <div class="widerspruch mb-2">
                    <b><?=htmlspecialchars($karten[$id1]['title'])?> ↔ <?=htmlspecialchars($karten[$id2]['title'])?></b>
                    <br>
                    <?=t('votes')?>: <?=implode(', ', $bewertungen)?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
</body>
</html>
