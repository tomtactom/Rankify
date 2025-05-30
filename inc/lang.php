<?php
// KEIN LEERZEICHEN/BOM vor dieser Zeile!

// Setze die Sprache aus Cookie oder Standard
function getLanguage() {
    if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['de','en'])) {
        return $_COOKIE['lang'];
    }
    // Default: Deutsch
    return 'de';
}

$lang = getLanguage();

// Übersetzungen
$t = [
    'de' => [
        // Navigation, Allgemein
        'sets_overview' => 'Übersicht',
        'progress' => 'Fortschritt',
        'back_to_sets' => 'Zurück zur Übersicht',
        'finished' => 'Fertig!',
        'see_results' => 'Ergebnisse ansehen',
        'results' => 'Ergebnisse',
        'final_ranking' => 'Deine Rangfolge',
        'points' => 'Punkte',
        'export_data' => 'Daten exportieren',
        'avg_time' => 'Ø Antwortzeit pro Vergleich',
        'bias' => 'Seitenpräferenz',
        'no_bias' => 'Keine Seitenpräferenz',
        'summary' => 'Zusammenfassung',
        'total_pairs' => 'Vergleiche insgesamt',
        'consistent_pairs' => 'Paare konsistent',
        'inconsistent_pairs' => 'Widersprüchliche Paare',
        'votes' => 'Abstimmungen',
        'consistency' => 'Konsistenz',
        'consistency_warning' => 'Viele widersprüchliche Urteile.',
        'instructions_title' => 'Kurze Instruktion',
        'instructions_text' => 'Bitte vergleiche jeweils die beiden Karten und entscheide, welche dir wichtiger ist. Jedes Paar kann mehrmals auftauchen.',
        'instructions_continue' => 'Starten',
        'card1_much' => 'deutlich wichtiger',
        'card1_some' => 'eher wichtiger',
        'card2_some' => 'eher wichtiger',
        'card2_much' => 'deutlich wichtiger',
        'comparison_question' => 'Welches ist für dich wichtiger?',
        // Fehlertexte
        'error_no_set' => 'Kein Kartenset ausgewählt oder gefunden.',
        'error_not_found' => 'Fehler',
        'error_too_few_cards' => 'Das Kartenset enthält weniger als zwei Karten und kann nicht verglichen werden.',
        // Bias
        'bias_left' => 'Du hast auffällig häufig die linke Karte bevorzugt.',
        'bias_right' => 'Du hast auffällig häufig die rechte Karte bevorzugt.',

        'total_comparisons' => 'Anzahl der Vergleiche',
        'results_subtitle' => 'Deine individuelle Rangfolge auf Basis deiner Vergleiche.',
        'restart_set' => 'Set neu starten',
        'export_results' => 'Ergebnisse exportieren',
        'conflict_pairs_title' => 'Widersprüchliche Paare entdeckt!',
        'conflict_pairs_explainer' => 'Für diese Kartenpaare hast du in verschiedenen Durchgängen unterschiedlich abgestimmt. Das kommt vor – vielleicht weil die Karten ähnlich sind, du dir unsicher warst oder deine Bewertung variiert hat.<br><b>Was tun?</b> Du kannst das Set neu starten und die Paare nochmal vergleichen, falls du ein eindeutigeres Ergebnis möchtest. Ansonsten zeigen wir dir trotzdem die beste Schätzung deiner Rangfolge.',
        'apa_method_punkte_de' => 'Die Rangfolge wurde mit einer einfachen Punktewertung aus paarweisen Vergleichen ermittelt.',
        'apa_method_thurstone_de' => 'Die Rangfolge wurde nach Thurstone Case V mittels paarweiser Vergleiche erstellt.',
        'apa_method_bradleyterry_de' => 'Die Rangfolge wurde mit dem Bradley-Terry-Modell aus paarweisen Vergleichen berechnet.',
        'apa_summary_de' => 'Es wurden insgesamt %s Paarvergleiche durchgeführt. Die Konsistenz der Bewertungen beträgt %s%%.',
        'apa_avgtime_de' => 'Durchschnittliche Antwortzeit pro Vergleich: %s Sekunden.',
        'apa_conflict_hint_de' => 'Hinweis: Es wurden widersprüchliche Bewertungen bei %s Paaren gefunden.',
        'apa_ranking_head_de' => 'Individuelle Rangreihe mit Punktwerten:',
        'apa_lit_punkte' => "Literatur: Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
        'apa_lit_thurstone' => "Literatur: Thurstone, L.L. (1927). A Law of Comparative Judgment. Psychological Review, 34, 273–286. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
        'apa_lit_bradleyterry' => "Literatur: Bradley, R. A., & Terry, M. E. (1952). Rank Analysis of Incomplete Block Designs: I. The Method of Paired Comparisons. Biometrika, 39(3/4), 324-345. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",

    ],
    'en' => [
        // Navigation, General
        'sets_overview' => 'Overview',
        'progress' => 'Progress',
        'back_to_sets' => 'Back to overview',
        'finished' => 'Finished!',
        'see_results' => 'View results',
        'results' => 'Results',
        'final_ranking' => 'Your ranking',
        'points' => 'Points',
        'export_data' => 'Export data',
        'avg_time' => 'Ø Response time per comparison',
        'bias' => 'Side preference',
        'no_bias' => 'No side preference',
        'summary' => 'Summary',
        'total_pairs' => 'Total comparisons',
        'consistent_pairs' => 'Consistent pairs',
        'inconsistent_pairs' => 'Inconsistent pairs',
        'votes' => 'Votes',
        'consistency' => 'Consistency',
        'consistency_warning' => 'Many inconsistent decisions.',
        'instructions_title' => 'Short instruction',
        'instructions_text' => 'Please compare the two cards and decide which is more important to you. Each pair can appear multiple times.',
        'instructions_continue' => 'Start',
        'card1_much' => 'Left: much more important',
        'card1_some' => 'Left: rather more important',
        'card2_some' => 'Right: rather more important',
        'card2_much' => 'Right: much more important',
        'comparison_question' => 'Which is more important to you?',
        // Errors
        'error_no_set' => 'No card set selected or found.',
        'error_not_found' => 'Error',
        'error_too_few_cards' => 'The card set contains less than two cards and cannot be compared.',
        // Bias
        'bias_left' => 'You frequently preferred the left card.',
        'bias_right' => 'You frequently preferred the right card.',

        'apa_method_punkte_en' => 'Ranking was determined using simple point scoring from pairwise comparisons.',
        'apa_method_thurstone_en' => 'Ranking was determined by Thurstone’s Case V paired comparison model.',
        'apa_method_bradleyterry_en' => 'Ranking was determined using the Bradley-Terry model from pairwise comparisons.',
        'apa_summary_en' => 'A total of %s pairwise comparisons were performed. Consistency of judgments: %s%%.',
        'apa_avgtime_en' => 'Average response time per comparison: %s seconds.',
        'apa_conflict_hint_en' => 'Note: Conflicting ratings found for %s pairs.',
        'apa_ranking_head_en' => 'Individual ranking (with point values):',
        'apa_lit_punkte' => "References: Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
        'apa_lit_thurstone' => "References: Thurstone, L.L. (1927). A Law of Comparative Judgment. Psychological Review, 34, 273–286. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
        'apa_lit_bradleyterry' => "References: Bradley, R. A., & Terry, M. E. (1952). Rank Analysis of Incomplete Block Designs: I. The Method of Paired Comparisons. Biometrika, 39(3/4), 324-345. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
        'copy_output' => 'Copy',
    ]
];

// Übersetzungsfunktion
function t($key) {
    global $t, $lang;
    return $t[$lang][$key] ?? $key;
}
