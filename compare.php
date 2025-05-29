<?php
// ------- PARAMETER ---------
$WIEDERHOLUNGEN = 2; // Anzahl Wiederholungen pro Paarvergleich
$INSTRUKTIONS_TEXT = "Hier siehst du jeweils zwei Karten im Vergleich. Wähle pro Paar, was für dich wichtiger ist! Jedes Paar wird mehrfach angezeigt – manchmal in unterschiedlicher Reihenfolge.";
// ------- ENDE PARAMETER ----

$kartensetPfad = $_GET['set'] ?? '';
include 'inc/lang.php';
include 'inc/kartenset_loader.php';
include 'inc/session_handler.php';
include 'inc/vergleichslogik.php';

// ---------- Hilfsfunktion ----------
function now_millis() {
    return round(microtime(true) * 1000);
}

// ---------- Kartenset laden ----------
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

// ---------- Tiefenprüfung: Mindestens zwei Karten nötig! ----------
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

// ---------- Progress Reset bei "Neustart" (immer bei neuem Set-Aufruf) ----------
if (isset($_GET['reset'])) {
    resetProgress($kartensetPfad);
    // Um Weiterleitung zu erzwingen (ohne reset-Param):
    header("Location: compare.php?set=".urlencode($kartensetPfad));
    exit;
}

// ---------- Progress laden/initialisieren ----------
$progress = loadProgress($kartensetPfad);
// Automatisch zurücksetzen, wenn keine Paare mehr zu vergleichen sind (also: Set abgeschlossen):
if (
    (isset($progress['antworten']) && isset($progress['paare']))
    && count($progress['paare']) === 0
    && count($progress['antworten']) > 0
) {
    resetProgress($kartensetPfad);
    $progress = loadProgress($kartensetPfad);
}

$paare = $progress['paare'] ?? alleVergleichspaare($ids, $WIEDERHOLUNGEN);
$antworten = $progress['antworten'] ?? [];
$instruktion_gelesen = $progress['instruktion_gelesen'] ?? false;

// Falls Progress gar nicht initialisiert war (neu!), setze Paare initial:
if (!isset($progress['paare']) || !is_array($progress['paare']) || count($progress['paare']) === 0) {
    $paare = alleVergleichspaare($ids, $WIEDERHOLUNGEN);
    $progress['paare'] = $paare;
    $progress['antworten'] = [];
    $progress['instruktion_gelesen'] = false;
    saveProgress($kartensetPfad, $progress);
    $antworten = [];
    $instruktion_gelesen = false;
}

// ---------- Session-Export (JSON) ----------
if (isset($_GET['export_json'])) {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="rankifmy_session.json"');
    echo json_encode([
        'kartenset' => $kartensetPfad,
        'antworten' => $antworten,
        'paare' => $paare,
        'zeitpunkt' => date('c'),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// ---------- Antwortverarbeitung ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['instruktion_gelesen'])) {
        // Instruktion bestätigt
        $progress['instruktion_gelesen'] = true;
        saveProgress($kartensetPfad, $progress);
        header("Location: compare.php?set=".urlencode($kartensetPfad));
        exit;
    } elseif (isset($_POST['id1'], $_POST['id2'], $_POST['bewertung'], $_POST['show_left'], $_POST['zeit_start'])) {
        $antworten[] = [
            'id1' => $_POST['id1'],
            'id2' => $_POST['id2'],
            'bewertung' => (int)$_POST['bewertung'],
            'show_left' => $_POST['show_left'],
            'zeit_start' => intval($_POST['zeit_start']),
            'zeit_ende' => now_millis(),
        ];
        array_shift($paare);
        $progress['paare'] = $paare;
        $progress['antworten'] = $antworten;
        saveProgress($kartensetPfad, $progress);
        header("Location: compare.php?set=".urlencode($kartensetPfad));
        exit;
    }
}

// ---------- Fortschritt ----------
$gesamt = count(alleVergleichspaare($ids, $WIEDERHOLUNGEN));
$fortschritt = $gesamt ? (100 * (count($antworten) / $gesamt)) : 0;
?>
<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
    <meta charset="UTF-8">
    <title>Rankifmy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { background: linear-gradient(120deg,#e6ecf7 0%,#fafdfe 100%); min-height: 100vh;}
        .progress { background: #e5e9f3; border-radius: 1rem; box-shadow: 0 2px 8px rgba(110,130,160,0.06);}
        .progress-bar { font-size: 1.11rem; font-weight: bold; background: linear-gradient(90deg,#6281e3 60%,#82c0ff 100%);}
        .compare-hero { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2.5rem;}
        .compare-hero-logo { width: 58px; height: 58px; border-radius: 14px; background: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: bold; color: #6281e3; box-shadow: 0 2px 10px rgba(80,110,200,0.09); border: 2px solid #e4eefe;}
        .compare-hero-title { font-size: 1.45rem; font-weight: 800; color: #294288; margin-bottom: .4rem;}
        .compare-hero-text { color: #4d68a5; font-size: 1.1rem;}
        .card-compare { border-radius: 1.2rem; box-shadow: 0 2px 14px rgba(60,90,140,0.08); background: #fff;}
        .btn-group-lg>.btn, .btn-lg { padding: 1rem 1.1rem; font-size: 1.1rem;}
        .btn-outline-primary:focus, .btn-outline-primary.focus { box-shadow: 0 0 0 .2rem #a5c2fa;}
        .vs-badge { font-size: 1.2rem; background: #b8cdfc; color: #2951a7; border-radius: 50%; padding: .7rem 1.2rem;}
        @media (max-width: 768px) { .compare-hero { gap: 0.7rem; flex-direction: column; } .compare-hero-logo { width: 46px; height: 46px; font-size: 1.15rem; } .card-compare { margin-bottom: 1.5rem; } }
    </style>
    <script>
        let zeit_start;
        window.onload = function() {
            zeit_start = Date.now();
            var inp = document.getElementById("zeit_start");
            if(inp) inp.value = zeit_start;
        };
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-3">

    <!-- Hero Section -->
    <div class="compare-hero">
        <div class="compare-hero-logo" aria-label="Logo">R</div>
        <div>
            <div class="compare-hero-title"><?=t('progress')?>: <?=round($fortschritt)?>%</div>
            <div class="compare-hero-text"><?=t('comparison_question')?></div>
        </div>
    </div>

    <!-- Fortschritt -->
    <div class="mb-4">
        <div class="progress" style="height:1.6rem;">
            <div class="progress-bar" role="progressbar" style="width: <?=round($fortschritt)?>%;" aria-valuenow="<?=round($fortschritt)?>" aria-valuemin="0" aria-valuemax="100">
                <?=round($fortschritt)?>%
            </div>
        </div>
    </div>

    <!-- Instruktionsphase -->
    <?php if (!$instruktion_gelesen): ?>
        <form method="post">
            <div class="alert alert-info" style="font-size:1.15em;">
                <b><?=t('instructions_title') ?? "Instruktionen"?></b><br>
                <?=t('instructions_text') ?? $INSTRUKTIONS_TEXT?>
            </div>
            <button class="btn btn-primary" name="instruktion_gelesen" value="1"><?=t('instructions_continue') ?? "Starten"?></button>
        </form>
        </div></body></html>
        <?php exit; ?>
    <?php endif; ?>

    <?php if (empty($paare)): ?>
        <div class="alert alert-success mt-4">
            <h4><?=t('finished')?></h4>
            <p>
                <a href="results.php?set=<?=urlencode($kartensetPfad)?>" class="btn btn-success"><?=t('see_results')?></a>
                <a href="compare.php?set=<?=urlencode($kartensetPfad)?>&export_json=1" class="btn btn-outline-secondary">JSON-Export</a>
                <a href="compare.php?set=<?=urlencode($kartensetPfad)?>&reset=1" class="btn btn-sm btn-outline-primary ms-2"><?=t('instructions_continue') ?? "Nochmal starten"?></a>
            </p>
        </div>
    <?php else: ?>
        <?php
        // Aktuelles Paar – Randomisierung der Reihenfolge:
        $aktuellesPaar = $paare[0];
        $show_left = rand(0,1) ? 'normal' : 'swapped';
        if($show_left === 'swapped') $aktuellesPaar = array_reverse($aktuellesPaar);
        $karte1 = $karten[$aktuellesPaar[0]];
        $karte2 = $karten[$aktuellesPaar[1]];
        ?>
        <form method="post" class="mb-5" autocomplete="off">
            <input type="hidden" name="id1" value="<?=htmlspecialchars($karte1['id'])?>">
            <input type="hidden" name="id2" value="<?=htmlspecialchars($karte2['id'])?>">
            <input type="hidden" name="show_left" value="<?=htmlspecialchars($show_left)?>">
            <input type="hidden" name="zeit_start" id="zeit_start" value="">
            <div class="row align-items-center">
                <div class="col-md-5 mb-3">
                    <div class="card card-compare h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?=htmlspecialchars($karte1['title'])?></h5>
                            <p class="card-text"><?=htmlspecialchars($karte1['subtitle'])?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 text-center mb-3">
                    <span class="vs-badge" aria-label="Vergleich">vs.</span>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="card card-compare h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?=htmlspecialchars($karte2['title'])?></h5>
                            <p class="card-text"><?=htmlspecialchars($karte2['subtitle'])?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-4">
                <div class="btn-group btn-group-lg d-flex flex-wrap gap-2 justify-content-center" role="group">
                    <button type="submit" name="bewertung" value="1" class="btn btn-outline-primary flex-fill"><?=t('card1_much')?></button>
                    <button type="submit" name="bewertung" value="2" class="btn btn-outline-primary flex-fill"><?=t('card1_some')?></button>
                    <button type="submit" name="bewertung" value="3" class="btn btn-outline-primary flex-fill"><?=t('card2_some')?></button>
                    <button type="submit" name="bewertung" value="4" class="btn btn-outline-primary flex-fill"><?=t('card2_much')?></button>
                </div>
            </div>
        </form>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mt-3"><?=t('back_to_sets')?></a>
</div>
</body>
</html>
