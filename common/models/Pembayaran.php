<?php

namespace common\models;

use Yii;
use Ramsey\Uuid\Uuid;

/**
 * This is the model class for table "pembayaran".
 *
 * @property int $id
 * @property string $uuid
 * @property string $tgl_bayar
 * @property float $jumlah_tagihan
 * @property float $biaya_admin
 * @property float $total_bayar
 * @property float $bayar
 * @property float $kembalian
 * @property int $agen_id
 */
class Pembayaran extends \yii\db\ActiveRecord
{
    public $tanggal;
    public $tempTagihan;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pembayaran}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'tgl_bayar', 'jumlah_tagihan', 'biaya_admin', 'total_bayar', 'bayar', 'kembalian', 'agen_id'], 'required'],
            [['tgl_bayar'], 'safe'],
            [['jumlah_tagihan', 'biaya_admin', 'total_bayar', 'bayar', 'kembalian'], 'number'],
            [['agen_id'], 'integer'],
            [['uuid'], 'string', 'max' => 36],
            [['bayar'], 'validateBayar'],
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
            'tgl_bayar' => Yii::t('app', 'Tgl Bayar'),
            'jumlah_tagihan' => Yii::t('app', 'Jumlah Tagihan'),
            'biaya_admin' => Yii::t('app', 'Biaya Admin'),
            'total_bayar' => Yii::t('app', 'Total Bayar'),
            'bayar' => Yii::t('app', 'Bayar'),
            'kembalian' => Yii::t('app', 'Kembalian'),
            'agen_id' => Yii::t('app', 'Agen ID'),
        ];
    }

    public function validateBayar($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->bayar < $this->total_bayar) {
                $this->addError($attribute, 'Nominal Bayar tidak boleh kurang dari Total Bayar');
            }
        }
    }

    public function setDefaultValues()
    {
        $this->loadDefaultValues();

        $this->tgl_bayar = date('Y-m-d H:i:s');
        $this->tanggal = date('d F Y');

        if ($this->agen_id) {
            $this->biaya_admin = $this->agen->fee;
        }

        $this->uuid = Uuid::uuid4()->toString();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            foreach ($this->tempTagihan as $tagihan) {
                $model = new PembayaranDetail();
                $model->uuid = Uuid::uuid4()->toString();
                $model->pembayaran_id = $this->id;
                $model->tagihan_id = $tagihan->id;
                $model->save();
                $tagihan->status = 1;
                $tagihan->save();
            }
        }
    }

    public function getAgen()
    {
        return $this->hasOne(Agen::class, ['user_id' => 'agen_id']);
    }
}
