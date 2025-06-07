<?php
include 'inc/lang.php';
include 'navbar.php';
$history = [];
if (isset($_COOKIE['rankify_history'])) {
    $history = json_decode($_COOKIE['rankify_history'], true);
    if (!is_array($history)) $history = [];
}

function loadCardTitles($setPath) {
    $file = __DIR__ . '/data/' . $setPath;
    if (!file_exists($file)) return [];
    $rows = array_map(function($l){ return str_getcsv($l, ';'); }, file($file));
    array_shift($rows);
    $cards = [];
    foreach ($rows as $r) {
        if (count($r) < 3) continue;
        $cards[$r[0]] = ['title'=>$r[1], 'subtitle'=>$r[2]];
    }
    return $cards;
}
?>
<div class="container py-4">
  <h1 class="d-flex justify-content-between align-items-center">
      <span><?=t('account_title')?></span>
      <?php if(!empty($history)): ?>
        <button id="clearHistory" class="btn btn-outline-danger btn-sm"><?=t('account_clear_history') ?? 'Clear history'?></button>
      <?php endif; ?>
  </h1>
  <p class="lead"><?=t('account_lead')?></p>
  <?php if(empty($history)): ?>
    <p><?=t('account_no_results')?></p>
  <?php else: ?>
    <?php $hist = array_reverse($history); foreach($hist as $idx => $entry): ?>
      <?php
        $cards = loadCardTitles($entry['set']);
        $setDisplay = preg_replace('/(_[a-z]{2})?\.csv$/', '', basename($entry['set']));
        $maxScore = max($entry['scores']);
      ?>
      <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
          <span><?=htmlspecialchars($setDisplay)?></span>
          <span>🏆 <?=date('d.m.Y H:i', strtotime($entry['time']))?></span>
        </div>
        <ul class="list-group list-group-flush">
          <?php $c=0; foreach($entry['scores'] as $id=>$score): if($c>=3) break; ?>
            <?php $title = $cards[$id]['title'] ?? $id; $percent = $maxScore ? round($score/$maxScore*100) : 0; ?>
            <li class="list-group-item">
              <div class="d-flex justify-content-between">
                <span>#<?=($c+1)?> <?=htmlspecialchars($title)?></span>
                <span class="badge bg-secondary"><?=$score?></span>
              </div>
              <div class="progress mt-1" style="height:6px;">
                <div class="progress-bar" style="width:<?=$percent?>%"></div>
              </div>
            </li>
          <?php $c++; endforeach; ?>
        </ul>
        <div class="card-body">
          <?php $firstId = array_key_first($entry['scores']); ?>
          <?php if(isset($cards[$firstId])): ?>
            <p class="card-text"><?=t('account_highest_value')?>: <b><?=htmlspecialchars($cards[$firstId]['title'])?></b></p>
          <?php endif; ?>
          <a href="download.php?index=<?=$idx?>&format=apa" class="btn btn-outline-secondary btn-sm">APA</a>
          <a href="download.php?index=<?=$idx?>&format=json" class="btn btn-outline-secondary btn-sm">JSON</a>
          <a href="download.php?index=<?=$idx?>&format=png" class="btn btn-outline-secondary btn-sm">PNG</a>
          <a href="download.php?index=<?=$idx?>&format=pdf" class="btn btn-outline-secondary btn-sm">PDF</a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
<script>
document.getElementById('clearHistory')?.addEventListener('click', function(){
    if(confirm('Delete all saved results?')) {
        document.cookie = 'rankify_history=; path=/; max-age=0';
        location.reload();
    }
});
</script>
<?php include 'footer.php'; ?>
</body>
</html>
