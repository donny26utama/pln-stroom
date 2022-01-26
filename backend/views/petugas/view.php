<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Petugas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->kode;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1>Informasi Petugas</h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->kode], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->kode], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nama',
            'jenis_kelamin',
            'no_telepon',
            'alamat',
            'username',
            'email:ntext',
            'status',
            'role',
        ],
    ]) ?>

</div>
