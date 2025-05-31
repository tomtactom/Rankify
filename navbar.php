<script>
(function(){
    var m = document.cookie.match(/(?:^|;) ?theme=([^;]*)/);
    if (m && m[1]) document.body.className = m[1];
})();
</script>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="border-radius:0 0 1.4rem 1.4rem;">
    <div class="container">
        <!-- LOGO + NAME -->
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php" style="font-size:1.25em;">
            <img src="assets/img/rankifmy-logo.png" alt="Logo" width="36" height="36" style="border-radius:0.7em;">
            <span style="letter-spacing:0.02em;">Rankifmy</span>
        </a>
        <!-- Slogan als Tooltip -->
        <span class="navbar-text d-none d-lg-inline ms-1"
              style="color:#6281e3;font-size:1em;font-weight:400;"
              title="<?=t('slogan') ?? 'Deine Reihenfolge, deine Entscheidung'?>">
            <?=t('slogan') ?? 'Deine Reihenfolge, deine Entscheidung'?>
        </span>
        <!-- Burger Menu Icon -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavMain"
                aria-controls="navbarNavMain" aria-expanded="false" aria-label="Navigation ein-/ausblenden">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0" id="navbarNavMain">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><?=t('sets_overview') ?? 'Übersicht'?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="results.php"><?=t('results') ?? 'Ergebnisse'?></a>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link" href="instructions.php"><?=t('instructions_title') ?? 'Anleitung'?></a>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link" href="about.php"><?=t('about') ?? 'Über'?></a>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link" href="faq.php"><?=t('faq') ?? 'FAQ'?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php"><?=t('contact') ?? 'Kontakt'?></a>
                </li>
                <!-- Sprachumschalter -->
                <li class="nav-item px-1">
                    <button id="lang-switch-btn" class="btn btn-sm btn-outline-secondary" type="button" style="min-width:2.4em;">
                        <?=getLanguage()=='de'?'EN':'DE'?>
                    </button>
                </li>
                <script>
                document.getElementById('lang-switch-btn').onclick = function() {
                    var nextLang = "<?=getLanguage()=='de'?'en':'de'?>";
                    document.cookie = "lang=" + nextLang + ";path=/;max-age=31536000";
                    location.reload();
                };
                </script>
                <!-- THEME SWITCHER: Light, Dark, Rainbow -->
                <select id="theme-switcher" style="margin-left:1em;">
                    <option value="light">🌞</option>
                    <option value="dark">🌚</option>
                    <option value="rainbow">🌈</option>
                </select>

                <!-- AVATAR + FAQ/Feedback -->
                <li class="nav-item ms-2">
                    <a class="nav-link d-flex align-items-center" href="faq.php" title="<?=t('profile_feedback') ?? 'FAQ & Feedback'?>">
                        <img src="assets/img/avatar.png" alt="Avatar" width="30" height="30" style="border-radius:50%;box-shadow:0 2px 7px rgba(110,130,160,0.12);margin-right:0.3em;">
                        <span class="d-none d-xl-inline"><?=t('profile') ?? 'Profil'?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
