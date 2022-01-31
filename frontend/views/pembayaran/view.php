<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Pembayaran;

/* @var $this yii\web\View */
/* @var $model common\models\Pembayaran */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pembayaran'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pembayaran-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
            [
                'attribute' => 'pelanggan_id',
                'title' => 'Nama Pelanggan'
            ],
            'tgl_bayar:date',
            'jumlah_tagihan:currency',
            'biaya_admin:currency',
            'total_bayar:currency',
            'bayar:currency',
            'kembalian:currency',
        ],
    ]) ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Periode Tagihan</th>
                <th class="text-center">Jumlah Bayar</th>
                <th class="text-center">Biaya Admin</th>
                <th class="text-center">Struk</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $rows = [];
                foreach ($model->pembayaranDetails as $key => $detail) {
                    $tagihan = $detail->tagihan;
                    $row = [];
                    $row[] = '<tr>';
                    $row[] = '<td class="text-center">' . ($key+1) . '</td>';
                    $row[] = '<td class="text-center">'.date('M Y', strtotime(sprintf('%s-%s-01', $tagihan->tahun, $tagihan->bulan))).'</td>';
                    $row[] = '<td class="text-right">' . Yii::$app->stroom->formatCurrency($tagihan->total_bayar) . '</td>';
                    $row[] = '<td class="text-right">' . Yii::$app->stroom->formatCurrency($detail->biaya_admin) . '</td>';
                    $row[] = '<td class="text-center">' . Html::a('Cetak', ['print', 'id' => $detail->uuid], ['class' => 'btn btn-primary', 'target' => '_blank']) . '</td>';
                    $row[] = '</tr>';
                    $rows[] = implode("\n", $row);
                }

                echo implode("\n", $rows);
            ?>
        </tbody>
    </table>

</div>
