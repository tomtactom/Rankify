// theme.js
function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    document.cookie = "theme=" + theme + ";path=/;max-age=31536000";
    updateThemeIcon(theme);
}

function updateThemeIcon(theme) {
    const themeIcon = document.getElementById('themeIcon');
    if (!themeIcon) return;
    if (theme === 'dark') themeIcon.textContent = "🌙";
    else if (theme === 'rainbow') themeIcon.textContent = "🌈";
    else themeIcon.textContent = "☀️";
}

// Initialisieren
document.addEventListener('DOMContentLoaded', function() {
    // Theme lesen
    let theme = (document.cookie.match(/theme=([^;]+)/) || [])[1] || 'light';
    setTheme(theme);

    // Switcher
    document.getElementById('themeSwitcher').onclick = function() {
        let theme = (document.cookie.match(/theme=([^;]+)/) || [])[1] || 'light';
        let next = theme === 'light' ? 'dark' : (theme === 'dark' ? 'rainbow' : 'light');
        setTheme(next);
    };
});
