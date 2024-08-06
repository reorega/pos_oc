<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Tabel User</h1>
  </section>
  <input type="hidden" id="page" value="1">
  <section class="content">
    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-md-9">
            <button type="button" class="btn btn-primary" onclick="bukaModalTambah()">
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
<!-- Modal for Adding Data -->
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
        <form id="formTambahData" action="<?= base_url('/admin/tambahData'); ?>" method="post"
          enctype="multipart/form-data">
          <div class="form-group">
            <label for="inputUserName" class="form-label">Username</label>
            <input type="text" class="form-control" id="inputUserName" name="username">
            <p class="invalid-feedback text-danger"></p>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="email">
            <p class="invalid-feedback text-danger"></p>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="password">
            <p class="invalid-feedback text-danger"></p>
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
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/sweetalert2.js'); ?>"></script>
<script>
  $(document).ready(function() {
    ambilData();
    $('#search').keyup(function() {
      ambilData();
    });
    $(document).on('click', '.pagination a', function(event) {
      event.preventDefault();
      const page = $(this).attr('href').split('page=')[1];
      ambilData(page);
    });
    $('#formTambahData').on('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this); // Use FormData to handle file uploads
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        processData: false, // Prevent jQuery from automatically transforming the data into a query string
        contentType: false, // Prevent jQuery from setting the content type
        dataType: 'json',
        success: function(response) {
          $('.invalid-feedback').empty();
          $('.form-group').removeClass('has-error has-feedback');
          if (response.success) {
            $('#tambahData').modal('hide');
            ambilData($('#page').val());
            Swal.fire('Tersimpan!', 'Data berhasil ditambahkan.', 'success');
          } else {
            $.each(response.errors, function(field, message) {
              const element = $('[name=' + field + ']');
              element.closest('.form-group').addClass('has-error has-feedback');
              element.next('.invalid-feedback').text(message);
            });
          }
        },
        error: function(xhr, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    });
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

  function bukaModalTambah() {
    $('#tambahData').modal('show');
    $('.invalid-feedback').empty();
    $('.form-group').removeClass('has-error has-feedback');
  }

  function previewTambahFoto(input, idPreview) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        $('#' + idPreview).attr('src', e.target.result).show();
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function hapusData(id_user) {
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Data ini akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "<?= site_url('/admin/hapusDataUser') ?>",
        data: { id: id_user },
        dataType: "json",
        success: function(response) {
          if (response.success) {
            Swal.fire('Dihapus!', 'Data berhasil dihapus.', 'success');
            ambilData(); // Refresh the data without reloading the page
          } else {
            Swal.fire('Gagal!', response.message, 'error');
          }
        },
        error: function(xhr, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    }
  });
}
</script>
<?= $this->endSection() ?>