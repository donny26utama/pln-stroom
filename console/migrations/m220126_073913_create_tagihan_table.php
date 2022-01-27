<?php

use yii\db\Migration;
use common\models\Tagihan;
use common\models\Pelanggan;
use common\models\User;

/**
 * Handles the creation of table `{{%tagihan}}`.
 */
class m220126_073913_create_tagihan_table extends Migration
{
    public $tagihanTableName;
    public $pelangganTableName;
    public $petugasTableName;

    public function init()
    {
        parent::init();

        $this->tagihanTableName = Tagihan::tableName();
        $this->pelangganTableName = Pelanggan::tableName();
        $this->petugasTableName = User::tableName();
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

        $this->createTable($this->tagihanTableName, [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->notNull(),
            'pelanggan_id' => $this->integer()->notNull(),
            'bulan' => $this->string(2)->notNull(),
            'tahun' => $this->integer(4)->notNull(),
            'jumlah_meter' => $this->integer()->notNull(),
            'tarif_perkwh' => $this->double()->notNull(),
            'total_bayar' => $this->double()->notNull(),
            'data' => $this->text()->notNull(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'petugas_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-tagihan-pelanggan_id', $this->tagihanTableName, 'pelanggan_id');
        $this->createIndex('idx-tagihan-petugas_id', $this->tagihanTableName, 'petugas_id');
        $this->addForeignKey('fk-tagihan-pelanggan_id-to-pelanggan-id', $this->tagihanTableName, 'pelanggan_id', $this->pelangganTableName, 'id');
        $this->addForeignKey('fk-tagihan-petugas_id-to-user-id', $this->tagihanTableName, 'petugas_id', $this->petugasTableName, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-tagihan-petugas_id-to-user-id', $this->tagihanTableName);
        $this->dropForeignKey('fk-tagihan-pelanggan_id-to-pelanggan-id', $this->tagihanTableName);
        $this->dropIndex('idx-tagihan-petugas_id', $this->tagihanTableName);
        $this->dropIndex('idx-tagihan-pelanggan_id', $this->tagihanTableName);
        $this->dropTable($this->tagihanTableName);
    }
}
