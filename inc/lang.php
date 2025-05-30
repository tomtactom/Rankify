<?php
// Sprachdatei für Rankifmy – DE & EN

function t($key) {
    global $lang;
    return $lang[$key] ?? $key;
}

if (!function_exists('langf')) {
    function langf($text, ...$args) {
        return vsprintf($text, $args);
    }
}

// Das Spracharray **nur einmal deklarieren!**
$lang = [
    // --- Deutsch ---
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
    // ... (alles weitere DE, wie im letzten Beispiel)
    'conflict_pairs_title'     => 'Widersprüchliche Paare entdeckt!',
    'conflict_pairs_explainer' => 'Für diese Kartenpaare hast du in verschiedenen Durchgängen unterschiedlich abgestimmt. ...',
    'apa_results_de' =>
        "Die individuelle Rangfolge wurde mittels %s (vgl. %s) ermittelt. Insgesamt wurden %d Paarvergleiche durchgeführt (Konsistenz der Bewertungen: %d%%, durchschnittliche Antwortzeit: %.2f Sekunden pro Vergleich).%s
Die höchste Priorität erhielt: %s. Die vollständige Rangreihe (mit Punktwerten) findest du unten.
%s
Literatur: %s",
    'apa_conflict_sentence_de' => " Bei %d Paaren wurden widersprüchliche Bewertungen festgestellt.",
    'method_bradleyterry_de'  => "dem Bradley-Terry-Modell",
    'method_thurstone_de'     => "dem Thurstone Case V Modell",
    'method_punkte_de'        => "einer einfachen Punktewertung",
    'citation_bradleyterry_de' => "Bradley & Terry (1952), Eidous & Al-Rawwash (2022)",
    'citation_thurstone_de'    => "Thurstone (1927), Eidous & Al-Rawwash (2022)",
    'citation_punkte_de'       => "Eidous & Al-Rawwash (2022)",
    'lit_bradleyterry_de' => "...",
    'lit_thurstone_de'    => "...",
    'lit_punkte_de'       => "...",
    'error_not_found'     => 'Nicht gefunden',
    'error_no_set'        => 'Kein Kartenset gefunden.',
    'error_too_few_cards' => 'Zu wenig Karten im Set.',
    'finished'            => 'Fertig!',
    'see_results'         => 'Ergebnisse anzeigen',
    'comparison_question' => 'Welche Karte passt für dich eher?',
    'card1_much' => 'Linke Karte trifft viel mehr zu',
    'card1_some' => 'Linke Karte trifft eher zu',
    'card2_some' => 'Rechte Karte trifft eher zu',
    'card2_much' => 'Rechte Karte trifft viel mehr zu',
    'apa_ranking_head_de' => 'Individuelle Rangreihe mit Punktwerten:',

    // --- Englisch ---
    'results_en'           => 'Results',
    'results_subtitle_en'  => 'Your individual ranking based on your pairwise comparisons.',
    'back_to_sets_en'      => 'Back to overview',
    'restart_set_en'       => 'Restart set',
    'export_results_en'    => 'Export results',
    'copy_output_en'       => 'Copy',
    'summary_en'           => 'Summary',
    'total_comparisons_en' => 'Total comparisons',
    'consistency_en'       => 'Consistency',
    'avg_time_en'          => 'Ø response time',
    'conflict_pairs_title_en'     => 'Conflicting pairs detected!',
    'conflict_pairs_explainer_en' => 'For these pairs, you gave conflicting ratings ...',
    'apa_results_en' =>
        "The individual ranking was determined using %s (see %s). A total of %d pairwise comparisons were conducted (consistency: %d%%, mean response time: %.2f seconds per comparison).%s
The highest ranked value was: %s. The complete ranking (with point values) is shown below.
%s
References: %s",
    'apa_conflict_sentence_en' => " There were conflicting judgments for %d pairs.",
    'method_bradleyterry_en'  => "the Bradley-Terry model",
    'method_thurstone_en'     => "the Thurstone Case V model",
    'method_punkte_en'        => "simple point scoring",
    'citation_bradleyterry_en' => "Bradley & Terry (1952), Eidous & Al-Rawwash (2022)",
    'citation_thurstone_en'    => "Thurstone (1927), Eidous & Al-Rawwash (2022)",
    'citation_punkte_en'       => "Eidous & Al-Rawwash (2022)",
    'lit_bradleyterry_en' => "...",
    'lit_thurstone_en'    => "...",
    'lit_punkte_en'       => "...",
    'error_not_found_en'     => 'Not found',
    'error_no_set_en'        => 'No card set found.',
    'error_too_few_cards_en' => 'Too few cards in the set.',
    'finished_en'            => 'Done!',
    'see_results_en'         => 'Show results',
    'comparison_question_en' => 'Which card fits you better?',
    'card1_much_en' => 'Left card fits much better',
    'card1_some_en' => 'Left card fits better',
    'card2_some_en' => 'Right card fits better',
    'card2_much_en' => 'Right card fits much better',
    'apa_ranking_head_en' => 'Individual ranking (with point values):',
];
