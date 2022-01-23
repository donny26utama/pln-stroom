<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "agen".
 *
 * @property int $id
 * @property int $user_id
 * @property float|null $fee
 * @property float|null $saldo
 */
class Agen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['fee', 'saldo'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'fee' => Yii::t('app', 'Fee'),
            'saldo' => Yii::t('app', 'Saldo'),
        ];
    }
}
