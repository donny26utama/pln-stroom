<?php

namespace common\models;

use Yii;

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
            'no_meter' => Yii::t('app', 'No Meter'),
            'nama' => Yii::t('app', 'Nama'),
            'alamat' => Yii::t('app', 'Alamat'),
            'tenggang' => Yii::t('app', 'Tenggang'),
            'tarif_id' => Yii::t('app', 'Tarif ID'),
        ];
    }
}
