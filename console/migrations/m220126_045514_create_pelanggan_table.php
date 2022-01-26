<?php

use yii\db\Migration;
use Ramsey\Uuid\Uuid;
use common\models\Pelanggan;
use common\models\Tarif;

/**
 * Handles the creation of table `{{%pelanggan}}`.
 */
class m220126_045514_create_pelanggan_table extends Migration
{
    public $pelangganTableName;
    public $tarifTableName;

    public function init()
    {
        parent::init();

        $this->pelangganTableName = Pelanggan::tableName();
        $this->tarifTableName = Tarif::tableName();
    }

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

        $this->createTable($this->pelangganTableName, [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->notNull(),
            'kode' => $this->string(14)->notNull(),
            'no_meter' => $this->string(14)->notNull(),
            'nama' => $this->string(50)->notNull(),
            'alamat' => $this->text()->notNull(),
            'tenggang' => $this->string(2)->notNull(),
            'tarif_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-pelanggan-tarif_id', $this->pelangganTableName, 'tarif_id');
        $this->addForeignKey('fk-pelanggan-tarif_id-to-tarif-id', $this->pelangganTableName, 'tarif_id', $this->tarifTableName, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-pelanggan-tarif_id-to-tarif-id', $this->pelangganTableName);
        $this->dropIndex('idx-pelanggan-tarif_id', $this->pelangganTableName);
        $this->dropTable($this->pelangganTableName);
    }
}
