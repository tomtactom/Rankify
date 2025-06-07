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
  <h1><?=t('legal_title')?></h1>
  <p><?=t('legal_addr')?></p>
  <p><?=htmlspecialchars($ADMIN_NAME)?><br>
     <?=nl2br(htmlspecialchars($ADMIN_ADDRESS))?><br>
     E-Mail: <a href="mailto:<?=htmlspecialchars($ADMIN_EMAIL)?>"><?=htmlspecialchars($ADMIN_EMAIL)?></a></p>
  <p><?=t('legal_resp')?><br>
     <?=htmlspecialchars($ADMIN_NAME)?>, <?=htmlspecialchars($ADMIN_ADDRESS)?></p>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
