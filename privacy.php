<?php
include 'inc/lang.php';
if (file_exists('settings.php')) {
    include 'settings.php';
} else {
    include 'settings.php.bak';
}
$robots = 'noindex,nofollow';
include 'navbar.php';
?>
<div class="container py-4">
  <h1><?=t('privacy_title')?></h1>
  <p><?=t('privacy_intro')?></p>

  <h3><?=t('privacy_heading_responsible')?></h3>
  <?php list($u,$d)=explode('@',$ADMIN_EMAIL,2); ?>
  <p><?=htmlspecialchars($ADMIN_NAME)?><br><span class="obfuscated-text" data-value="<?=base64_encode($ADMIN_ADDRESS)?>">[address protected]</span><br>E-Mail: <span class="obfuscated-email" data-user="<?=htmlspecialchars($u)?>" data-domain="<?=htmlspecialchars($d)?>" data-link="1">[email protected]</span></p>

  <h3><?=t('privacy_heading_usage')?></h3>
  <p><?=t('privacy_usage')?></p>

  <h3><?=t('privacy_heading_session')?></h3>
  <p><?=t('privacy_session')?></p>

  <h3><?=t('privacy_heading_cookies')?></h3>
  <ul>
    <li><?=t('privacy_cookie_history')?></li>
    <li><?=t('privacy_cookie_lang')?></li>
    <li><?=t('privacy_cookie_demo')?></li>
  </ul>
  <p><?=t('privacy_cookies_note')?></p>

  <h3><?=t('privacy_heading_contact')?></h3>
  <p><?=t('privacy_contact')?></p>

  <h3><?=t('privacy_heading_rights')?></h3>
  <p><?=t('privacy_rights')?></p>

  <h3><?=t('privacy_heading_purpose')?></h3>
  <p><?=t('privacy_purpose')?></p>

  <h3><?=t('privacy_heading_storage')?></h3>
  <p><?=t('privacy_storage')?></p>

  <?php list($u2,$d2)=explode('@',$ADMIN_EMAIL,2); ?>
  <p><?=t('privacy_questions')?> <span class="obfuscated-email" data-user="<?=htmlspecialchars($u2)?>" data-domain="<?=htmlspecialchars($d2)?>" data-link="1">[email protected]</span>.</p>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
