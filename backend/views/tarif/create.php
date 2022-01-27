<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tarif */

$this->title = sprintf('%s | Tarif', Yii::t('app', 'Tarif Baru'));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tarif'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Tarif Baru';
?>

<div class="tarif-create col-12 col-md-6 offset-md-3">
    <div class="card bg-light">
        <div class="card-header">
            Tarif Baru
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
