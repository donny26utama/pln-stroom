<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use common\models\Pelanggan;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PelangganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pelanggan');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pelanggan-index">

    <?php if(Yii::$app->session->hasFlash('pelanggan')):?>
        <div class="info">
            <?php echo Yii::$app->session->getFlash('pelanggan'); ?>
        </div>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => 'primary',
            'heading' => 'Daftar Pelanggan',
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => [
                'enablePushState' => false,
            ],
        ],
        'responsive' => true,
        'toolbar' => [
            [
                'content' => Html::a('<i class="fas fa-plus"></i>', ['create'], [
                    'class' => 'btn btn-success',
                    'title' => Yii::t('app', 'Tambah Pelanggan'),
                    'data' => ['pjax' => 0],
                ]),
                'options' => ['class' => 'btn-group mr-2 me-2'],
            ],
            [
                'content' => common\widgets\PageSize::widget([
                    'template' => '{list}',
                    'sizes' => [5 => 5, 10 => 10, 20 => 20, 25 => 25, 50 => 50],
                ]),
            ],
        ],
        'filterSelector' => 'select[name="per-page"]',
        'columns' => [
            ['class' => kartik\grid\SerialColumn::class],

            'kode',
            'no_meter',
            'nama',
            'alamat:ntext',

            [
                'class' => kartik\grid\ActionColumn::class,
                'header' => 'Aksi',
                'urlCreator' => function ($action, Pelanggan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->uuid]);
                },
                'buttons' => [
                    'delete' => function ($url, Pelanggan $model) {
                        return !$model->pelangganBaru ? Html::a('<i class="fas fa-remove"></i>', $url) : '';
                    },
                ],
            ],
        ],
    ]); ?>

</div>
