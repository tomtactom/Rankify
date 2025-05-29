<?php
// Hilfsfunktion: alle möglichen Paare aus IDs (ohne Selbstvergleich)
function alleVergleichspaare($ids) {
    $paare = [];
    $n = count($ids);
    for ($i = 0; $i < $n; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            $paare[] = [$ids[$i], $ids[$j]];
        }
    }
    shuffle($paare); // Zufällige Reihenfolge
    return $paare;
}
?>
