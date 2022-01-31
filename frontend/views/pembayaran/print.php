<?php
    $pembayaran = $model->pembayaran;
    $agen = $pembayaran->agen;
    $pelanggan = $pembayaran->pelanggan;
    $tagihan = $model->tagihan;
    $penggunaan = $tagihan->penggunaan;
    $data = json_decode($tagihan->data, true);
    $tarif = $data['tarif'];
    $totalBayar = $tagihan->total_bayar + $model->biaya_admin;

    $this->registerCss("
        body {
            font-family: monospace;
            font-size: 13px;
        }
        #btn-close:hover {
            cursor: pointer;
        }
    ");

    $this->registerJs("
        jQuery(document).ready(function() {
            window.print();
        });
        jQuery('#btn-close').click(function() {
            window.close();
        })
    ");
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="7" align="center"><center>STRUK PEMBAYARAN TAGIHAN LISTRIK</center></td>
    </tr>
    <br>
    <tr>
        <td align="left">IDPEL</td>
        <td align="left">:</td>
        <td align="left"><?= $pelanggan->kode; ?></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td align="left">BL/TH</td>
        <td align="left">:</td>
        <td align="left"><?= date('My', strtotime(sprintf('%s-%s-01', $tagihan->tahun, $tagihan->bulan))); ?></td>
    </tr>
    <tr>
        <td align="left">NAMA</td>
        <td align="left">:</td>
        <td align="left"><?= $pelanggan->nama; ?></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td align="left">STAND METER</td>
        <td align="left">:</td>
        <td align="left"><?= $penggunaan->meter_awal."-".$penggunaan->meter_akhir; ?></td>
    </tr>
    <tr>
        <td align="left">TARIF/DAYA</td>
        <td align="left">:</td>
        <td align="left"><?= $tarif['kode']; ?></td>
    </tr>
    <tr>
        <td align="left">RP. TAG PLN</td>
        <td align="left">:</td>
        <td align="left">
            <?= Yii::$app->stroom->formatCurrency($tagihan->total_bayar); ?>
        </td>
    </tr>
    <tr>
        <td align="left">JFA REF</td>
        <td align="left">:</td>
        <td align="left"><?= strtoupper(sha1($pembayaran->kode . $agen->kode)); ?></td>
    </tr>
    <tr>
        <td colspan="7" align="center">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="7" align="center"><center>PLN Menyatakan struk ini seabgai bukti pembayaran yang sah</center></td>
    </tr>
    <tr>
        <td colspan="7" align="center">&nbsp;</td>
    </tr>
    <tr>
        <td align="left">ADMIN BANK</td>
        <td align="left">:</td>
        <td align="left"><?= Yii::$app->stroom->formatCurrency($model->biaya_admin); ?></td>
    </tr>
    <tr>
        <td align="left">TOTAL BAYAR</td>
        <td align="left">:</td>
        <td align="left"><?= Yii::$app->stroom->formatCurrency($totalBayar); ?></td>
    </tr>
    <tr>
        <td align="left">TERBILANG</td>
        <td align="left">:</td>
        <td align="left" colspan="5"><?= strtoupper(Yii::$app->stroom->terbilang($totalBayar)); ?></td>
    </tr>
    <tr>
        <td colspan="7" align="center">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="7" align="center">TERIMA KASIH<td>
    </tr>
    <tr>
        <td colspan="7" align="center">Rincian Tagihan dapat diakses di www.pln.co.id, Informasi Hubungi Call Center:123</td>
    </tr>
    <tr>
        <td colspan="7" align="center">PPOB STROOM PAYMENT/<?= $agen->nama."/".$pembayaran->tgl_bayar; ?></td>
    </tr>
</table>

<div class="text-center d-print-none my-5">
    <a id="btn-close" class="btn-link">Tutup [x]</a>
</div>