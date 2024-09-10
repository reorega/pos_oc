<?= $this->extend('layout/master'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Header Konten (Header halaman) -->
    <section class="content-header">
        <h1>
            Dashboard
            <!-- <small>Control panel</small> -->
        </h1>
        <!-- <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
        </ol> -->
    </section>
    <!-- Isi utama dashboard -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $dashboard['tanggal'] ?></h3>
                        <p><b>Tanggal</b></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar-o"></i>
                    </div>
                    
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $dashboard['jumlah_transaksi'] ?></h3>
                        <p><b>Total Transaksi Hari Ini</b></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $dashboard['item'] ?></h3>
                        <p><b>Total Item Terjual Hari Ini</b></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-truck"></i>
                    </div>
                    
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>Rp <?= number_format($dashboard['omset'],0,",",".")  ?></h3>
                        <p><b>Total Omset Hari Ini</b></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-line-chart"></i>
                    </div>
                    
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-6 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">
                        <div class="pull-right box-tools">
                        </div>
                        <li class="pull-left header"><i class="fa fa-bar-chart"></i>Jumlah Item Terjual Dalam 30 Hari Terakhir</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="revenue-chart"
                            style="position: relative; height: 300px;"></div>
                    </div>
                </div>
                <!-- /.nav-tabs-custom -->

            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">
                        <div class="pull-right box-tools">
                        </div>
                        <li class="pull-left header"><i class="fa fa-bar-chart"></i>5 Produk Terlaris Dalam 30 Hari Terakhir</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="sales-chart"
                            style="position: relative; height: 300px;"></div>
                    </div>
                </div>
                <!-- /.nav-tabs-custom -->

            </section>
        </div>
    </section>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
<script>
    $(document).ready(function () {
        ambilChart();
        ambilRadar();
    });
    function ambilChart(){
        $.ajax({
                url: '<?php echo base_url('/kasir/ambilDataChart'); ?>',
                type: 'POST',
                success: function(response) {
                    const dates = response.map(item => item.tanggal);
                    const items = response.map(item => item.item);

                    var options = {
                        chart: {
                            type: 'line',
                            height: 400,  // Tinggi chart
                            width: '100%'
                        },
                        series: [{
                            name: 'Total Items',
                            data: items
                        }],
                        xaxis: {
                            categories: dates
                        }
                    }

                    var chart = new ApexCharts(document.querySelector("#revenue-chart"), options);

                    chart.render();
                },
                error: function (xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
        });
    }
    function ambilRadar(){
    $.ajax({
        url: '<?= base_url('/kasir/ambilDataDonut'); ?>',
        type: 'POST',
        success: function(response) {
            const products = response.map(item => item.produk);
            const totals = response.map(item => item.total_jumlah);

            var options = {
                chart: {
                    type: 'radar',
                    height: 550,
                    width: '100%',
                    toolbar: {
                        show: true,
                        tools: {
                            download: true
                        }
                    }
                },
                series: [{
                    name: 'Total Quantity',
                    data: totals
                }],
                labels: products,
                markers: {
                    size: 4
                },
                radar: {
                    size: 900,
                    polygons: {
                        strokeColors: '#e9e9e9',
                        fillColors: '#f7f7f7'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#sales-chart"), options);
            chart.render();
        },
        error: function (xhr, thrownError) {
            console.error('Error fetching radar chart data:', xhr, thrownError);
        }
    });
}
</script>
<?= $this->endSection(); ?>