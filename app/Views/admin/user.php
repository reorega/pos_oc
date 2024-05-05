<?= $this->extend('layout/master')?>
<?= $this->section('content')?>
<div class="content-wrapper">
  <section class="content">
  <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#tambahData">
  <i class="fa fa-plus-square"></i>
</button>
<div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/admin/tambahData');?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="inputUserName" class="form-label">Username : </label>
          <input type="text" class="form-control" id="inputUserName" name="username" >
        </div>
        <div class="form-group">
          <label for="inputEmail" class="form-label">Email : </label>
          <input type="email" class="form-control" id="inputEmail" name="email" >
        </div>
        <div class="form-group">
          <label for="inputPassword" class="form-label">Password : </label>
          <input type="password" class="form-control" id="inputPassword" name="password">
        </div>
        <div class="form-group">
          <label for="formFile" class="form-label">Foto User : </label>
          <input class="form-control" type="file" id="formFile" name="foto_user">
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
      <td>ID</td>
      <td>Username</td>
      <td>Level</td>
      <td>Foto User</td>
      <td>Aksi</td>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $user) : ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['username'] ?></td>
            <?php
             if($user['level_users']==2){
                $user['level_users']="Kasir";
             }
            ?>
            <td><?= $user['level_users'] ?></td>
            <td><img src="<?= base_url('/assets/fotoUser/'.$user['foto_user']);?>" width="50" height="50"></td>
            <td>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editData<?= $user['id'] ?>">
                  <i class="fa fa-pencil"></i>
                </button>
                  <div class="modal fade" id="editData<?= $user['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="exampleModalLabel">Edit Data</h4>
                        </div>
                        <div class="modal-body">
                          <form action="<?= base_url('/admin/editData');?>" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="inputUserName" class="form-label">Username : </label>
                            <input type="text" class="form-control" id="inputUserName" name="username" value="<?= $user['username'] ?>">
                          </div>
                          <div class="form-group">
                            <label for="inputEmail" class="form-label">Email : </label>
                            <input type="email" class="form-control" id="inputEmail" name="email" value="<?= $user['email'] ?>">
                          </div>
                          <div class="form-group">
                            <label for="inputPassword" class="form-label">Password : </label>
                            <input type="password" class="form-control" id="inputPassword" name="password" value="<?= $user['password'] ?>">
                          </div>
                          <div class="form-group">
                            <label for="formFile" class="form-label">Foto User : </label>
                            <input class="form-control" type="file" id="formFile" name="foto_user">
                          </div>
                          <input type="hidden" name="id" value="<?= $user['id']?>">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusData<?= $user['id'] ?>">
                  <i class="fa fa-trash"></i>
                </button>
                <div class="modal fade " id="hapusData<?= $user['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title " id="exampleModalLabel">Hapus Data</h4>
                        </div>
                        <div class="modal-body">
                          <div>
                            <p class="">Anda Yakin Menghapus Data User <?= $user['username']?></p>
                          </div> 
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <a href="<?= base_url('/admin/hapusDataUser/' . $user['id']);?>" class="btn btn-danger">Hapus Data</a>
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

