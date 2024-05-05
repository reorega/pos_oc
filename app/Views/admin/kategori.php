<?= $this->extend('layout/master')?>

<?= $this->section('content')?>
<div class="content-wrapper">
    <section class="content">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
            <i class="fa fa-plus-square"></i> Tambah Kategori
        </button>
    <br><br>
        <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalLabel">Tambah Kategori</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('/admin/tambahDataKategori');?>" method="post"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputNamaKategori" class="form-label">Nama Kategori : </label>
                                <input type="text" class="form-control" id="inputNamaKategori" name="nama_kategori">
                            </div>
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
                    <td>Nama Kategori</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kategori as $key => $kat) : ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $kat['nama_kategori'] ?></td>
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal"
                            data-target="#editData<?= $kat['id_kategori'] ?>">
                            <i class="fa fa-pencil"></i> Edit
                        </button>
                        <div class="modal fade" id="editData<?= $kat['id_kategori'] ?>" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="exampleModalLabel">Edit Kategori</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?= base_url('/admin/editDataKategori');?>" method="post"
                                            enctype="multipart/form-data">
                                            <input type="hidden" name="id_kategori" value="<?= $kat['id_kategori'] ?>">
                                            <div class="form-group">
                                                <label for="editNamaKategori" class="form-label">Nama Kategori :
                                                </label>
                                                <input type="text" class="form-control" id="editNamaKategori"
                                                    name="edit_nama_kategori" value="<?= $kat['nama_kategori'] ?>">
                                            </div>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#hapusData<?= $kat['id_kategori'] ?>">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                        <div class="modal fade" id="hapusData<?= $kat['id_kategori'] ?>" tabindex="-1"
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
                                        Apakah Anda yakin ingin menghapus kategori ini?
                                    </div>
                                    <div class="modal-footer">
                                        <form id="formHapus<?= $kat['id_kategori'] ?>"
                                            action="<?= base_url('/admin/hapusDataKategori');?>" method="post">
                                            <input type="hidden" name="id_kategori" value="<?= $kat['id_kategori'] ?>">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
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
    </section>
</div>
<?= $this->endSection()?>


