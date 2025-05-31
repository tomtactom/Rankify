<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
  <meta charset="UTF-8">
  <title>Rankify – <?=t('sets_overview')?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Grundlegende Meta-Tags -->
  <meta name="description" content="Rankify unterstützt dich, persönliche Werte und Prioritäten transparent herauszufinden. Einfach, anonym und wissenschaftlich fundiert.">
  <meta name="author" content="Tom Aschmann">
  <meta name="copyright" content="&copy; <?=date('Y')?> Rankify">
  <meta name="robots" content="index, follow">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="referrer" content="strict-origin-when-cross-origin">
  <meta http-equiv="Content-Language" content="<?=getLanguage()?>">

  <!-- SEO: Canonical, Language (für Mehrsprachigkeit) -->
  <link rel="canonical" href="https://rankify.tomaschmann.de<?=htmlspecialchars($_SERVER['REQUEST_URI'])?>">

  <!-- Open Graph / Facebook / LinkedIn -->
  <meta property="og:title" content="Rankify – Finde deine Prioritäten">
  <meta property="og:description" content="Ranke und vergleiche deine Werte, Entscheidungen oder Ziele. Kostenlos & anonym.">
  <meta property="og:image" content="https://rankify.tomaschmann.de/assets/img/rankifmy-logo.png">
  <meta property="og:url" content="https://rankify.tomaschmann.de<?=htmlspecialchars($_SERVER['REQUEST_URI'])?>">
  <meta property="og:type" content="website">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Rankify – Finde deine Prioritäten">
  <meta name="twitter:description" content="Ranke und vergleiche deine Werte, Entscheidungen oder Ziele. Kostenlos & anonym.">
  <meta name="twitter:image" content="https://rankify.tomaschmann.de/assets/img/rankifmy-logo.png">

  <!-- Theme Colors -->
  <meta name="theme-color" content="#2E5BDA" id="meta-theme-color">
  <meta name="msapplication-TileColor" content="#2E5BDA">
  <meta name="msapplication-TileImage" content="/assets/fav/ms-icon-144x144.png">

  <!-- Apple WebApp -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="Rankify">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">

  <!-- Favicon & PWA Manifest -->
  <link rel="manifest" href="/assets/fav/manifest.json">
  <link rel="apple-touch-icon" sizes="57x57" href="/assets/fav/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/assets/fav/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/assets/fav/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/assets/fav/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/assets/fav/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/assets/fav/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/assets/fav/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/assets/fav/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/fav/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/assets/fav/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/fav/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/assets/fav/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/fav/favicon-16x16.png">

  <!-- Preconnects und Prefetch für Performance -->
  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- CSS & JS -->
  <!-- Bootstrap 5.3.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap 5.3.3 JS + Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="/assets/js/theme.js"></script>
  <script src="/assets/js/lang.js"></script>


  <!-- Progressive Enhancement / Accessibility (z.B. Schema.org, falls gewünscht) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebApplication",
    "name": "Rankify",
    "url": "https://rankify.tomaschmann.de",
    "applicationCategory": "ProductivityApplication",
    "operatingSystem": "All",
    "description": "Transparente Wert- und Prioritätenfindung – wissenschaftlich fundiert."
  }
  </script>
</head>
<body>
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
                <!-- Language Switcher -->
                <li class="nav-item mx-1">
                    <button class="btn btn-navbar btn-sm" id="langSwitcher" title="Sprache wechseln" aria-label="Sprache wechseln">
                        <span id="langLabel"><?= strtoupper(getLanguage()) ?></span>
                    </button>
                </li>
                <!-- Account-Icon mit Bild & Fallback -->
                <li class="nav-item mx-1">
                    <a class="btn btn-navbar btn-sm" href="account.php" title="Account/Profil" aria-label="Account/Profil" style="padding:0.2em;">
                        <?php if(file_exists("assets/img/avatar.png")): ?>
                            <img src="assets/img/avatar.png" alt="Account" width="32" height="32" style="border-radius:50%;border:1px solid #eee;">
                        <?php else: ?>
                            <span style="font-size:1.25em;">🙋‍♂️</span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
