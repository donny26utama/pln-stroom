<?php

use yii\db\Migration;
use Ramsey\Uuid\Uuid;

/**
 * Handles the creation of table `{{%tarif}}`.
 */
class m220126_044918_create_tarif_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tarif}}', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->notNull(),
            'kode' => $this->string(20)->notNull(),
            'golongan' => $this->string(10)->notNull(),
            'daya' => $this->string(10)->notNull(),
            'tarif_perkwh' => $this->double()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tarif}}');
    }
}
