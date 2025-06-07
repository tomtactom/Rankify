<?php
$WIEDERHOLUNGEN = 1;

$kartensetPfad = $_GET['set'] ?? '';
include 'inc/lang.php';
include 'inc/kartenset_loader.php';
include 'inc/session_handler.php';
include 'inc/vergleichslogik.php';

// Reset-Logik
if (isset($_GET['reset'])) {
    resetProgress($kartensetPfad);
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

// Fortschritt laden
$progress = loadProgress($kartensetPfad);
$antworten = isset($progress['antworten']) && is_array($progress['antworten']) ? $progress['antworten'] : [];
$paare = isset($progress['paare']) && is_array($progress['paare']) ? $progress['paare'] : null;
$instruktion_gelesen = isset($progress['instruktion_gelesen']) ? $progress['instruktion_gelesen'] : false;

// Erstinitialisierung, falls nötig
if ((empty($paare) || !is_array($paare)) && empty($antworten)) {
    $paare = alleVergleichspaare($ids, $WIEDERHOLUNGEN);
    $antworten = [];
    $instruktion_gelesen = false;
    $progress = [
        'paare' => $paare,
        'antworten' => $antworten,
        'instruktion_gelesen' => $instruktion_gelesen,
    ];
    saveProgress($kartensetPfad, $progress);
}

// Falls alle Paare beantwortet sind, weiterleiten zu den Ergebnissen
if (empty($paare) && !empty($antworten)) {
    header("Location: results.php?set=" . urlencode($kartensetPfad));
    exit;
}

function now_millis() { return round(microtime(true) * 1000); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['instruktion_gelesen'])) {
        $instruktion_gelesen = true;
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

$gesamt = count(alleVergleichspaare($ids, $WIEDERHOLUNGEN));
$fortschritt = $gesamt ? (100 * (count($antworten) / $gesamt)) : 0;

include 'navbar.php';
?>
<script>
    let zeit_start;
    window.onload = function() {
        zeit_start = Date.now();
        var inp = document.getElementById("zeit_start");
        if(inp) inp.value = zeit_start;
        // Mobile: Automatisch scrollen
        if(window.innerWidth < 800) {
            let el = document.getElementById('vergleichsbereich');
            if(el) el.scrollIntoView({behavior: 'smooth', block: 'start'});
        }
    };
</script>
<div class="container py-3">
    <!-- Hero Section -->
    <div class="compare-hero">
      <div class="compare-hero-logo" aria-label="Logo">R</div>
      <div class="compare-hero-content">
        <div class="compare-hero-title-row">
          <span class="compare-hero-title"><?=t('progress')?>: </span>
          <span class="progress-chip"><?=round($fortschritt)?>%</span>
        </div>
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
                <?=t('instructions_text') ?? ""?>
            </div>
            <button class="btn btn-primary" name="instruktion_gelesen" value="1"><?=t('instruction_continue') ?? "Starten"?></button>
        </form>
        </div></body></html>
        <?php exit; ?>
    <?php endif; ?>

    <?php
    // ==== Sicherstellen, dass das nächste Paar gültig ist! ====
    $valide = false;
    if (isset($paare[0]) && is_array($paare[0]) && count($paare[0]) === 2 &&
        isset($karten[$paare[0][0]]) && isset($karten[$paare[0][1]])) {
        $valide = true;
    }

    if (!$valide) {
        echo "<div style='background:#fff3cd;color:#856404;padding:1.2em;margin:2em 0;border-radius:10px;font-family:monospace;'>";
        echo "<b>Debug-Infos:</b><br>";
        echo "<b>\$paare:</b><pre>" . htmlspecialchars(print_r($paare, true)) . "</pre>";
        echo "<b>\$karten:</b><pre>" . htmlspecialchars(print_r($karten, true)) . "</pre>";
        echo "<b>\$ids:</b><pre>" . htmlspecialchars(print_r($ids, true)) . "</pre>";
        echo "</div>";
        ?>
        <div class="alert alert-danger mt-5">
            <b>Fehler:</b> Die Vergleichspaare sind ungültig oder unvollständig.<br>
            Bitte <a href="compare.php?set=<?=urlencode($kartensetPfad)?>&reset=1">Set neu starten</a>.<br>
            Falls das Problem weiterhin auftritt, prüfe die CSV-Datei und lösche ggf. die gespeicherten Sitzungsdaten dieses Sets.
        </div>
        </body></html>
        <?php exit;
    }

    $aktuellesPaar = $paare[0];
    $show_left = rand(0,1) ? 'normal' : 'swapped';
    if($show_left === 'swapped') $aktuellesPaar = array_reverse($aktuellesPaar);
    $karte1 = $karten[$aktuellesPaar[0]];
    $karte2 = $karten[$aktuellesPaar[1]];
    ?>

    <div class="vergleichsbereich-wrapper" id="vergleichsbereich">
      <!-- MOBILE: vertikal -->
      <div class="d-block d-md-none">
        <!-- Karte 1 oben -->
        <div class="card card-compare mb-2" style="width:100%;max-width:370px;margin:auto;">
          <div class="card-body text-center">
            <h5 class="card-title"><?=htmlspecialchars($karte1['title'])?></h5>
            <p class="card-text"><?=htmlspecialchars($karte1['subtitle'])?></p>
          </div>
        </div>
        <form method="post" class="likert-vertical" autocomplete="off" style="width:100%;max-width:380px;margin:auto;">
          <input type="hidden" name="id1" value="<?=htmlspecialchars($karte1['id'])?>">
          <input type="hidden" name="id2" value="<?=htmlspecialchars($karte2['id'])?>">
          <input type="hidden" name="show_left" value="<?=htmlspecialchars($show_left)?>">
          <input type="hidden" name="zeit_start" id="zeit_start" value="">
          <button type="submit" name="bewertung" value="1" class="likert-v-btn"><?=t('this_card_much')?></button>
          <button type="submit" name="bewertung" value="2" class="likert-v-btn"><?=t('this_card_some')?></button>
          <button type="submit" name="bewertung" value="3" class="likert-v-btn"><?=t('other_card_some')?></button>
          <button type="submit" name="bewertung" value="4" class="likert-v-btn"><?=t('other_card_much')?></button>
        </form>
        <!-- Karte 2 unten -->
        <div class="card card-compare mt-2" style="width:100%;max-width:370px;margin:auto;">
          <div class="card-body text-center">
            <h5 class="card-title"><?=htmlspecialchars($karte2['title'])?></h5>
            <p class="card-text"><?=htmlspecialchars($karte2['subtitle'])?></p>
          </div>
        </div>
      </div>
      <!-- DESKTOP: horizontal -->
      <div class="d-none d-md-block">
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
      </div>
    </div>
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary"><?=t('back_to_sets')?></a>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
