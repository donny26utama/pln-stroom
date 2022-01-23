<?php

namespace common\models;

use Yii;
use Ramsey\Uuid\Uuid;

/**
 * This is the model class for table "penggunaan".
 *
 * @property int $id
 * @property string $kode
 * @property int $pelanggan_id
 * @property string $bulan
 * @property string $tahun
 * @property int $meter_awal
 * @property int $meter_akhir
 * @property string|null $tgl_cek
 * @property int|null $petugas_id
 */
class Penggunaan extends \yii\db\ActiveRecord
{
    public $periode;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penggunaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meter_awal', 'meter_akhir'], 'default', 'value' => 0],
            [['kode', 'pelanggan_id', 'bulan', 'tahun'], 'required'],
            [['pelanggan_id', 'meter_awal', 'meter_akhir', 'petugas_id'], 'integer'],
            [['tahun', 'tgl_cek'], 'safe'],
            [['kode'], 'string', 'max' => 20],
            [['bulan'], 'string', 'max' => 2],
            [['meter_akhir'], 'validateMeterAkhir', 'on' => 'update'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'kode' => Yii::t('app', 'Kode'),
            'pelanggan_id' => Yii::t('app', 'Pelanggan'),
            'bulan' => Yii::t('app', 'Bulan'),
            'tahun' => Yii::t('app', 'Tahun'),
            'meter_awal' => Yii::t('app', 'Meter Awal'),
            'meter_akhir' => Yii::t('app', 'Meter Akhir'),
            'tgl_cek' => Yii::t('app', 'Tanggal Pengecekan'),
            'petugas_id' => Yii::t('app', 'Petugas'),
            'periode' => Yii::t('app', 'Bulan Penggunaan'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!$insert) {
            $pelanggan = $this->pelanggan;
            $tarif = $pelanggan->tarif;
            $jumlah_meter = $this->meter_akhir - $this->meter_awal;

            $model = new Tagihan();
            $model->uuid = Uuid::uuid4()->toString();
            $model->pelanggan_id = $this->pelanggan_id;
            $model->bulan = $this->bulan;
            $model->tahun = $this->tahun;
            $model->jumlah_meter = $jumlah_meter;
            $model->tarif_perkwh = $tarif->tarif_perkwh;
            $model->total_bayar = $jumlah_meter * $tarif->tarif_perkwh;
            $model->data = json_encode([
                'tarif' => [
                    'kode' => $tarif->kode,
                    'daya' => $tarif->daya,
                    'tarif_perkwh' => $tarif->tarif_perkwh,
                ],
            ]);
            $model->petugas_id = Yii::$app->user->id;
            $model->save();

            $period = date('Y-m-d', strtotime(sprintf('%s-%s-01', $this->tahun, $this->bulan) . ' +1 month'));

            $model = new Penggunaan();
            $model->kode = date('YmdHis') . date('mY', strtotime($period));
            $model->pelanggan_id = $this->pelanggan_id;
            $model->bulan = date('m', strtotime($period));
            $model->tahun = date('Y', strtotime($period));
            $model->meter_awal = $this->meter_akhir;
            $model->save();
        }
    }

    public function validateMeterAkhir($attribute)
    {
        if ($this->meter_akhir < $this->meter_awal) {
            $this->addError($attribute, 'Meter Akhir tidak boleh kurang dari Meter Awal.');
        }
    }

    public function setDefaultValues()
    {
        $this->loadDefaultValues();

        if ($this->pelanggan_id) {
            $pelanggan = $this->pelanggan;
            $this->periode = date('M Y', strtotime(sprintf('%s-%s-01', $this->tahun, $this->bulan)));
        }
    }

    public function getPelanggan()
    {
        return $this->hasOne(Pelanggan::class, ['id' => 'pelanggan_id']);
    }
}
