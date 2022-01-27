<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Tarif;

/* @var $this yii\web\View */
/* @var $model common\models\Pelanggan */
/* @var $form yii\widgets\ActiveForm */

$listTarif = Tarif::find()->select(['id', 'kode'])->all();
?>

<div class="pelanggan-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">
        <?= $form->errorSummary($model, ['encode' => false]) ?>

        <div class="row">
            <div class="col-6">
                <?= $form->field($model, 'kode')->textInput(['maxlength' => true, 'readonly' => true]) ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'no_meter')->textInput(['maxlength' => true, 'readonly' => true]) ?>
            </div>
        </div>

        <?= $form->field($model, 'tarif_id')->widget(Select2::class, [
            'data' => ArrayHelper::map($listTarif, 'id', 'kode'),
            'options' => ['placeholder' => 'Pilih Jenis Tarif ...'],
        ]) ?>

        <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'alamat')->textarea(['rows' => 6]) ?>
    </div>

    <div class="card-footer">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
