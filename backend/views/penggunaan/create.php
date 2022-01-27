<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Penggunaan */

$this->title = sprintf('%s | Penggunaan', Yii::t('app', 'Penggunaan Baru'));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Penggunaan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Penggunaan Baru';
?>
<div class="penggunaan-create">
    <div class="row">
        <div class="col-6 offset-3">
            <div class="card bg-light mb-3">
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
            <div class="card bg-light mb-3">
                <div class="card-header">
                    Input Data Penggunaan
                </div>
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>