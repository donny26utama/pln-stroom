<?php

namespace common\models;

class UserPetugas extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['role', 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_PETUGAS, self::ROLE_AGEN]],
        ];
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
