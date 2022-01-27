<?php

namespace backend\controllers;

use common\models\Pelanggan;
use common\models\Penggunaan;
use common\models\PenggunaanSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PenggunaanController implements the CRUD actions for Penggunaan model.
 */
class PenggunaanController extends Controller
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
     * Lists all Penggunaan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PenggunaanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Penggunaan model.
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
     * Creates a new Penggunaan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Penggunaan();
        $filter = $this->request->queryParams;

        if (isset($filter['search'])) {
            $pelanggan = Pelanggan::find()->where(['OR', ['kode' => $filter['search']], ['no_meter' => $filter['search']]])->one();
            if ($pelanggan) {
                $penggunaan = Penggunaan::findOne(['pelanggan_id' => $pelanggan->id, 'meter_akhir' => 0]);
                $model = $penggunaan ?: new Penggunaan();
            }
        }

        if ($this->request->isPost) {
            $model->petugas_id = Yii::$app->user->identity->id;

            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->setDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'filter' => $filter,
        ]);
    }

    /**
     * Updates an existing Penggunaan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id = null)
    {
        $model = $this->findModel($id);
        $filter = $this->request->queryParams;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'filter' => $filter,
        ]);
    }

    /**
     * Deletes an existing Penggunaan model.
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
     * Finds the Penggunaan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Penggunaan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penggunaan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
