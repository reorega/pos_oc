<style>
    .table-wrapper thead th {
        background-color: #343a40;
        color: #ffffff;
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>

<div class="table-wrapper">
    <table class="table table-hover mt-2 table-bordered">
        <thead class="table">
            <tr>
                <th>No</th>
                <th>Kode Supplier</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nilai =$no ?? 1;?>
            <?php foreach ($supplier as $sup) : ?>
            <tr>
                <td><?= $nilai ?></td>
                <td><?= $sup['kode_supplier'] ?></td>
                <td><?= $sup['nama'] ?></td>
                <td><?= $sup['alamat'] ?></td>
                <td><?= $sup['telepon'] ?></td>
                <td>
                    <!-- Tombol Edit -->
                    <button type="button" class="btn btn-warning" data-toggle="modal"
                        data-target="#editData<?= $sup['id_supplier'] ?>">
                        <i class="fa fa-pencil"></i> Edit
                    </button>
                    <div class="modal fade" id="editData<?= $sup['id_supplier'] ?>" tabindex="-1"
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
                                    <input type="hidden" name="id_supplier" id="id<?= $sup['id_supplier'] ?>"
                                        value="<?= $sup['id_supplier'] ?>">
                                    <div class="form-group">
                                        <label for="editNamaSupplier" class="form-label">Nama Supplier</label>
                                        <input type="text" class="form-control"
                                            id="editNamaSupplier<?= $sup['id_supplier'] ?>" name="edit_nama"
                                            value="<?= $sup['nama'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="editAlamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control"
                                            id="editAlamat<?= $sup['id_supplier'] ?>" name="edit_alamat"
                                            value="<?= $sup['alamat'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="editTelepon" class="form-label">Telepon</label>
                                        <input type="text" class="form-control"
                                            id="editTelepon<?= $sup['id_supplier'] ?>" name="edit_telepon"
                                            value="<?= $sup['telepon'] ?>">
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-success"
                                        onclick="editData('<?= $sup['id_supplier'] ?>')">Simpan Perubahan</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tombol Hapus -->
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#hapusData<?= $sup['id_supplier'] ?>">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                    <div class="modal fade" id="hapusData<?= $sup['id_supplier'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="">Anda Yakin Menghapus Data Supplier <?= $sup['nama']?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="hapusData('<?= $sup['id_supplier'] ?>')">Hapus Data</button>
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
    <?php
    if($search=="no"){
        echo $pager->links();
    }
?>
</div>