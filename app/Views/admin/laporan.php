<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tabel Laporan
        </h1>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-7">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
                            <i class="fa fa-plus-square"></i> Pilih Periode
                        </button>
                    </div>
                    <div class="col-md-5">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" onclick="cetakPdf()">Cetak PDF</button>
                        </div>
                    </div>
                </div>
                <br>
                <div class="dataLaporan">
                </div>
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
                <h4 class="modal-title" id="exampleModalLabel">Pilih Periode</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="tanggalmulai" class="form-label">Dari Tanggal : </label>
                        <input type="text" class="form-control" id="tanggalmulai" name="tanggalmulai">
                    </div>
                    <div class="form-group">
                        <label for="tanggalakhir" class="form-label">Sampai Tanggal : </label>
                        <input type="text" class="form-control" id="tanggalakhir" name="tanggalakhir">
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="btnTerapkan">Terapkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
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
    });

    function ambilData() {
        console.log($('#tanggalmulai').val())
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/ambilDataLaporan') ?>",
            data: {
                tanggalmulai: $('#tanggalmulai').val(),
                tanggalakhir: $('#tanggalakhir').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.table) {
                    $('.dataLaporan').html(response.table);
                    $('#tambahData').modal('hide');
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function cetakPdf() {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/cetakLaporanPdf') ?>",
            data: {
                tanggalmulai: $('#tanggalmulai').val(),
                tanggalakhir: $('#tanggalakhir').val(),
            },
            dataType: "json",
            success: function(response) {},
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection() ?>