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
        <thead class="table">
            <tr>
                <th class="no">No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Beli</th>
                <th>Diskon</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nilai = $no ?? 1; ?>
            <?php foreach ($produk as $pdk) : ?>
            <tr class="text-center">
                <td><?= $nilai ?></td>
                <td><?= $pdk['kode_produk'] ?></td>
                <td><?= $pdk['nama_produk'] ?></td>
                <td><?= $pdk['kategori'] ?></td>
                <td><?= $pdk['harga_beli'] ?></td>
                <td><?= $pdk['diskon'] ?></td>
                <td><?= $pdk['harga_jual'] ?></td>
                <td><?= $pdk['stok'] ?></td>
                <td>
                    <button type="button" class="btn btn-success"
                        onclick="window.open('<?= base_url('/admin/barcode/' . $pdk['id_produk']) ?>', '_blank')">
                        <i class="fa fa-barcode"></i> Barcode
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal"
                        data-target="#infoData<?= $pdk['id_produk'] ?>">
                        <i class="fa fa-eye"></i> Detail
                    </button>
                    <!-- Detail Modal -->
                    <div class="modal fade" id="infoData<?= $pdk['id_produk'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title text-left" id="exampleModalLabel">Detail Data</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Produk</th>
                                                <th>Kategori</th>
                                                <th>Nama Supplier</th>
                                                <th>Nama Produk</th>
                                                <th>Harga Beli</th>
                                                <th>Diskon</th>
                                                <th>Harga Jual</th>
                                                <th>Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= $nilai ?></td>
                                                <td><?= $pdk['kode_produk'] ?></td>
                                                <td><?= $pdk['kategori'] ?></td>
                                                <td><?= $pdk['suplier'] ?></td>
                                                <td><?= $pdk['nama_produk'] ?></td>
                                                <td><?= $pdk['harga_beli'] ?></td>
                                                <td><?= $pdk['diskon'] ?></td>
                                                <td><?= $pdk['harga_jual'] ?></td>
                                                <td><?= $pdk['stok'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#editData<?= $pdk['id_produk'] ?>">
                        <i class="fa fa-pencil"></i> Edit
                    </button>
                    <!-- Edit Modal -->
                    <div class="modal fade text-left" id="editData<?= $pdk['id_produk'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="exampleModalLabel">Edit Data</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="kategori_id" class="form-label">Nama Kategori</label>
                                            <select class="form-control selectpicker" name="kategori_id"
                                                data-live-search="true" id="editKategori<?= $pdk['id_produk'] ?>">
                                                <option value="" <?= ($pdk['kategori_id'] == 0) ? 'selected' : ''; ?>>
                                                    Pilih Kategori Produk</option>
                                                <?php foreach ($kategori as $ktg) : ?>
                                                <option value="<?= $ktg['id_kategori']; ?>"
                                                    <?= ($ktg['id_kategori'] == $pdk['kategori_id']) ? 'selected' : ''; ?>>
                                                    <?= $ktg['nama_kategori'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="suplier_id" class="form-label">Nama Supplier</label>
                                            <select class="form-control selectpicker" name="suplier_id"
                                                data-live-search="true" id="editSuplier<?= $pdk['id_produk'] ?>">
                                                <?php foreach ($suplier as $sp) : ?>
                                                <option value="<?= $sp['id_supplier']; ?>"
                                                    <?= ($sp['id_supplier'] == $pdk['suplier_id']) ? 'selected' : ''; ?>>
                                                    <?= $sp['nama'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_produk" class="form-label">Nama Produk</label>
                                            <input type="text" class="form-control"
                                                id="editNamaProduk<?= $pdk['id_produk'] ?>" name="nama_produk"
                                                value="<?= $pdk['nama_produk'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="harga_beli" class="form-label">Harga Beli</label>
                                            <input type="number" class="form-control"
                                                id="editHargaBeli<?= $pdk['id_produk'] ?>" name="harga_beli"
                                                value="<?= $pdk['harga_beli'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="diskon" class="form-label">Diskon</label>
                                            <input type="number" class="form-control"
                                                id="editDiskon<?= $pdk['id_produk'] ?>" name="diskon"
                                                value="<?= $pdk['diskon'] ?>" step="0.01">
                                        </div>
                                        <div class="form-group">
                                            <label for="harga_jual" class="form-label">Harga Jual</label>
                                            <input type="number" class="form-control"
                                                id="editHargaJual<?= $pdk['id_produk'] ?>" name="harga_jual"
                                                value="<?= $pdk['harga_jual'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="stok" class="form-label">Stok</label>
                                            <input type="number" class="form-control"
                                                id="editStok<?= $pdk['id_produk'] ?>" name="stok"
                                                value="<?= $pdk['stok'] ?>">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-success"
                                                onclick="editData('<?= $pdk['id_produk'] ?>')">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#hapusData<?= $pdk['id_produk'] ?>">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                    <!-- Delete Modal -->
                    <div class="modal fade text-left" id="hapusData<?= $pdk['id_produk'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Anda Yakin Menghapus Data Produk <?= $pdk['nama_produk'] ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="hapusData('<?= $pdk['id_produk'] ?>')">Hapus Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <?php $nilai++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($search == "no") : ?>
    <?= $pager->links(); ?>
    <?php endif; ?>
</div>