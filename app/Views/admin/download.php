<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Barcode Produk</title>
    <style>
        .barcode-container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }
        .barcode-item {
            border : 1px solid #333;
            padding : 5px;
            display: inline-block;
            width: 250px;
            text-align: center;
            margin-bottom: 10px;
            margin-left: 50px;
        }
    </style>
</head>

<body>
    <?php
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo '<div class="barcode-container">';
        for($i = 1;$i<= 13;$i++){
            for ($j = 2;$j>=1;$j--){
                echo '<div class="barcode-item">';
                echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($kode['kode_produk'], $generator::TYPE_CODE_128)) . '" style="width: 250px;">';
                echo '<br>';
                echo $kode['kode_produk'];
                echo '</div>';
            }
            echo '<br>';
        }
        echo '</div>';    
    ?>
</body>

</html>