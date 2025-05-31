<?php
include 'inc/lang.php';

// Kartensets finden (durchsuche alle Unterordner in data/)
$verzeichnisse = ['punkte', 'thurstone', 'bradleyterry'];
$kartensets = [];

foreach ($verzeichnisse as $modell) {
    $dir = __DIR__."/data/$modell";
    if (!is_dir($dir)) continue;
    foreach (glob($dir.'/*.csv') as $file) {
        $filename = basename($file);
        $langcode = preg_match('/_([a-z]{2})\.csv$/', $filename, $m) ? $m[1] : '';
        $kartensets[] = [
            'modell' => $modell,
            'filename' => $filename,
            'langcode' => $langcode,
            'displayname' => preg_replace('/(_[a-z]{2})?\.csv$/', '', $filename),
        ];
    }
}
usort($kartensets, function($a, $b) {
    return strcmp($a['displayname'], $b['displayname']);
});

?>
<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
    <meta charset="UTF-8">
    <title>Rankifmy – <?=t('sets_overview')?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/lang.js"></script>

</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">

    <h1 class="mb-4"><?=t('sets_overview')?></h1>

    <?php if(empty($kartensets)): ?>
        <div class="alert alert-warning"><?=t('error_no_set')?></div>
    <?php else: ?>
        <div class="cardset-list mb-4">
        <?php foreach($kartensets as $set): ?>
            <div class="cardset">
                <div class="cardset-title"><?=htmlspecialchars($set['displayname'])?></div>
                <div class="cardset-meta mb-2">
                    <span class="modell-badge"><?=ucfirst($set['modell'])?></span>
                    <?php if($set['langcode']): ?>
                        <span class="lang-badge"><?=strtoupper($set['langcode'])?></span>
                    <?php endif; ?>
                </div>
                <a href="compare.php?set=<?=urlencode($set['modell'].'/'.$set['filename'])?>" class="btn btn-primary btn-cardset">
                    <?=t('progress')?> starten
                </a>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
</body>
</html>
