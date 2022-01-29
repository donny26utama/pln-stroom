<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\User;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Petugas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => 'primary',
            'heading' => 'Daftar Petugas',
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
                    'title' => Yii::t('app', 'Tambah Petugas'),
                    'data' => ['pjax' => 0],
                ]),
                'options' => ['class' => 'btn-group mr-2 me-2'],
            ],
            [
                'content' => Html::a('<i class="far fa-file-excel"></i>', ['export', $queryParams], [
                    'class' => 'btn btn-outline-info',
                    'title' => Yii::t('app', 'Export Petugas'),
                    'data' => ['pjax' => 0],
                    'target' => '_blank',
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

            'nama',
            'alamat',
            'no_telepon',
            'jenis_kelamin',
            'username',
            'email:ntext',
            [
                'attribute' => 'status',
                'filter' => [0 => 'Tidak Aktif', 1 => 'Aktif'],
                'value' => function ($rowData) {
                    return $rowData->status ? 'Aktif' : 'Tidak Aktif';
                }
            ],

            [
                'class' => kartik\grid\ActionColumn::class,
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->uuid]);
                },
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>

</div>
