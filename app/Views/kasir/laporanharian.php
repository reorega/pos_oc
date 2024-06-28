<?= $this->extend('layout/master')?>
<?= $this->section('content')?>
<div class="content-wrapper">
    <section class="content">
        <h4>Laporan Harian Tanggal <?= date('d-m-Y') ?></h4>
        <div class="my-2">
            <div class="row">
                <div class="col-sm-1">
                    <button type="button" class="btn btn-success" onclick="window.open('<?= base_url('kasir/printPdf')?>','blank')">
                        1
                        <i class="fa fa-print"></i>
                    </button>
                </div>
                <div class="col-sm-1">
                    <button type="button" class="btn btn-success" onclick="window.open('<?= base_url('kasir/printPdf2')?>','blank')">
                        2
                        <i class="fa fa-print"></i>
                    </button>
                </div>
            </div>
            
        </div>
        <br><br>
        <div class="box">
        <div class="box-body">
    <table class="table table-hover mt-2 table-bordered">
  <thead class="table-dark">
    <tr>
      <td>NO Faktur</td>
      <td>Jumlah Item</td>
      <td>Total Harga</td>
      <td>Diterima</td>
      <td>Kembalian</td>
      <td>Kasir</td>
      <td>Aksi</td>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($data as $dt) : ?>
        <tr>
            <td><?= $dt['no_faktur'] ?></td>
            <td><?= $dt['total_item'] ?></td>
            <td>RP <?= number_format($dt['total_harga'],0,',','.') ?></td>
            <td>RP <?= number_format($dt['diterima'],0,',','.') ?></td>
            <td>RP <?= number_format($dt['kembalian'],0,',','.') ?></td>
            <td><?= $dt['username'] ?></td>
            <td>
                <button type="button" class="btn btn-info" onclick="dataDetail('<?= $dt['no_faktur'] ?>')">
                  <i class="fa fa-eye"></i>
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>
<div class="viewmodaldatadetail" style="display:none;"></div>


    </section>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script>
    function dataDetail(id){
        $.ajax({
        type: "post",
        url: "<?= site_url('kasir/laporanHarianDetail') ?>",
        data: {
            nofaktur: id,
        },
        dataType: "json",
        success: function(response){
            $('.viewmodaldatadetail').html(response.viewModal).show();
            $('#modalDataDetail').modal('show');
        },
        error: function(xhr, thrownError){
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
    }
</script>
<?= $this->endSection()?>
