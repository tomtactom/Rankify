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
  <h1>Impressum</h1>
  <p>Angaben gem&auml;&szlig; &sect;5 TMG</p>
  <p><?=htmlspecialchars($ADMIN_NAME)?><br>
     <?=nl2br(htmlspecialchars($ADMIN_ADDRESS))?><br>
     E-Mail: <a href="mailto:<?=htmlspecialchars($ADMIN_EMAIL)?>"><?=htmlspecialchars($ADMIN_EMAIL)?></a></p>
  <p>Verantwortlich f&uuml;r den Inhalt nach &sect; 55 Abs. 2 RStV:<br>
     <?=htmlspecialchars($ADMIN_NAME)?>, <?=htmlspecialchars($ADMIN_ADDRESS)?></p>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
