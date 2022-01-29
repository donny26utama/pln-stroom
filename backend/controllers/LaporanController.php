<?php

namespace backend\controllers;

use common\models\Pelanggan;
use common\models\TagihanSearch;
use common\models\TunggakanSearch;
use common\models\PenggunaanSearch;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * LaporanController implements the CRUD actions for Laporan model.
 */
class LaporanController extends Controller
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

    public function actionTagihanPerBulan()
    {
        $searchModel = new TagihanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('tagihan_bulan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'queryParams' => ArrayHelper::merge($this->request->queryParams, ['report' => 'tagihan_bulan']),
        ]);
    }

    public function actionTunggakan()
    {
        $searchModel = new TunggakanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('tunggakan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'queryParams' => ArrayHelper::merge($this->request->queryParams, ['report' => 'tunggakan_3bulan']),
        ]);
    }

    public function actionPenggunaanPerTahun()
    {
        $searchModel = new PenggunaanSearch();
        $searchModel->pelanggan_id = 0;
        $queryParams = $this->request->queryParams;
        $pelanggan_id = ArrayHelper::getValue($queryParams, 'PenggunaanSearch.pelanggan_id', 0);

        if ($pelanggan_id) {
            if ($pelanggan = Pelanggan::findOne(['kode' => $pelanggan_id])) {
                $queryParams['PenggunaanSearch']['pelanggan_id'] = $pelanggan->id;
            }
        }

        if ($pelanggan_id === '') $queryParams['PenggunaanSearch']['pelanggan_id'] = 0;

        $dataProvider = $searchModel->searchTahun($queryParams);
        $searchModel->pelanggan_id = $searchModel->pelanggan_id === 0 ? '' : $pelanggan_id;

        return $this->render('penggunaan_tahun', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'queryParams' => ArrayHelper::merge($this->request->queryParams, ['report' => 'penggunaan_tahun']),
        ]);
    }

    /**
     * Export data laporan.
     *
     * @return string
     */
    public function actionExport()
    {
        $queryParams = $this->request->queryParams;
        $laporan = ArrayHelper::getValue($queryParams, 'report');

        if ($laporan) {
            unset($queryParams['report']);

            switch ($laporan) {
                case 'tagihan_bulan':
                    $this->exportTagihanPerBulan($queryParams);
                    break;
                case 'tunggakan_3bulan':
                    $this->exportTunggakan($queryParams);
                    break;
                case 'penggunaan_tahun':
                    $this->exportPenggunaanPerTahun($queryParams);
                    break;
            }
        }
    }

    private function exportTagihanPerBulan($params)
    {
        $searchModel = new TagihanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $data = $dataProvider->query->all();
        $listBulan = Yii::$app->params['bulan'];
        $listStatus = Yii::$app->params['statusBayar'];

        $fileName = 'Laporan Tagihan per Bulan.xlsx';
        $headers = WriterEntityFactory::createRowFromArray([
            'No',
            'ID Pelanggan',
            'Nama Pelanggan',
            'Bulan',
            'Jumlah Meter',
            'Jumlah Bayar',
            'Status',
            'Petugas',
        ]);

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);
        $writer->addRow($headers);

        $i = 1;
        foreach ($data as $tagihan) {
            $row = WriterEntityFactory::createRowFromArray([
                $i,
                $tagihan->pelanggan->kode,
                $tagihan->pelanggan->nama,
                sprintf('%s %s', $listBulan[$tagihan->bulan], $tagihan->tahun),
                $tagihan->jumlah_meter,
                $tagihan->total_bayar,
                $listStatus[$tagihan->status],
                $tagihan->petugas->nama,
            ]);
            $writer->addRow($row);
            $i++;
        }

        $writer->close();
    }

    private function exportTunggakan($params)
    {
        $searchModel = new TunggakanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $data = $dataProvider->query->all();

        $fileName = 'Laporan Tunggakan.xlsx';
        $headers = WriterEntityFactory::createRowFromArray([
            'No',
            'ID Pelanggan',
            'Nama Pelanggan',
            'Alamat',
            'Tunggakan',
            'Bulan',
            'Jumlah Meter',
            'Tarif/Kwh',
            'Jumlah Bayar',
        ]);

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);
        $writer->addRow($headers);

        $i = 1;
        foreach ($data as $tunggakan) {
            $show = [];
            $bulan = explode(',', $tunggakan->bulan);
            foreach ($bulan as $key => $value) {
                $show[] = date('MY', strtotime($value.'-01'));
            }
            $row = WriterEntityFactory::createRowFromArray([
                $i,
                $tunggakan->pelanggan->kode,
                $tunggakan->pelanggan->nama,
                $tunggakan->pelanggan->alamat,
                $tunggakan->tunggakan,
                implode(',', $show),
                $tunggakan->jumlah_meter,
                $tunggakan->tarif_perkwh,
                $tunggakan->total_bayar,
            ]);
            $writer->addRow($row);
            $i++;
        }

        $writer->close();
    }

    private function exportPenggunaanPerTahun($params)
    {
        $searchModel = new PenggunaanSearch();
        $searchModel->pelanggan_id = 0;
        $queryParams = $this->request->queryParams;
        $pelanggan_id = ArrayHelper::getValue($queryParams, 'PenggunaanSearch.pelanggan_id', 0);

        if ($pelanggan_id) {
            if ($pelanggan = Pelanggan::findOne(['kode' => $pelanggan_id])) {
                $queryParams['PenggunaanSearch']['pelanggan_id'] = $pelanggan->id;
            }
        }

        if ($pelanggan_id === '') $queryParams['PenggunaanSearch']['pelanggan_id'] = 0;

        $dataProvider = $searchModel->searchTahun($queryParams);
        $data = $dataProvider->query->all();
        $listBulan = Yii::$app->params['bulan'];

        $fileName = 'Laporan Penggunaan per Tahun.xlsx';
        $headers = WriterEntityFactory::createRowFromArray([
            'No',
            'ID Pelanggan',
            'Nama Pelanggan',
            'Bulan',
            'meter_awal',
            'meter_akhir',
            'Jumlah Meter',
            'Tarif/Kwh',
            'Jumlah Bayar',
        ]);

        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);
        $writer->addRow($headers);

        $i = 1;
        foreach ($data as $penggunaan) {
            $row = WriterEntityFactory::createRowFromArray([
                $i,
                $penggunaan->pelanggan->kode,
                $penggunaan->pelanggan->nama,
                sprintf('%s %s', $listBulan[$penggunaan->bulan], $penggunaan->tahun),
                $penggunaan->meter_awal,
                $penggunaan->meter_akhir,
                $penggunaan->tagihan->jumlah_meter,
                $penggunaan->tagihan->tarif_perkwh,
                $penggunaan->tagihan->total_bayar,
            ]);
            $writer->addRow($row);
            $i++;
        }

        $writer->close();
    }
}
