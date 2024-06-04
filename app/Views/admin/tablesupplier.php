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
        <?php foreach ($supplier as $key => $sup) : ?>
        <tr>
            <td><?= $key +1 ?></td>
            <td><?= $sup['kode_supplier'] ?></td>
            <td><?= $sup['nama'] ?></td>
            <td><?= $sup['alamat'] ?></td>
            <td><?= $sup['telepon'] ?></td>
            <td>
                <!-- Tombol Edit -->
                <button type="button" class="btn btn-warning" data-toggle="modal"
                    data-target="#editData<?= $sup['id_supplier'] ?>">
                    <i class="fa fa-pencil"></i>
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
                                <form action="<?= base_url('/admin/editDataSupplier');?>" method="post"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="id_supplier" value="<?= $sup['id_supplier'] ?>">
                                    <div class="form-group">
                                        <label for="editNamaSupplier" class="form-label">Nama Supplier</label>
                                        <input type="text" class="form-control" id="editNamaSupplier" name="edit_nama"
                                            value="<?= $sup['nama'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="editAlamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" id="editAlamat" name="edit_alamat"
                                            value="<?= $sup['alamat'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="editTelepon" class="form-label">Telepon</label>
                                        <input type="text" class="form-control" id="editTelepon" name="edit_telepon"
                                            value="<?= $sup['telepon'] ?>">
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tombol Hapus -->
                <button type="button" class="btn btn-danger" data-toggle="modal"
                    data-target="#hapusData<?= $sup['id_supplier'] ?>">
                    <i class="fa fa-trash"></i>
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
                                Apakah Anda yakin ingin menghapus supplier ini?
                            </div>
                            <div class="modal-footer">
                                <form id="formHapus<?= $sup['id_supplier'] ?>"
                                    action="<?= base_url('/admin/hapusDataSupplier');?>" method="post">
                                    <input type="hidden" name="id_supplier" value="<?= $sup['id_supplier'] ?>">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>