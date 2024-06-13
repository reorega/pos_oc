<table class="table table-hover mt-2 table-bordered">
    <thead class="table">
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $nilai = $no ?? 1;?>
        <?php foreach ($kategori as $kat) : ?>
        <tr>
            <td><?= $nilai ?></td>
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
                                <h4 class="modal-title" id="exampleModalLabel">Edit Data</h4>
                            </div>
                            <div class="modal-body">
                                <form action="" method="" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="editNamaKategori" class="form-label">Nama Kategori
                                        </label>
                                        <input type="text" class="form-control" id="editNamaKategori<?= $kat['id_kategori'] ?>" name="edit_nama_kategori" value="<?= $kat['nama_kategori'] ?>">
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-success" onclick="editData('<?= $kat['id_kategori'] ?>')">Simpan Perubahan</button>
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
                            <p class="">Anda Yakin Menghapus Data Kategori <?= $kat['nama_kategori']?>?</p>
                            </div>
                            <div class="modal-footer">
                                <form id="formHapus<?= $kat['id_kategori'] ?>" action="" method="">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-danger" onclick="hapusData('<?= $kat['id_kategori'] ?>')">Hapus Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php $nilai++ ;?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
    if($search=="no"){
        echo $pager->links();
    }
?>