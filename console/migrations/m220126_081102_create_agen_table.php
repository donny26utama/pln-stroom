<?php

use yii\db\Migration;
use common\models\Agen;
use common\models\User;

/**
 * Handles the creation of table `{{%agen}}`.
 */
class m220126_081102_create_agen_table extends Migration
{
    public $agenTableName;
    public $userTableName;

    public function init()
    {
        parent::init();

        $this->agenTableName = Agen::tableName();
        $this->userTableName = User::tableName();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->agenTableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'fee' => $this->double()->notNull()->defaultValue(0),
            'saldo' => $this->double()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-agen-user_id', $this->agenTableName, 'user_id');
        $this->addForeignKey('fk-agen-user_id-to-user-id', $this->agenTableName, 'user_id', $this->userTableName, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-agen-user_id-to-user-id', $this->agenTableName);
        $this->dropIndex('idx-agen-user_id', $this->agenTableName);
        $this->dropTable($this->agenTableName);
    }
}
