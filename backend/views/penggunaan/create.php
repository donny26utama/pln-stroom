<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Penggunaan */

$this->title = Yii::t('app', 'Create Penggunaan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Penggunaans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penggunaan-create">
    <div class="row">
        <div class="col-6 offset-3">
            <div class="card mb-3">
                <div class="card-header">
                    Cari Pelanggan
                </div>
                <div class="card-body">
                    <form action="" method="get">
                        <div class="form-group">
                            <label class="control-label" for="">ID Pelanggan/No Meter</label>
                            <input type="text" id="search" class="form-control" name="search" value="<?= isset($filter['search']) ? $filter['search'] : '' ?>">
                        </div>
                        <div class="form-group mb-0">
                            <button type="button" class="btn btn-primary" onclick="submit()">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php if (isset($filter['search'])) : ?>
        <div class="col-6 offset-3">
            <div class="card mb-3">
                <div class="card-header">
                    Input Data Penggunaan
                </div>
                <div class="card-body">
                    <?php if (!$model->isNewRecord) : ?>
                        <?= $this->render('_form', [
                            'model' => $model,
                        ]) ?>
                    <?php else :?>
                        <h1>Data Pelanggan Tidak Ditemukan atau Data Penggunaan Sudah Diinput.</h1>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>