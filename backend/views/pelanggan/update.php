<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pelanggan */

$pelanggan = sprintf('%s - %s', $model->kode, $model->nama);
$this->title = sprintf('Update %s| Pelanggan', $pelanggan, $model->nama);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pelanggan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $pelanggan, 'url' => ['view', 'id' => $model->uuid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="pelanggan-create col-12 col-md-6 offset-md-3">
    <div class="card bg-light">
        <div class="card-header">
            Ubah Pelanggan
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
