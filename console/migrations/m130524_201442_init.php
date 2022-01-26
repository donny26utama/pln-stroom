<?php

use yii\db\Migration;
use common\models\UserPetugas;
use Ramsey\Uuid\Uuid;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'kode' => $this->string()->notNull()->unique(),
            'nama' => $this->string()->notNull(),
            'alamat' => $this->text(),
            'no_telepon' => $this->string(),
            'jenis_kelamin' => $this->string()->notNull()->defaultValue('pria'),
            'role' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'auth_key' => $this->string(32)->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'verification_token' => $this->string()->defaultValue(null),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $model = new UserPetugas();
        $model->setDefaultValues();
        $model->uuid = Uuid::uuid4()->toString();
        $model->username = 'admin';
        $model->email = 'admin@example.com';
        $model->nama = 'System Administrator';
        $model->status = UserPetugas::STATUS_ACTIVE;
        $model->role = UserPetugas::ROLE_ADMIN;
        $model->setPassword('admin123');
        $model->generateAuthKey();
        $model->generateEmailVerificationToken();
        $model->save();
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
