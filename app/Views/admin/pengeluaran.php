<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content">
        <h2>Data Pengeluaran</h2>
        <a href="<?= site_url('admin/downloadpdf') ?>" class="btn btn-primary">Unduh PDF</a>
        <table class="table table-hover mt-2 table-bordered">
            <thead class="table">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Produk</th>
                    <th>Total Item</th>
                    <th>Harga Beli</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($BarangMasuks as $key => $barangMasuk) : ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= date('d F Y', strtotime($barangMasuk['created_at'])) ?></td>
                        <td><?= $barangMasuk['nama_supplier'] ?></td>
                        <td><?= $barangMasuk['nama_produk'] ?></td>
                        <td><?= $barangMasuk['total_item'] ?></td>
                        <td><?= 'Rp ' . number_format($barangMasuk['harga_beli'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<?= $this->endSection() ?>
