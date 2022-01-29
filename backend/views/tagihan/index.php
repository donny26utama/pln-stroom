<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Tagihan;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TagihanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tagihan');
$this->params['breadcrumbs'][] = $this->title;

$listTahun = Tagihan::find()->select('tahun')->groupBy(['tahun'])->orderBy(['tahun' => SORT_ASC])->all();
$listBulan = Yii::$app->params['bulan'];
$listStatus = Yii::$app->params['statusBayar'];
?>
<div class="tagihan-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => 'primary',
            'heading' => 'Daftar Tagihan',
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
                'content' => common\widgets\PageSize::widget([
                    'template' => '{list}',
                    'sizes' => [5 => 5, 10 => 10, 20 => 20, 25 => 25, 50 => 50],
                ]),
            ],
        ],
        'filterSelector' => 'select[name="per-page"]',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'attribute' => 'pelanggan_id',
                'header' => 'ID Pelanggan',
                'filter' => false,
                'value' => function ($data) {
                    return $data->pelanggan->kode;
                }
            ],
            [
                'attribute' => 'pelanggan_id',
                'header' => 'Nama Pelanggan',
                'filter' => false,
                'value' => function ($data) {
                    return $data->pelanggan->nama;
                }
            ],
            [
                'attribute' => 'bulan',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => $listBulan,
                    'options' => ['placeholder' => 'Pilih Bulan'],
                    'pluginOptions' => ['allowClear' => true],
                ],
                'value' => function (Tagihan $dataRow) use ($listBulan) {
                    return $listBulan[$dataRow->bulan];
                }
            ],
            [
                'attribute' => 'tahun',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'data' => ArrayHelper::map($listTahun, 'tahun', 'tahun'),
                    'options' => ['placeholder' => 'Pilih Tahun'],
                    'pluginOptions' => ['allowClear' => true],
                ],
            ],
            [
                'attribute' => 'jumlah_meter',
                'filter' => false,
            ],
            [
                'attribute' => 'total_bayar',
                'filter' => false,
            ],
            [
                'attribute' => 'status',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'hideSearch' => true,
                    'data' => $listStatus,
                    'options' => ['placeholder' => 'Semua Status'],
                    'pluginOptions' => ['allowClear' => true],
                ],
                'value' => function (Tagihan $dataRow) use ($listStatus) {
                    return $listStatus[$dataRow->status];
                }
            ],
            //'tarif_perkwh',
            //'data:ntext',
            [
                'attribute' => 'petugas_id',
                'filter' => false,
                'value' => function (Tagihan $dataRow) {
                    return $dataRow->petugas->nama;
                }
            ],

            // [
            //     'class' => kartik\grid\ActionColumn::class,
            //     'urlCreator' => function ($action, Tagihan $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //     }
            // ],
        ],
    ]); ?>

</div>
