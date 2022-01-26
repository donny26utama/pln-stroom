<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pembayaran_detail".
 *
 * @property int $id
 * @property int|null $pembayaran_id
 * @property int|null $tagihan_id
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
            [['pembayaran_id', 'tagihan_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pembayaran_id' => Yii::t('app', 'Pembayaran ID'),
            'tagihan_id' => Yii::t('app', 'Tagihan ID'),
        ];
    }
}
