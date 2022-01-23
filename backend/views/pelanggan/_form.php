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

    <?= $form->errorSummary($model, ['encode' => false]) ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'no_meter')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tarif_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($listTarif, 'id', 'kode'),
        'options' => ['placeholder' => 'Pilih Jenis Tarif ...'],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
