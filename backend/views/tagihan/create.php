<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tagihan */

$this->title = sprintf('%s | Tagihan', Yii::t('app', 'Tagihan Baru'));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tagihans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Tagihan Baru';
?>
<div class="tagihan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
