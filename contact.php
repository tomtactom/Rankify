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
            send_email($ADMIN_EMAIL, 'Rankify Kontakt', $body);
            unlink($file);
            $sent = true;
            $stage = 'confirmed';
        }
    }
    if (!$sent) $error = 'Ungültiger oder abgelaufener Bestätigungslink.';
}

// Formularversand
if (!$sent && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    $captcha = intval($_POST['captcha'] ?? 0);
    if ($captcha !== ($_SESSION['captcha_result'] ?? -1)) {
        $error = 'Captcha falsch.';
    } elseif ($name && $email && $msg) {
        $token = bin2hex(random_bytes(16));
        @mkdir(__DIR__.'/data/contact', 0777, true);
        file_put_contents(__DIR__.'/data/contact/'.$token.'.json', json_encode([
            'name'=>$name,'email'=>$email,'message'=>$msg
        ]));
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off'? 'https':'http').
            '://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?confirm='.$token;
        $body = '<p>Bitte bestätige deine Anfrage für Rankify, indem du auf folgenden Link klickst:</p>'.
                '<p><a href="'.$link.'">Nachricht bestätigen</a></p>';
        send_email($email, 'Bitte Kontakt bestätigen', $body);
        $sent = true;
        $stage = 'waiting';
    } else {
        $error = 'Bitte alle Felder ausfüllen.';
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
  <h1>Kontakt</h1>
  <p class="lead">Fragen, Feedback oder wissenschaftliche Anregungen? Wir freuen uns auf deine Nachricht.</p>
  <?php if($sent): ?>
    <?php if($stage=='waiting'): ?>
      <div class="alert alert-success">Bitte bestätige deine Nachricht über den Link in der zugesandten E-Mail.</div>
    <?php else: ?>
      <div class="alert alert-success">Deine Nachricht wurde verschickt.</div>
    <?php endif; ?>
  <?php else: ?>
    <?php if($error): ?><div class="alert alert-danger"><?=$error?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">E-Mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="message" class="form-label">Nachricht</label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
      </div>
      <div class="mb-3">
        <label for="captcha" class="form-label"><?=$_SESSION['captcha_question']?></label>
        <input type="number" class="form-control" id="captcha" name="captcha" required>
      </div>
      <button type="submit" class="btn btn-primary">Senden</button>
    </form>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
