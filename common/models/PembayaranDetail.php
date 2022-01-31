<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pembayaran_detail".
 *
 * @property int $id
 * @property string $uuid
 * @property int $pembayaran_id
 * @property int $tagihan_id
 * @property float $denda
 *
 * @property Pembayaran $pembayaran
 * @property Tagihan $tagihan
 */
class PembayaranDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pembayaran_detail}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'pembayaran_id', 'tagihan_id'], 'required'],
            [['pembayaran_id', 'tagihan_id'], 'integer'],
            [['denda', 'biaya_admin'], 'number'],
            [['uuid'], 'string', 'max' => 36],
            [['pembayaran_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pembayaran::class, 'targetAttribute' => ['pembayaran_id' => 'id']],
            [['tagihan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tagihan::class, 'targetAttribute' => ['tagihan_id' => 'id']],
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
            'pembayaran_id' => Yii::t('app', 'Pembayaran ID'),
            'tagihan_id' => Yii::t('app', 'Tagihan ID'),
            'denda' => Yii::t('app', 'Denda'),
            'biaya_admin' => Yii::t('app', 'Biaya Admin'),
        ];
    }

    /**
     * Gets query for [[Pembayaran]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembayaran()
    {
        return $this->hasOne(Pembayaran::class, ['id' => 'pembayaran_id']);
    }

    /**
     * Gets query for [[Tagihan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagihan()
    {
        return $this->hasOne(Tagihan::class, ['id' => 'tagihan_id']);
    }
}
