<?php
// Sprachsteuerung für Rankifmy

// 1. Sprachlogik mit Cookie-Save (nur Cookie setzen, wenn noch kein Output!)
function getLanguage() {
    // Sprache per GET-Parameter (setzt Cookie für 1 Jahr)
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['de', 'en'])) {
        // Nur Cookie setzen, wenn noch keine Header gesendet wurden:
        if (!headers_sent()) {
            setcookie('lang', $_GET['lang'], time() + 365*24*60*60, '/');
        }
        return $_GET['lang'];
    }
    if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['de', 'en'])) {
        return $_COOKIE['lang'];
    }
    return 'de';
}

function t($key) {
    global $lang;
    $langCode = getLanguage();
    if (isset($lang[$key . '_' . $langCode])) return $lang[$key . '_' . $langCode];
    if (isset($lang[$key])) return $lang[$key];
    return $key;
}

if (!function_exists('langf')) {
    function langf($text, ...$args) { return vsprintf($text, $args); }
}

// Alle Sprach-Keys für index.php, compare.php, results.php, navbar.php
$lang = [
    // -------- Navigation, Titles, Basics --------
    'app_title_de'           => 'Rankify',
    'app_title_en'           => 'Rankify',
    'sets_overview'          => 'Rankify',
    'slogan_de'              => 'Deine Reihenfolge, deine Entscheidung',
    'slogan_en'              => 'Your ranking, your choice',
    'navbar_results_de'      => 'Ergebnisse',
    'navbar_results_en'      => 'Results',
    'back_to_sets_de'        => 'Zurück zur Übersicht',
    'back_to_sets_en'        => 'Back to overview',
    'restart_set_de'         => 'Set neu starten',
    'restart_set_en'         => 'Restart set',
    'export_results_de'      => 'Ergebnisse exportieren',
    'export_results_en'      => 'Export results',
    'copy_output_de'         => 'Kopieren',
    'copy_output_en'         => 'Copy',

    // -------- Fortschritt & Status --------
    'progress_de'            => 'Fortschritt',
    'progress_en'            => 'Progress',
    'finished_de'            => 'Fertig!',
    'finished_en'            => 'Done!',
    'see_results_de'         => 'Ergebnisse anzeigen',
    'see_results_en'         => 'Show results',

    // -------- Übersicht / Index --------
    'available_sets_de'      => 'Verfügbare Kartensets',
    'available_sets_en'      => 'Available Card Sets',
    'continue_de'            => 'Weiter',
    'continue_en'            => 'Continue',
    'no_sets_de'             => 'Keine Kartensets gefunden.',
    'no_sets_en'             => 'No card sets found.',
    'set_language_de'        => 'Sprache',
    'set_language_en'        => 'Language',

    // -------- Fehler/Status --------
    'error_not_found_de'     => 'Nicht gefunden',
    'error_not_found_en'     => 'Not found',
    'error_no_set_de'        => 'Kein Kartenset gefunden.',
    'error_no_set_en'        => 'No card set found.',
    'error_too_few_cards_de' => 'Zu wenig Karten im Set.',
    'error_too_few_cards_en' => 'Too few cards in the set.',

    // -------- Vergleich & Bewertung --------
    'comparison_question_de' => 'Welche Karte passt für dich eher?',
    'comparison_question_en' => 'Which card fits you better?',

    // -------- Bewertungstexte (Likert) - Mobile (neutral, kurz) --------
    'this_card_much_de'    => 'Voll zu',
    'this_card_some_de'    => 'Eher zu',
    'other_card_some_de'   => 'Eher zu',
    'other_card_much_de'   => 'Voll zu',
    'this_card_much_en'    => 'Strongly this',
    'this_card_some_en'    => 'Somewhat this',
    'other_card_some_en'   => 'Somewhat this',
    'other_card_much_en'   => 'Strongly this',

    // -------- Bewertungstexte (Likert) - Desktop (optional) --------
    'card1_much_de'        => 'Voll zu',
    'card1_some_de'        => 'Eher zu',
    'card2_some_de'        => 'Eher zu',
    'card2_much_de'        => 'Voll zu',
    'card1_much_en'        => 'Strongly',
    'card1_some_en'        => 'Somewhat',
    'card2_some_en'        => 'Somewhat',
    'card2_much_en'        => 'Strongly',

    // -------- Instruktionen --------
    'instructions_title_de' => 'Kurze Anleitung',
    'instructions_title_en' => 'Quick Instructions',
    'instructions_text_de'  => 'Du siehst immer zwei Karten und entscheidest: <b>Welche passt für dich eher?</b><br>Nutze die Buttons, um anzugeben, welche Karte besser zu dir passt.',
    'instructions_text_en'  => 'You will always see two cards. Decide: <b>Which one fits you better?</b><br>Use the buttons to indicate which card is more important for you.',
    'instruction_continue_de' => 'Weiter',
    'instruction_continue_en' => 'Continue',

    // -------- Results/Results.php --------
    'results_de'           => 'Ergebnisse',
    'results_en'           => 'results',
    'results_subtitle_de'  => 'Deine individuelle Rangfolge auf Basis deiner Vergleiche.',
    'results_subtitle_en'  => 'Your individual ranking based on your pairwise comparisons.',
    'total_comparisons_de' => 'Anzahl der Vergleiche',
    'total_comparisons_en' => 'Total comparisons',
    'consistency_de'       => 'Konsistenz',
    'consistency_en'       => 'Consistency',
    'avg_time_de'          => 'Ø Antwortzeit',
    'avg_time_en'          => 'Ø response time',
    'summary_de'           => 'Zusammenfassung',
    'summary_en'           => 'Summary',

    // -------- Konflikt-Paare --------
    'conflict_pairs_title_de'     => 'Widersprüchliche Paare entdeckt!',
    'conflict_pairs_title_en'     => 'Conflicting pairs detected!',
    'conflict_pairs_explainer_de' =>
        'Für diese Kartenpaare hast du in verschiedenen Durchgängen unterschiedlich abgestimmt. Das kommt vor – vielleicht weil die Karten ähnlich sind, du dir unsicher warst oder deine Bewertung variiert hat.<br>
        <b>Was tun?</b> Du kannst das Set neu starten und die Paare nochmal vergleichen, falls du ein eindeutigeres Ergebnis möchtest. Ansonsten zeigen wir dir trotzdem die beste Schätzung deiner Rangfolge.',
    'conflict_pairs_explainer_en' =>
        'For these pairs, you gave conflicting ratings in different runs. That happens – maybe the cards are similar, you were unsure, or your judgment varied.<br>
        <b>What to do?</b> You can restart the set and compare the pairs again if you want a clearer result. Otherwise, we still show you the best estimate of your ranking.',

    // -------- APA/Export Output --------
    'apa_results_de' =>
        "Die individuelle Rangfolge wurde mittels %s (vgl. %s) ermittelt. Insgesamt wurden %d Paarvergleiche durchgeführt (Konsistenz der Bewertungen: %d%%, durchschnittliche Antwortzeit: %.2f Sekunden pro Vergleich).%s
Die höchste Priorität erhielt: %s. Die vollständige Rangreihe (mit Punktwerten) ist unten abgebildet.
%s
Literatur: %s",
    'apa_results_en' =>
        "The individual ranking was determined using %s (see %s). A total of %d pairwise comparisons were conducted (consistency: %d%%, mean response time: %.2f seconds per comparison).%s
The highest ranked value was: %s. The complete ranking (with point values) is shown below.
%s
References: %s",
    'apa_conflict_sentence_de' => " Bei %d Paaren wurden widersprüchliche Bewertungen festgestellt.",
    'apa_conflict_sentence_en' => " There were conflicting judgments for %d pairs.",
    'apa_ranking_head_de'      => 'Individuelle Rangreihe mit Punktwerten:',
    'apa_ranking_head_en'      => 'Individual ranking (with point values):',

    // -------- Methoden & Literatur --------
    'method_bradleyterry_de'  => "dem Bradley-Terry-Modell",
    'method_bradleyterry_en'  => "the Bradley-Terry model",
    'method_thurstone_de'     => "dem Thurstone Case V Modell",
    'method_thurstone_en'     => "the Thurstone Case V model",
    'method_punkte_de'        => "einer einfachen Punktewertung",
    'method_punkte_en'        => "simple point scoring",

    'citation_bradleyterry_de' => "Bradley & Terry (1952), Eidous & Al-Rawwash (2022)",
    'citation_bradleyterry_en' => "Bradley & Terry (1952), Eidous & Al-Rawwash (2022)",
    'citation_thurstone_de'    => "Thurstone (1927), Eidous & Al-Rawwash (2022)",
    'citation_thurstone_en'    => "Thurstone (1927), Eidous & Al-Rawwash (2022)",
    'citation_punkte_de'       => "Eidous & Al-Rawwash (2022)",
    'citation_punkte_en'       => "Eidous & Al-Rawwash (2022)",

    'lit_bradleyterry_de' => "Bradley, R. A. & Terry, M. E. (1952). Rank Analysis of Incomplete Block Designs: I. The Method of Paired Comparisons. Biometrika, 39(3/4), 324. https://doi.org/10.2307/2334029. Eidous, O., & Al-Rawwash, M. (2022). Eidous, O. M. & Al-Rawash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. arXiv (Cornell University). https://doi.org/10.48550/arxiv.2206.12601",
    'lit_bradleyterry_en' => "Bradley, R. A. & Terry, M. E. (1952). Rank Analysis of Incomplete Block Designs: I. The Method of Paired Comparisons. Biometrika, 39(3/4), 324. https://doi.org/10.2307/2334029. Eidous, O., & Al-Rawwash, M. (2022). Eidous, O. M. & Al-Rawash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. arXiv (Cornell University). https://doi.org/10.48550/arxiv.2206.12601",
    'lit_thurstone_de'    => "Thurstone, L. L. (1927). A law of comparative judgment. Psychological Review, 34(4), 273–286. https://doi.org/10.1037/h0070288. Eidous, O. M. & Al-Rawash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. arXiv (Cornell University). https://doi.org/10.48550/arxiv.2206.12601",
    'lit_thurstone_en'    => "Thurstone, L. L. (1927). A law of comparative judgment. Psychological Review, 34(4), 273–286. https://doi.org/10.1037/h0070288. Eidous, O. M. & Al-Rawash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. arXiv (Cornell University). https://doi.org/10.48550/arxiv.2206.12601",
    'lit_punkte_de'       => "Eidous, O. M. & Al-Rawash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. arXiv (Cornell University). https://doi.org/10.48550/arxiv.2206.12601",
    'lit_punkte_en'       => "Eidous, O. M. & Al-Rawash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. arXiv (Cornell University). https://doi.org/10.48550/arxiv.2206.12601",
];
