<?php
// Einfache Punktewertung: 2 Punkte für "viel wichtiger", 1 Punkt für "etwas wichtiger"
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

// Thurstone Case V: z-Werte aus Sieganteilen (viel=1, etwas=0.5), jetzt mit Eidous & Al-Rawwash Approximation
function thurstone($karten, $antworten) {
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

    $z = [];
    foreach($ids as $i) {
        $sum = 0; $n = 0;
        foreach($ids as $j) {
            if ($i == $j) continue;
            $wins = $matrix[$i][$j];
            $total = $matrix[$i][$j] + $matrix[$j][$i];
            if ($total > 0) {
                $p = $wins / $total;
                $p = max(0.001, min(0.999, $p)); // Begrenzung gegen Inf/NaN
                $sum += eidous_normsinv($p);
                $n++;
            }
        }
        $z[$i] = ($n>0) ? $sum / $n : 0;
    }
    arsort($z);
    return $z;
}

// Bradley-Terry-Modell: Maximum-Likelihood-Schätzung (Minorization-Maximization)
function bradley_terry($karten, $antworten, $max_iter = 100, $epsilon = 1e-5) {
    $ids = array_keys($karten);
    $thetas = [];
    foreach($ids as $id) $thetas[$id] = 1.0; // Startwerte
    $pair_counts = [];
    foreach($antworten as $a) {
        $id1 = $a['id1']; $id2 = $a['id2']; $bew = $a['bewertung'];
        if ($id1 == $id2) continue;
        if ($bew == 1)      $pair_counts[] = [$id1, $id2, 2, 0];
        elseif ($bew == 2)  $pair_counts[] = [$id1, $id2, 1, 0];
        elseif ($bew == 3)  $pair_counts[] = [$id2, $id1, 1, 0];
        elseif ($bew == 4)  $pair_counts[] = [$id2, $id1, 2, 0];
    }
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
        $sum = array_sum($updates);
        foreach($ids as $id) $thetas[$id] = $updates[$id] / $sum;
        $delta = 0.0;
        foreach($ids as $id) $delta = max($delta, abs($thetas[$id] - $prev[$id]));
        if ($delta < $epsilon) break;
    }
    arsort($thetas);
    return $thetas;
}

// Eidous & Al-Rawwash (2022): Präzise Inverse der Standardnormalverteilung
function eidous_normsinv($p) {
    // Gilt für p in [0,1], symmetrisch um 0.5
    if ($p < 0.5) return -eidous_normsinv(1-$p);
    // d1 wie in der Publikation
    $d1 = 0.8039 - 0.9446 * $p + 1.5806 * pow($p,2) - 1.7824 * pow($p,4) + 1.5098 * pow($p,6) - 0.5689 * pow($p,8);
    $inner = 1 - pow(2*($p-0.5),2);
    if ($inner <= 0) $inner = 1e-16; // numerische Sicherheit für log(0)
    return sqrt(-1/$d1 * log($inner));
}

function alleVergleichspaare($ids) {
    $paare = [];
    $n = count($ids);
    if ($n < 2) return [];
    for ($i = 0; $i < $n-1; $i++) {
        for ($j = $i+1; $j < $n; $j++) {
            $paare[] = [$ids[$i], $ids[$j]];
        }
    }
    shuffle($paare);
    return $paare;
}
?>
