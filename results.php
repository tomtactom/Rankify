<?php
include 'inc/lang.php';
include 'inc/kartenset_loader.php';
include 'inc/session_handler.php';
include 'inc/methods.php';

$kartensetPfad = $_GET['set'] ?? '';
if (!$kartensetPfad || !file_exists('data/'.$kartensetPfad)) {
    die(t('choose_set') . '. <a href="index.php">' . t('back_to_sets') . '</a>');
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

// Methoden-Text übersetzbar machen
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

?>
<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
    <meta charset="UTF-8">
    <title><?=$titel?> – Rankifmy</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .rankbar {
            height: 2.5rem;
            border-radius: 1rem;
            background: #e7eaf6;
            position: relative;
            margin-bottom: 1rem;
        }
        .rankbar-inner {
            height: 100%;
            border-radius: 1rem;
            background: #0d6efd;
            color: white;
            padding-left: 1rem;
            display: flex;
            align-items: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1><?=t('ranking')?></h1>
    <p><?=$text?></p>
    <div class="mb-3">
        <b><?=$gesamtVergleiche?></b> <?=t('progress')?>.
    </div>
    <div class="mb-3">
        <a href="results.php?set=<?=urlencode($kartensetPfad)?>&methode=punkte" class="btn btn-outline-primary <?php if($methode=='punkte')echo'active';?>"><?=t('model_points')?></a>
        <a href="results.php?set=<?=urlencode($kartensetPfad)?>&methode=thurstone" class="btn btn-outline-primary <?php if($methode=='thurstone')echo'active';?>"><?=t('model_thurstone')?></a>
        <a href="results.php?set=<?=urlencode($kartensetPfad)?>&methode=bradleyterry" class="btn btn-outline-primary <?php if($methode=='bradleyterry')echo'active';?>"><?=t('model_bradleyterry')?></a>
    </div>
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

    <div class="my-4">
        <a href="index.php" class="btn btn-secondary"><?=t('back_to_sets')?></a>
        <a href="compare.php?set=<?=urlencode($kartensetPfad)?>" class="btn btn-outline-primary ms-2"><?=t('repeat_comparisons')?></a>
        <form method="post" class="d-inline">
            <input type="hidden" name="reset" value="1">
            <button class="btn btn-outline-danger ms-2" name="reset" value="1" onclick="return confirm('<?=t('reset_confirm')?>')"><?=t('reset_session')?></button>
        </form>
    </div>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    saveProgress($kartensetPfad, []);
    header("Location: compare.php?set=".urlencode($kartensetPfad));
    exit;
}
?>
</body>
</html>
