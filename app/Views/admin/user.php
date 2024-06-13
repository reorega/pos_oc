<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Tabel User
    </h1>
  </section>
  <input type="hidden" id="page" value="1">
  <section class="content">
    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-md-9">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
              <i class="fa fa-plus-square"></i> Tambah Data
            </button>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon bg-primary"><i class="fa fa-search"></i></span>
              <input type="text" class="form-control" id="search" name="search" placeholder="Pencarian">
            </div>
          </div>
        </div>
        <br>
        <div class="dataUsers"></div>
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('/admin/tambahData');?>" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="inputUserName" class="form-label">Username</label>
            <input type="text" class="form-control" id="inputUserName" name="username">
          </div>
          <div class="form-group">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="email">
          </div>
          <div class="form-group">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="password">
          </div>
          <div class="form-group">
            <label for="formFile" class="form-label">Foto User</label>
            <input class="form-control" type="file" id="formFile" name="foto_user">
          </div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Data</button>
        </form>
      </div>
    </div>
  </div>
</div>
</section>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script>
  $(document).ready(function() {
    ambilData();
    $('#search').keyup(function() {
      console.log($('#search').val())
      ambilData();
    });
  });

  function ambilData() {
    $.ajax({
      type: "post",
      url: "<?= site_url('admin/ambilDataUsers') ?>",
      data: {
        search: $('#search').val(),
      },
      dataType: "json",
      success: function(response) {
        if (response.table) {
          $('.dataUsers').html(response.table);
        }
      },
      error: function(xhr, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }
</script>
<?= $this->endSection()?>