<?php
include 'inc/lang.php';
include 'navbar.php';
$history = [];
if (isset($_COOKIE['rankify_history'])) {
    $history = json_decode($_COOKIE['rankify_history'], true);
    if (!is_array($history)) $history = [];
}
?>
<div class="container py-4">
  <h1>Dein Profil</h1>
  <p class="lead">Hier findest du eine spielerische &Uuml;bersicht deiner gespeicherten Ergebnisse.</p>
  <?php if(empty($history)): ?>
    <p>Noch keine Ergebnisse gespeichert.</p>
  <?php else: ?>
    <?php foreach(array_reverse($history) as $entry): ?>
      <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
          <span>Set: <?=htmlspecialchars($entry['set'])?></span>
          <span>🏆 <?=date('d.m.Y H:i', strtotime($entry['time']))?></span>
        </div>
        <ul class="list-group list-group-flush">
          <?php $c=0; foreach($entry['scores'] as $id=>$score): if($c>=3) break; ?>
            <li class="list-group-item">#<?=($c+1)?> <?=htmlspecialchars($id)?> <span class="badge bg-secondary float-end"><?=$score?></span></li>
          <?php $c++; endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
