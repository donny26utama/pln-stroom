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
 * @property string $tahun
 * @property int $jumlah_meter
 * @property float $tarif_perkwh
 * @property float $total_bayar
 * @property string $data
 * @property int $status
 * @property int $petugas_id
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
            [['uuid', 'pelanggan_id', 'bulan', 'tahun', 'jumlah_meter', 'data', 'petugas_id'], 'required'],
            [['pelanggan_id', 'jumlah_meter', 'status', 'petugas_id'], 'integer'],
            [['tahun'], 'safe'],
            [['tarif_perkwh', 'total_bayar'], 'number'],
            [['data'], 'string'],
            [['uuid'], 'string', 'max' => 36],
            [['bulan'], 'string', 'max' => 2],
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
            'pelanggan_id' => Yii::t('app', 'Pelanggan ID'),
            'bulan' => Yii::t('app', 'Bulan'),
            'tahun' => Yii::t('app', 'Tahun'),
            'jumlah_meter' => Yii::t('app', 'Jumlah Meter'),
            'tarif_perkwh' => Yii::t('app', 'Tarif Perkwh'),
            'total_bayar' => Yii::t('app', 'Total Bayar'),
            'data' => Yii::t('app', 'Data'),
            'status' => Yii::t('app', 'Status'),
            'petugas_id' => Yii::t('app', 'Petugas ID'),
        ];
    }
}
