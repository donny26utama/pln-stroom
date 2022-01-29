<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Pembayaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pembayaran-form">

    <?php $form = ActiveForm::begin(); ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Periode Tagihan</th>
                <th>Total Penggunaan (Kwh)</th>
                <th>Tarif/Kwh</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 1;
                $rows = [];
                $sum = 0;
                foreach ($tagihan as $key => $value) {
                    $row = [];
                    $row[] = '<tr>';
                    $row[] = '<td>'.$i.'</td>';
                    $row[] = '<td>'.date('M Y', strtotime(sprintf('%s-%s-01', $value->tahun, $value->bulan))).'</td>';
                    $row[] = '<td>'.$value->jumlah_meter.'</td>';
                    $row[] = '<td>'.$value->tarif_perkwh.'</td>';
                    $row[] = '<td>'.$value->total_bayar.'</td>';
                    $row[] = '</tr>';
                    $sum += $value->total_bayar;
                    $rows[] = implode("\n", $row);
                    $i++;
                }
                echo implode("\n", $rows);
                $model->jumlah_tagihan = $sum;
                $model->total_bayar = $model->jumlah_tagihan + $model->biaya_admin;
            ?>
        </tbody>
    </table>

    <?= $form->errorSummary($model, ['encode' => false]) ?>

    <?= $form->field($model, 'tanggal')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'jumlah_tagihan')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'biaya_admin')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'total_bayar')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'bayar')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
