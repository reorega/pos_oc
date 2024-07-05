<?= $this->extend('layout/master')?>
<?= $this->section('content')?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tabel Penjualan
        </h1>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
                            <i class="fa fa-plus-square"></i> Pilih Periode
                        </button>
                        <br><br>
                        <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="exampleModalLabel">Pilih Periode</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="tanggalmulai" class="form-label">Dari Tanggal</label>
                                                <input type="text" class="form-control" id="tanggalmulai"
                                                    name="tanggalmulai">
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggalakhir" class="form-label">Sampai Tanggal</label>
                                                <input type="text" class="form-control" id="tanggalakhir"
                                                    name="tanggalakhir">
                                            </div>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-success"
                                                id="btnTerapkan">Terapkan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dataPenjualan"></div>
            </div>
        </div>
    </section>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script>
    $(document).ready(function() {
        $('#tanggalmulai').datepicker({
            format: "yyyy-mm-dd"
        });
        $('#tanggalakhir').datepicker({
            format: "yyyy-mm-dd"
        });
        ambilData();
        $('#btnTerapkan').on('click', function() {
            ambilData();
        });
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            ambilData(page);
        });
    });

    function ambilData(page = 1) {
        console.log($('#tanggalmulai').val())
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/ambilDataPenjualan') ?>",
            data: {
                tanggalmulai: $('#tanggalmulai').val(),
                tanggalakhir: $('#tanggalakhir').val(),
                page: page,
            },
            dataType: "json",
            success: function(response) {
                if (response.table) {
                    $('.dataPenjualan').html(response.table);
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection()?>