<style>
    .table-wrapper thead th {
        background-color: #343a40;
        color: #ffffff;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .no {
        width: 50px;
    }

    .table th {
        text-align: center;
    }
</style>

<div class="table-wrapper">
    <table class="table table-hover mt-2 table-bordered">
        <thead class="thead-dark">
            <tr>
                <th class="no">No</th>
                <th>Nama Produk</th>
                <th>Nama Supplier</th>
                <th>Jumlah Retur</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($returbarang as $key => $rtb) : ?>
            <tr class="text-center">
                <td><?= $key + 1 ?></td>
                <td><?= $rtb['product_name'] ?></td>
                <td><?= $rtb['supplier_name'] ?></td>
                <td><?= $rtb['jumlah'] ?></td>
                <td><?= $rtb['keterangan'] ?></td>
                <td>
                    <!-- Button detail -->
                    <button type="button" class="btn btn-info" data-toggle="modal"
                        data-target="#infoData<?= $rtb['id_retur_barang'] ?>">
                        <i class="fa fa-eye"></i> Detail
                    </button>

                    <!-- Modal detail -->
                    <div class="modal fade" id="infoData<?= $rtb['id_retur_barang'] ?>" tabindex="-1"
                        aria-labelledby="infoDataLabel<?= $rtb['id_retur_barang'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title text-left" id="infoDataLabel<?= $rtb['id_retur_barang'] ?>">
                                        Detail Data
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Produk</th>
                                                <th>Nama Supplier</th>
                                                <th>Jumlah Retur</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $rtb['product_name'] ?></td>
                                                <td><?= $rtb['supplier_name'] ?></td>
                                                <td><?= $rtb['jumlah'] ?></td>
                                                <td><?= $rtb['keterangan'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal detail -->

                    <!-- Button edit -->
                    <button type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#editData<?= $rtb['id_retur_barang'] ?>">
                        <i class="fa fa-pencil"></i> Edit
                    </button>

                    <!-- Modal edit -->
                    <div class="modal fade text-left" id="editData<?= $rtb['id_retur_barang'] ?>" tabindex="-1"
                        aria-labelledby="editDataLabel<?= $rtb['id_retur_barang'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="editDataLabel<?= $rtb['id_retur_barang'] ?>">Edit Data
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id_retur_barang"
                                            value="<?= $rtb['id_retur_barang'] ?>">
                                        <div class="form-group">
                                            <label for="editProduk<?= $rtb['id_retur_barang'] ?>"
                                                class="form-label">Nama Produk</label>
                                            <select class="form-control selectpicker"
                                                aria-label="Default select example"
                                                id="editProduk<?= $rtb['id_retur_barang'] ?>" data-live-search="true"
                                                disabled>
                                                <option selected disabled>Pilih Produk</option>
                                                <?php foreach ($produk as $product) : ?>
                                                <option value="<?= $product['id_produk']; ?>"
                                                    <?= ($rtb['produk_id'] == $product['id_produk']) ? 'selected' : ''; ?>>
                                                    <?= $product['nama_produk'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="editJumlah<?= $rtb['id_retur_barang'] ?>"
                                                class="form-label">Jumlah Retur</label>
                                            <input type="text" class="form-control"
                                                id="editJumlah<?= $rtb['id_retur_barang'] ?>" name="jumlah"
                                                value="<?= $rtb['jumlah'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="editKeterangan<?= $rtb['id_retur_barang'] ?>"
                                                class="form-label">Keterangan</label>
                                            <input type="text" class="form-control"
                                                id="editKeterangan<?= $rtb['id_retur_barang'] ?>" name="keterangan"
                                                value="<?= $rtb['keterangan'] ?>">
                                        </div>
                                        <!-- Hidden input for the current date -->
                                        <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                                        <!-- End of hidden input -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-success"
                                                onclick="editData('<?= $rtb['id_retur_barang'] ?>')">Simpan
                                                Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal edit -->

                    <!-- Button hapus -->
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#hapusData<?= $rtb['id_retur_barang'] ?>">
                        <i class="fa fa-trash"></i> Hapus
                    </button>

                    <!-- Modal hapus -->
                    <div class="modal fade text-left" id="hapusData<?= $rtb['id_retur_barang'] ?>" tabindex="-1"
                        aria-labelledby="hapusDataLabel<?= $rtb['id_retur_barang'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="hapusDataLabel<?= $rtb['id_retur_barang'] ?>">Konfirmasi
                                        Hapus</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Anda Yakin Menghapus Data Retur Barang?</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="formHapus<?= $rtb['id_retur_barang'] ?>" action="" method="">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="hapusData('<?= $rtb['id_retur_barang'] ?>')">Hapus Data</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal hapus -->
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if ($search == "no") : ?>
<?= $pager->links() ?>
<?php endif; ?>