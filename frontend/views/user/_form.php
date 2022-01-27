<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$disabled = !$model->isNewRecord;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">
        <?= $form->errorSummary($model, ['encode' => false]) ?>

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
        </div>

        <?= $form->field($model, 'alamat')->textarea(['rows' => 3]) ?>

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
    </div>

    <div class="card-footer">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
