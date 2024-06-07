<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
            <i class="fa fa-plus-square"></i> Tambah Barang Masuk
        </button>
        <!-- Modal Tambah Barang Masuk -->
        <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalLabel">Tambah Barang Masuk</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('/admin/tambahDataBarangMasuk'); ?>" method="post"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputSupplier" class="form-label">Nama Supplier : </label>
                                <select class="form-control selectpicker" aria-label="Default select example"
                                    name="id_supplier" data-live-search="true">
                                    <option selected disabled>Pilih Supplier</option>
                                    <?php foreach ($suppliers as $supplier) : ?>
                                    <option value="<?= $supplier['id_supplier']; ?>"><?= $supplier['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputProduk" class="form-label">Produk :</label>
                                <select class="form-control selectpicker" aria-label="Default select example"
                                    name="produk_id" data-live-search="true">
                                    <option selected disabled>Pilih Produk</option>
                                    <?php foreach ($produk as $pdk) : ?>
                                    <option value="<?= $pdk['id_produk']; ?>"><?= $pdk['nama_produk']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputTotalItem" class="form-label">Total Item : </label>
                                <input type="text" class="form-control" id="inputTotalItem" name="total_item">
                            </div>
                            <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pencarian -->
        <div class="col-md-4 pull-right">
            <div class="input-group">
                <span class="input-group-addon bg-primary"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" id="search" name="search" placeholder="Pencarian">
            </div>
        </div>
        <br><br>
        <!-- Tabel Data Barang Masuk -->
        <div class="dataProduk"></div>
    </section>
</div>

<script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
<script>
    $(document).ready(function() {
        ambilData();
        $('#search').keyup(function() {
            ambilData();
        });
    });

    function ambilData() {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/ambilDataBarangMasuk') ?>",
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
<?= $this->endSection() ?>