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
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
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
        ];
        $menuItems[] = [
            'label' => 'Data Transaksi',
            'items' => [
                ['label' => 'Data Penggunaan', 'url' => ['/penggunaan/index']],
                ['label' => 'Data Tagihan', 'url' => ['/tagihan/index']],
            ],
        ];
        $menuItems[] = [
            'label' => 'Laporan',
            'items' => [
                ['label' => 'Data Tarif', 'url' => ['/laporan/tarif']],
                ['label' => 'Data Pelanggan', 'url' => ['/laporan/pelanggan']],
                ['label' => 'Data Agen', 'url' => ['/laporan/agen']],
            ],
        ];
    }
    echo NavX::widget([
        'options' => ['class' => 'navbar-nav mr-auto'],
        'items' => $menuItems,
        'activateParents' => true,
        'encodeLabels' => false
    ]);
    $menuItems = [];
    $menuItems[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
    echo NavX::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
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

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
