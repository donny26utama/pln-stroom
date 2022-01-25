<?php

namespace common\models;

use Yii;

class UserPetugas extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['role', 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_PETUGAS]],
            [['password', 'c_password'], 'validatePassword'],
            [['password', 'c_password'], 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            [['password', 'c_password'], 'required', 'on' => 'create'],
            [['kode', 'username', 'email', 'nama', 'jenis_kelamin'], 'required'],
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->password !== $this->c_password) {
                $this->addError($attribute, 'password yang diinput tidak sama.');
            } else {
                $this->setPassword($this->password);
            }
        }
    }

    public function setDefaultValues()
    {
        $this->loadDefaultValues();

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
