<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><b>Barcode Generator</b></h3>
                <div class="pull-right">
                    <a href="<?= site_url('admin/produk') ?>" class="btn btn-warning btn-flat btn-sm">
                        <i class="fa fa-undo"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <?php
                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($kode['kode_produk'], $generator::TYPE_CODE_128)) . '">';
                ?>
                <br>
                <?=$kode['kode_produk']?>
                <br><br>
                <a href="<?= base_url('/admin/download/' . $kode['id_produk']);?>" target="_blank" class="btn btn-default btn-xs">
                 Download <i class="fa fa-download"></i>
                </a>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>