<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Ramsey\Uuid\Uuid;

/**
 * User model
 *
 * @property integer $id
 * @property string $uuid
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $kode
 * @property string $nama
 * @property string|null $alamat
 * @property string|null $no_telepon
 * @property string $jenis_kelamin
 * @property string $role
 * @property int $status
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property string|null $password_reset_token
 * @property string|null $verification_token
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Agen[] $agens
 * @property Pembayaran[] $pembayarans
 * @property Penggunaan[] $penggunaans
 * @property Tagihan[] $tagihans
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = -1;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const ROLE_ADMIN = 'admin';
    const ROLE_PETUGAS = 'petugas';
    const ROLE_AGEN = 'agen';

    const JK_PRIA = 'pria';
    const JK_WANITA = 'wanita';

    public $password;
    public $c_password;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            [['uuid'], 'default', 'value' => Uuid::uuid4()->toString()],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['role', 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_PETUGAS, self::ROLE_AGEN]],
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nama' => Yii::t('app', 'Nama Lengkap'),
            'no_telepon' => Yii::t('app', 'No Telp'),
            'alamat' => Yii::t('app', 'Alamat'),
            'jenis_kelamin' => Yii::t('app', 'Jenis Kelamin'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'verification_token' => Yii::t('app', 'Verification Token'),
            'role' => Yii::t('app', 'Role'),
            'password' => Yii::t('app', 'Password'),
            'c_password' => Yii::t('app', 'Konfirmasi Password'),
        ];
    }

    /**
     * Gets query for [[Agens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgens()
    {
        return $this->hasMany(Agen::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Pembayarans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembayarans()
    {
        return $this->hasMany(Pembayaran::class, ['agen_id' => 'id']);
    }

    /**
     * Gets query for [[Penggunaans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPenggunaans()
    {
        return $this->hasMany(Penggunaan::class, ['petugas_id' => 'id']);
    }

    /**
     * Gets query for [[Tagihans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagihans()
    {
        return $this->hasMany(Tagihan::class, ['petugas_id' => 'id']);
    }

    public function getAgen()
    {
        return $this->hasOne(Agen::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function validatePasswordInput($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->password !== $this->c_password) {
                $this->addError($attribute, 'password yang diinput tidak sama.');
            } else {
                $this->setPassword($this->password);
            }
        }
    }
}
