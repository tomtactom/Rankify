document.addEventListener('DOMContentLoaded', function() {
    // Reveal obfuscated email addresses
    document.querySelectorAll('.obfuscated-email').forEach(function(el) {
        var user = el.dataset.user;
        var domain = el.dataset.domain;
        if (!user || !domain) return;
        var email = user + '@' + domain;
        var display = user + ' [\u00e4t] ' + domain;
        if (el.dataset.link) {
            el.innerHTML = '<a href="mailto:' + email + '">' + display + '</a>';
        } else {
            el.textContent = display;
        }
    });

    // Reveal generic obfuscated text (base64 encoded)
    document.querySelectorAll('.obfuscated-text').forEach(function(el) {
        var encoded = el.dataset.value;
        if (!encoded) return;
        try {
            var decoded = atob(encoded);
            if (el.dataset.link === 'mailto') {
                el.innerHTML = '<a href="mailto:' + decoded + '">' + decoded + '</a>';
            } else {
                el.textContent = decoded;
            }
        } catch (e) {
            console.error('Decode error', e);
        }
    });
});
