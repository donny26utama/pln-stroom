<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pembayaran */

$this->title = Yii::t('app', 'Create Pembayaran');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pembayarans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pembayaran-create">
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
        <div class="col-10 offset-1">
            <div class="card mb-3">
                <div class="card-header">
                    Input Pembayaran
                </div>
                <div class="card-body">
                    <?php if (!$pelanggan) : ?>
                        <h1>Pelanggan Tidak Ditemukan.</h1>
                    <?php else :?>
                        <?php if (!$tagihan) : ?>
                            <h1>Tagihan Sudah Dibayar.</h1>
                        <?php else : ?>
                            <?= $this->render('_form', [
                                'model' => $model,
                                'pelanggan' => $pelanggan,
                                'tagihan' => $tagihan,
                            ]) ?>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <?php endif ?>
    </div>

</div>
