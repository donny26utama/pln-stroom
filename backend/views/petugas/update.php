<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = sprintf('%s | Pelanggan', Yii::t('app', 'Update {name}', [
    'name' => $model->kode,
]));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Petugas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode, 'url' => ['view', 'id' => $model->uuid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="petugas-update col-12 col-md-6 offset-md-3">
    <div class="card bg-light">
        <div class="card-header">
            Ubah Petugas
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
