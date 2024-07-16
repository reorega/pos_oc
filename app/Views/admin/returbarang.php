<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tabel Retur Barang
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
                <div class="dataReturBarang"></div>
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
                    <!-- <div class="form-group">
                        <label for="inputSupplier" class="form-label">Nama Supplier</label>
                        <select class="form-control selectpicker" aria-label="Default select example" name="id_supplier"
                            id="supplier" data-live-search="true">
                            <option selected disabled>Pilih Supplier</option>
                            <?php foreach ($suppliers as $supplier) : ?>
                            <option value="<?= $supplier['id_supplier']; ?>"><?= $supplier['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="inputProduk" class="form-label">Nama Produk</label>
                        <select class="form-control selectpicker" aria-label="Default select example" name="produk_id"
                            id="produk" data-live-search="true">
                            <option selected disabled>Pilih Produk</option>
                            <?php foreach ($produk as $pdk) : ?>
                            <option value="<?= $pdk['id_produk']; ?>"><?= $pdk['nama_produk']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputJumlah" class="form-label">Jumlah Retur</label>
                        <input type="text" class="form-control" id="inputJumlah" name="jumlah">
                    </div>
                    <div class="form-group">
                        <label for="inputKeterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="inputKeterangan" name="keterangan">
                    </div>
                    <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="tambahData()">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Pastikan jQuery dan Bootstrap dimuat -->
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
<script>
    $(document).ready(function() {
        var page = $('#page').val();
        ambilData();
        $('#search').keyup(function() {
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
            url: "<?= site_url('admin/ambilDataReturBarang') ?>",
            data: {
                search: $('#search').val(),
                page: page,
            },
            dataType: "json",
            success: function(response) {
                if (response.table) {
                    $('.dataReturBarang').html(response.table);
                    $('#page').val(page);
                    $('.selectpicker').selectpicker();
                }
            },
            error: function(xhr, thrownError) {
                console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                alert("Error: " + xhr.responseText);
            }
        });
    }

    function tambahData() {
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/tambahDataReturBarang') ?>",
            data: {
                produk_id: $('#produk').val(), // perbaikan nama input
                total_item: $('#inputJumlah').val(),
                keterangan: $('#inputKeterangan').val(), // perbaikan nama input
            },
            dataType: "json",
            success: function(response) {
                if (response.status == 'success') {
                    ambilData($('#page').val());
                    $('#tambahData').modal('hide');
                } else {
                    alert('Gagal menambahkan data!');
                }
            },
            error: function(xhr, thrownError) {
                console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                alert("Error: " + xhr.responseText);
            }
        });
    }

    function editData(id_retur_barang) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/editDataReturBarang') ?>",
            data: {
                id_retur_barang: id_retur_barang,
                produk_id: $('#editProduk' + id_retur_barang).val(), // perbaikan nama input
                jumlah: $('#editJumlah' + id_retur_barang).val(),
                keterangan: $('#editKeterangan' + id_retur_barang).val(), // perbaikan nama input
            },
            dataType: "json",
            success: function(response) {
                if (response.status == 'success') {
                    ambilData($('#page').val());
                    $('#editData' + id_retur_barang).modal('hide');
                } else {
                    alert('Gagal mengedit data!');
                }
            },
            error: function(xhr, thrownError) {
                console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                alert("Error: " + xhr.responseText);
            }
        });
    }

    function hapusData(id_retur_barang) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/hapusDataReturBarang') ?>",
            data: {
                id: id_retur_barang,
            },
            dataType: "json",
            success: function(response) {
                if (response.status == 'success') {
                    ambilData($('#page').val());
                    $('#hapusData' + id_retur_barang).modal('hide');
                } else {
                    alert('Gagal menghapus data!');
                }
            },
            error: function(xhr, thrownError) {
                console.error(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                alert("Error: " + xhr.responseText);
            }
        });
    }
</script>
<?= $this->endSection()?>