<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Penggunaan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penggunaan-form">

    <?php $form = ActiveForm::begin(); ?>

    <div>
        <table class="table table-bordered table-striped">
            <tr>
                <td colspan="2"><strong>Informasi Pelanggan</strong></td>
            </tr>
            <tr>
                <td>ID Pelanggan</td>
                <td><?= $model->pelanggan->kode ?></td>
            </tr>
            <tr>
                <td>Nomor Meteran</td>
                <td><?= $model->pelanggan->no_meter ?></td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td><?= $model->pelanggan->nama ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><?= $model->pelanggan->alamat ?></td>
            </tr>
            <tr>
                <td>Jenis Daya</td>
                <td><?= $model->pelanggan->tarif->kode ?></td>
            </tr>
        </table>
    </div>

    <?= $form->field($model, 'periode')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'meter_awal')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'meter_akhir')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'tgl_cek')->textInput(['type' => 'date']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
