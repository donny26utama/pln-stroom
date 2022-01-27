<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tarif */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tarif-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">
        <?= $form->errorSummary($model, ['encode' => false]) ?>

        <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'golongan')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'daya')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tarif_perkwh')->textInput(['type' => 'number']) ?>
    </div>

    <div class="card-footer">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
