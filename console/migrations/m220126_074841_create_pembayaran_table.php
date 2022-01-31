<?php

use yii\db\Migration;
use common\models\Pembayaran;
use common\models\PembayaranDetail;
use common\models\Tagihan;
use common\models\User;
use common\models\Pelanggan;

/**
 * Handles the creation of table `{{%pembayaran}}`.
 */
class m220126_074841_create_pembayaran_table extends Migration
{
    public $pembayaranTableName;
    public $pembayaranDetailTableName;
    public $tagihanTableName;
    public $agenTableName;
    public $pelangganTableName;

    public function init()
    {
        parent::init();

        $this->pembayaranTableName = Pembayaran::tableName();
        $this->pembayaranDetailTableName = PembayaranDetail::tableName();
        $this->tagihanTableName = Tagihan::tableName();
        $this->agenTableName = User::tableName();
        $this->pelangganTableName = Pelanggan::tableName();
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

        $this->createTable($this->pembayaranTableName, [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->notNull(),
            'kode' => $this->string(15)->notNull(),
            'pelanggan_id' => $this->integer()->notNull(),
            'tgl_bayar' => $this->datetime()->notNull(),
            'jumlah_tagihan' => $this->double()->notNull(),
            'biaya_admin' => $this->double()->notNull(),
            'total_bayar' => $this->double()->notNull(),
            'bayar' => $this->double()->notNull(),
            'kembalian' => $this->double()->notNull(),
            'agen_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-pembayaran-pelanggan_id', $this->pembayaranTableName, 'pelanggan_id');
        $this->addForeignKey('fk-pembayaran-pelanggan_id-to-pelanggan-id', $this->pembayaranTableName, 'pelanggan_id', $this->pelangganTableName, 'id');
        $this->createIndex('idx-pembayaran-agen_id', $this->pembayaranTableName, 'agen_id');
        $this->addForeignKey('fk-pembayaran-agen_id-to-user-id', $this->pembayaranTableName, 'agen_id', $this->agenTableName, 'id');

        $this->createTable($this->pembayaranDetailTableName, [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->notNull(),
            'pembayaran_id' => $this->integer()->notNull(),
            'tagihan_id' => $this->integer()->notNull(),
            'denda' => $this->double()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('idx-pembayaran_detil-pembayaran_id', $this->pembayaranDetailTableName, 'pembayaran_id');
        $this->createIndex('idx-pembayaran_detil-tagihan_id', $this->pembayaranDetailTableName, 'tagihan_id');
        $this->addForeignKey('fk-pembayaran_detil-pembayaran_id-to-user-id', $this->pembayaranDetailTableName, 'pembayaran_id', $this->pembayaranTableName, 'id');
        $this->addForeignKey('fk-pembayaran_detil-tagihan_id-to-tagihan-id', $this->pembayaranDetailTableName, 'tagihan_id', $this->tagihanTableName, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-pembayaran_detil-tagihan_id-to-tagihan-id', $this->pembayaranDetailTableName);
        $this->dropForeignKey('fk-pembayaran_detil-pembayaran_id-to-user-id', $this->pembayaranDetailTableName);
        $this->dropIndex('idx-pembayaran_detil-tagihan_id', $this->pembayaranDetailTableName);
        $this->dropIndex('idx-pembayaran_detil-pembayaran_id', $this->pembayaranDetailTableName);
        $this->dropForeignKey('fk-pembayaran-agen_id-to-user-id', $this->pembayaranTableName);
        $this->dropIndex('idx-pembayaran-agen_id', $this->pembayaranTableName);
        $this->dropForeignKey('fk-pembayaran-pelanggan_id-to-pelanggan-id', $this->pembayaranTableName);
        $this->dropIndex('idx-pembayaran-pelanggan_id', $this->pembayaranTableName);
        $this->dropTable($this->pembayaranDetailTableName);
        $this->dropTable($this->pembayaranTableName);
    }
}
