<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "view_tunggakan".
 *
 * @property int $pelanggan_id
 * @property int $tunggakan
 * @property string|null $bulan
 * @property float|null $jumlah_meter
 * @property float|null $total_bayar
 * @property float $tarif_perkwh
 *
 * @property Pelanggan $pelanggan
 */
class Tunggakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%view_tunggakan}}';
    }

    public static function primaryKey()
    {
        return ['pelanggan_id', 'tarif_perkwh'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pelanggan_id', 'tarif_perkwh'], 'required'],
            [['pelanggan_id', 'tunggakan'], 'integer'],
            [['bulan'], 'string'],
            [['jumlah_meter', 'total_bayar', 'tarif_perkwh'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pelanggan_id' => Yii::t('app', 'Pelanggan ID'),
            'tunggakan' => Yii::t('app', 'Tunggakan'),
            'bulan' => Yii::t('app', 'Bulan'),
            'jumlah_meter' => Yii::t('app', 'Jumlah Meter'),
            'total_bayar' => Yii::t('app', 'Total Bayar'),
            'tarif_perkwh' => Yii::t('app', 'Tarif Perkwh'),
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
}
