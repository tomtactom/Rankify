<?php
include 'inc/lang.php';
include 'inc/kartenset_loader.php';
$kartensets = getKartensets();

function sprachName($code) {
    $langs = ['de' => 'Deutsch', 'en' => 'English'];
    return $langs[$code] ?? $code;
}
?>
<!DOCTYPE html>
<html lang="<?=getLanguage()?>">
<head>
    <meta charset="UTF-8">
    <title><?=t('title')?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Design-Feinschliff für Startseite */
        body {
            background: linear-gradient(120deg,#e6ecf7 0%,#fafdfe 100%);
            min-height: 100vh;
        }
        .card {
            border-radius: 1.2rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            transition: box-shadow 0.2s;
            min-height: 230px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .card:hover {
            box-shadow: 0 6px 24px rgba(50,80,180,0.09);
            transform: scale(1.015);
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .set-label {
            font-size: .97rem;
            color: #4d68a5;
            margin-bottom: 0.3rem;
            display: inline-block;
            background: #e3edfc;
            border-radius: 8px;
            padding: 2px 12px;
        }
        .hero {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .hero-text h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #294288;
            margin-bottom: .7rem;
        }
        .hero-text p {
            color: #4d68a5;
            font-size: 1.2rem;
            margin-bottom: 0;
        }
        @media (max-width: 768px) {
            .hero { flex-direction: column; gap: 1rem; }
            .hero-text h1 { font-size: 1.4rem; }
            .card { min-height: 190px; }
        }
        .logo-placeholder {
            width: 78px; height: 78px; border-radius: 18px;
            background: #fff; display: flex; align-items: center; justify-content: center;
            font-size: 2.3rem; font-weight: bold; color: #6281e3;
            box-shadow: 0 2px 12px rgba(80,110,200,0.09);
            border: 2px solid #e4eefe;
        }
        .add-set {
            font-size: .96rem;
            color: #7f8da3;
            margin-top: 2.5rem;
            text-align: center;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-4">

    <!-- Hero Section -->
    <div class="hero">
        <div class="logo-placeholder" aria-label="Logo">R</div>
        <div class="hero-text">
            <h1><?=t('title')?></h1>
            <p><?=t('choose_set')?>.</p>
        </div>
    </div>

    <!-- Kartensets -->
    <div class="row">
        <?php foreach($kartensets as $set): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <span class="set-label"><?=t('model_'.$set['modell'])?></span>
                        <h5 class="card-title mt-2"><?= htmlspecialchars($set['name']) ?></h5>
                        <p class="card-text text-muted">
                            <span><?=sprachName($set['sprache'])?></span>
                        </p>
                    </div>
                    <a href="compare.php?set=<?= urlencode($set['modell'].'/'.$set['filename']) ?>" class="btn btn-primary mt-3 w-100"><?=t('start')?></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($kartensets)): ?>
            <div class="col-12">
                <div class="add-set">
                    <?=t('error_no_set')?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
