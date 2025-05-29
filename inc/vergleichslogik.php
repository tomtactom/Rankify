<?php
// KEIN LEERZEICHEN ODER BOM vor diesem Tag!

/**
 * Erzeugt alle möglichen 2er-Paare aus einer Liste von IDs.
 * Jedes Paar wird $wiederholungen mal (ggf. in zufälliger Reihenfolge) zurückgegeben.
 * Optional: $seed für reproduzierbare Reihenfolge (z.B. für Tests).
 *
 * @param array $ids
 * @param int $wiederholungen
 * @param int|null $seed
 * @return array
 */
function alleVergleichspaare($ids, $wiederholungen = 1, $seed = null) {
    $paare = [];
    $n = count($ids);
    if ($n < 2) return [];
    for ($i = 0; $i < $n-1; $i++) {
        for ($j = $i+1; $j < $n; $j++) {
            for ($k = 0; $k < $wiederholungen; $k++) {
                $paare[] = [$ids[$i], $ids[$j]];
            }
        }
    }
    // Shuffle (optional mit Seed für Konsistenz)
    if ($seed !== null) {
        srand($seed);
        shuffle($paare);
        srand(); // Reset random seed
    } else {
        shuffle($paare);
    }
    return $paare;
}

/**
 * Erweiterungspunkt: Adaptive Auswahl (z.B. für "unsicherste" Paare bevorzugen).
 * Noch nicht implementiert, hier nur als Platzhalter!
 */
function adaptiveVergleichspaare($ids, $antworten, $wiederholungen = 1) {
    // TODO: Adaptive Logik, falls gewünscht
    return alleVergleichspaare($ids, $wiederholungen);
}
