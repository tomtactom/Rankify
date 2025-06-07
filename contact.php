<?php
include 'inc/lang.php';
if (file_exists('settings.php')) {
    include 'settings.php';
} else {
    include 'settings.php.bak';
}
include 'inc/email.php';
session_start();
$sent = false;
$error = '';
$stage = '';

// Bestätigungslink
if (isset($_GET['confirm'])) {
    $token = preg_replace('/[^a-zA-Z0-9]/','', $_GET['confirm']);
    $file = __DIR__.'/data/contact/'.$token.'.json';
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
        if ($data) {
            $body  = '<p><strong>Name:</strong> '.htmlspecialchars($data['name']).'</p>';
            $body .= '<p><strong>Email:</strong> '.htmlspecialchars($data['email']).'</p>';
            $body .= '<p>'.nl2br(htmlspecialchars($data['message'])).'</p>';
            send_email($ADMIN_EMAIL, t('contact_admin_subject'), $body);
            unlink($file);
            $sent = true;
            $stage = 'confirmed';
        }
    }
    if (!$sent) $error = t('contact_error_token');
}

// Formularversand
if (!$sent && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    $captcha = intval($_POST['captcha'] ?? 0);
    if ($captcha !== ($_SESSION['captcha_result'] ?? -1)) {
        $error = t('contact_error_captcha');
    } elseif ($name && $email && $msg) {
        $token = bin2hex(random_bytes(16));
        @mkdir(__DIR__.'/data/contact', 0777, true);
        file_put_contents(__DIR__.'/data/contact/'.$token.'.json', json_encode([
            'name'=>$name,'email'=>$email,'message'=>$msg
        ]));
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off'? 'https':'http').
            '://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?confirm='.$token;
        $body = langf(t('contact_email_body'), $link);
        send_email($email, t('contact_email_subject'), $body);
        $sent = true;
        $stage = 'waiting';
    } else {
        $error = t('contact_error_fill');
    }
}

// Captcha erstellen
if (!isset($_SESSION['captcha_result']) || $sent) {
    $a = random_int(1,9); $b = random_int(1,9);
    $_SESSION['captcha_result'] = $a + $b;
    $_SESSION['captcha_question'] = "$a + $b = ?";
}
include 'navbar.php';
?>
<div class="container py-4">
  <h1><?=t('contact_title')?></h1>
  <p class="lead"><?=t('contact_intro')?></p>
  <?php if($sent): ?>
    <?php if($stage=='waiting'): ?>
      <div class="alert alert-success"><?=t('contact_waiting')?></div>
    <?php else: ?>
      <div class="alert alert-success"><?=t('contact_sent')?></div>
    <?php endif; ?>
  <?php else: ?>
    <?php if($error): ?><div class="alert alert-danger"><?=$error?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label for="name" class="form-label"><?=t('contact_label_name')?></label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label"><?=t('contact_label_email')?></label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="message" class="form-label"><?=t('contact_label_message')?></label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
      </div>
      <div class="mb-3">
        <label for="captcha" class="form-label"><?=$_SESSION['captcha_question']?></label>
        <input type="number" class="form-control" id="captcha" name="captcha" required>
      </div>
      <button type="submit" class="btn btn-primary"><?=t('contact_send')?></button>
    </form>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
