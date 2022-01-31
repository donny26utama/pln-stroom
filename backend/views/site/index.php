<?php

/* @var $this yii\web\View */

$this->title = 'Home';
?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">PLN STROOM</h1>
        <p class="lead">
            Hai <strong><?= Yii::$app->user->identity->nama ?></strong>, Selamat datang di Aplikasi Tagihan Listrik PT PLN (Persero).
        </p>
    </div>
</div>
