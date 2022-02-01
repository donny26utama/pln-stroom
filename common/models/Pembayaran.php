<?php

namespace common\models;

use Yii;
use Ramsey\Uuid\Uuid;

/**
 * This is the model class for table "pembayaran".
 *
 * @property int $id
 * @property string $uuid
 * @property string $kode
 * @property int $pelanggan_id
 * @property string $tgl_bayar
 * @property float $jumlah_tagihan
 * @property float $biaya_admin
 * @property float $total_bayar
 * @property float $bayar
 * @property float $kembalian
 * @property int $agen_id
 *
 * @property User $agen
 * @property Pelanggan $pelanggan
 * @property PembayaranDetail[] $pembayaranDetails
 */
class Pembayaran extends \yii\db\ActiveRecord
{
    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;

    public $fee;
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
            [['uuid', 'kode', 'pelanggan_id', 'tgl_bayar', 'jumlah_tagihan', 'biaya_admin', 'total_bayar', 'bayar', 'kembalian', 'agen_id'], 'required'],
            [['pelanggan_id', 'agen_id'], 'integer'],
            [['tgl_bayar'], 'safe'],
            [['jumlah_tagihan', 'biaya_admin', 'total_bayar', 'bayar', 'kembalian'], 'number'],
            [['uuid'], 'string', 'max' => 36],
            [['kode'], 'string', 'max' => 15],
            [['agen_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['agen_id' => 'id']],
            [['pelanggan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pelanggan::class, 'targetAttribute' => ['pelanggan_id' => 'id']],
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
            'kode' => Yii::t('app', 'ID Pembayaran'),
            'pelanggan_id' => Yii::t('app', 'Pelanggan'),
            'tgl_bayar' => Yii::t('app', 'Tgl Bayar'),
            'jumlah_tagihan' => Yii::t('app', 'Jumlah Tagihan'),
            'biaya_admin' => Yii::t('app', 'Biaya Admin'),
            'total_bayar' => Yii::t('app', 'Total Bayar'),
            'bayar' => Yii::t('app', 'Bayar'),
            'kembalian' => Yii::t('app', 'Kembalian'),
            'agen_id' => Yii::t('app', 'Agen'),
        ];
    }

    /**
     * Gets query for [[Agen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgen()
    {
        return $this->hasOne(User::class, ['id' => 'agen_id']);
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
        return $this->hasMany(PembayaranDetail::class, ['pembayaran_id' => 'id']);
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
        $this->agen_id = Yii::$app->user->id;
        $this->fee = $this->agen->agen->fee;
        $this->uuid = Uuid::uuid4()->toString();

        $today = date('Ymd');
        $lastBayar = Pembayaran::find()->where(['like', 'kode', $today])->one();
        $kode = $lastBayar ? substr($lastBayar->kode, 12, 4) + 1 : 1;
        $this->kode = sprintf('BYR%s%04s', $today, $kode);
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
                // $model->denda = 0;
                $model->biaya_admin = $this->fee;
                $model->save();

                $tagihan->status = self::STATUS_PAID;
                $tagihan->save();
            }
        }
    }
}
