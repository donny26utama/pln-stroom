<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pelanggan */

$this->title = Yii::t('app', 'Create Pelanggan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pelanggans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pelanggan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
