// theme.js – Für <head> jeder Seite, am besten so früh wie möglich einbinden!
(function() {
    // ---- 1. Theme beim Laden aus Cookie setzen (BEVOR Styles greifen!) ----
    let m = document.cookie.match(/theme=(light|dark|rainbow)/);
    let theme = m ? m[1] : 'light';
    document.documentElement.setAttribute('data-theme', theme);

    // ---- 2. Sprache beim Laden aus Cookie setzen (optional, falls du <html lang=""> dynamisch willst) ----
    let l = document.cookie.match(/lang=(de|en)/);
    let lang = l ? l[1] : 'de';
    document.documentElement.setAttribute('lang', lang);

    // ---- 3. Theme Switcher: Nach DOM-Load Switcher-Button korrekt initialisieren ----
    document.addEventListener('DOMContentLoaded', function() {
        // Theme-Switcher
        let themeBtn = document.getElementById('themeToggle');
        if(themeBtn){
            // Icon korrekt initialisieren
            let icon = document.getElementById('themeIcon');
            if(icon) icon.textContent = theme==='light'?'🌞':(theme==='dark'?'🌚':'🌈');
            themeBtn.onclick = function(){
                let next = theme==='light' ? 'dark' : (theme==='dark' ? 'rainbow' : 'light');
                document.documentElement.setAttribute('data-theme', next);
                document.cookie = 'theme='+next+';path=/;max-age='+(365*24*60*60);
                if(icon) icon.textContent = next==='light'?'🌞':(next==='dark'?'🌚':'🌈');
                theme = next; // Update für nächste Klicks
            };
        }

        // Sprach-Switcher
        let langBtn = document.getElementById('langToggle');
        if(langBtn){
            let icon = document.getElementById('langIcon');
            if(icon) icon.textContent = lang==='en'?'EN':'DE';
            langBtn.onclick = function(){
                let newLang = (lang === 'de') ? 'en' : 'de';
                document.cookie = 'lang='+newLang+';path=/;max-age='+(365*24*60*60);
                if(icon) icon.textContent = newLang==='en'?'EN':'DE';
                // Empfohlene Option: reload, damit Server/Seitenlogik neue Sprache sofort verwendet
                location.reload();
            };
        }
    });
})();
