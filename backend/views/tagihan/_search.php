<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TagihanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tagihan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uuid') ?>

    <?= $form->field($model, 'pelanggan_id') ?>

    <?= $form->field($model, 'bulan') ?>

    <?= $form->field($model, 'tahun') ?>

    <?php // echo $form->field($model, 'jumlah_meter') ?>

    <?php // echo $form->field($model, 'tarif_perkwh') ?>

    <?php // echo $form->field($model, 'total_bayar') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'petugas_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
