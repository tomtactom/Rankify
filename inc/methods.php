<?php
function simple_points($karten, $antworten) {
    $punkte = [];
    foreach($karten as $id => $k) $punkte[$id] = 0;
    foreach($antworten as $antwort) {
        $id1 = $antwort['id1'];
        $id2 = $antwort['id2'];
        $bew = $antwort['bewertung'];
        if ($bew == 1) { $punkte[$id1] += 2; }
        elseif ($bew == 2) { $punkte[$id1] += 1; }
        elseif ($bew == 3) { $punkte[$id2] += 1; }
        elseif ($bew == 4) { $punkte[$id2] += 2; }
    }
    arsort($punkte);
    return $punkte;
}

function thurstone($karten, $antworten) {
    // 1. Präferenzmatrix aufbauen
    $ids = array_keys($karten);
    $matrix = [];
    foreach($ids as $i) foreach($ids as $j) $matrix[$i][$j] = 0;

    foreach($antworten as $a) {
        $id1 = $a['id1'];
        $id2 = $a['id2'];
        $bew = $a['bewertung'];
        if ($bew == 1 || $bew == 2) { // id1 gewinnt
            $matrix[$id1][$id2] += ($bew == 1 ? 1.0 : 0.5);
        } elseif ($bew == 3 || $bew == 4) { // id2 gewinnt
            $matrix[$id2][$id1] += ($bew == 4 ? 1.0 : 0.5);
        }
    }

    // 2. Relativer Sieganteil (pro Paar), dann in z-Werte transformieren
    $z = [];
    foreach($ids as $i) {
        $sum = 0; $n = 0;
        foreach($ids as $j) {
            if ($i == $j) continue;
            $wins = $matrix[$i][$j];
            $total = $matrix[$i][$j] + $matrix[$j][$i];
            if ($total > 0) {
                $p = $wins / $total;
                // Begrenzen um unendlich zu vermeiden
                $p = max(0.001, min(0.999, $p));
                $sum += normsinv($p);
                $n++;
            }
        }
        $z[$i] = ($n>0) ? $sum / $n : 0;
    }
    arsort($z);
    return $z;
}

// Inverse der Standardnormalverteilungsfunktion (approximativ)
function normsinv($p) {
    // Algorithmus von Peter J. Acklam (vereinfachte Version)
    $a1 = -39.6968302866538; $a2 = 220.946098424521; $a3 = -275.928510446969;
    $a4 = 138.357751867269; $a5 = -30.6647980661472; $a6 = 2.50662827745924;
    $b1 = -54.4760987982241; $b2 = 161.585836858041; $b3 = -155.698979859887;
    $b4 = 66.8013118877197; $b5 = -13.2806815528857;
    $c1 = -0.00778489400243029; $c2 = -0.322396458041136; $c3 = -2.40075827716184;
    $c4 = -2.54973253934373; $c5 = 4.37466414146497; $c6 = 2.93816398269878;
    $d1 = 0.00778469570904146; $d2 = 0.32246712907004; $d3 = 2.445134137143;
    $d4 = 3.75440866190742;
    $p_low = 0.02425; $p_high = 1 - $p_low;
    if ($p < $p_low) {
        $q = sqrt(-2 * log($p));
        return ((((( $c1 * $q + $c2 ) * $q + $c3 ) * $q + $c4 ) * $q + $c5 ) * $q + $c6 ) /
               (((( $d1 * $q + $d2 ) * $q + $d3 ) * $q + $d4 ) * $q + 1);
    }
    if ($p > $p_high) {
        $q = sqrt(-2 * log(1 - $p));
        return -((((( $c1 * $q + $c2 ) * $q + $c3 ) * $q + $c4 ) * $q + $c5 ) * $q + $c6 ) /
                (((( $d1 * $q + $d2 ) * $q + $d3 ) * $q + $d4 ) * $q + 1);
    }
    $q = $p - 0.5;
    $r = $q * $q;
    return ((((( $a1 * $r + $a2 ) * $r + $a3 ) * $r + $a4 ) * $r + $a5 ) * $r + $a6 ) * $q /
           ((((( $b1 * $r + $b2 ) * $r + $b3 ) * $r + $b4 ) * $r + $b5 ) * $r + 1);
}

function bradley_terry($karten, $antworten, $max_iter = 100, $epsilon = 1e-5) {
    $ids = array_keys($karten);
    $thetas = [];
    foreach($ids as $id) $thetas[$id] = 1.0; // Initial alle gleich stark
    $pair_counts = [];
    foreach($antworten as $a) {
        $id1 = $a['id1']; $id2 = $a['id2']; $bew = $a['bewertung'];
        if ($id1 == $id2) continue;
        // Siegpunkt-Zuteilung
        if ($bew == 1)      $pair_counts[] = [$id1, $id2, 2, 0];
        elseif ($bew == 2)  $pair_counts[] = [$id1, $id2, 1, 0];
        elseif ($bew == 3)  $pair_counts[] = [$id2, $id1, 1, 0];
        elseif ($bew == 4)  $pair_counts[] = [$id2, $id1, 2, 0];
    }
    // Minorization-Maximization-Iteration
    for ($iter=0; $iter<$max_iter; $iter++) {
        $prev = $thetas;
        $updates = [];
        foreach($ids as $id) {
            $num = 0.0; $den = 0.0;
            foreach($pair_counts as $p) {
                list($w, $l, $wpts, $lpts) = $p;
                if ($id == $w) {
                    $num += $wpts;
                    $den += $wpts / ($thetas[$w] + $thetas[$l]);
                }
                if ($id == $l) {
                    $den += $wpts * $thetas[$w] / pow($thetas[$w] + $thetas[$l], 2);
                }
            }
            if ($den > 0) $updates[$id] = $thetas[$id] * $num / $den;
            else $updates[$id] = $thetas[$id];
        }
        // Normieren (optional)
        $sum = array_sum($updates);
        foreach($ids as $id) $thetas[$id] = $updates[$id] / $sum;
        // Abbruchkriterium
        $delta = 0.0;
        foreach($ids as $id) $delta = max($delta, abs($thetas[$id] - $prev[$id]));
        if ($delta < $epsilon) break;
    }
    arsort($thetas);
    return $thetas;
}
?>
