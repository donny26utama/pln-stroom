<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Pembayaran;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PembayaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pembayarans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembayaran-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Pembayaran'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'tgl_bayar:date',
            'jumlah_tagihan',
            'biaya_admin',
            //'total_bayar',
            //'bayar',
            //'kembalian',
            //'agen_id',

            // [
            //     'class' => kartik\grid\ActionColumn::class,
            //     'urlCreator' => function ($action, Pembayaran $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //     }
            // ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
