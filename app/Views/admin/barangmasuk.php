<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tabel Barang Masuk
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
                <div class="dataBarangMasuk"></div>
            </div>
        </div>
    </section>
</div>
<!-- Modal Tambah Barang Masuk -->
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
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="inputSupplier" class="form-label">Nama Supplier</label>
                        <select class="form-control selectpicker" aria-label="Default select example" name="id_supplier"
                            id="supplier" data-live-search="true">
                            <option selected disabled>Pilih Supplier</option>
                            <?php foreach ($suppliers as $supplier) : ?>
                            <option value="<?= $supplier['id_supplier']; ?>"><?= $supplier['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputProduk" class="form-label">Produk</label>
                        <select class="form-control selectpicker" aria-label="Default select example" name="produk_id"
                            id="produk" data-live-search="true">
                            <option selected disabled>Pilih Produk</option>
                            <?php foreach ($produk as $pdk) : ?>
                            <option value="<?= $pdk['id_produk']; ?>"><?= $pdk['nama_produk']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputTotalItem" class="form-label">Total Item</label>
                        <input type="text" class="form-control" id="inputTotalItem" name="total_item">
                    </div>
                    <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
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
    });

    function ambilData(page = 1) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/ambilDataBarangMasuk') ?>",
            data: {
                search: $('#search').val(),
                page: page,
            },
            dataType: "json",
            success: function(response) {
                if (response.table) {
                    $('.dataBarangMasuk').html(response.table);
                    $('#page').val(page);
                    $('.selectpicker').selectpicker();
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
            url: "<?= site_url('/admin/tambahDataBarangMasuk') ?>",
            data: {
                supplier: $('#supplier').val(),
                produk: $('#produk').val(),
                totalitem: $('#inputTotalItem').val(),
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

    function editData(id_barang_masuk) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/editDataBarangMasuk') ?>",
            data: {
                id: id_barang_masuk,
                supplier: $('#editSupplier' + id_barang_masuk).val(),
                produk: $('#editProduk' + id_barang_masuk).val(),
                totalitem: $('#editTotalItem' + id_barang_masuk).val(),
            },
            dataType: "json",
            success: function(response) {
                ambilData($('#page').val());
                $('#editData' + id_barang_masuk).modal('hide');
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function hapusData(id_barang_masuk) {
        id_barang_masuk = id_barang_masuk
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/hapusDataBarangMasuk') ?>",
            data: {
                id: id_barang_masuk,
            },
            dataType: "json",
            success: function(response) {
                ambilData($('#page').val());
                $('#hapusData' + id_barang_masuk).modal('hide');
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection()?>