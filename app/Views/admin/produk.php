<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tabel Produk
        </h1>
    </section>
    <input type="hidden" id="page" value="1">
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-9">
                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="bukaModalTambah()">
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
                <div class="dataProduk"></div>
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
                <form action="<?= site_url('/admin/tambahDataProduk') ?>" enctype="multipart/form-data" id="formTambahData" method="post">
                    <div class="form-group">
                        <label for="kategori_id" class="form-label">Nama Kategori</label>
                        <select class="form-control selectpicker" aria-label="Default select example" name="kategori_id" id="inputKategori" data-live-search="true">
                            <option selected disabled>Pilih Kategori Produk</option>
                            <?php foreach ($kategori as $ktg) : ?>
                                <option value="<?= $ktg['id_kategori']; ?>"><?= $ktg['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="invalid-feedback text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label for="suplier_id" class="form-label">Nama Supplier</label>
                        <select class="form-control selectpicker" aria-label="Default select example" name="suplier_id" id="inputSuplier" data-live-search="true">
                            <option selected disabled>Pilih Suplier</option>
                            <?php foreach ($suplier as $sp) : ?>
                                <option value="<?= $sp['id_supplier']; ?>"><?= $sp['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="invalid-feedback text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk" class="control-label">Nama Produk</label>
                        <input type="text" class="form-control" id="inputNamaProduk" name="nama_produk">
                        <p class="invalid-feedback text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli" class="control-label">Harga Beli</label>
                        <input type="number" class="form-control" id="inputHargaBeli" name="harga_beli">
                        <p class="invalid-feedback text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label for="diskon" class="form-label">Diskon</label>
                        <input type="number" class="form-control" id="inputDiskon" name="diskon" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="harga_jual" class="control-label">Harga Jual</label>
                        <input type="number" class="form-control" id="inputHargaJual" name="harga_jual">
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
    $(document).ready(function(){
        var page=$('#page').val();
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
        $('#formTambahData').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
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
                        $.each(response.errors, function (field, message) {
                            var element = $('[name=' + field + ']');
                            element.closest('.form-group').addClass('has-error');
                            element.closest('.form-group').addClass('has-feedback');
                            element.next('.invalid-feedback').text(message);
                            element.after('<span class="glyphicon glyphicon-warning-sign form-control-feedback text-danger"></span>');
                        });
                    }
                },
                error: function (xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });   
    });
    function ambilData(page = 1){
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/ambilDataProduk') ?>",
            data: {
                search: $('#search').val(),
                page : page,
            },
            dataType: "json",
            success: function(response){
                if(response.table){
                    $('.dataProduk').html(response.table);
                    $('#page').val(page);
                    $('.selectpicker').selectpicker();
                }
            },
            error: function(xhr, thrownError){
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
        });
    }
    function tambahData(){
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/tambahDataProduk') ?>",
            data: {
                kategori: $('#inputKategori').val(),
                suplier: $('#inputSuplier').val(),
                produk: $('#inputNamaProduk').val(),
                hargabeli: $('#inputHargaBeli').val(),
                diskon: $('#inputDiskon').val(),
                hargajual: $('#inputHargaJual').val(),
                stok: $('#inputStok').val(),
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
    function editData(id_produk){
        idprod=id_produk
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/editDataProduk') ?>",
            data: {
                id: idprod,
                kategori: $('#editKategori'+idprod).val(),
                suplier: $('#editSuplier'+idprod).val(),
                produk: $('#editNamaProduk'+idprod).val(),
                hargabeli: $('#editHargaBeli'+idprod).val(),
                diskon: $('#editDiskon'+idprod).val(),
                hargajual: $('#editHargaJual'+idprod).val(),
                stok: $('#editStok'+idprod).val(),
            },
            dataType: "json",
            success: function(response) {
                ambilData($('#page').val());
                $('#editData'+idprod).modal('hide');
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    function hapusData(id_produk){
        idprod=id_produk
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
                    url: "<?= site_url('/admin/hapusDataProduk') ?>",
                    data: {
                        id: idprod,
                    },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire(
                            'Berhasil!',
                            'Data berhasil dihapus',
                            'success'
                        );
                        ambilData($('#page').val());
                        $('#hapusData'+idprod).modal('hide');
                    },
                    error: function (xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }
    function bukaModalTambah(){
        $('#tambahData').modal('show');
        $('.invalid-feedback').empty();
        $('.form-group').removeClass('has-error');
        $('.form-group').removeClass('has-feedback');
        $('.form-group .glyphicon').remove();
    }
</script>
<?= $this->endSection()?>
