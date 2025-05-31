<?php
// Sprachsteuerung für Rankifmy

// 1. Sprachlogik
function getLanguage() {
    // Cookie (z.B. vom User gesetzt)
    if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['de', 'en'])) {
        return $_COOKIE['lang'];
    }
    // Query-Parameter
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['de', 'en'])) {
        return $_GET['lang'];
    }
    // Default
    return 'de';
}

// 2. Übersetzungsfunktion: Sucht immer erst "key_LANG", dann fallback "key"
function t($key) {
    global $lang;
    $langCode = getLanguage();
    if (isset($lang[$key . '_' . $langCode])) return $lang[$key . '_' . $langCode];
    if (isset($lang[$key])) return $lang[$key];
    return $key;
}

// Optional: sprintf für sprachsensitive Texte
if (!function_exists('langf')) {
    function langf($text, ...$args) { return vsprintf($text, $args); }
}

// 3. Das Spracharray (immer nur EIN Mal deklarieren!)
$lang = [
    // ---------- Navigation & Buttons ----------
    'results_de'           => 'Ergebnisse',
    'results_en'           => 'Results',
    'results_subtitle_de'  => 'Deine individuelle Rangfolge auf Basis deiner Vergleiche.',
    'results_subtitle_en'  => 'Your individual ranking based on your pairwise comparisons.',
    'back_to_sets_de'      => 'Zurück zur Übersicht',
    'back_to_sets_en'      => 'Back to overview',
    'restart_set_de'       => 'Set neu starten',
    'restart_set_en'       => 'Restart set',
    'export_results_de'    => 'Ergebnisse exportieren',
    'export_results_en'    => 'Export results',
    'copy_output_de'       => 'Kopieren',
    'copy_output_en'       => 'Copy',
    'summary_de'           => 'Zusammenfassung',
    'summary_en'           => 'Summary',
    'total_comparisons_de' => 'Anzahl der Vergleiche',
    'total_comparisons_en' => 'Total comparisons',
    'consistency_de'       => 'Konsistenz',
    'consistency_en'       => 'Consistency',
    'avg_time_de'          => 'Ø Antwortzeit',
    'avg_time_en'          => 'Ø response time',

    // ---------- Konflikt-Paare ----------
    'conflict_pairs_title_de'     => 'Widersprüchliche Paare entdeckt!',
    'conflict_pairs_title_en'     => 'Conflicting pairs detected!',
    'conflict_pairs_explainer_de' => 'Für diese Kartenpaare hast du in verschiedenen Durchgängen unterschiedlich abgestimmt. Das kommt vor – vielleicht weil die Karten ähnlich sind, du dir unsicher warst oder deine Bewertung variiert hat.<br>
        <b>Was tun?</b> Du kannst das Set neu starten und die Paare nochmal vergleichen, falls du ein eindeutigeres Ergebnis möchtest. Ansonsten zeigen wir dir trotzdem die beste Schätzung deiner Rangfolge.',
    'conflict_pairs_explainer_en' => 'For these pairs, you gave conflicting ratings in different runs. That happens – maybe the cards are similar, you were unsure, or your judgment varied.<br>
        <b>What to do?</b> You can restart the set and compare the pairs again if you want a clearer result. Otherwise, we still show you the best estimate of your ranking.',

    // ---------- Wissenschaftlicher Ergebnis-Output ----------
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

    // ---------- Methoden & Literatur ----------
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

    'lit_bradleyterry_de' => "Bradley, R. A., & Terry, M. E. (1952). Rank Analysis of Incomplete Block Designs: I. The Method of Paired Comparisons. Biometrika, 39(3/4), 324-345. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
    'lit_bradleyterry_en' => "Bradley, R. A., & Terry, M. E. (1952). Rank Analysis of Incomplete Block Designs: I. The Method of Paired Comparisons. Biometrika, 39(3/4), 324-345. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
    'lit_thurstone_de'    => "Thurstone, L.L. (1927). A Law of Comparative Judgment. Psychological Review, 34, 273–286. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
    'lit_thurstone_en'    => "Thurstone, L.L. (1927). A Law of Comparative Judgment. Psychological Review, 34, 273–286. Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
    'lit_punkte_de'       => "Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",
    'lit_punkte_en'       => "Eidous, O., & Al-Rawwash, M. (2022). Approximations for Standard Normal Distribution Function and Its Invertible. Computational Statistics & Data Analysis, 177, 107578. https://doi.org/10.1016/j.csda.2022.107578",

    // ---------- Fehler/Status ----------
    'error_not_found_de'     => 'Nicht gefunden',
    'error_not_found_en'     => 'Not found',
    'error_no_set_de'        => 'Kein Kartenset gefunden.',
    'error_no_set_en'        => 'No card set found.',
    'error_too_few_cards_de' => 'Zu wenig Karten im Set.',
    'error_too_few_cards_en' => 'Too few cards in the set.',
    'finished_de'            => 'Fertig!',
    'finished_en'            => 'Done!',
    'see_results_de'         => 'Ergebnisse anzeigen',
    'see_results_en'         => 'Show results',
    'comparison_question_de' => 'Welche Karte passt für dich eher?',
    'comparison_question_en' => 'Which card fits you better?',

    // ---------- Bewertungstexte (Likert) ----------
    // Mobile Likert (neutral, ohne Richtungen)
    'card_most_de'   => 'Trifft sehr zu',
    'card_more_de'   => 'Trifft eher zu',
    'card_less_de'   => 'Trifft eher zu',
    'card_least_de'  => 'Trifft sehr zu',
    'card_most_en'   => 'Fits very much',
    'card_more_en'   => 'Fits more',
    'card_less_en'   => 'Fits more',
    'card_least_en'  => 'Fits very much',


    // ---------- APA Ranking Überschrift ----------
    'apa_ranking_head_de' => 'Individuelle Rangreihe mit Punktwerten:',
    'apa_ranking_head_en' => 'Individual ranking (with point values):',

    // Instruktionen
    'instructions_title_de' => 'Kurze Anleitung',
    'instructions_title_en' => 'Quick Instructions',
    'instructions_text_de' =>
    'Du siehst immer zwei Karten und entscheidest: <b>Welche passt für dich eher?</b><br>Nutze die Buttons, um anzugeben, welche Karte besser zu dir passt.',
    'instructions_text_en' =>
    'You will always see two cards. Decide: <b>Which one fits you better?</b><br>Use the buttons to indicate which card is more important for you.',
    'instruction_continue_de' => 'Weiter',
    'instruction_continue_en' => 'Continue',

];
