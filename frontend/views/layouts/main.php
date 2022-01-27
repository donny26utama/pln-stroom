<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
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
    <title><?= Html::encode($this->title) ?> | Agen Stroom</title>
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

    if (Yii::$app->user->isGuest) {
        $menuItems = [];
        $rigthMenuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $rigthMenuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems = [
            [
                'label' => 'Transaksi',
                'items' => [
                    ['label' => 'Pembayaran', 'url' => ['/pembayaran/create']],
                    ['label' => 'Riwayat Pembayaran', 'url' => ['/pembayaran/index']],
                ],
            ],
            [
                'label' => 'Laporan',
                'url' => ['/laporan/pembayaran'],
            ],
        ];
        $rigthMenuItems[] = [
            'label' => 'Hi, ' . Yii::$app->user->identity->username,
            'labelOptions' => ['encode' => false],
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
        'items' => $menuItems,
    ]) . NavX::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $rigthMenuItems,
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
