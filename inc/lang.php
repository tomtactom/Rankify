<?php
// Sprachdatei für Rankifmy – DE & EN

function t($key) {
    global $lang;
    return $lang[$key] ?? $key;
}

// Optionale Hilfsfunktion für Platzhalter
if (!function_exists('langf')) {
    function langf($text, ...$args) {
        return vsprintf($text, $args);
    }
}

// ----------------------
//      DEUTSCH
// ----------------------

$lang = [
    // Navigation & Buttons
    'results'           => 'Ergebnisse',
    'results_subtitle'  => 'Deine individuelle Rangfolge auf Basis deiner Vergleiche.',
    'back_to_sets'      => 'Zurück zur Übersicht',
    'restart_set'       => 'Set neu starten',
    'export_results'    => 'Ergebnisse exportieren',
    'copy_output'       => 'Kopieren',
    'summary'           => 'Zusammenfassung',
    'total_comparisons' => 'Anzahl der Vergleiche',
    'consistency'       => 'Konsistenz',
    'avg_time'          => 'Ø Antwortzeit',

    // Konfliktpaare
    'conflict_pairs_title'     => 'Widersprüchliche Paare entdeckt!',
    'conflict_pairs_explainer' => 'Für diese Kartenpaare hast du in verschiedenen Durchgängen unterschiedlich abgestimmt. Das kommt vor – vielleicht weil die Karten ähnlich sind, du dir unsicher warst oder deine Bewertung variiert hat.<br>
        <b>Was tun?</b> Du kannst das Set neu starten und die Paare nochmal vergleichen, falls du ein eindeutigeres Ergebnis möchtest. Ansonsten zeigen wir dir trotzdem die beste Schätzung deiner Rangfolge.',

    // Wissenschaftlicher Ergebnis-Output (DEUTSCH)
    'apa_results_de' =>
        "Die individuelle Rangfolge wurde mittels %s (vgl. %s) ermittelt. Insgesamt wurden %d Paarvergleiche durchgeführt (Konsistenz der Bewertungen: %d%%, durchschnittliche Antwortzeit: %.2f Sekunden pro Vergleich).%s
Die höchste Priorität erhielt: %s. Die vollständige Rangreihe (mit Punktwerten) findest du unten.
%s
Literatur: %s",

    'apa_conflict_sentence_de' => " Bei %d Paaren wurden widersprüchliche Bewertungen festgestellt.",

    // Methoden & Literatur
    'method_bradleyterry_de'  => "dem Bradley-Terry-Modell",
    'method_thurstone_de'     => "dem Thurstone Case V Modell",
    'method_punkte_de'        => "einer einfachen Punktewertung",

    'citation_bradleyterry_de' => "Bradley & Terry (1952), Eidous & Al-Rawwash (2022)",
    'citation_thurstone_de'    => "Thurstone (1927), Eidous & Al-Rawwash (2022)",
    'citation_punkte_de'       => "Eidous & Al-Rawwash (2022)",

    'lit_bradleyterry_de' => "Bradley, R. A., & Terry, M. E. (1952). Rank Analysis of Incomplete Block Designs: I. The Method of Paired Comparisons. Biometrika, 39(3/4), 324-345. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
    'lit_thurstone_de'    => "Thurstone, L.L. (1927). A Law of Comparative Judgment. Psychological Review, 34, 273–286. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
    'lit_punkte_de'       => "Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",

    // Fehlermeldungen
    'error_not_found'     => 'Nicht gefunden',
    'error_no_set'        => 'Kein Kartenset gefunden.',
    'error_too_few_cards' => 'Zu wenig Karten im Set.',
    'finished'            => 'Fertig!',
    'see_results'         => 'Ergebnisse anzeigen',
    'comparison_question' => 'Welche Karte passt für dich eher?',

    // Bewertungstexte (Likert)
    'card1_much' => 'Linke Karte trifft viel mehr zu',
    'card1_some' => 'Linke Karte trifft eher zu',
    'card2_some' => 'Rechte Karte trifft eher zu',
    'card2_much' => 'Rechte Karte trifft viel mehr zu',

    // APA Ranking-Überschrift
    'apa_ranking_head_de' => 'Individuelle Rangreihe mit Punktwerten:',
];

// ----------------------
//       ENGLISH
// ----------------------

$lang += [
    'results'           => 'Results',
    'results_subtitle'  => 'Your individual ranking based on your pairwise comparisons.',
    'back_to_sets'      => 'Back to overview',
    'restart_set'       => 'Restart set',
    'export_results'    => 'Export results',
    'copy_output'       => 'Copy',
    'summary'           => 'Summary',
    'total_comparisons' => 'Total comparisons',
    'consistency'       => 'Consistency',
    'avg_time'          => 'Ø response time',

    // Conflicting pairs
    'conflict_pairs_title'     => 'Conflicting pairs detected!',
    'conflict_pairs_explainer' => 'For these pairs, you gave conflicting ratings in different runs. That happens – maybe the cards are similar, you were unsure, or your judgment varied.<br>
        <b>What to do?</b> You can restart the set and compare the pairs again if you want a clearer result. Otherwise, we still show you the best estimate of your ranking.',

    // Scientific result output (ENGLISH)
    'apa_results_en' =>
        "The individual ranking was determined using %s (see %s). A total of %d pairwise comparisons were conducted (consistency: %d%%, mean response time: %.2f seconds per comparison).%s
The highest ranked value was: %s. The complete ranking (with point values) is shown below.
%s
References: %s",

    'apa_conflict_sentence_en' => " There were conflicting judgments for %d pairs.",

    // Methods & references
    'method_bradleyterry_en'  => "the Bradley-Terry model",
    'method_thurstone_en'     => "the Thurstone Case V model",
    'method_punkte_en'        => "simple point scoring",

    'citation_bradleyterry_en' => "Bradley & Terry (1952), Eidous & Al-Rawwash (2022)",
    'citation_thurstone_en'    => "Thurstone (1927), Eidous & Al-Rawwash (2022)",
    'citation_punkte_en'       => "Eidous & Al-Rawwash (2022)",

    'lit_bradleyterry_en' => "Bradley, R. A., & Terry, M. E. (1952). Rank Analysis of Incomplete Block Designs: I. The Method of Paired Comparisons. Biometrika, 39(3/4), 324-345. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
    'lit_thurstone_en'    => "Thurstone, L.L. (1927). A Law of Comparative Judgment. Psychological Review, 34, 273–286. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
    'lit_punkte_en'       => "Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",

    // Error messages
    'error_not_found'     => 'Not found',
    'error_no_set'        => 'No card set found.',
    'error_too_few_cards' => 'Too few cards in the set.',
    'finished'            => 'Done!',
    'see_results'         => 'Show results',
    'comparison_question' => 'Which card fits you better?',

    // Likert button texts
    'card1_much' => 'Left card fits much better',
    'card1_some' => 'Left card fits better',
    'card2_some' => 'Right card fits better',
    'card2_much' => 'Right card fits much better',

    // APA ranking headline
    'apa_ranking_head_en' => 'Individual ranking (with point values):',
];
