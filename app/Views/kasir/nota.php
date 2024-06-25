<?php
    $session = session();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota</title>

    <?php
    $style = '
    <style>
        * {
            font-family: "consolas", sans-serif;
        }
        p {
            display: block;
            margin: 3px;
            font-size: 10pt;
        }
        table td {
            font-size: 9pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }

        @media print {
            @page {
                margin: 0;
                size: 75mm 
    ';
    ?>
    <?php 
    $style .= 
        ! empty($_COOKIE['innerHeight'])
            ? $_COOKIE['innerHeight'] .'mm; }'
            : '}';
    ?>
    <?php
    $style .= '
            html, body {
                width: 60mm;
            }
            .btn-print {
                display: none;
            }
        }
    </style>
    ';
    ?>
    <?= $style; ?>
</head>

<body onload="window.print(); window.close();">
    <?php  $session=session(); 
            $pj=$penjualan[0];
    ?>

    <button class="btn-print" style="position: absolute; right: 1rem; top: rem;" onclick="window.print()">Print</button>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;"><?=$session->nama_perusahaan?></h3>
        <p><?=$session->alamat?></p>
        <p>No. <?=$session->telepon?></p>
    </div>
    <br>
    <div>
        <p style="float: left;"><?= date('d-m-Y')  ?></p>
        <p style="float: right"><?= $session->username ?></p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>No Faktur : <?= $pj['no_faktur'];   ?></p>
    <p class="text-center">===================================</p>

    <br>
    <table width="100%" style="border: 0;">
        <?php $i=0;   ?>
        <?php foreach ($detail as $item) :  ?>
        <?php $dt = $item; ?>
        <tr>
            <td colspan="3"><?= $dt['produk'] ?></td>
        </tr>
        <tr>
            <td><?= $dt['jumlah'] ?> x RP <?=number_format($dt['harga_jual'],0,",",".");?></td>
            <td></td>
            <td class="text-right">RP <?=number_format($dt['sub_total'],0,",",".");?></td>
        </tr>
        <?php $i++;  ?>
        <?php  endforeach;  ?>
    </table>
    <p class="text-center">-----------------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Harga:</td>
            <td class="text-right">RP <?=number_format($pj['total_harga'],0,",",".");?></td>
        </tr>
        <tr>
            <td>Total Item:</td>
            <td class="text-right"><?=$pj['total_item'];?></td>
        </tr>
        <tr>
            <td>Diterima:</td>
            <td class="text-right">RP <?=number_format($pj['diterima'],0,",",".");?></td>
        </tr>
        <tr>
            <td>Kembali:</td>
            <td class="text-right"><?= $pj['kembalian'];   ?></td>
        </tr>
    </table>

    <p class="text-center">===================================</p>
    <p class="text-center">-- TERIMA KASIH --</p>

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
            body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight
        );
        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight=" + ((height + 50) * 0.264583);
    </script>
</body>

</html>