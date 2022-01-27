<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Tarif;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TarifSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tarif');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarif-index">

    <?php if(Yii::$app->session->hasFlash('pelanggan')):?>
        <div class="info">
            <?php echo Yii::$app->session->getFlash('pelanggan'); ?>
        </div>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => 'primary',
            'heading' => 'Daftar Tarif',
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => [
                'enablePushState' => false,
            ],
        ],
        'responsive' => true,
        'toolbar' => [
            [
                'content' => Html::a('<i class="fas fa-plus"></i>', ['create'], [
                    'class' => 'btn btn-success',
                    'title' => Yii::t('app', 'Tambah Tarif'),
                    'data' => ['pjax' => 0],
                ]),
                'options' => ['class' => 'btn-group mr-2 me-2'],
            ],
            [
                'content' => common\widgets\PageSize::widget([
                    'template' => '{list}',
                    'sizes' => [5 => 5, 10 => 10, 20 => 20, 25 => 25, 50 => 50],
                ]),
            ],
        ],
        'filterSelector' => 'select[name="per-page"]',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'kode',
            'golongan',
            'daya',
            'tarif_perkwh',
            [
                'class' => kartik\grid\ActionColumn::class,
                'urlCreator' => function ($action, Tarif $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->uuid]);
                }
            ],
        ],
    ]); ?>

</div>
