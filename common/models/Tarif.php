<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tarif".
 *
 * @property int $id
 * @property string $kode
 * @property string $golongan
 * @property string $daya
 * @property float $tarif_perkwh
 */
class Tarif extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tarif}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'golongan', 'daya', 'tarif_perkwh'], 'required'],
            [['tarif_perkwh'], 'number'],
            [['kode'], 'string', 'max' => 20],
            [['golongan', 'daya'], 'string', 'max' => 10],
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
            'golongan' => Yii::t('app', 'Golongan'),
            'daya' => Yii::t('app', 'Daya'),
            'tarif_perkwh' => Yii::t('app', 'Tarif Perkwh'),
        ];
    }
}
