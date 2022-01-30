<?php

namespace common\models;

use Yii;
use Ramsey\Uuid\Uuid;

class UserAgen extends User
{
    public $agenFee;
    public $agenSaldo;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_INACTIVE],
            [['username', 'email'], 'trim'],
            [['username', 'email', 'kode'], 'unique'],
            [['username'], 'string', 'min' => 2, 'max' => 255],
            [['email'], 'email'],
            [['username', 'email', 'nama', 'role'], 'string', 'max' => 255],
            [['uuid'], 'string', 'max' => 36],
            [['kode', 'no_telepon'], 'string', 'max' => 20],
            [['jenis_kelamin'], 'string', 'max' => 10],
            [['alamat'], 'string'],
            [['kode', 'username', 'email', 'nama', 'jenis_kelamin', 'role'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['kode', 'username', 'email', 'nama', 'jenis_kelamin', 'agenFee', 'agenSaldo'], 'required'],
            [['password', 'c_password'], 'required', 'on' => 'create'],
            [['password', 'c_password'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            [['password', 'c_password'], 'validatePasswordInput'],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['role'], 'in', 'range' => [self::ROLE_AGEN]],
            [['agenFee', 'agenSaldo'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE, 'role' => self::ROLE_AGEN]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'role' => self::ROLE_AGEN, 'status' => self::STATUS_ACTIVE]);
    }

    public function setDefaultValues()
    {
        $this->loadDefaultValues();

        $this->uuid = Uuid::uuid4()->toString();

        $today = date('Ymd');
        $lastAgen = User::find()->where(['like', 'kode', $today])->one();

        $kode = $lastAgen ? substr($lastAgen->kode, 9, 3) + 1 : 1;
        $this->kode = sprintf('A%s%03s', $today, $kode);

        if ($this->isNewRecord) {
            $this->role = User::ROLE_AGEN;
            $this->agenFee = 2500;
            $this->agenSaldo = 0;
        }
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->setPassword($this->password);
        $this->role = self::ROLE_AGEN;
        $this->generateAuthKey();
        $this->generateEmailVerificationToken();

        return $this->save();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $model = new Agen();
            $model->user_id = $this->id;
            $model->fee = $this->agenFee;
            $model->saldo = $this->agenSaldo;
            $model->save();
        }
    }

    public function getAgen()
    {
        return $this->hasOne(Agen::class, ['user_id' => 'id']);
    }

    public function afterFind()
    {
        $this->agenFee = $this->agen->fee;
        $this->agenSaldo = $this->agen->saldo;
    }
}
