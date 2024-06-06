<?= $this->extend('layout/master')?>
<?= $this->section('content')?>
<div class="content-wrapper">
    <section class="content">
        <h3 class="active" style="background-color: white; margin: 0px 0px 10px 0px; padding: 10px">Tabel Kategori</h3>
        <br>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
            <i class="fa fa-plus-square"></i> <b>Tambah Data</b>
        </button>
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
                        <form action="<?= base_url('/admin/tambahDataKategori');?>" method="post"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputNamaKategori" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="inputNamaKategori" name="nama_kategori">
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 pull-right">
            <div class="input-group ">
                <span class="input-group-addon bg-primary"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" id="search" name="search" placeholder="Pencarian">
            </div>
        </div>
        <br><br>
        <div class="dataKategori"></div>
    </section>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script>
    $(document).ready(function() {
        ambilData();
        $('#search').keyup(function() {
            console.log($('#search').val())
            ambilData();
        });
    });

    function ambilData() {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/ambilDataKategori') ?>",
            data: {
                search: $('#search').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.table) {
                    $('.dataKategori').html(response.table);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection()?>