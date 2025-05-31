<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" style="border-radius:0 0 1.5rem 1.5rem;">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php" style="font-size:1.3em;">
            <img src="assets/img/rankifmy-logo.png" alt="Logo" width="36" height="36" class="me-2" style="border-radius:0.7em;">
            Rankifmy
        </a>
        <span class="navbar-text d-none d-md-inline mx-2" style="color:#6383e0;font-size:1em;">
            <?=t('slogan') ?: 'Deine Reihenfolge, deine Entscheidung'?>
        </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Navigation ein-/ausblenden">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><?=t('sets_overview') ?? 'Übersicht'?></a>
                </li>
                <li class="nav-item d-none d-md-inline">
                    <a class="nav-link" href="https://rankify.tomaschmann.de" target="_blank" rel="noopener">Projekt</a>
                </li>
                <li class="nav-item d-none d-md-inline">
                    <a class="nav-link" href="faq.php"><?=t('faq') ?? 'FAQ'?></a>
                </li>
                <li class="nav-item d-none d-md-inline">
                    <a class="nav-link" href="kontakt.php"><?=t('contact') ?? 'Kontakt'?></a>
                </li>
                <!-- Theme Switcher -->
                <li class="nav-item ms-2">
                    <button class="btn btn-sm btn-outline-secondary" id="themeToggle" title="Design wechseln" style="border-radius:1em;">
                        <span id="themeIcon">🌞</span>
                    </button>
                </li>
                <!-- Sprach-Switcher -->
                <li class="nav-item ms-2">
                    <button class="btn btn-sm btn-outline-primary" id="langToggle" title="Sprache wechseln" style="border-radius:1em;">
                        <span id="langIcon"><?=getLanguage()=='en'?'EN':'DE'?></span>
                    </button>
                </li>
                <!-- Avatar/Profil -->
                <li class="nav-item ms-2">
                    <a href="profil.php" class="nav-link p-0" style="display:inline-block;">
                        <img src="assets/img/avatar.png" alt="Avatar" width="32" height="32" style="border-radius:50%;border:2px solid #e3e3e3;">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Theme/Language Script (sicher!) -->
<script>
(function(){
    // Theme Toggle
    let themeBtn = document.getElementById('themeToggle');
    if(themeBtn){
        themeBtn.onclick = function(){
            let theme = document.documentElement.getAttribute('data-theme') || 'light';
            let next = theme==='light'?'dark':(theme==='dark'?'rainbow':'light');
            document.documentElement.setAttribute('data-theme', next);
            document.cookie = 'theme='+next+';path=/;max-age='+(365*24*60*60);
            document.getElementById('themeIcon').textContent = next==='light'?'🌞':(next==='dark'?'🌚':'🌈');
        };
        // Icon setzen (init)
        let m = document.cookie.match(/theme=(light|dark|rainbow)/);
        let theme = m?m[1]:'light';
        document.getElementById('themeIcon').textContent = theme==='light'?'🌞':(theme==='dark'?'🌚':'🌈');
    }
    // Language Toggle
    let langBtn = document.getElementById('langToggle');
    if(langBtn){
        langBtn.onclick = function(){
            let cur = document.cookie.match(/lang=(de|en)/);
            let lang = (cur && cur[1]==='de') ? 'en' : 'de';
            document.cookie = 'lang='+lang+';path=/;max-age='+(365*24*60*60);
            location.reload();
        };
    }
})();
</script>
