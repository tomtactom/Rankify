<?php
include 'inc/lang.php';
if (file_exists('settings.php')) {
    include 'settings.php';
} else {
    include 'settings.php.bak';
}
$sent = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    if ($name && $email && $msg) {
        $headers = 'From: '.mb_encode_mimeheader($name).' <'.$email.'>';
        @mail($ADMIN_EMAIL, 'Rankify Kontakt', $msg, $headers);
        $sent = true;
    } else {
        $error = t('contact_error');
    }
}
include 'navbar.php';
?>
<div class="container py-4">
  <h1><?=t('contact_title')?></h1>
  <p class="lead"><?=t('contact_lead')?></p>
  <?php if($sent): ?>
    <div class="alert alert-success"><?=t('contact_sent')?></div>
  <?php else: ?>
    <?php if($error): ?><div class="alert alert-danger"><?=$error?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label for="name" class="form-label"><?=t('contact_name')?></label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label"><?=t('contact_email')?></label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="message" class="form-label"><?=t('contact_message')?></label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary"><?=t('contact_submit')?></button>
    </form>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
