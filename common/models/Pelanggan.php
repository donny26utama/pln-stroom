<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use Ramsey\Uuid\Uuid;

/**
 * This is the model class for table "pelanggan".
 *
 * @property int $id
 * @property string $uuid
 * @property string $kode
 * @property string $no_meter
 * @property string $nama
 * @property string $alamat
 * @property string $tenggang
 * @property int $tarif_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property Penggunaan[] $penggunaans
 * @property Tagihan[] $tagihans
 * @property Tarif $tarif
 */
class Pelanggan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pelanggan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid'], 'default', 'value' => $this->generateUuid()],
            [['uuid', 'kode', 'no_meter', 'nama', 'alamat', 'tenggang', 'tarif_id'], 'required'],
            [['alamat'], 'string'],
            [['tarif_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['uuid'], 'string', 'max' => 36],
            [['kode', 'no_meter'], 'string', 'max' => 14],
            [['nama'], 'string', 'max' => 50],
            [['tenggang'], 'string', 'max' => 2],
            [['tarif_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tarif::class, 'targetAttribute' => ['tarif_id' => 'id']],
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
            'nama' => Yii::t('app', 'Nama'),
            'alamat' => Yii::t('app', 'Alamat'),
            'tenggang' => Yii::t('app', 'Tenggang'),
            'tarif_id' => Yii::t('app', 'Jenis Tarif'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
        ];
    }

    /**
     * Gets query for [[Penggunaans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenggunaans()
    {
        return $this->hasMany(Penggunaan::class, ['pelanggan_id' => 'id']);
    }

    /**
     * Gets query for [[Tagihans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagihans()
    {
        return $this->hasMany(Tagihan::class, ['pelanggan_id' => 'id']);
    }

    /**
     * Gets query for [[Tarif]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTarif()
    {
        return $this->hasOne(Tarif::class, ['id' => 'tarif_id']);
    }

    public function getPelangganBaru()
    {
        return $this->getPenggunaans()->andWhere(['meter_awal' => 0, 'meter_akhir' => 0]);
    }

    public function getPenggunaanBaru()
    {
        return $this->getPenggunaans()->andWhere(['meter_akhir' => 0])->one();
    }

    public function getTunggakan()
    {
        return $this->getTagihans()->andWhere(['status' => Tagihan::STATUS_UNPAID])->count();
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

    public function generateUuid()
    {
        return Uuid::uuid4()->toString();
    }

    private function generatePenggunaan()
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

        $prefix = '';
        $prefix = date('z') < 10 ? '00' : (date('z') < 100 ? '0' : '');
        $this->no_meter = sprintf('%s%s', $prefix, date('zymNHs'));
    }

    public function softDelete()
    {
        $this->deleted_at = time();
        $this->save();
    }
}
