document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.obfuscated-email').forEach(function(el) {
        var user = el.dataset.user;
        var domain = el.dataset.domain;
        if (!user || !domain) return;
        var email = user + '@' + domain;
        if (el.dataset.link) {
            el.innerHTML = '<a href="mailto:' + email + '">' + email + '</a>';
        } else {
            el.textContent = email;
        }
    });
});
