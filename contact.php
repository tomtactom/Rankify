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
        $error = 'Bitte alle Felder ausfüllen.';
    }
}
include 'navbar.php';
?>
<div class="container py-4">
  <h1>Kontakt</h1>
  <p class="lead">Fragen, Feedback oder wissenschaftliche Anregungen? Wir freuen uns auf deine Nachricht.</p>
  <?php if($sent): ?>
    <div class="alert alert-success">Deine Nachricht wurde verschickt.</div>
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
      <button type="submit" class="btn btn-primary">Senden</button>
    </form>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
