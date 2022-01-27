<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tarif */

$this->title = sprintf('%s | Tarif', Yii::t('app', 'Update {name}', [
    'name' => $model->kode,
]));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tarif'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => sprintf('%s-%s', $model->golongan, $model->daya), 'url' => ['view', 'id' => $model->uuid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Edit');
?>

<div class="tarif-update col-12 col-md-6 offset-md-3">
    <div class="card bg-light">
        <div class="card-header">
            Ubah Tarif
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>