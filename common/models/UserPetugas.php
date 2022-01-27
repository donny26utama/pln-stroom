<?php

namespace common\models;

use Yii;
use Ramsey\Uuid\Uuid;

class UserPetugas extends User
{
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
            [['password', 'c_password'], 'required', 'on' => 'create'],
            [['password', 'c_password'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            [['password', 'c_password'], 'validatePasswordInput'],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['role'], 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_PETUGAS]],
        ];
    }

    public function setDefaultValues()
    {
        $this->loadDefaultValues();

        $this->uuid = Uuid::uuid4()->toString();

        $today = date('Ymd');
        $lastPetugas = User::find()->where(['like', 'kode', $today])->one();

        $kode = $lastPetugas ? substr($lastPetugas->kode, 9, 3) + 1 : 1;
        $this->kode = sprintf('P%s%03s', $today, $kode);
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
        $this->role = self::ROLE_PETUGAS;
        $this->generateAuthKey();
        $this->generateEmailVerificationToken();

        return $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE, ['in', 'role', [self::ROLE_ADMIN, self::ROLE_PETUGAS]]]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE, ['in', 'role', [self::ROLE_ADMIN, self::ROLE_PETUGAS]]]);
    }
}
