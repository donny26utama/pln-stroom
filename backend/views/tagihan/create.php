<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tagihan */

$this->title = Yii::t('app', 'Create Tagihan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tagihans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tagihan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
