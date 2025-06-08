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
        for ($i = count($paare) - 1; $i > 0; $i--) {
            $seed = ($seed * 1103515245 + 12345) & 0x7fffffff;
            $j = $seed % ($i + 1);
            [$paare[$i], $paare[$j]] = [$paare[$j], $paare[$i]];
        }
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
    $pairs = alleVergleichspaare($ids, $wiederholungen);
    $stats = [];
    foreach ($antworten as $a) {
        $pair = [$a['id1'], $a['id2']];
        sort($pair);
        $key = implode('_', $pair);
        if (!isset($stats[$key])) $stats[$key] = ['a'=>0,'b'=>0];
        if (in_array($a['bewertung'], [1,2])) $stats[$key]['a']++;
        elseif (in_array($a['bewertung'], [3,4])) $stats[$key]['b']++;
    }
    usort($pairs, function($x, $y) use ($stats) {
        $px = $x; sort($px); $kx = implode('_', $px);
        $py = $y; sort($py); $ky = implode('_', $py);
        $sx = $stats[$kx] ?? ['a'=>0,'b'=>0];
        $sy = $stats[$ky] ?? ['a'=>0,'b'=>0];
        $ux = ($sx['a']+$sx['b'])>0 ? 1 - abs($sx['a']-$sx['b'])/($sx['a']+$sx['b']) : 1;
        $uy = ($sy['a']+$sy['b'])>0 ? 1 - abs($sy['a']-$sy['b'])/($sy['a']+$sy['b']) : 1;
        return $uy <=> $ux;
    });
    return $pairs;
}
