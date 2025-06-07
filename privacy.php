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
  <h1><?=t('privacy_title')?></h1>
  <p><?=t('privacy_intro')?></p>

  <h3><?=t('privacy_contact_title')?></h3>
  <p><?=htmlspecialchars($ADMIN_NAME)?><br><?=nl2br(htmlspecialchars($ADMIN_ADDRESS))?><br>E-Mail: <a href="mailto:<?=htmlspecialchars($ADMIN_EMAIL)?>"><?=htmlspecialchars($ADMIN_EMAIL)?></a></p>

  <h3><?=t('privacy_usage_title')?></h3>
  <p><?=t('privacy_usage')?></p>

  <h3><?=t('privacy_session_title')?></h3>
  <p><?=t('privacy_session')?></p>

  <h3><?=t('privacy_cookie_title')?></h3>
  <?=t('privacy_cookie')?>

  <h3><?=t('privacy_contact_title')?></h3>
  <p><?=t('privacy_contact')?></p>

  <h3><?=t('privacy_rights_title')?></h3>
  <p><?=t('privacy_rights')?></p>

  <h3><?=t('privacy_purpose_title')?></h3>
  <p><?=t('privacy_purpose')?></p>

  <h3><?=t('privacy_storage_title')?></h3>
  <p><?=t('privacy_storage')?></p>

  <p><?=t('privacy_questions')?> <a href="mailto:<?=htmlspecialchars($ADMIN_EMAIL)?>"><?=htmlspecialchars($ADMIN_EMAIL)?></a>.</p>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
