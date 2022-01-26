<?php

use yii\db\Migration;
use common\models\Penggunaan;
use common\models\Pelanggan;
use common\models\User;

/**
 * Handles the creation of table `{{%penggunaan}}`.
 */
class m220126_062410_create_penggunaan_table extends Migration
{
    public $penggunaanTableName;
    public $pelangganTableName;
    public $petugasTableName;

    public function init()
    {
        parent::init();

        $this->penggunaanTableName = Penggunaan::tableName();
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

        $this->createTable($this->penggunaanTableName, [
            'id' => $this->primaryKey(),
            'kode' => $this->string(20)->notNull(),
            'pelanggan_id' => $this->integer()->notNull(),
            'bulan' => $this->string(2)->notNull(),
            'tahun' => $this->integer(4)->notNull(),
            'meter_awal' => $this->integer()->notNull()->defaultValue(0),
            'meter_akhir' => $this->integer()->notNull(),
            'tgl_cek' => $this->date(),
            'petugas_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-penggunaan-kode', $this->penggunaanTableName, 'kode', true);
        $this->createIndex('idx-penggunaan-pelanggan_id', $this->penggunaanTableName, 'pelanggan_id');
        $this->createIndex('idx-penggunaan-petugas_id', $this->penggunaanTableName, 'petugas_id');
        $this->addForeignKey('fk-penggunaan-pelanggan_id-to-pelanggan-id', $this->penggunaanTableName, 'pelanggan_id', $this->pelangganTableName, 'id');
        $this->addForeignKey('fk-penggunaan-petugas_id-to-user-id', $this->penggunaanTableName, 'petugas_id', $this->petugasTableName, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-penggunaan-petugas_id-to-user-id', $this->penggunaanTableName);
        $this->dropForeignKey('fk-penggunaan-pelanggan_id-to-pelanggan-id', $this->penggunaanTableName);
        $this->dropIndex('idx-penggunaan-petugas_id', $this->penggunaanTableName);
        $this->dropIndex('idx-penggunaan-pelanggan_id', $this->penggunaanTableName);
        $this->dropIndex('idx-penggunaan-kode', $this->penggunaanTableName);
        $this->dropTable($this->penggunaanTableName);
    }
}
