<?php
// Stelle sicher, dass Bootstrap 5 JS und CSS geladen sind (header/footer!)
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rank-navbar" style="border-radius:0 0 1.5rem 1.5rem;">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php" style="font-size:1.3em;">
            <img src="assets/img/rankifmy-logo.png" alt="Logo" width="36" height="36" class="me-2" style="border-radius:0.7em;">
            Rankifmy
        </a>
        <span class="navbar-text d-none d-md-inline mx-2 nav-claim" style="color:#6383e0;font-size:1em;">
            Deine Reihenfolge, deine Entscheidung
        </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Menü öffnen/schließen">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto align-items-center gap-1 gap-md-2">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><?=t('sets_overview') ?? 'Übersicht'?></a>
                </li>
                <li class="nav-item d-none d-md-inline">
                    <a class="nav-link" href="https://rankify.tomaschmann.de" target="_blank" rel="noopener">Projekt</a>
                </li>
                <li class="nav-item d-none d-md-inline">
                    <a class="nav-link" href="faq.php">FAQ</a>
                </li>
                <li class="nav-item d-none d-md-inline">
                    <a class="nav-link" href="kontakt.php">Kontakt</a>
                </li>
                <!-- Theme-Switcher -->
                <li class="nav-item mx-1">
                    <button class="btn btn-navbar btn-sm" id="themeSwitcher" title="Theme wechseln" aria-label="Theme wechseln">
                        <span id="themeIcon" style="font-size:1.25em;">🌈</span>
                    </button>
                </li>
                <!-- Language Switcher (NO FLAG) -->
                <li class="nav-item mx-1">
                    <button class="btn btn-navbar btn-sm" id="langSwitcher" title="Sprache wechseln" aria-label="Sprache wechseln">
                        <span id="langLabel"><?= strtoupper(getLanguage()) ?></span>
                    </button>
                </li>
                <!-- Account-Icon mit Tooltip -->
                <li class="nav-item mx-1">
                    <a class="btn btn-navbar btn-sm" href="account.php" title="Account/Profil" aria-label="Account/Profil">
                        <span style="font-size:1.22em;">🙋‍♂️</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
