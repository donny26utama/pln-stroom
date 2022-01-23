<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PembayaranSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pembayaran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uuid') ?>

    <?= $form->field($model, 'tgl_bayar') ?>

    <?= $form->field($model, 'jumlah_tagihan') ?>

    <?= $form->field($model, 'biaya_admin') ?>

    <?php // echo $form->field($model, 'total_bayar') ?>

    <?php // echo $form->field($model, 'bayar') ?>

    <?php // echo $form->field($model, 'kembalian') ?>

    <?php // echo $form->field($model, 'agen_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
