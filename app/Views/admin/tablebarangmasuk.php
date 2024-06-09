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
        <?php foreach ($barangmasuk as $key => $brg) : ?>
        <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $brg['supplier_name'] ?></td>
            <td><?= $brg['product_name'] ?></td>
            <td><?= $brg['total_item'] ?></td>
            <td><?= 'Rp ' . number_format($brg['harga_beli'], 0, ',', '.') ?></td>
            <td><?= 'Rp ' . number_format($brg['total_bayar'], 0, ',', '.') ?></td>
            <td>
                        <!-- Modal Previews -->
                        <button type="button" class="btn btn-info" data-toggle="modal"
                            data-target="#infoData<?= $brg['id_barang_masuk'] ?>">
                            <i class="fa fa-eye"></i>
                        </button>
                        <div class="modal fade" id="infoData<?= $brg['id_barang_masuk'] ?>" tabindex="-1"
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
                                                <?= date('d F Y', strtotime($brg['created_at'])) ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Supplier:
                                                <?= $brg['supplier_name'] ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Produk:
                                                <?= $brg['product_name'] ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Total Item:
                                                <?= $brg['total_item'] ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Harga Beli:
                                                <?= $brg['harga_beli'] ?></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Total Bayar:
                                                <?= $brg['total_bayar'] ?></label>
                                        </div>
                                        <input type="hidden" name="id_barang_masuk"
                                            value="<?= $brg['id_barang_masuk'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Previews -->

                        <button type="button" class="btn btn-warning" data-toggle="modal"
                            data-target="#editData<?= $brg['id_barang_masuk'] ?>">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <!-- Modal Edit -->
                        <div class="modal fade" id="editData<?= $brg['id_barang_masuk'] ?>" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="exampleModalLabel">Edit brg</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= base_url('/admin/editDataBarangMasuk'); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <input type="hidden" name="id_barang_masuk"
                                                value="<?= $brg['id_barang_masuk'] ?>">
                                                <div class="form-group">
                                                <label for="inputSupplier" class="form-label">Nama Supplier : </label>
                                                <select class="form-control selectpicker" aria-label="Default select example"
                                                    name="id_supplier" data-live-search="true">
                                                    <option selected disabled>Pilih Supplier</option>
                                                    <?php foreach ($suppliers as $supplier) : ?>
                                                    <option value="<?= $supplier['id_supplier']; ?>"
                                                        <?= ($brg['id_supplier'] == $supplier['id_supplier']) ? 'selected' : ''; ?>>
                                                        <?= $supplier['nama'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputProduk" class="form-label">Nama Produk : </label>
                                                <select class="form-control selectpicker" aria-label="Default select example"
                                                    name="produk_id" data-live-search="true">
                                                    <option selected disabled>Pilih Produk</option>
                                                    <?php foreach ($produk as $pdk) : ?>
                                                    <option value="<?= $pdk['id_produk']; ?>"
                                                        <?= ($brg['id_produk'] == $pdk['id_produk']) ? 'selected' : ''; ?>>
                                                        <?= $pdk['nama_produk'] ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputTotalItem" class="form-label">Total Item : </label>
                                                <input type="text" class="form-control" id="inputTotalItem"
                                                    name="total_item" value="<?= $brg['total_item'] ?>">
                                            </div>
                                            <!-- Hidden input for the current date -->
                                            <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                                            <!-- End of hidden input -->
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="subrgit" class="btn btn-success">Simpan Data</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal Edit -->
                        <!-- Modal Hapus -->
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#hapusData<?= $brg['id_barang_masuk'] ?>">
                            <i class="fa fa-trash"></i>
                        </button>
                        <div class="modal fade" id="hapusData<?= $brg['id_barang_masuk'] ?>" tabindex="-1"
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
                                        <p>Anda yakin ingin menghapus data brg ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <form
                                            action="<?= base_url('/admin/hapusDataBarangMasuk/' . $brg['id_barang_masuk']); ?>"
                                            method="post">
                                            <button type="subrgit" class="btn btn-danger">Hapus Data</button>
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