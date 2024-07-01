<table class="table table-hover mt-2 table-bordered">
    <thead class="table">
        <tr>
            <th>No</th>
            <th>Supplier</th>
            <th>Produk</th>
            <th>Total Item</th>
            <th>Harga Barang</th>
            <th>Total Bayar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $nilai = $no ?? 1; ?>
        <?php foreach ($barangmasuk as $key => $brg) : ?>
        <tr>
            <td><?= $nilai ?></td>
            <td><?= $brg['supplier_name'] ?></td>
            <td><?= $brg['product_name'] ?></td>
            <td><?= $brg['total_item'] ?></td>
            <td><?= 'Rp ' . number_format($brg['harga_beli'], 0, ',', '.') ?></td>
            <td><?= 'Rp ' . number_format($brg['total_bayar'], 0, ',', '.') ?></td>
            <td>
                <!-- Modal Previews -->
                <button type="button" class="btn btn-info" data-toggle="modal"
                    data-target="#infoData<?= $brg['id_barang_masuk'] ?>">
                    <i class="fa fa-eye"></i> Detail
                </button>
                <div class="modal fade" id="infoData<?= $brg['id_barang_masuk'] ?>" tabindex="-1"
                    aria-labelledby="infoDataLabel<?= $brg['id_barang_masuk'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="infoDataLabel<?= $brg['id_barang_masuk'] ?>">Detail Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Supplier</th>
                                            <th>Produk</th>
                                            <th>Total Item</th>
                                            <th>Harga Barang</th>
                                            <th>Total Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $nilai ?></td>
                                            <td><?= $brg['supplier_name'] ?></td>
                                            <td><?= $brg['product_name'] ?></td>
                                            <td><?= $brg['total_item'] ?></td>
                                            <td><?= 'Rp ' . number_format($brg['harga_beli'], 0, ',', '.') ?></td>
                                            <td><?= 'Rp ' . number_format($brg['total_bayar'], 0, ',', '.') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Previews -->
                <button type="button" class="btn btn-warning" data-toggle="modal"
                    data-target="#editData<?= $brg['id_barang_masuk'] ?>">
                    <i class="fa fa-pencil"></i> Edit
                </button>
                <!-- Modal Edit -->
                <div class="modal fade" id="editData<?= $brg['id_barang_masuk'] ?>" tabindex="-1" role="dialog"
                    aria-labelledby="editDataLabel<?= $brg['id_barang_masuk'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editDataLabel<?= $brg['id_barang_masuk'] ?>">Edit Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id_barang_masuk" value="<?= $brg['id_barang_masuk'] ?>">
                                    <!-- <div class="form-group">
                                        <label for="editSupplier<?= $brg['id_barang_masuk'] ?>" class="form-label">Nama
                                            Supplier</label>
                                        <select class="form-control selectpicker" aria-label="Default select example"
                                            id="editSupplier<?= $brg['id_barang_masuk'] ?>" data-live-search="true">
                                            <option selected disabled>Pilih Supplier</option>
                                            <?php foreach ($suppliers as $supplier) : ?>
                                            <option value="<?= $supplier['id_supplier']; ?>"
                                                <?= ($brg['id_supplier'] == $supplier['id_supplier']) ? 'selected' : ''; ?>>
                                                <?= $supplier['nama'] ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="editProduk<?= $brg['id_barang_masuk'] ?>" class="form-label">Nama
                                            Produk</label>
                                        <select class="form-control selectpicker" aria-label="Default select example"
                                            id="editProduk<?= $brg['id_barang_masuk'] ?>" data-live-search="true" disabled>
                                            <option selected disabled>Pilih Produk</option>
                                            <?php foreach ($produk as $product) : ?>
                                            <option value="<?= $product['id_produk']; ?>"
                                                <?= ($brg['id_produk'] == $product['id_produk']) ? 'selected' : ''; ?>>
                                                <?= $product['nama_produk'] ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editTotalItem<?= $brg['id_barang_masuk'] ?>" class="form-label">Total
                                            Item</label>
                                        <input type="text" class="form-control"
                                            id="editTotalItem<?= $brg['id_barang_masuk'] ?>" name="total_item"
                                            value="<?= $brg['total_item'] ?>">
                                    </div>
                                    <!-- Hidden input for the current date -->
                                    <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                                    <!-- End of hidden input -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-success"
                                            onclick="editData('<?= $brg['id_barang_masuk'] ?>')">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Edit -->
                <!-- Modal Hapus -->
                <button type="button" class="btn btn-danger" data-toggle="modal"
                    data-target="#hapusData<?= $brg['id_barang_masuk'] ?>">
                    <i class="fa fa-trash"></i> Hapus
                </button>
                <div class="modal fade" id="hapusData<?= $brg['id_barang_masuk'] ?>" tabindex="-1"
                    aria-labelledby="hapusDataLabel<?= $brg['id_barang_masuk'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hapusDataLabel<?= $brg['id_barang_masuk'] ?>">Konfirmasi
                                    Hapus</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Anda Yakin Menghapus Data Barang Masuk?</p>
                            </div>
                            <div class="modal-footer">
                                <form id="formHapus<?= $brg['id_barang_masuk'] ?>" action="" method="">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="hapusData('<?= $brg['id_barang_masuk'] ?>')">Hapus Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Hapus -->
            </td>
        </tr>
        <?php $nilai++; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php if ($search == "no") : ?>
    <?= $pager->links(); ?>
<?php endif; ?>
