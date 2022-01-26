<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use Ramsey\Uuid\Uuid;

/**
 * This is the model class for table "tarif".
 *
 * @property int $id
 * @property string $uuid
 * @property string $kode
 * @property string $golongan
 * @property string $daya
 * @property float $tarif_perkwh
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property Pelanggan[] $pelanggans
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
            [['uuid', 'kode', 'golongan', 'daya'], 'required'],
            [['tarif_perkwh'], 'number'],
            [['uuid'], 'string', 'max' => 36],
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
            'uuid' => Yii::t('app', 'UUID'),
            'kode' => Yii::t('app', 'Kode'),
            'golongan' => Yii::t('app', 'Golongan'),
            'daya' => Yii::t('app', 'Daya'),
            'tarif_perkwh' => Yii::t('app', 'Tarif Perkwh'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
        ];
    }

    /**
     * Gets query for [[Pelanggans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPelanggans()
    {
        return $this->hasMany(Pelanggan::class, ['tarif_id' => 'id']);
    }

    public function generateUuid()
    {
        return Uuid::uuid4()->toString();
    }
}
