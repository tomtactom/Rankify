<?php
// Keine Header setzen hier!
// Sprach-Text via t('...'), Annahme: lang.php schon inkludiert!
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="border-radius:0 0 1.5rem 1.5rem;">
    <div class="container">
        <!-- Logo & Slogan -->
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php" style="font-size:1.3em;">
            <img src="assets/img/rankifmy-logo.png" alt="Logo" width="36" height="36" class="me-2" style="border-radius:0.7em;">
            Rankifmy
        </a>
        <span class="navbar-text d-none d-md-inline mx-2" style="color:#6383e0;font-size:1em;">
            <?=t('slogan') ?: 'Deine Reihenfolge, deine Entscheidung'?>
        </span>

        <!-- Toggler für Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Navigation ein-/ausblenden">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Hauptnavigation -->
        <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">

                <li class="nav-item">
                    <a class="nav-link" href="index.php"><?=t('sets_overview') ?? 'Übersicht'?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="results.php"><?=t('results') ?? 'Ergebnisse'?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="faq.php"><?=t('faq') ?? 'FAQ'?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kontakt.php"><?=t('contact') ?? 'Kontakt'?></a>
                </li>

                <!-- Sprache- & Theme-Switcher -->
                <li class="nav-item dropdown d-flex align-items-center">
                    <!-- Sprache (kein Flaggen!) -->
                    <select id="lang-switcher" class="form-select form-select-sm me-2" style="width:auto;min-width:70px;">
                        <option value="de"<?=getLanguage()=='de'?' selected':''?>>Deutsch</option>
                        <option value="en"<?=getLanguage()=='en'?' selected':''?>>English</option>
                    </select>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <!-- Theme Switcher -->
                    <select id="theme-switcher" class="form-select form-select-sm" style="width:auto;min-width:70px;">
                        <option value="light">🌞</option>
                        <option value="dark">🌚</option>
                        <option value="rainbow">🌈</option>
                    </select>
                </li>
                <!-- Optional User Avatar / Profil-Link -->
                <li class="nav-item ms-2">
                    <a href="profil.php">
                        <img src="assets/img/user-avatar.png" alt="Avatar" width="36" height="36"
                             style="border-radius:50%;border:1.5px solid #e2e6f0;">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="assets/js/theme.js"></script>
<script>
    // ---- LANGUAGE SWITCH ----
    document.getElementById('lang-switcher').addEventListener('change', function () {
        document.cookie = "lang=" + this.value + ";path=/;max-age=" + (365*24*60*60);
        location.reload();
    });
    // ---- THEME SWITCH handled in theme.js ----
</script>
