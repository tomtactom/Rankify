// assets/js/theme.js

// Theme aus Cookie lesen
function getTheme() {
    return document.cookie.replace(/(?:(?:^|.*;\s*)rankifmy_theme\s*\=\s*([^;]*).*$)|^.*$/, "$1") || "light";
}
function setTheme(theme) {
    document.cookie = "rankifmy_theme=" + theme + ";path=/;max-age=" + (365*24*60*60);
    applyTheme(theme);
}
function applyTheme(theme) {
    document.body.classList.remove('theme-light', 'theme-dark', 'theme-rainbow');
    if (theme === 'dark') document.body.classList.add('theme-dark');
    else if (theme === 'rainbow') document.body.classList.add('theme-rainbow');
    else document.body.classList.add('theme-light');
}

// On page load: Set theme
document.addEventListener("DOMContentLoaded", function() {
    applyTheme(getTheme());
    // Optional: Theme-Switcher Buttons aktualisieren, wenn du visuelle Indikatoren hast
    var themeSelect = document.getElementById('theme-switcher');
    if (themeSelect) {
        themeSelect.value = getTheme();
        themeSelect.onchange = function() { setTheme(this.value); }
    }
});
