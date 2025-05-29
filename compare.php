<?php
include 'inc/lang.php';
include 'inc/kartenset_loader.php';
include 'inc/session_handler.php';
include 'inc/vergleichslogik.php';

$kartensetPfad = $_GET['set'] ?? '';
if (!$kartensetPfad || !file_exists('data/'.$kartensetPfad)) {
    die(t('choose_set') . '. <a href="index.php">' . t('back_to_sets') . '</a>');
}

// Kartenset laden
$daten = array_map('str_getcsv', file('data/'.$kartensetPfad));
$kopf = array_shift($daten);
$karten = [];
foreach($daten as $zeile) {
    $karten[$zeile[0]] = ['id'=>$zeile[0],'title'=>$zeile[1],'subtitle'=>$zeile[2]];
}
$ids = array_keys($karten);

// Session laden
$progress = loadProgress($kartensetPfad);
$paare = $progress['paare'] ?? alleVergleichspaare($ids);
$antworten = $progress['antworten'] ?? [];

// Antwort verarbeiten
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id1'], $_POST['id2'], $_POST['bewertung'])) {
    $antworten[] = [
        'id1' => $_POST['id1'],
        'id2' => $_POST['id2'],
        'bewertung' => (int)$_POST['bewertung'],
    ];
    array_shift($paare);
    saveProgress($kartensetPfad, ['paare' => $paare, 'antworten' => $antworten]);
    // Redirect für frisches Laden (PRG)
    header("Location: compare.php?set=".urlencode($kartensetPfad));
    exit;
}

// Fortschritt
$gesamt = count(alleVergleichspaare($ids));
$fortschritt = $gesamt ? (100 * (count($antworten) / $gesamt)) : 0;
?>
<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
    <meta charset="UTF-8">
    <title>Rankifmy</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1><?=t('progress')?>: <?=round($fortschritt)?>%</h1>
    <div class="mb-3">
        <div class="progress" style="height:1.5rem;">
            <div class="progress-bar" role="progressbar" style="width: <?=round($fortschritt)?>%;" aria-valuenow="<?=round($fortschritt)?>" aria-valuemin="0" aria-valuemax="100">
                <?=round($fortschritt)?>%
            </div>
        </div>
    </div>

    <?php if (empty($paare)): ?>
        <div class="alert alert-success mt-4">
            <h4><?=t('finished')?></h4>
            <p>
                <a href="results.php?set=<?=urlencode($kartensetPfad)?>"><?=t('see_results')?></a>
            </p>
        </div>
    <?php else: ?>
        <?php
        $aktuellesPaar = $paare[0];
        $karte1 = $karten[$aktuellesPaar[0]];
        $karte2 = $karten[$aktuellesPaar[1]];
        ?>
        <form method="post" class="mb-5">
            <input type="hidden" name="id1" value="<?=htmlspecialchars($karte1['id'])?>">
            <input type="hidden" name="id2" value="<?=htmlspecialchars($karte2['id'])?>">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5><?=htmlspecialchars($karte1['title'])?></h5>
                            <p><?=htmlspecialchars($karte1['subtitle'])?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-center justify-content-center">
                    <div>
                        <span class="badge bg-secondary">vs.</span>
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5><?=htmlspecialchars($karte2['title'])?></h5>
                            <p><?=htmlspecialchars($karte2['subtitle'])?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-4">
                <label class="mb-2"><?=t('comparison_question')?></label><br>
                <div class="btn-group btn-group-lg" role="group">
                    <button type="submit" name="bewertung" value="1" class="btn btn-outline-primary"><?=t('card1_much')?></button>
                    <button type="submit" name="bewertung" value="2" class="btn btn-outline-primary"><?=t('card1_some')?></button>
                    <button type="submit" name="bewertung" value="3" class="btn btn-outline-primary"><?=t('card2_some')?></button>
                    <button type="submit" name="bewertung" value="4" class="btn btn-outline-primary"><?=t('card2_much')?></button>
                </div>
            </div>
        </form>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mt-3"><?=t('back_to_sets')?></a>
</div>
</body>
</html>
