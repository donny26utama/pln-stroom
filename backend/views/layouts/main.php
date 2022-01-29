<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\NavBar;
use kartik\nav\NavX;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= trim(Html::encode($this->title)) ?> | PT PLN (Persero)</title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);

    $leftMenuItems = [];
    $rightMenuItems = [];

    if (Yii::$app->user->isGuest) {
        $rightMenuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $leftMenuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            [
                'label' => 'Data Master',
                'items' => [
                    ['label' => 'Data Tarif', 'url' => ['/tarif/index']],
                    ['label' => 'Data Pelanggan', 'url' => ['/pelanggan/index']],
                    [
                        'label' => 'Data User',
                        'items' => [
                            ['label' => 'Data Petugas', 'url' => ['/petugas/index']],
                            ['label' => 'Data Agen', 'url' => ['/agen/index']],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Data Transaksi',
                'items' => [
                    ['label' => 'Data Penggunaan', 'url' => ['/penggunaan/index']],
                    ['label' => 'Data Tagihan', 'url' => ['/tagihan/index']],
                ],
            ],
            [
                'label' => 'Laporan',
                'items' => [
                    ['label' => 'Tagihan per Bulan', 'url' => ['/laporan/tagihan-per-bulan']],
                    ['label' => 'Tunggakan', 'url' => ['/laporan/tunggakan']],
                    ['label' => 'Riwayat Penggunaan per Tahun', 'url' => ['/laporan/penggunaan-per-tahun']],
                ],
            ],
        ];
        $rightMenuItems[] = [
            'label' => 'Hi, ' . Yii::$app->user->identity->username,
            'items' => [
                ['label' => 'Edit Profil', 'url' => ['/user/profile']],
                [
                    'label' => 'Logout',
                    'url' => ['/site/logout'],
                    'linkOptions' => [
                        'data' => ['method' => 'post'],
                    ],
                ],
            ],
        ];
    }

    echo NavX::widget([
        'options' => ['class' => 'navbar-nav mr-auto'],
        'items' => $leftMenuItems,
        'activateParents' => true,
        'encodeLabels' => false
    ]) . NavX::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $rightMenuItems,
        'activateParents' => true,
        'encodeLabels' => false
    ]);

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted d-print-none">
    <div class="container">
        <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
