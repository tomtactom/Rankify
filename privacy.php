<?php
include 'inc/lang.php';
if (file_exists('settings.php')) {
    include 'settings.php';
} else {
    include 'settings.php.bak';
}
include 'navbar.php';
?>
<div class="container py-4">
  <h1>Datenschutz</h1>
  <p>Wir verarbeiten deine Daten ausschlie&szlig;lich zur Bereitstellung und Verbesserung von Rankify. Alle Angaben sind freiwillig und werden anonymisiert ausgewertet.</p>
  <p>Bei Fragen erreichst du uns unter <a href="mailto:<?=htmlspecialchars($ADMIN_EMAIL)?>"><?=htmlspecialchars($ADMIN_EMAIL)?></a>.</p>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
