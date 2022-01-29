<?php

namespace backend\controllers;

use common\models\UserPetugas;
use common\models\UserSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class PetugasController extends UserController
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $searchModel->role = 'petugas';
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'queryParams' => $this->request->queryParams,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserPetugas(['scenario' => 'create']);
        $model->setDefaultValues();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->signup()) {
                return $this->redirect(['view', 'id' => $model->uuid]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
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
     * Export all Tarif data.
     *
     * @return string
     */
    public function actionExport()
    {
        $searchModel = new UserSearch();
        $searchModel->role = 'petugas';
        $dataProvider = $searchModel->search($this->request->queryParams);
        $data = $dataProvider->query->all();

        $fileName = 'Laporan Petugas.xlsx';
        $headers = WriterEntityFactory::createRowFromArray([
            'ID Petugas',
            'Nama Petugas',
            'Alamat',
            'No.Telp',
            'Jenis Kelamin',
            'email',
            'Status'
        ]);

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);
        $writer->addRow($headers);

        foreach ($data as $petugas) {
            $row = WriterEntityFactory::createRowFromArray([
                $petugas->kode,
                $petugas->nama,
                $petugas->alamat,
                $petugas->no_telepon,
                ucwords($petugas->jenis_kelamin),
                $petugas->email,
                $petugas->status ? 'Aktif' : 'Tidak Aktif',
            ]);
            $writer->addRow($row);
        }

        $writer->close();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = UserPetugas::find()->where(['AND', ['uuid' => $id], ['in', 'role', [UserPetugas::ROLE_ADMIN, UserPetugas::ROLE_PETUGAS]]])->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
