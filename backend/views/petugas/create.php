<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = sprintf('%s | Petugas', Yii::t('app', 'Petugas Baru'));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Petugas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Petugas Baru';
?>
<div class="petugas-create col-12 col-md-6 offset-md-3">
    <div class="card bg-light">
        <div class="card-header">
            Petugas Baru
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
