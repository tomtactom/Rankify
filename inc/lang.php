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
    ]
];

// Übersetzungsfunktion
function t($key) {
    global $t, $lang;
    return $t[$lang][$key] ?? $key;
}
