<?php

namespace backend\controllers;

use common\models\Pelanggan;
use common\models\PelangganSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * PelangganController implements the CRUD actions for Pelanggan model.
 */
class PelangganController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
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
     * Lists all Pelanggan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PelangganSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'queryParams' => $this->request->queryParams,
        ]);
    }

    /**
     * Displays a single Pelanggan model.
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
     * Creates a new Pelanggan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pelanggan();
        $model->setDefaultValues();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model->refresh();
                Yii::$app->session->setFlash('pelanggan', 'Data Pelanggan Berhasil Ditambahkan');

                return $this->redirect(['view', 'id' => $model->uuid]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pelanggan model.
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
     * Deletes an existing Pelanggan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->softDelete();

        return $this->redirect(['index']);
    }

    /**
     * Export all Tarif data.
     *
     * @return string
     */
    public function actionExport()
    {
        $searchModel = new PelangganSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $data = $dataProvider->query->all();

        $fileName = 'Laporan Pelanggan.xlsx';
        $headers = WriterEntityFactory::createRowFromArray([
            'ID Pelanggan',
            'No. Meteran',
            'Nama Pelanggan',
            'Alamat',
            'Tenggang',
            'Jenis Tarif',
        ]);

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);
        $writer->addRow($headers);

        foreach ($data as $pelanggan) {
            $row = WriterEntityFactory::createRowFromArray([
                $pelanggan->kode,
                $pelanggan->no_meter,
                $pelanggan->nama,
                $pelanggan->alamat,
                $pelanggan->tenggang,
                $pelanggan->tarif->kode,
            ]);
            $writer->addRow($row);
        }

        $writer->close();
    }

    /**
     * Finds the Pelanggan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Pelanggan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pelanggan::findOne(['uuid' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
