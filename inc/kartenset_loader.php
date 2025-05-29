<?php
function getKartensets($dataDir = 'data') {
    $modelle = ['punkte', 'thurstone', 'bradleyterry'];
    $sets = [];
    foreach ($modelle as $modell) {
        $pfad = "$dataDir/$modell";
        if (!is_dir($pfad)) continue;
        foreach (glob("$pfad/*_*.csv") as $file) {
            $filename = basename($file);
            if (preg_match('/^(.*)_(\w{2})\.csv$/', $filename, $match)) {
                $name = $match[1];
                $sprache = $match[2];
                $sets[] = [
                    'name' => $name,
                    'modell' => $modell,
                    'sprache' => $sprache,
                    'filename' => $filename,
                    'path' => $file
                ];
            }
        }
    }
    return $sets;
}
?>
