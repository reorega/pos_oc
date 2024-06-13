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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
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
                <div class="form-group">
                    <label for="inputNamaSupplier" class="form-label">Nama Supplier</label>
                    <input type="text" class="form-control" id="inputNamaSupplier" name="nama">
                </div>
                <div class="form-group">
                    <label for="inputAlamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="inputAlamat" name="alamat">
                </div>
                <div class="form-group">
                    <label for="inputTelepon" class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="inputTelepon" name="telepon">
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="tambahData();">Simpan Data</button>
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
                suplier: $('#inputNamaSupplier').val(),
                alamat: $('#inputAlamat').val(),
                telepon: $('#inputTelepon').val(),
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
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection()?>