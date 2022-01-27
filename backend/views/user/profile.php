<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Update User: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = Yii::t('app', 'My Profile');
?>
<div class="user-update col-12 col-md-6 offset-md-3">
    <div class="card bg-light">
        <div class="card-header">
            Ubah Data Pribadi
        </div>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
