<?= $this->extend('layout/master')?>
<?= $this->section('content')?>

<style>
    .laporan-harian {
          max-height: 450px;
          overflow-y: scroll;
        }
        .laporan-harian .table thead {
          position: sticky;
          top: 0;
          z-index: 1;
        }
    .table-wrapper thead th {
        background-color: #343a40;
        color: #ffffff;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    th.no {
        width: 115px;
    }

    .table-dark th {
        text-align: center;
    }

    td.no {
        text-align: center;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tabel Laporan Harian (<?= date('d-m-Y') ?>)
        </h1>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-success"
                            onclick="window.open('<?= base_url('kasir/printPdf')?>','blank')">
                            Print 1
                            <i class="fa fa-print"></i>
                        </button>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-success"
                            onclick="window.open('<?= base_url('kasir/printPdf2')?>','blank')">
                            Print 2
                            <i class="fa fa-print"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-body">
                    <div class="table-wrapper laporan-harian">
                        <table class="table table-hover mt-2 table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th class="no">No Faktur</th>
                                    <th>Jumlah Item</th>
                                    <th>Total Harga</th>
                                    <th>Diterima</th>
                                    <th>Kembalian</th>
                                    <th>Kasir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $dt) : ?>
                                <tr class="text-center">
                                    <td><?= $dt['no_faktur'] ?></td>
                                    <td><?= $dt['total_item'] ?></td>
                                    <td>Rp <?= number_format($dt['total_harga'],0,',','.') ?></td>
                                    <td>Rp <?= number_format($dt['diterima'],0,',','.') ?></td>
                                    <td>Rp <?= number_format($dt['kembalian'],0,',','.') ?></td>
                                    <td><?= $dt['username'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info"
                                            onclick="dataDetail('<?= $dt['no_faktur'] ?>')">
                                            <i class="fa fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="viewmodaldatadetail" style="display:none;"></div>
    </section>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script>
    function dataDetail(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kasir/laporanHarianDetail') ?>",
            data: {
                nofaktur: id,
            },
            dataType: "json",
            success: function(response) {
                $('.viewmodaldatadetail').html(response.viewModal).show();
                $('#modalDataDetail').modal('show');
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection()?>