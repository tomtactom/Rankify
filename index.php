<?php
include 'inc/lang.php';

// Kartensets finden (durchsuche alle Unterordner in data/)
$verzeichnisse = ['punkte', 'thurstone', 'bradleyterry'];
$kartensets = [];

foreach ($verzeichnisse as $modell) {
    $dir = __DIR__."/data/$modell";
    if (!is_dir($dir)) continue;
    foreach (glob($dir.'/*.csv') as $file) {
        $filename = basename($file);
        $langcode = preg_match('/_([a-z]{2})\.csv$/', $filename, $m) ? $m[1] : '';
        $kartensets[] = [
            'modell' => $modell,
            'filename' => $filename,
            'langcode' => $langcode,
            'displayname' => preg_replace('/(_[a-z]{2})?\.csv$/', '', $filename),
        ];
    }
}
usort($kartensets, function($a, $b) {
    return strcmp($a['displayname'], $b['displayname']);
});

include 'navbar.php';
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
  var audio = document.getElementById('bgmusic');
  var btn = document.getElementById('musicToggle');
  var icon = document.getElementById('musicIcon');

  // Merke letzten Status im LocalStorage
  var isMuted = localStorage.getItem('musicMuted') === 'true';
  if(audio) audio.muted = isMuted;
  if(icon) icon.textContent = isMuted ? "🔇" : "🔊";

  if(btn) btn.addEventListener('click', function(e){
    e.preventDefault();
    if(!audio) return;
    audio.muted = !audio.muted;
    icon.textContent = audio.muted ? "🔇" : "🔊";
    localStorage.setItem('musicMuted', audio.muted ? "true" : "false");
  });

  // Autoplay Workaround (Mobile): versuche nach erstem Interaktions-Klick zu starten
  function tryPlay() {
    if(audio && audio.paused && !audio.muted) {
      audio.play().catch(()=>{});
    }
    window.removeEventListener('click', tryPlay);
  }
  window.addEventListener('click', tryPlay);
});
</script>

<audio id="bgmusic" src="assets/audio/background.mp3" autoplay loop></audio>
<div class="container py-4">

    <h1 class="mb-4"><?=t('sets_overview')?></h1>

    <?php if(empty($kartensets)): ?>
        <div class="alert alert-warning"><?=t('error_no_set')?></div>
    <?php else: ?>
        <div class="cardset-list mb-4">
        <?php foreach($kartensets as $set): ?>
            <div class="cardset">
                <div class="cardset-title"><?=htmlspecialchars($set['displayname'])?></div>
                <div class="cardset-meta mb-2">
                    <span class="modell-badge"><?=ucfirst($set['modell'])?></span>
                    <?php if($set['langcode']): ?>
                        <span class="lang-badge"><?=strtoupper($set['langcode'])?></span>
                    <?php endif; ?>
                </div>
                <a href="compare.php?set=<?=urlencode($set['modell'].'/'.$set['filename'])?>" class="btn btn-primary btn-cardset">
                    <?=t('progress')?>
                </a>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
</body>
</html>
