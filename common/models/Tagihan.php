<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tagihan".
 *
 * @property int $id
 * @property string $uuid
 * @property int $pelanggan_id
 * @property string $bulan
 * @property int $tahun
 * @property int $jumlah_meter
 * @property float $tarif_perkwh
 * @property float $total_bayar
 * @property string $data
 * @property int $status
 * @property int $petugas_id
 *
 * @property Pelanggan $pelanggan
 * @property PembayaranDetail[] $pembayaranDetails
 * @property User $petugas
 */
class Tagihan extends \yii\db\ActiveRecord
{
    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tagihan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'pelanggan_id', 'bulan', 'tahun', 'jumlah_meter', 'tarif_perkwh', 'total_bayar', 'data', 'petugas_id'], 'required'],
            [['pelanggan_id', 'tahun', 'jumlah_meter', 'status', 'petugas_id'], 'integer'],
            [['tarif_perkwh', 'total_bayar'], 'number'],
            [['data'], 'string'],
            [['uuid'], 'string', 'max' => 36],
            [['bulan'], 'string', 'max' => 2],
            [['pelanggan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pelanggan::class, 'targetAttribute' => ['pelanggan_id' => 'id']],
            [['petugas_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['petugas_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uuid' => Yii::t('app', 'Uuid'),
            'pelanggan_id' => Yii::t('app', 'Pelanggan'),
            'bulan' => Yii::t('app', 'Bulan'),
            'tahun' => Yii::t('app', 'Tahun'),
            'jumlah_meter' => Yii::t('app', 'Jumlah Meter'),
            'tarif_perkwh' => Yii::t('app', 'Tarif Perkwh'),
            'total_bayar' => Yii::t('app', 'Total Bayar'),
            'data' => Yii::t('app', 'Data'),
            'status' => Yii::t('app', 'Status'),
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
     * Gets query for [[PembayaranDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembayaranDetails()
    {
        return $this->hasMany(PembayaranDetail::class, ['tagihan_id' => 'id']);
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
}
