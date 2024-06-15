<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tabel Kategori
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
                        <div class="input-group pull-right">
                            <span class="input-group-addon bg-primary"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Pencarian">
                        </div>
                    </div>
                </div>
                <br>
                <div class="dataKategori"></div>
            </div>
        </div>
    </section>
</div>
<!-- Modal Tambah Data -->
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
                <form id="formTambahKategori" action="<?= site_url('/admin/tambahDataKategori') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="inputNamaKategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="inputNamaKategori" name="nama_kategori" required>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="tambahData()">Simpan Data</button>
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
            url: "<?= site_url('admin/ambilDataKategori') ?>",
            data: {
                search: $('#search').val(),
                page: page,
            },
            dataType: "json",
            success: function(response) {
                if (response.table) {
                    $('.dataKategori').html(response.table);
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
            url: "<?= site_url('/admin/tambahDataKategori') ?>",
            data: {
                nama_kategori: $('#inputNamaKategori').val(),
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

    function editData(id_kategori) {
        idkat = id_kategori
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/editDataKategori') ?>",
            data: {
                id: idkat,
                edit_nama_kategori: $('#editNamaKategori' + idkat).val(),
            },
            dataType: "json",
            success: function(response) {
                ambilData($('#page').val());
                $('#editData' + idkat).modal('hide');
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function hapusData(id_kategori) {
        idkat = id_kategori
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/hapusDataKategori') ?>",
            data: {
                id: idkat,
            },
            dataType: "json",
            success: function(response) {
                ambilData($('#page').val());
                $('#hapusData' + idkat).modal('hide');
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection()?>