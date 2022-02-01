<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Pembayaran;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PembayaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pembayaran');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembayaran-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => 'primary',
            'heading' => 'Daftar Pembayaran',
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
                    'title' => Yii::t('app', 'Tambah Pembayaran'),
                    'data' => ['pjax' => 0],
                ]),
                'options' => ['class' => 'btn-group mr-2 me-2'],
            ],
            [
                'content' => Html::a('<i class="far fa-file-excel"></i>', ['export', $queryParams], [
                    'class' => 'btn btn-outline-info',
                    'title' => Yii::t('app', 'Export Agen'),
                    'data' => ['pjax' => 0],
                    'target' => '_blank',
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
            ['class' => 'kartik\grid\SerialColumn'],

            'kode',
            'pelanggan.kode',
            'pelanggan.nama',
            [
                'attribute' => 'tgl_bayar',
                'format' => 'datetime',
                'filterType' => GridView::FILTER_DATE,
            ],
            'jumlah_tagihan:currency',
            'biaya_admin:currency',
            'total_bayar:currency',
            //'bayar',
            //'kembalian',
            //'agen_id',

            [
                'class' => kartik\grid\ActionColumn::class,
                'template' => '{view}',
                'urlCreator' => function ($action, Pembayaran $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->uuid]);
                }
            ],
        ],
    ]); ?>

</div>
