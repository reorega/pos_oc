<?= $this->extend('layout/template')?>
<?= $this->section('content')?>
<!--Tombol Modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahData">
  Tambah Data
</button>

<!-- Modal -->
<div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="#" method="post">
        <div class="mb-3">
          <label for="inputEmail" class="form-label">Email address</label>
          <input type="email" class="form-control" id="inputEmail" name="email">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
<table class="responsive">
  <thead>
    <tr>
      <td>ID</td>
      <td>Username</td>
      <td>Level</td>
      <td>foto_user</td>
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
            <td><?= $user['foto_user'] ?></td>
            <td>
                <a href="#">Edit</a>
                <a href="#">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?= $this->endSection()?>
