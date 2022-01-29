<?php

use yii\db\Migration;

/**
 * Class m220129_134040_create_tunggakan_view
 */
class m220129_134040_create_tunggakan_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE VIEW view_tunggakan AS SELECT 
                `tagihan`.`pelanggan_id` AS `pelanggan_id`,
                COUNT(`tagihan`.`pelanggan_id`) AS `tunggakan`,
                GROUP_CONCAT(
                    CONCAT_WS(
                        '-',
                        CAST(`tagihan`.`tahun` as char),
                        CAST(`tagihan`.`bulan` as char)
                    ) 
                    SEPARATOR ','
                ) AS `bulan`,
                SUM(`tagihan`.`jumlah_meter`) AS `jumlah_meter`,
                SUM(`tagihan`.`total_bayar`) AS `total_bayar`,
                `tagihan`.`tarif_perkwh` AS `tarif_perkwh` 
            FROM 
                `tagihan` 
            WHERE
                `tagihan`.`status` = 0
            GROUP BY 
                `tagihan`.`pelanggan_id`,
                `tagihan`.`tarif_perkwh` 
            HAVING COUNT(`tagihan`.`pelanggan_id`) >= 3
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DROP VIEW view_tunggakan");
    }
}
