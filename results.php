<?php
$kartensetPfad = $_GET['set'] ?? '';
include 'inc/lang.php';
include 'inc/kartenset_loader.php';
include 'inc/session_handler.php';

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

// Fortschritt laden
$progress = loadProgress($kartensetPfad);
$antworten = $progress['antworten'] ?? [];
if (count($antworten) === 0) {
    header("Location: compare.php?set=" . urlencode($kartensetPfad));
    exit;
}

// JSON-Export
if (isset($_GET['export'])) {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="rankifmy_results.json"');
    echo json_encode([
        'kartenset' => $kartensetPfad,
        'antworten' => $antworten,
        'zeitpunkt' => date('c'),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// Auswertung
$punkte = array_fill_keys($ids, 0);
$vergleichspaare = [];
$seiten = ['links'=>0,'rechts'=>0];
$zeiten = [];
foreach($antworten as $a) {
    // Punktesystem für einfache Wertung (kreativ anpassbar)
    if ($a['bewertung'] <= 2) $punkte[$a['id1']]++;
    if ($a['bewertung'] >= 3) $punkte[$a['id2']]++;
    // Widerspruchspaare sammeln
    $key = $a['id1'].'_'.$a['id2'];
    if (!isset($vergleichspaare[$key])) $vergleichspaare[$key] = [];
    $vergleichspaare[$key][] = $a['bewertung'];
    // Seitenpräferenz
    if (($a['show_left'] === 'normal' && $a['bewertung'] <= 2) || ($a['show_left'] === 'swapped' && $a['bewertung'] >= 3)) $seiten['links']++;
    if (($a['show_left'] === 'normal' && $a['bewertung'] >= 3) || ($a['show_left'] === 'swapped' && $a['bewertung'] <= 2)) $seiten['rechts']++;
    // Antwortzeiten
    if (!empty($a['zeit_ende']) && !empty($a['zeit_start'])) {
        $zeiten[] = ($a['zeit_ende'] - $a['zeit_start']) / 1000;
    }
}

// Konsistenz und Widersprüche
$konsistent = 0; $widerspruechlich = [];
foreach($vergleichspaare as $paar=>$bew) {
    if (count(array_unique($bew)) === 1) $konsistent++;
    else $widerspruechlich[$paar] = $bew;
}
$gesamtpaare = count($vergleichspaare);
$konsistenz_rate = $gesamtpaare ? round(100*$konsistent/$gesamtpaare) : 100;

// Sortierung der Karten nach Punktzahl (und Titel als Tie-Breaker)
arsort($punkte);

// Seitenpräferenz
if ($seiten['links'] > $seiten['rechts']) $seitenBias = t('left_bias') ?? 'Links-Präferenz';
elseif ($seiten['links'] < $seiten['rechts']) $seitenBias = t('right_bias') ?? 'Rechts-Präferenz';
else $seitenBias = false;

// Antwortzeiten
$avg_time = count($zeiten) ? number_format(array_sum($zeiten)/count($zeiten),2) : '–';

?>
<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
    <meta charset="UTF-8">
    <title>Ergebnisse – Rankifmy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { background: linear-gradient(120deg,#e6ecf7 0%,#fafdfe 100%); min-height: 100vh;}
        .lab-summary { background: #fffbe9; border-radius: 1.2em; box-shadow:0 1px 13px rgba(180,180,120,.07); padding: 1.6em 2em; margin: 1.3em auto 1.9em auto; max-width: 740px; font-size: 1.07em;}
        .ranking-list { display: flex; flex-direction: column; align-items: center; margin-top:2.5em; gap: 2.4em;}
        .fancy-rank { width: 100%; max-width: 600px; background: #fcfcfd; border-radius: 2.2em; box-shadow: 0 2px 18px rgba(120,160,200,0.12); padding: 1.7em 2.2em 1.3em 1.4em; margin-bottom: 0; transition: box-shadow 0.19s, transform 0.14s; display: flex; align-items: center; min-height: 90px; position: relative; animation: fadeInUp .4s cubic-bezier(.57,.2,.27,1) both;}
        .fancy-rank:hover { box-shadow: 0 6px 36px rgba(80,140,230,0.13); transform: translateY(-2px) scale(1.013);}
        .avatar-badge { min-width: 72px; min-height: 72px; width: 72px; height: 72px; background: #fff; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 2.1em; font-weight: 800; margin-right: 1.5em; margin-left: .1em; box-shadow: 0 2px 14px rgba(150,180,220,0.17); border: 4px solid #fafdff; position: relative; z-index: 2;}
        .avatar-badge .platz { position: absolute; bottom: 5px; right: 11px; font-size: .68em; color: #fff; opacity: .84; font-weight: 600; background: #4561ff; border-radius: 1.2em; padding: 2px 11px; box-shadow: 0 1px 4px rgba(120,160,200,0.13);}
        .ranking-title { font-size: 1.27em; font-weight: 800; color: #204478; margin-bottom: .2em; letter-spacing: .012em;}
        .ranking-desc { color: #4d6789; font-size: .99em; margin-bottom: .31em; opacity: .88;}
        .score-badge { position: absolute; right: 34px; top: 36px; background: #fff; border-radius: 1.1em; box-shadow: 0 2px 8px rgba(80,100,160,.09); padding: 6px 17px; font-size: 1.18em; font-family: monospace; font-weight: 700; opacity: .96;}
        .progress { height: 12px; background: #eaf4ff; border-radius: 1em; margin-top: 1.0em;}
        .progress-bar { border-radius: 1em; transition: width 1.3s cubic-bezier(.77,0,.18,1.01); font-size: 0; min-width: 7%; box-shadow: 0 1px 6px rgba(120,160,200,0.09);}
        .fancy-rank:nth-child(1) .score-badge, .fancy-rank:nth-child(1) .progress-bar { color:#4f8cff; background:#4f8cff;}
        .fancy-rank:nth-child(2) .score-badge, .fancy-rank:nth-child(2) .progress-bar { color:#78d7f7; background:#78d7f7;}
        .fancy-rank:nth-child(3) .score-badge, .fancy-rank:nth-child(3) .progress-bar { color:#72e0a0; background:#72e0a0;}
        .fancy-rank:nth-child(4) .score-badge, .fancy-rank:nth-child(4) .progress-bar { color:#ffd86a; background:#ffd86a;}
        .fancy-rank:nth-child(5) .score-badge, .fancy-rank:nth-child(5) .progress-bar { color:#ff8b94; background:#ff8b94;}
        .fancy-rank:nth-child(1) { border-left: 8px solid #4f8cff; }
        .fancy-rank:nth-child(2) { border-left: 8px solid #78d7f7; }
        .fancy-rank:nth-child(3) { border-left: 8px solid #72e0a0; }
        .fancy-rank:nth-child(4) { border-left: 8px solid #ffd86a; }
        .fancy-rank:nth-child(5) { border-left: 8px solid #ff8b94; }
        @media (max-width: 850px) {
            .fancy-rank { max-width: 96vw; padding: 1.2em 0.7em;}
            .lab-summary { max-width:98vw;padding:1.2em 0.8em;}
        }
        @media (max-width: 650px) {
            .avatar-badge { width: 44px; height: 44px; font-size: 1.2em; min-width:44px; min-height:44px;}
            .fancy-rank { min-height: unset;}
            .ranking-list { gap: 1.6em;}
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(18px);}
            100% { opacity: 1; transform: none;}
        }
        .conflicts-box { background: #fff6f3; border: 1.5px dashed #e89182; border-radius: .9em; padding: 1.2em; max-width: 600px; margin: 2.4em auto 0 auto; box-shadow: 0 1px 10px rgba(220,140,120,0.03);}
        .conflicts-title { font-weight:700; color:#d05454;}
        .conflict-card { background:#ffe9e6; border-radius:.6em; padding:.7em .8em; margin-bottom:.3em; display:flex;align-items:center;gap:1em;}
        .conflict-card .votes {font-size:0.97em;color:#9e4d36;}
        .conflict-card .info {margin-left:auto;font-size:1.15em;opacity:.7;cursor:help;}
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-3">
    <h1 class="mb-4"><?=t('results_title') ?? 'Ergebnisse'?></h1>

    <div class="lab-summary mb-4">
        <b><?=t('summary')??'Zusammenfassung:'?></b><br>
        Vergleiche insgesamt: <b><?=count($antworten)?></b>
        Konsistenz: <span class="badge <?=($konsistenz_rate>=90?'bg-success':($konsistenz_rate>=80?'bg-warning text-dark':'bg-danger'))?>"><?=$konsistenz_rate?> %</span>
        Seitenpräferenz: <?= $seitenBias ? "<span class='badge bg-warning text-dark'>$seitenBias</span>" : "<span class='badge bg-success'>".(t('no_bias')??'Keine Seitenpräferenz')."</span>"; ?>
        Ø Antwortzeit pro Vergleich: <span class="badge bg-info text-dark"><?=$avg_time?>s</span>
        <div class="d-flex flex-wrap gap-2 mt-2">
            <a href="index.php" class="btn btn-secondary"><?=t('back_to_sets')?></a>
            <a href="results.php?set=<?=urlencode($kartensetPfad)?>&export=1" class="btn btn-outline-secondary">Daten exportieren</a>
            <a href="compare.php?set=<?=urlencode($kartensetPfad)?>&reset=1" class="btn btn-outline-primary ms-2">Set neu starten</a>
        </div>
    </div>

    <div class="ranking-list mb-5">
        <?php
        $platz = 1;
        $maxScore = max($punkte) ?: 1;
        foreach($punkte as $id=>$score):
            $percent = round(($score/$maxScore)*100);
            $emoji = $platz==1?'👑':($platz==2?'🥈':($platz==3?'🥉':'🎲'));
        ?>
        <div class="ranking-card fancy-rank mb-4 p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-badge">
                    <span><?= $emoji ?></span>
                    <div class="platz"><?= $platz ?></div>
                </div>
                <div class="flex-grow-1">
                    <div class="ranking-title"><?=htmlspecialchars($karten[$id]['title'])?></div>
                    <div class="ranking-desc"><?=htmlspecialchars($karten[$id]['subtitle'])?></div>
                    <div class="progress mt-2" style="height:12px;background:#eaf4ff;">
                        <div class="progress-bar" style="width:<?=$percent?>%">
                            <span class="visually-hidden"><?=$percent?>%</span>
                        </div>
                    </div>
                </div>
                <div class="score-badge ms-3"><?=$score?> <span style="font-size:0.9em;opacity:0.7;">Punkte</span></div>
            </div>
        </div>
        <?php $platz++; endforeach; ?>
    </div>

    <?php if(count($widerspruechlich)): ?>
        <div class="conflicts-box mb-5">
            <div class="conflicts-title mb-2"><span style="font-size:1.3em;">⚡</span> Widersprüchliche Paare:</div>
            <?php foreach($widerspruechlich as $paar=>$bewertungen):
                [$id1, $id2] = explode('_', $paar);
            ?>
                <div class="conflict-card mb-2">
                    <b><?=htmlspecialchars($karten[$id1]['title'])?> ↔ <?=htmlspecialchars($karten[$id2]['title'])?></b>
                    <span class="votes">Abstimmungen: <?=implode(', ', $bewertungen)?></span>
                    <span class="info" title="Dieses Paar wurde unterschiedlich beurteilt.">❓</span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
