<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Penggunaan */

$this->title = Yii::t('app', 'Update Penggunaan: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Penggunaans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="penggunaan-update">
    <div class="row">
        <div class="col-6 offset-3">
            <div class="card bg-light mb-3">
                <div class="card-header">
                    Ubah Penggunaan
                </div>
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
