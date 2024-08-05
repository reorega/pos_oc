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
            <input class="form-control" type="file" id="formFileTambah" name="foto_user"
              onchange="previewTambahFoto(this, 'tambahFotoPreview')">
            <br>
            <img id="tambahFotoPreview" src="" alt="Foto User" style="max-height: 150px; display: none;">
          </div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Data</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script>
  $(document).ready(function() {
    var page = $('#page').val();
    ambilData();
    $('#search').keyup(function() {
      console.log($('#search').val())
      ambilData();
    });
    $(document).on('click', '.pagination a', function(event) {
      event.preventDefault();
      page = $(this).attr('href').split('page=')[1];
      ambilData(page);
    });
    console.log(page);
  });

  function ambilData(page = 1) {
    $.ajax({
      type: "post",
      url: "<?= site_url('admin/ambilDataUsers') ?>",
      data: {
        search: $('#search').val(),
        page: page,
      },
      dataType: "json",
      success: function(response) {
        if (response.table) {
          $('.dataUsers').html(response.table);
          $('#page').val(page);
        }
      },
      error: function(xhr, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function tambahData() {
    $.ajax({
      type: "post",
      url: "<?= site_url('/admin/tambahData') ?>",
      data: {
        username: $('#inputUserName').val(),
        email: $('#inputEmail').val(),
        password: $('#inputPassword').val(),
        foto_user: $('#formFile').val(),
      },
      dataType: "json",
      success: function(response) {
        ambilData($('#page').val());
        $('#tambahData').modal('hide');
      },
      error: function(xhr, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function editData(id_user) {
    iduser = id_user
    $.ajax({
      type: "post",
      url: "<?= site_url('/admin/editDataKategori') ?>",
      data: {
        id: iduser,
        username: $('#inputUserName' + iduser).val(),
        email: $('#inputEmail' + iduser).val(),
        password: $('#inputPassword' + iduser).val(),
        foto_user: $('#formFile' + iduser).val(),
      },
      dataType: "json",
      success: function(response) {
        ambilData($('#page').val());
        $('#editData' + iduser).modal('hide');
      },
      error: function(xhr, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function hapusData(id_user) {
    iduser = id_user
    $.ajax({
      type: "post",
      url: "<?= site_url('/admin/hapusData') ?>",
      data: {
        id: iduser,
      },
      dataType: "json",
      success: function(response) {
        ambilData($('#page').val());
        $('#hapusData' + iduser).modal('hide');
      },
      error: function(xhr, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function previewTambahFoto(input, idPreview) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#' + idPreview).attr('src', e.target.result).show();
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
<?= $this->endSection()?>