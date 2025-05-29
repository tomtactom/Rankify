<?php
include 'inc/lang.php';
include 'inc/kartenset_loader.php';
$kartensets = getKartensets();

function sprachName($code) {
    $langs = ['de' => 'Deutsch', 'en' => 'English'];
    return $langs[$code] ?? $code;
}
?>
<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
    <meta charset="UTF-8">
    <title><?=t('title')?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h1 class="mb-4"><?=t('choose_set')?></h1>
    <div class="row">
        <?php foreach($kartensets as $set): ?>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($set['name']) ?></h5>
                    <p class="card-text">
                        <?=t('model_'.$set['modell'])?><br>
                        Sprache: <b><?= sprachName($set['sprache']) ?></b>
                    </p>
                    <a href="compare.php?set=<?= urlencode($set['modell'].'/'.$set['filename']) ?>" class="btn btn-primary w-100"><?=t('start')?></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($kartensets)): ?>
            <div class="col-12"><p class="text-muted">Noch keine Kartensets vorhanden.</p></div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
