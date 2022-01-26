<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Tarif */

$this->title = sprintf('%s | Tarif', $model->kode);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tarif'), 'url' => ['index']];
$this->params['breadcrumbs'][] = sprintf('%s-%s', $model->golongan, $model->daya);
\yii\web\YiiAsset::register($this);
?>
<div class="tarif-view">

    <h1>Informasi Tarif</h1>

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
            'golongan',
            'daya',
            'tarif_perkwh',
        ],
    ]) ?>

</div>
