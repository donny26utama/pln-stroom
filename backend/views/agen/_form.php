<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model, ['encode' => false]) ?>

    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'kode')->textInput(['readonly' => 'true']) ?>
        </div>
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'username')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'nama')->textInput() ?>

    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'no_telepon')->textInput() ?>
        </div>
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'email')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'jenis_kelamin')->dropDownList(['pria' => 'Pria', 'wanita' => 'Wanita']) ?>
        </div>
        <div class="col-12 col-md-6">
        <?= $form->field($model, 'status')->dropDownList([0 => 'Tidak Aktif', 1 => 'Aktif']) ?>
        </div>
    </div>

    <?= $form->field($model, 'alamat')->textarea(['rows' => 3]) ?>

    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'agenFee')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'agenSaldo')->textInput(['type' => 'number']) ?>
        </div>
    </div>

    <?php if (!$model->isNewRecord) : ?>
    <hr />

    <h5>Ubah Password</h5>
    <p>Kosongkan jika tidak ingin mengubah password</p>
    <?php endif ?>

    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'c_password')->passwordInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
