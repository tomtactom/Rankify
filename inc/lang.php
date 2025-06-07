<?php
// Sprachsteuerung für Rankifmy

// 1. Sprachlogik mit Cookie-Save (nur Cookie setzen, wenn noch kein Output!)
function getLanguage() {
    // Sprache nur über Cookie, Default = de
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
    'start_cardset_de'       => 'Kartenset starten',
    'start_cardset_en'       => 'start cardset',

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

    // ===== Demografie-Formular =====
    'demographic_title_de'   => 'Demografische Angaben',
    'demographic_title_en'   => 'Demographic information',

    'demographic_instruction_title_de' => 'Warum fragen wir nach diesen Daten?',
    'demographic_instruction_title_en' => 'Why do we ask for this information?',

    'demographic_instruction_text_de' =>
        'Indem du uns einige anonyme Angaben machst, hilfst du mit, die Ergebnisse besser vergleichbar und nützlicher zu machen.
        Wir möchten möglichst viele Menschen unterstützen, die eigene Rangfolge zu verstehen und einzuordnen.
        Deine Angaben werden nur pseudonymisiert gespeichert und dienen ausschließlich wissenschaftlichen Zwecken (Empathie-Altruismus-Hypothese: Wer sich in andere hineinversetzen kann, hilft eher – und gemeinsames Vergleichen hilft uns allen).
        Die Angabe ist freiwillig, aber jeder Beitrag stärkt den Wert dieser Auswertung für alle.
        Wohnort wird – falls möglich – automatisch erkannt.',

    'demographic_instruction_text_en' =>
        'By providing some anonymous information, you help us make results more comparable and valuable.
        Our goal is to support as many people as possible in understanding and interpreting their own rankings.
        Your data is stored only in a pseudonymized way and used for scientific purposes only (Empathy-Altruism Hypothesis: The more we can understand each other, the more we help – and collective comparison benefits everyone).
        Sharing this info is voluntary, but every answer makes these results more meaningful for all.
        Location is detected automatically, if possible.',

    'demographic_age_de'     => 'Wie alt bist du? (in Jahren)',
    'demographic_age_en'     => 'How old are you? (in years)',

    'demographic_gender_de'  => 'Welchem Geschlecht fühlst du dich zugehörig?',
    'demographic_gender_en'  => 'Which gender do you identify with?',

    'demographic_nosay_de'   => 'Keine Angabe',
    'demographic_nosay_en'   => 'Prefer not to say',

    'demographic_female_de'  => 'weiblich',
    'demographic_female_en'  => 'female',

    'demographic_male_de'    => 'männlich',
    'demographic_male_en'    => 'male',

    'demographic_diverse_de' => 'divers',
    'demographic_diverse_en' => 'diverse',

    'demographic_edu_de'     => 'Welchen höchsten Abschluss hast du?',
    'demographic_edu_en'     => 'What is your highest degree?',

    'demographic_edu_none_de'     => 'Kein Schulabschluss',
    'demographic_edu_none_en'     => 'No school degree',

    'demographic_edu_haupt_de'    => 'Hauptschulabschluss',
    'demographic_edu_haupt_en'    => 'Lower secondary school certificate',

    'demographic_edu_realschule_de' => 'Mittlere Reife / Realschulabschluss',
    'demographic_edu_realschule_en' => 'Intermediate secondary school certificate',

    'demographic_edu_abi_de'      => 'Allgemeine Hochschulreife (Abitur)',
    'demographic_edu_abi_en'      => 'High school diploma (Abitur/A-levels)',

    'demographic_edu_voc_de'      => 'Berufsausbildung (mit Abschluss)',
    'demographic_edu_voc_en'      => 'Vocational training (with diploma)',

    'demographic_edu_studium_de'  => 'Studium (Bachelor / Master / Diplom)',
    'demographic_edu_studium_en'  => 'University degree (Bachelor/Master/Diploma)',

    'demographic_edu_phd_de'      => 'Promotion (Doktorgrad)',
    'demographic_edu_phd_en'      => 'Doctorate (PhD)',

    'demographic_edu_other_de'    => 'Sonstiger Abschluss',
    'demographic_edu_other_en'    => 'Other degree',

    'demographic_submit_de'       => 'Weiter zu den Ergebnissen',
    'demographic_submit_en'       => 'Continue to results',

    'slogan_de' => 'Deine Reihenfolge, deine Entscheidung',
    'slogan_en' => 'Your order, your choice',
    'sets_overview_de' => 'Übersicht',
    'sets_overview_en' => 'Overview',
    'faq_de' => 'FAQ',
    'faq_en' => 'FAQ',
    'contact_de' => 'Kontakt',
    'contact_en' => 'Contact',
    'demographic_note_de' => 'Diese Angaben sind freiwillig und werden nur pseudonymisiert zur Verbesserung der Vergleichswerte verwendet.',
    'demographic_note_en' => 'This informations are optional and they\'re only used in pseudonymized form to improve the comparative values.',

    // ------ FAQ ------
    'faq_title_de'  => 'Häufige Fragen',
    'faq_title_en'  => 'Frequently Asked Questions',
    'faq_intro_de'  => 'Hier findest du Antworten auf die wichtigsten Fragen rund um Rankify und die zugrunde liegenden Methoden.',
    'faq_intro_en'  => 'Here you can find answers to the most important questions about Rankify and its underlying methods.',
    'faq_q1_de'     => 'Was ist Rankify?',
    'faq_q1_en'     => 'What is Rankify?',
    'faq_a1_de'     => 'Rankify hilft dir, Prioritäten transparent zu machen. Durch Paarvergleiche ermittelst du spielerisch eine Rangfolge deiner Optionen.',
    'faq_a1_en'     => 'Rankify helps you uncover your priorities. By making pairwise comparisons, you generate a ranked order of your options in a playful way.',
    'faq_q2_de'     => 'Wie funktioniert die Methode?',
    'faq_q2_en'     => 'How does the method work?',
    'faq_a2_de'     => 'Unsere Berechnung orientiert sich an etablierten Modellen des Paarvergleichs wie Thurstone und Bradley–Terry. Moderne Varianten nutzen auch Algorithmen aus dem maschinellen Lernen, zum Beispiel "Pairwise comparison based ranking and scoring algorithms" (2021, DOI:10.31219/osf.io/ev7fw).',
    'faq_a2_en'     => 'Our calculations build on established paired-comparison models such as Thurstone and Bradley–Terry. Modern variants also use machine learning, for example "Pairwise comparison based ranking and scoring algorithms" (2021, DOI:10.31219/osf.io/ev7fw).',
    'faq_q3_de'     => 'Sind meine Daten sicher?',
    'faq_q3_en'     => 'Are my data secure?',
    'faq_a3_de'     => 'Ja. Es werden nur anonyme Daten gespeichert, um dir und anderen bessere Vergleiche zu ermöglichen. Details findest du in unserer Datenschutzerklärung.',
    'faq_a3_en'     => 'Yes. Only anonymous data are stored to provide better comparisons for you and others. See our privacy policy for details.',
    'faq_q4_de'     => 'Welche psychologischen Hintergründe gibt es?',
    'faq_q4_en'     => 'Which psychological background is behind it?',
    'faq_a4_de'     => 'Paarvergleiche werden seit über hundert Jahren genutzt, um subjektive Bewertungen messbar zu machen. Sie stammen aus der Entscheidungsforschung und zeigen latente Vorlieben. Neuere Studien untersuchen zudem kognitive Biases und neuropsychologische Mechanismen.',
    'faq_a4_en'     => 'Pairwise comparisons have been used for over a century to quantify subjective judgments. The approach stems from decision research and reveals latent preferences. Recent studies also examine cognitive biases and neuropsychological mechanisms.',
    'faq_q5_de'     => 'Was hat das mit Mathematik zu tun?',
    'faq_q5_en'     => 'What does this have to do with mathematics?',
    'faq_a5_de'     => 'Hinter den Ranglisten stecken statistische Modelle. Aus deinen Entscheidungen werden Punktwerte und Wahrscheinlichkeiten berechnet, um eine stabile Reihenfolge zu schätzen. Siehe z. B. Thurstone (1927) oder Bradley & Terry (1952).',
    'faq_a5_en'     => 'Statistical models underlie the rankings. From your choices we compute scores and probabilities to estimate a stable order. See, for example, Thurstone (1927) or Bradley & Terry (1952).',
    'faq_q6_de'     => 'Warum ist das pädagogisch sinnvoll?',
    'faq_q6_en'     => 'Why is this educationally useful?',
    'faq_a6_de'     => 'Durch bewusstes Vergleichen reflektierst du deine Werte. Diese Selbstreflexion fördert eigenverantwortliche Entscheidungen und kann in der Bildungsarbeit oder Beratung eingesetzt werden.',
    'faq_a6_en'     => 'By comparing options you reflect on your values. Such self-reflection fosters autonomous decisions and can be used in educational settings or counselling.',
    'faq_q7_de'     => 'Was bedeutet Ranking neuropsychologisch?',
    'faq_q7_en'     => 'What does ranking mean neuropsychologically?',
    'faq_a7_de'     => 'Beim Priorisieren werden Belohnungs- und Bewertungssysteme im Gehirn aktiviert. Indem du Alternativen gegeneinander abwägst, trainierst du die Fähigkeit zur Selbstregulation.',
    'faq_a7_en'     => 'Prioritizing activates reward and evaluation systems in your brain. By weighing alternatives you train self-regulation abilities.',
    'faq_q8_de'     => 'Welches Ziel hat diese Seite?',
    'faq_q8_en'     => 'What is the goal of this site?',
    'faq_a8_de'     => 'Rankify soll dir einen einfachen Zugang zu Methoden bieten, mit denen du persönliche Prioritäten erkennen und mit anderen diskutieren kannst. Alle Funktionen sind frei nutzbar und sollen zum Nachdenken anregen.',
    'faq_a8_en'     => 'Rankify aims to provide easy access to methods that help you discover your personal priorities and discuss them with others. All features are free to use and encourage reflection.',
    'faq_q9_de'     => 'Welche aktuellen Entwicklungen gibt es in der Forschung?',
    'faq_q9_en'     => 'What are recent developments in research?',
    'faq_a9_de'     => 'Aktuelle Arbeiten befassen sich mit adaptiven Verfahren, Machine-Learning-Methoden und neuen Skalierungsansätzen. Ein Beispiel ist "Pairwise comparison based ranking and scoring algorithms" (2021, DOI:10.31219/osf.io/ev7fw).',
    'faq_a9_en'     => 'Recent studies address adaptive methods, machine learning techniques and new scaling approaches. An example is "Pairwise comparison based ranking and scoring algorithms" (2021, DOI:10.31219/osf.io/ev7fw).',
    'faq_q10_de'    => 'Wo finde ich weiterführende Literatur?',
    'faq_q10_en'    => 'Where can I find further reading?',
    'faq_a10_de'    => 'Siehe u. a. Thurstone (1927), Bradley & Terry (1952) sowie Maydeu-Olivares & Brown (2010) und weitere aktuelle Veröffentlichungen zu Paarvergleichsmodellen.',
    'faq_a10_en'    => 'See, for example, Thurstone (1927), Bradley & Terry (1952) and Maydeu-Olivares & Brown (2010) as well as more recent publications on paired-comparison models.',
];
