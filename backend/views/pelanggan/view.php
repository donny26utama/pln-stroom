<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Pelanggan */

$pelanggan = sprintf('%s - %s', $model->kode, $model->nama);
$this->title = sprintf('%s | Pelanggan', $pelanggan);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pelanggan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $pelanggan;
\yii\web\YiiAsset::register($this);
?>
<div class="pelanggan-view">

    <h1>Informasi Pelanggan</h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->uuid], ['class' => 'btn btn-primary']) ?>
        <?= !$model->pelangganBaru ? Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->uuid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) : '' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kode',
            'no_meter',
            'nama',
            'alamat:ntext',
            'tenggang',
            [
                'attribute' => 'tarif_id',
                'value' => function ($data) {
                    return $data->tarif->kode;
                }
            ],
        ],
    ]) ?>

</div>
