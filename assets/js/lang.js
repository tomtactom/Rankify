// lang.js
document.addEventListener('DOMContentLoaded', function() {
    let btn = document.getElementById('langSwitcher');
    if (!btn) return;
    btn.onclick = function() {
        // Hole aktuelle Sprache
        let current = (document.cookie.match(/lang=([^;]+)/) || [])[1] || 'de';
        let next = (current === 'de' ? 'en' : 'de');
        document.cookie = "lang=" + next + ";path=/;max-age=31536000";
        location.reload();
    };
});
