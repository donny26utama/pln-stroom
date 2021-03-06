<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\Tagihan;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TagihanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Laporan Tagihan per Bulan');
$this->params['breadcrumbs'][] = 'Laporan';
$this->params['breadcrumbs'][] = 'Tagihan per Bulan';

$listTahun = Tagihan::find()->select('tahun')->groupBy(['tahun'])->orderBy(['tahun' => SORT_ASC])->all();
$listBulan = Yii::$app->params['bulan'];
?>
<div class="laporan-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => 'primary',
            'heading' => 'Laporan Tagihan per Bulan',
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
                'content' => Html::a('<i class="far fa-file-excel"></i>', ArrayHelper::merge(['export'], $queryParams), [
                    'class' => 'btn btn-outline-info',
                    'title' => Yii::t('app', 'Export Laporan'),
                    'data' => ['pjax' => 0],
                    'target' => '_blank',
                ]),
                'options' => ['class' => 'btn-group mr-2 me-2'],
            ],
            [
                'content' => common\widgets\PageSize::widget([
                    'template' => '{list}',
                    'sizes' => Yii::$app->params['pageSizeList'],
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
                'value' => function (Tagihan $dataRow) {
                    return $dataRow->pelanggan->kode;
                }
            ],
            [
                'attribute' => 'pelanggan_id',
                'header' => 'Nama Pelanggan',
                'filter' => false,
                'value' => function (Tagihan $dataRow) {
                    return $dataRow->pelanggan->nama;
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
            //'tarif_perkwh',
            [
                'attribute' => 'total_bayar',
                'filter' => false,
            ],
            //'data:ntext',
            [
                'attribute' => 'status',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'hideSearch' => true,
                    'data' => [0 => 'Belum Dibayar', 1 => 'Terbayar',],
                    'options' => ['placeholder' => 'Semua Status'],
                    'pluginOptions' => ['allowClear' => true],
                ],
            ],
            [
                'attribute' => 'petugas_id',
                'filter' => false,
                'value' => function (Tagihan $dataRow) {
                    return $dataRow->petugas->nama;
                }
            ],
        ],
    ]); ?>

</div>
