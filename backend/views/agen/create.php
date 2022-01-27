<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = sprintf('%s | Agen', Yii::t('app', 'Agen Baru'));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agen'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Agen Baru';
?>
<div class="agen-create  col-12 col-md-6 offset-md-3">
    <div class="card bg-light">
        <div class="card-header">
            Agen Baru
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
