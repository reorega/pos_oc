<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tabel Supplier
        </h1>
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
                        <div class="input-group ">
                            <span class="input-group-addon bg-primary"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control " id="search" name="search" placeholder="Pencarian">
                        </div>
                    </div>
                </div>
                <br>
                <div class="dataSupplier"></div>
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
                <form action="<?= site_url('/admin/tambahDataSupplier') ?>" enctype="multipart/form-data"
                    id="formTambahData" method="post">
                    <div class="form-group">
                        <label for="inputNamaSupplier" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control" id="inputNamaSupplier" name="nama">
                        <p class="invalid-feedback text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label for="inputAlamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="inputAlamat" name="alamat">
                        <p class="invalid-feedback text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label for="inputTelepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="inputTelepon" name="telepon">
                        <p class="invalid-feedback text-danger"></p>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script src="<?= base_url('assets/js/sweetalert2.js'); ?>"></script>
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
        $('#formTambahData').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $('#responseMessage').empty();
                    $('.invalid-feedback').empty();
                    $('.is-invalid').removeClass('is-invalid');
                    if (response.success) {
                        $('#tambahData').modal('hide');
                        ambilData($('#page').val());
                        Swal.fire(
                            'Tersimpan!',
                            'Data berhasi ditambahkan.',
                            'success'
                        );
                    } else {
                        $.each(response.errors, function(field, message) {
                            var element = $('[name=' + field + ']');
                            element.closest('.form-group').addClass('has-error');
                            element.closest('.form-group').addClass('has-feedback');
                            element.next('.invalid-feedback').text(message);
                            element.after(
                                '<span class="glyphicon glyphicon-warning-sign form-control-feedback text-danger"></span>'
                            );
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
            url: "<?= site_url('admin/ambilDataSupplier') ?>",
            data: {
                search: $('#search').val(),
                page: page,
            },
            dataType: "json",
            success: function(response) {
                if (response.table) {
                    $('.dataSupplier').html(response.table);
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
            url: "<?= site_url('/admin/tambahDataSupplier') ?>",
            data: {
                nama: $('#inputNamaSupplier').val(),
                alamat: $('#inputAlamat').val(),
                telepon: $('#inputTelepon').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    ambilData($('#page').val());
                    $('#tambahData').modal('hide');
                    Swal.fire(
                        'Tersimpan!',
                        'Data berhasil ditambahkan.',
                        'success'
                    );
                } else {
                    $.each(response.errors, function(field, message) {
                        var element = $('[name=' + field + ']');
                        element.closest('.form-group').addClass('has-error');
                        element.closest('.form-group').addClass('has-feedback');
                        element.next('.invalid-feedback').text(message);
                        element.after(
                            '<span class="glyphicon glyphicon-warning-sign form-control-feedback text-danger"></span>'
                        );
                    });
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function editData(id_suplier) {
        idsup = id_suplier
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/editDataSupplier') ?>",
            data: {
                id: idsup,
                suplier: $('#editNamaSupplier' + idsup).val(),
                alamat: $('#editAlamat' + idsup).val(),
                telepon: $('#editTelepon' + idsup).val(),
            },
            dataType: "json",
            success: function(response) {
                ambilData($('#page').val());
                $('#editData' + idsup).modal('hide');
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function hapusData(id_suplier) {
        idsup = id_suplier
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "kamu tidak dapat mengembalikan datanya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('/admin/hapusDataSupplier') ?>",
                    data: {
                        id: idsup,
                    },
                    dataType: "json",
                    success: function(response) {
                        ambilData($('#page').val());
                        $('#hapusData' + idsup).modal('hide');
                        Swal.fire(
                            'Berhasil!',
                            'Data berhasil dihapus',
                            'success'
                        );
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }

    function bukaModalTambah() {
        $('#tambahData').modal('show');
        $('.invalid-feedback').empty();
        $('.form-group').removeClass('has-error');
        $('.form-group').removeClass('has-feedback');
        $('.form-group .glyphicon').remove();
    }
</script>
<?= $this->endSection()?>