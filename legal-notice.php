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
  <p><?=t('legal_intro')?></p>
  <?php list($u,$d)=explode('@',$ADMIN_EMAIL,2); ?>
  <p><?=htmlspecialchars($ADMIN_NAME)?><br>
     <?=nl2br(htmlspecialchars($ADMIN_ADDRESS))?><br>
     E-Mail: <span class="obfuscated-email" data-user="<?=htmlspecialchars($u)?>" data-domain="<?=htmlspecialchars($d)?>" data-link="1">[email protected]</span></p>
  <p><?=t('legal_responsible')?><br>
     <?=htmlspecialchars($ADMIN_NAME)?>, <?=htmlspecialchars($ADMIN_ADDRESS)?></p>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
