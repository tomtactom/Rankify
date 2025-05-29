<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><?=t('title')?></a>
        <span class="navbar-text ms-2 text-muted" style="font-size:1.1em;">
            <!-- Optional: Slogan oder zweizeilig -->
            <?php if(getLanguage()=='de'): ?>
                Deine Reihenfolge, deine Entscheidung
            <?php else: ?>
                Your order, your choice
            <?php endif; ?>
        </span>
        <div class="ms-auto">
            <a href="?lang=de" class="btn btn-link<?=getLanguage()=='de'?' fw-bold text-primary':'';?>">DE</a>
            <a href="?lang=en" class="btn btn-link<?=getLanguage()=='en'?' fw-bold text-primary':'';?>">EN</a>
        </div>
    </div>
</nav>
