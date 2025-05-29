<?php
include 'inc/lang.php';
include 'inc/kartenset_loader.php';
include 'inc/session_handler.php';
include 'inc/methods.php';

$kartensetPfad = $_GET['set'] ?? '';
if (!$kartensetPfad || !file_exists('data/'.$kartensetPfad)) {
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
        <div class="alert alert-danger mt-5">
            <?=t('error_no_set')?> <br>
            <a href="index.php" class="btn btn-secondary mt-3"><?=t('back_to_sets')?></a>
        </div>
    </div>
    </body>
    </html>
    <?php exit;
}
$methode = $_GET['methode'] ?? 'punkte';

// Kartenset laden
$daten = array_map('str_getcsv', file('data/'.$kartensetPfad));
$kopf = array_shift($daten);
$karten = [];
foreach($daten as $zeile) {
    $karten[$zeile[0]] = ['id'=>$zeile[0],'title'=>$zeile[1],'subtitle'=>$zeile[2]];
}

// Antworten laden
$progress = loadProgress($kartensetPfad);
$antworten = $progress['antworten'] ?? [];

// Falls noch keine Antworten: Hinweis
if (empty($antworten)) {
    ?>
    <!DOCTYPE html>
    <html lang="<?=getLanguage()?>">
    <head>
        <meta charset="UTF-8">
        <title><?=t('ranking')?> – Rankifmy</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    </head>
    <body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="alert alert-warning mt-5">
            <?=t('error_no_answers')?> <br>
            <a href="compare.php?set=<?=urlencode($kartensetPfad)?>" class="btn btn-primary mt-3"><?=t('repeat_comparisons')?></a>
            <a href="index.php" class="btn btn-secondary mt-3"><?=t('back_to_sets')?></a>
        </div>
    </div>
    </body>
    </html>
    <?php exit;
}

// Methoden-Auswahl
switch($methode) {
    case 'thurstone':
        $result = thurstone($karten, $antworten);
        $titel = t('method_thurstone');
        $text = t('method_thurstone') . ".";
        break;
    case 'bradleyterry':
        $result = bradley_terry($karten, $antworten);
        $titel = t('method_bradleyterry');
        $text = t('method_bradleyterry') . ".";
        break;
    default:
        $result = simple_points($karten, $antworten);
        $titel = t('method_points');
        $text = t('method_points') . ".";
        break;
}

$gesamtVergleiche = count($antworten);

// CSV-Export
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_csv'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=rankifmy_result.csv');
    echo "Platz;Titel;Untertitel;Wert\n";
    $platz = 1;
    foreach($result as $id => $wert) {
        $k = $karten[$id];
        echo $platz . ";" . $k['title'] . ";" . $k['subtitle'] . ";" . round($wert,2) . "\n";
        $platz++;
    }
    exit;
}

// Session-Reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    saveProgress($kartensetPfad, []);
    header("Location: compare.php?set=".urlencode($kartensetPfad));
    exit;
}
?>
<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
    <meta charset="UTF-8">
    <title><?=$titel?> – Rankifmy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: linear-gradient(120deg,#e6ecf7 0%,#fafdfe 100%);
            min-height: 100vh;
        }
        .results-hero {
            display: flex; align-items: center; gap: 1.3rem; margin-bottom: 2.5rem;
        }
        .results-hero-logo {
            width: 58px; height: 58px; border-radius: 14px;
            background: #fff; display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; font-weight: bold; color: #6281e3;
            box-shadow: 0 2px 10px rgba(80,110,200,0.09);
            border: 2px solid #e4eefe;
        }
        .results-hero-title {
            font-size: 1.35rem; font-weight: 800; color: #294288; margin-bottom: .3rem;
        }
        .results-hero-text {
            color: #4d68a5; font-size: 1.06rem;
        }
        .rankbar {
            height: 2.5rem;
            border-radius: 1rem;
            background: #e7eaf6;
            position: relative;
            margin-bottom: 1rem;
            box-shadow: 0 1px 7px rgba(110,130,160,0.06);
        }
        .rankbar-inner {
            height: 100%;
            border-radius: 1rem;
            background: linear-gradient(90deg,#0d6efd 60%,#67a6fa 100%);
            color: white;
            padding-left: 1rem;
            display: flex;
            align-items: center;
            font-weight: bold;
            transition: width 0.5s;
        }
        .method-buttons .btn { margin-right: .7rem; margin-bottom: .5rem; }
        .my-4 .btn { margin-right: .7rem; }
        @media (max-width: 768px) {
            .results-hero { gap: 0.7rem; flex-direction: column; }
            .results-hero-logo { width: 46px; height: 46px; font-size: 1.15rem; }
            .rankbar { height: 2rem; }
            .rankbar-inner { font-size: 0.98rem; }
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-3">

    <!-- Hero Section -->
    <div class="results-hero">
        <div class="results-hero-logo" aria-label="Logo">R</div>
        <div>
            <div class="results-hero-title"><?=t('ranking')?></div>
            <div class="results-hero-text"><?=$text?></div>
        </div>
    </div>

    <div class="mb-3">
        <span style="color:#6481a5; font-size:1.1rem;">
            <b><?=$gesamtVergleiche?></b> <?=t('progress')?>.
        </span>
    </div>

    <!-- Methoden-Auswahl -->
    <div class="method-buttons mb-3">
        <a href="results.php?set=<?=urlencode($kartensetPfad)?>&methode=punkte" class="btn btn-outline-primary <?php if($methode=='punkte')echo'active';?>"><?=t('model_points')?></a>
        <a href="results.php?set=<?=urlencode($kartensetPfad)?>&methode=thurstone" class="btn btn-outline-primary <?php if($methode=='thurstone')echo'active';?>"><?=t('model_thurstone')?></a>
        <a href="results.php?set=<?=urlencode($kartensetPfad)?>&methode=bradleyterry" class="btn btn-outline-primary <?php if($methode=='bradleyterry')echo'active';?>"><?=t('model_bradleyterry')?></a>
    </div>

    <!-- Ergebnis-Rangfolge -->
    <?php
    $maxVal = max($result) ?: 1;
    $platz = 1;
    foreach($result as $id => $wert):
        $k = $karten[$id];
        $breite = intval(($wert / $maxVal) * 100);
    ?>
    <div class="mb-2">
        <div><b>#<?=$platz?></b> <?=htmlspecialchars($k['title'])?> <span class="text-muted">(<?=htmlspecialchars($k['subtitle'])?>)</span></div>
        <div class="rankbar">
            <div class="rankbar-inner" style="width: <?=$breite?>%;">
                <?=round($wert,2)?>
            </div>
        </div>
    </div>
    <?php $platz++; endforeach; ?>

    <!-- Aktionen -->
    <div class="my-4">
        <a href="index.php" class="btn btn-secondary"><?=t('back_to_sets')?></a>
        <a href="compare.php?set=<?=urlencode($kartensetPfad)?>" class="btn btn-outline-primary"><?=t('repeat_comparisons')?></a>
        <form method="post" class="d-inline">
            <button class="btn btn-outline-success" name="export_csv" value="1">CSV-Export</button>
        </form>
        <form method="post" class="d-inline">
            <input type="hidden" name="reset" value="1">
            <button class="btn btn-outline-danger" name="reset" value="1" onclick="return confirm('<?=t('reset_confirm')?>')"><?=t('reset_session')?></button>
        </form>
    </div>
</div>
</body>
</html>
