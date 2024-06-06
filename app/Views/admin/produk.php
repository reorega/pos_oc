<?= $this->extend('layout/master')?>
<?= $this->section('content')?>
<div class="content-wrapper">
    <section class="content">
        <h3 class="active" style="background-color: white; margin: 0px 0px 10px 0px; padding: 10px">Tabel Produk</h3>
        <br>
        <div class="row">
            <!-- Kolom untuk tombol tambah data -->
            <div class="col-sm-1 text-left">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
                    <i class="fa fa-plus-square"></i> <b>Tambah Data</b>
                </button>
                <br><br>
                <!-- Modal untuk menambahkan data -->
                <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('admin/tambahDataProduk');?>" method="post"
                                    enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="kategori_id" class="form-label">Nama Kategori</label>
                                        <select class="form-control selectpicker" aria-label="Default select example"
                                            name="kategori_id" data-live-search="true">
                                            <option selected disabled>Pilih Kategori Produk</option>
                                            <?php foreach ($kategori as $ktg) : ?>
                                            <option value="<?= $ktg['id_kategori']; ?>"><?= $ktg['nama_kategori']?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="suplier_id" class="form-label">Nama Suplier</label>
                                        <select class="form-control selectpicker" aria-label="Default select example"
                                            name="suplier_id" data-live-search="true">
                                            <option selected disabled>Pilih Suplier</option>
                                            <?php foreach ($suplier as $sp) : ?>
                                            <option value="<?= $sp['id_supplier']; ?>"><?= $sp['nama']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_produk" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" id="nama_produk" name="nama_produk">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_beli" class="form-label">Harga Beli</label>
                                        <input type="number" class="form-control" id="harga_beli" name="harga_beli">
                                    </div>
                                    <div class="form-group">
                                        <label for="diskon" class="form-label">Diskon</label>
                                        <input type="number" class="form-control" id="diskon" name="diskon" step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_jual" class="form-label">Harga Jual</label>
                                        <input type="number" class="form-control" id="harga_jual" name="harga_jual">
                                    </div>
                                    <div class="form-group">
                                        <label for="stok" class="form-label">Stok</label>
                                        <input type="number" class="form-control" id="stok" name="stok">
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Simpan Data</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kolom untuk pencarian data -->
            <div class="col-md-4 pull-right">
                <div class="input-group">
                    <span class="input-group-addon bg-primary"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Pencarian">
                </div>
            </div>
        </div>
        <div class="dataProduk"></div>
    </section>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script>
    $(document).ready(function() {
        // Panggil fungsi ambilData saat halaman dimuat
        ambilData();
        // Panggil fungsi ambilData saat pengguna mengetik di kolom pencarian
        $('#search').keyup(function() {
            console.log($('#search').val());
            ambilData();
        });
    });
    // Fungsi untuk mengambil data produk
    function ambilData() {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/ambilDataProduk') ?>",
            data: {
                search: $('#search').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.table) {
                    $('.dataProduk').html(response.table);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection()?>