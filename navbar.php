<?php
// KEIN LEERZEICHEN ODER BOM VOR DIESER ZEILE!
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="border-radius:0 0 1.5rem 1.5rem;">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php" style="font-size:1.3em;">
            <img src="assets/img/rankifmy-logo.png" alt="Logo" width="36" height="36" class="me-2" style="border-radius:0.7em;">
            Rankifmy
        </a>
        <span class="navbar-text d-none d-md-inline mx-2" style="color:#6383e0;font-size:1em;">
            Deine Reihenfolge, deine Entscheidung
        </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Navigation ein-/ausblenden">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Hier können weitere Navigationspunkte ergänzt werden -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><?=t('sets_overview') ?? 'Übersicht'?></a>
                </li>
                <li class="nav-item d-none d-md-inline">
                    <a class="nav-link" href="https://rankifmy.tomaschmann.de" target="_blank" rel="noopener">Projekt</a>
                </li>
                <!--
                <li class="nav-item">
                    <a class="nav-link" href="faq.php">FAQ</a>
                </li>
                -->
            </ul>
        </div>
    </div>
</nav>
