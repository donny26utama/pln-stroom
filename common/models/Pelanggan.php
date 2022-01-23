<?php

namespace common\models;

use Yii;
use Ramsey\Uuid\Uuid;

/**
 * This is the model class for table "pelanggan".
 *
 * @property int $id
 * @property string $kode
 * @property string $no_meter
 * @property string $nama
 * @property string $alamat
 * @property string $tenggang
 * @property int $tarif_id
 */
class Pelanggan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelanggan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'no_meter', 'nama', 'alamat', 'tenggang', 'tarif_id'], 'required'],
            [['alamat'], 'string'],
            [['tarif_id'], 'integer'],
            [['kode'], 'string', 'max' => 14],
            [['no_meter'], 'string', 'max' => 12],
            [['nama'], 'string', 'max' => 50],
            [['tenggang'], 'string', 'max' => 2],
            [['uuid'], 'thamtech\uuid\validators\UuidValidator'],
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
            'kode' => Yii::t('app', 'ID Pelanggan'),
            'no_meter' => Yii::t('app', 'No Meter'),
            'nama' => Yii::t('app', 'Nama Lengkap'),
            'alamat' => Yii::t('app', 'Alamat'),
            'tenggang' => Yii::t('app', 'Tenggang'),
            'tarif_id' => Yii::t('app', 'Jenis Tarif'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $this->generatePenggunaan();
        }
    }

    private function generatePenggunaan($periode = '')
    {
        $model = new Penggunaan();
        $model->kode = $this->kode . date('mY');
        $model->pelanggan_id = $this->id;
        $model->bulan = date('m');
        $model->tahun = date('Y');
        $model->save();
    }

    public function setDefaultValues()
    {
        $this->loadDefaultValues();

        $this->tenggang = date('d');
        $this->kode = date('YmdHis');
        $this->uuid = Uuid::uuid4();

        $prefix = '';
        $prefix = date('z') < 10 ? '00' : (date('z') < 100 ? '0' : '');
        $this->no_meter = sprintf('%s%s', $prefix, date('zymNHs'));
    }

    public function getTarif()
    {
        return $this->hasOne(Tarif::class, ['id' => 'tarif_id']);
    }

    public function getPenggunaan()
    {
        return $this->hasMany(Penggunaan::class, ['pelanggan_id' => 'id']);
    }

    public function getTagihan()
    {
        return $this->hasMany(Tagihan::class, ['pelanggan_id' => 'id']);
    }

    public function getPelangganBaru()
    {
        return $this->getPenggunaan()->andWhere(['meter_awal' => 0, 'meter_akhir' => 0]);
    }

    public function getPenggunaanBaru()
    {
        return $this->getPenggunaan()->andWhere(['meter_akhir' => 0])->one();
    }

    public function getTunggakan()
    {
        return $this->getTagihan()->andWhere(['status' => Tagihan::STATUS_UNPAID])->count();
    }
}
