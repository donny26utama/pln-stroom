<?php

namespace frontend\controllers;

use common\models\Pelanggan;
use common\models\Tagihan;
use common\models\Pembayaran;
use common\models\PembayaranSearch;
use common\models\PembayaranDetail;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * PembayaranController implements the CRUD actions for Pembayaran model.
 */
class PembayaranController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Pembayaran models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PembayaranSearch();
        $searchModel->agen_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'queryParams' => $this->request->queryParams,
        ]);
    }

    /**
     * Displays a single Pembayaran model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pembayaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pembayaran();
        $pelanggan = null;
        $tagihan = null;
        $filter = $this->request->queryParams;
        $model->setDefaultValues();

        if (isset($filter['search'])) {
            $pelanggan = Pelanggan::find()->where(['OR', ['kode' => $filter['search']], ['no_meter' => $filter['search']]])->one();
            if ($pelanggan) {
                $tagihan = Tagihan::find()->where(['pelanggan_id' => $pelanggan->id, 'status' => 0])->all();
            }
        }

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->pelanggan_id = $pelanggan->id;
            $model->tempTagihan = $tagihan;
            $model->kembalian = $model->bayar - $model->total_bayar;

            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->uuid]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'filter' => $filter,
            'pelanggan' => $pelanggan,
            'tagihan' => $tagihan,
        ]);
    }

    /**
     * Updates an existing Pembayaran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->uuid]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pembayaran model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Export all Tarif data.
     *
     * @return string
     */
    public function actionExport()
    {
        $searchModel = new PembayaranSearch();
        $searchModel->agen_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        $data = $dataProvider->query->all();

        $fileName = 'Laporan Pembayaran.xlsx';
        $headers = WriterEntityFactory::createRowFromArray([
            'ID Pembayaran',
            'ID Pelanggan',
            'Nama Pelanggan',
            'Tanggal Pembayaran',
            'Periode',
            'Jumlah Bayar',
            'Biaya Admin',
            'Total Akhir',
        ]);

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);
        $writer->addRow($headers);

        foreach ($data as $pembayaran) {
            $pelanggan = $pembayaran->pelanggan;
            foreach ($pembayaran->pembayaranDetails as $key => $detail) {
                $tagihan = $detail->tagihan;
                $totalAkhir = $tagihan->total_bayar + $detail->biaya_admin;
                $periode = sprintf('%s-%s-01', $tagihan->tahun, $tagihan->bulan);
                $row = WriterEntityFactory::createRowFromArray([
                    $pembayaran->kode,
                    $pelanggan->kode,
                    $pelanggan->nama,
                    $pembayaran->tgl_bayar,
                    date('M Y', strtotime($periode)),
                    $tagihan->total_bayar,
                    $detail->biaya_admin,
                    $totalAkhir,
                ]);
                $writer->addRow($row);
            }
        }

        $writer->close();
    }

    public function actionPrint($id)
    {
        if (($model = PembayaranDetail::findOne(['uuid' => $id])) !== null) {
            $this->layout = 'blank';

            return $this->render('print', [
                'model' => $model,
            ]);
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the Pembayaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Pembayaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pembayaran::findOne(['uuid' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
