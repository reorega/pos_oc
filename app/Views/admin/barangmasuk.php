<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
            <i class="fa fa-plus-square"></i> Tambah Barang Masuk
        </button>
        <br><br>
        <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalLabel">Tambah Barang Masuk</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('/admin/tambahDataBarangMasuk'); ?>" method="post"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputSupplier" class="form-label">Nama Supplier : </label>
                                <select class="form-control select2" aria-label="Default select example"
                                    name="id_supplier" style="width: 100%;">
                                    <option selected disabled>Pilih Supplier</option>
                                    <?php foreach ($suppliers as $supplier) : ?>
                                    <option value="<?= $supplier['id_supplier']; ?>"><?= $supplier['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputProduk" class="form-label">Nama Produk : </label>
                                <select class="form-control select2" aria-label="Default select example"
                                    name="produk_id" style="width: 100%;">
                                    <option selected disabled>Pilih Produk</option>
                                    <?php foreach ($produks as $produk) : ?>
                                    <option value="<?= $produk['id_produk']; ?>"><?= $produk['nama_produk'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputKategori" class="form-label">Kategori : </label>
                                <select class="form-control select2" aria-label="Default select example"
                                    name="kategori_id" style="width: 100%;">
                                    <option selected disabled>Pilih Kategori</option>
                                    <?php foreach ($kategoris as $kategori) : ?>
                                    <option value="<?= $kategori['id_kategori']; ?>"><?= $kategori['nama_kategori'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputTotalItem" class="form-label">Total Item : </label>
                                <input type="text" class="form-control" id="inputTotalItem" name="total_item">
                            </div>
                            <div class="form-group">
                                <label for="inputHargaBeli" class="form-label">Harga Beli : </label>
                                <input type="text" class="form-control" id="inputHargaBeli" name="harga_beli">
                            </div>
                            <!-- Hidden input for the current date -->
                            <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                            <!-- End of hidden input -->
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-hover mt-2 table-bordered">
            <thead class="table">
                <tr>
                    <td>No</td>
                    <td>Tanggal</td>
                    <td>Supplier</td>
                    <td>Produk</td>
                    <td>Kategori</td>
                    <td>Total Item</td>
                    <td>Harga Beli</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($BarangMasuks as $key => $BarangMasuk) : ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= date('d F Y', strtotime($BarangMasuk['created_at'])) ?></td>
                    <td><?= $BarangMasuk['nama_supplier'] ?></td>
                    <td><?= $BarangMasuk['nama_produk'] ?></td>
                    <td><?= $BarangMasuk['nama_kategori'] ?></td>
                    <td><?= $BarangMasuk['total_item'] ?></td>
                    <td><?= 'Rp ' . number_format($BarangMasuk['harga_beli'], 0, ',', '.') ?></td>
                    <td>
                        <!-- Modal Previews -->
                        <button type="button" class="btn btn-info" data-toggle="modal"
                            data-target="#infoData<?= $BarangMasuk['id_barang_masuk'] ?>">
                            <i class="fa fa-eye"></i>
                        </button>
                        <div class="modal fade" id="infoData<?= $BarangMasuk['id_barang_masuk'] ?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="exampleModalLabel">Info Data</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="" class="form-label">Tanggal:
                                                <?= date('d F Y', strtotime($BarangMasuk['created_at'])) ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Supplier:
                                                <?= $BarangMasuk['nama_supplier'] ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Produk:
                                                <?= $BarangMasuk['nama_produk'] ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Kategori:
                                                <?= $BarangMasuk['nama_kategori'] ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Total Item:
                                                <?= $BarangMasuk['total_item'] ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Harga Beli:
                                                <?= $BarangMasuk['harga_beli'] ?></label>
                                        </div>
                                        <input type="hidden" name="id_barang_masuk"
                                            value="<?= $BarangMasuk['id_barang_masuk'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Previews -->

                        <button type="button" class="btn btn-warning" data-toggle="modal"
                            data-target="#editData<?= $BarangMasuk['id_barang_masuk'] ?>">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <!-- Modal Edit -->
                        <div class="modal fade" id="editData<?= $BarangMasuk['id_barang_masuk'] ?>" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="exampleModalLabel">Edit BarangMasuk</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= base_url('/admin/editDataBarangMasuk'); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <input type="hidden" name="id_barang_masuk"
                                                value="<?= $BarangMasuk['id_barang_masuk'] ?>">
                                            <div class="form-group">
                                                <label for="inputSupplier" class="form-label">Nama Supplier : </label>
                                                <select class="form-control select2" aria-label="Default select example"
                                                    name="id_supplier" style="width: 100%;">
                                                    <option selected disabled>Pilih Supplier</option>
                                                    <?php foreach ($suppliers as $supplier) : ?>
                                                    <option value="<?= $supplier['id_supplier']; ?>"
                                                        <?= ($BarangMasuk['id_supplier'] == $supplier['id_supplier']) ? 'selected' : ''; ?>>
                                                        <?= $supplier['nama'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputProduk" class="form-label">Nama Produk : </label>
                                                <select class="form-control select2" aria-label="Default select example"
                                                    name="produk_id" style="width: 100%;">
                                                    <option selected disabled>Pilih Produk</option>
                                                    <?php foreach ($produks as $produk) : ?>
                                                    <option value="<?= $produk['id_produk']; ?>"
                                                        <?= ($BarangMasuk['id_produk'] == $produk['id_produk']) ? 'selected' : ''; ?>>
                                                        <?= $produk['nama_produk'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputKategori" class="form-label">Kategori : </label>
                                                <select class="form-control select2" aria-label="Default select example"
                                                    name="kategori_id" style="width: 100%;">
                                                    <option selected disabled>Pilih Kategori</option>
                                                    <?php foreach ($kategoris as $kategori) : ?>
                                                    <option value="<?= $kategori['id_kategori']; ?>"
                                                        <?= ($BarangMasuk['id_kategori'] == $kategori['id_kategori']) ? 'selected' : ''; ?>>
                                                        <?= $kategori['nama_kategori'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputTotalItem" class="form-label">Total Item : </label>
                                                <input type="text" class="form-control" id="inputTotalItem"
                                                    name="total_item" value="<?= $BarangMasuk['total_item'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputHargaBeli" class="form-label">Harga Beli : </label>
                                                <input type="text" class="form-control" id="inputHargaBeli"
                                                    name="harga_beli" value="<?= $BarangMasuk['harga_beli'] ?>">
                                            </div>
                                            <!-- Hidden input for the current date -->
                                            <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                                            <!-- End of hidden input -->
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan Data</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal Edit -->
                        <!-- Modal Hapus -->
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#hapusData<?= $BarangMasuk['id_barang_masuk'] ?>">
                            <i class="fa fa-trash"></i>
                        </button>
                        <div class="modal fade" id="hapusData<?= $BarangMasuk['id_barang_masuk'] ?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin menghapus data BarangMasuk ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <form
                                            action="<?= base_url('/admin/hapusDataBarangMasuk/' . $BarangMasuk['id_barang_masuk']); ?>"
                                            method="post">
                                            <button type="submit" class="btn btn-danger">Hapus Data</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal Hapus -->
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<?= $this->endSection() ?>