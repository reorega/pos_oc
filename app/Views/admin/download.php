<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Barcode Produk</title>
</head>

<body>
    <?php
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($kode['kode_produk'], $generator::TYPE_CODE_128)) . '"style="width:250px">';
    ?>
    <br>
    <?=$kode['kode_produk']?>
</body>

</html>