<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Pelanggan */

$this->title = sprintf('%s | Pelanggan', $model->kode);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pelanggan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->kode;
\yii\web\YiiAsset::register($this);
?>
<div class="pelanggan-view">

    <h1>Informasi Pelanggan</h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->uuid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->uuid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
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
