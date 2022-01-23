<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Penggunaan;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PenggunaanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Penggunaans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penggunaan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Penggunaan'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => kartik\grid\SerialColumn::class],

            'kode',
            [
                'attribute' => 'pelanggan_id',
                'value' => function ($data) {
                    return $data->pelanggan->nama;
                }
            ],
            'bulan',
            'tahun',

            [
                'class' => kartik\grid\ActionColumn::class,
                'urlCreator' => function ($action, Penggunaan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
