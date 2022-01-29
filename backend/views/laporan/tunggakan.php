<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\Tunggakan;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TunggakanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Laporan Tunggakan');
$this->params['breadcrumbs'][] = 'Laporan';
$this->params['breadcrumbs'][] = 'Tunggakan';
?>
<div class="laporan-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'type' => 'primary',
            'heading' => 'Laporan Tunggakan > 3 Bulan',
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
                'value' => function (Tunggakan $dataRow) {
                    return $dataRow->pelanggan->kode;
                }
            ],
            [
                'attribute' => 'pelanggan_id',
                'header' => 'Nama Pelanggan',
                'value' => function (Tunggakan $dataRow) {
                    return $dataRow->pelanggan->nama;
                }
            ],
            [
                'attribute' => 'pelanggan_id',
                'header' => 'Alamat',
                'value' => function (Tunggakan $dataRow) {
                    return $dataRow->pelanggan->alamat;
                }
            ],
            'tunggakan',
            [
                'attribute' => 'bulan',
                'value' => function (Tunggakan $dataRow) {
                    $show = [];
                    $bulan = explode(',', $dataRow->bulan);
                    foreach ($bulan as $key => $value) {
                        $show[] = date('MY', strtotime($value.'-01'));
                    }
                    return implode(', ', $show);
                }
            ],
            'jumlah_meter',
            'tarif_perkwh',
            'total_bayar',
        ],
    ]); ?>

</div>
