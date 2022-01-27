<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pelanggan */

$this->title = sprintf('%s | Pelanggan', Yii::t('app', 'Pelanggan Baru'));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pelanggan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Pelanggan Baru';
?>

<div class="pelanggan-create col-12 col-md-6 offset-md-3">
    <div class="card bg-light">
        <div class="card-header">
            Pelanggan Baru
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
