<?php
include 'inc/kartenset_loader.php';
include 'inc/session_handler.php';

$kartensetPfad = $_GET['set'] ?? '';
if (!$kartensetPfad || !file_exists('data/'.$kartensetPfad)) {
    die('Kartenset nicht gefunden. <a href="index.php">Zurück</a>');
}

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

// Punktewertung (4er Skala: viel wichtiger = 2 Punkte, etwas wichtiger = 1 Punkt)
$punkte = [];
foreach($karten as $id => $k) $punkte[$id] = 0;

foreach($antworten as $antwort) {
    $id1 = $antwort['id1'];
    $id2 = $antwort['id2'];
    $bew = $antwort['bewertung'];
    if ($bew == 1) { // Karte 1 viel wichtiger
        $punkte[$id1] += 2;
    } elseif ($bew == 2) { // Karte 1 etwas wichtiger
        $punkte[$id1] += 1;
    } elseif ($bew == 3) { // Karte 2 etwas wichtiger
        $punkte[$id2] += 1;
    } elseif ($bew == 4) { // Karte 2 viel wichtiger
        $punkte[$id2] += 2;
    }
}

// Rangliste absteigend sortieren
arsort($punkte);
$gesamtVergleiche = count($antworten);

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Rangreihe – Rankifmy</title>
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
<nav class="navbar navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Rankifmy</a>
    </div>
</nav>
<div class="container">
    <h1>Deine Rangreihe</h1>
    <p>Basierend auf <b><?=$gesamtVergleiche?></b> Vergleichen (Punktewertung):</p>

    <?php
    $maxPunkte = max($punkte) ?: 1;
    $platz = 1;
    foreach($punkte as $id => $pkt):
        $k = $karten[$id];
        $breite = intval(($pkt / $maxPunkte) * 100);
    ?>
    <div class="mb-2">
        <div><b>#<?=$platz?></b> <?=htmlspecialchars($k['title'])?> <span class="text-muted">(<?=$k['subtitle']?>)</span></div>
        <div class="rankbar">
            <div class="rankbar-inner" style="width: <?=$breite?>%;">
                <?=$pkt?> Punkte
            </div>
        </div>
    </div>
    <?php $platz++; endforeach; ?>

    <div class="my-4">
        <a href="index.php" class="btn btn-secondary">Zurück zur Übersicht</a>
        <a href="compare.php?set=<?=urlencode($kartensetPfad)?>" class="btn btn-outline-primary ms-2">Vergleiche wiederholen</a>
        <form method="post" class="d-inline">
            <input type="hidden" name="reset" value="1">
            <button class="btn btn-outline-danger ms-2" name="reset" value="1" onclick="return confirm('Session wirklich löschen?')">Session zurücksetzen</button>
        </form>
    </div>
</div>
<?php
// Session löschen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    saveProgress($kartensetPfad, []); // Session leeren
    header("Location: compare.php?set=".urlencode($kartensetPfad));
    exit;
}
?>
</body>
</html>
