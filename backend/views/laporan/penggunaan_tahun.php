<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\Penggunaan;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PenggunaanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Laporan Riwayat Penggunaan per Tahun');
$this->params['breadcrumbs'][] = 'Laporan';
$this->params['breadcrumbs'][] = 'Penggunaan per Tahun';

$listTahun = Penggunaan::find()->select('tahun')->groupBy(['tahun'])->orderBy(['tahun' => SORT_ASC])->all();
$listBulan = Yii::$app->params['bulan'];
?>
<div class="laporan-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => 'primary',
            'heading' => 'Laporan Riwayat Penggunaan per Tahun',
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
                'value' => function (Penggunaan $dataRow) {
                    return $dataRow->pelanggan->kode;
                }
            ],
            [
                'attribute' => 'pelanggan.nama',
                'header' => 'Nama Pelanggan',
            ],
            [
                'attribute' => 'bulan',
                'filter' => false,
                'value' => function (Penggunaan $dataRow) use ($listBulan) {
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
            'meter_awal',
            'meter_akhir',
            'tagihan.jumlah_meter',
            'tagihan.tarif_perkwh',
            'tagihan.total_bayar',
        ],
    ]); ?>

</div>
