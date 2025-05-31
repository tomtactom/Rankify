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
                <!-- SPRACHWECHSEL ohne Flaggen -->
                <li class="nav-item px-1">
                    <form method="get" action="" class="d-inline">
                        <input type="hidden" name="lang" value="<?=getLanguage()=='de'?'en':'de'?>">
                        <button type="submit" class="btn btn-sm btn-outline-secondary" style="min-width:2.4em;">
                            <?=getLanguage()=='de'?'EN':'DE'?>
                        </button>
                    </form>
                </li>
                <!-- THEME SWITCHER: Light, Dark, Rainbow -->
                <li class="nav-item px-1 d-none d-md-inline">
                    <div class="btn-group" role="group" aria-label="Theme switcher">
                        <button id="theme-light" class="btn btn-sm btn-outline-secondary" title="Helles Farbschema">
                            <span aria-hidden="true">&#9728;</span>
                        </button>
                        <button id="theme-dark" class="btn btn-sm btn-outline-secondary" title="Dunkles Farbschema">
                            <span aria-hidden="true">&#9790;</span>
                        </button>
                        <button id="theme-rainbow" class="btn btn-sm btn-outline-secondary" title="Rainbow Modus">
                            <span aria-hidden="true">&#127752;</span>
                        </button>
                    </div>
                    <script>
                        // Theme-Switcher Demo (du kannst das mit echtem Theme-Management ersetzen)
                        document.getElementById('theme-light').onclick = function(){document.body.className='';};
                        document.getElementById('theme-dark').onclick  = function(){document.body.className='darkmode';};
                        document.getElementById('theme-rainbow').onclick = function(){document.body.className='rainbowmode';};
                        function setThemeCookie(theme) {
                            document.cookie = "theme=" + theme + ";path=/;max-age=31536000"; // 1 Jahr gültig
                        }
                        function getThemeCookie() {
                            let m = document.cookie.match(/(?:^|;) ?theme=([^;]*)/);
                            return m ? m[1] : "";
                        }
                        function applyTheme(theme) {
                            document.body.className = theme;
                        }
                        document.addEventListener("DOMContentLoaded", function() {
                            // Theme-Buttons
                            var themeBtns = {
                                '':      document.getElementById('theme-light'),
                                'darkmode': document.getElementById('theme-dark'),
                                'rainbowmode': document.getElementById('theme-rainbow')
                            };
                            // Theme-Setter
                            for (const [cls,btn] of Object.entries(themeBtns)) {
                                if (!btn) continue;
                                btn.onclick = function(e){
                                    e.preventDefault();
                                    setThemeCookie(cls);
                                    applyTheme(cls);
                                };
                            }
                            // Beim Laden Theme aus Cookie anwenden
                            var theme = getThemeCookie();
                            if (typeof theme === "string" && theme.length <= 15) {
                                applyTheme(theme);
                            }
                        });
                    </script>
                </li>
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
