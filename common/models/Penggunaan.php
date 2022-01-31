<?php

namespace common\models;

use Yii;
use Ramsey\Uuid\Uuid;

/**
 * This is the model class for table "penggunaan".
 *
 * @property int $id
 * @property string $uuid
 * @property string $kode
 * @property int $pelanggan_id
 * @property string $bulan
 * @property int $tahun
 * @property int $meter_awal
 * @property int $meter_akhir
 * @property string|null $tgl_cek
 * @property int|null $petugas_id
 *
 * @property Pelanggan $pelanggan
 * @property User $petugas
 */
class Penggunaan extends \yii\db\ActiveRecord
{
    public $periode;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%penggunaan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['petugas_id'], 'default', 'value' => Yii::$app->user->id],
            [['uuid'], 'default', 'value' => $this->generateUuid()],
            [['meter_awal', 'meter_akhir'], 'default', 'value' => 0],
            [['uuid', 'kode', 'pelanggan_id', 'bulan', 'tahun', 'meter_akhir'], 'required'],
            [['pelanggan_id', 'tahun', 'meter_awal', 'meter_akhir', 'petugas_id'], 'integer'],
            [['tgl_cek'], 'safe'],
            [['uuid'], 'string', 'max' => 36],
            [['kode'], 'string', 'max' => 20],
            [['bulan'], 'string', 'max' => 2],
            [['kode'], 'unique'],
            [['pelanggan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pelanggan::class, 'targetAttribute' => ['pelanggan_id' => 'id']],
            [['petugas_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['petugas_id' => 'id']],
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
            'uuid' => Yii::t('app', 'UUID'),
            'kode' => Yii::t('app', 'Kode'),
            'pelanggan_id' => Yii::t('app', 'Pelanggan'),
            'bulan' => Yii::t('app', 'Bulan'),
            'tahun' => Yii::t('app', 'Tahun'),
            'meter_awal' => Yii::t('app', 'Meter Awal'),
            'meter_akhir' => Yii::t('app', 'Meter Akhir'),
            'tgl_cek' => Yii::t('app', 'Tanggal Pengecekan'),
            'petugas_id' => Yii::t('app', 'Petugas'),
        ];
    }

    /**
     * Gets query for [[Pelanggan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPelanggan()
    {
        return $this->hasOne(Pelanggan::class, ['id' => 'pelanggan_id']);
    }

    /**
     * Gets query for [[Petugas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPetugas()
    {
        return $this->hasOne(User::class, ['id' => 'petugas_id']);
    }

    /**
     * Gets query for [[Tagihan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagihan()
    {
        return $this->hasOne(Tagihan::class, ['pelanggan_id' => 'pelanggan_id', 'bulan' => 'bulan', 'tahun' => 'tahun']);
    }

    public function generateUuid()
    {
        return Uuid::uuid4()->toString();
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
            $model->penggunaan_id = $this->id;
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
            $this->periode = date('M Y', strtotime(sprintf('%s-%s-01', $this->tahun, $this->bulan)));
        }
    }
}
