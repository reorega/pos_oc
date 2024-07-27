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
                        <h3><?= $totalKategori ?></h3>
                        <p><b>TOTAL KATEGORI</b></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cubes"></i>
                    </div>
                    
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $totalProduk ?></h3>
                        <p><b>TOTAL PRODUK</b></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cube"></i>
                    </div>
                    
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $totalSupplier ?></h3>
                        <p><b>TOTAL SUPPLIER</b></p>
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
                        <h3><?= $totalUser ?></h3>
                        <p><b>TOTAL USERS</b></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
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
                            <button type="button" class="btn btn-primary btn-sm daterange pull-right"
                                data-toggle="tooltip" title="Date range">
                                <i class="fa fa-calendar"></i></button>
                            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                                data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                                <i class="fa fa-minus"></i></button>
                        </div>
                        <li class="pull-left header"><i class="fa fa-bar-chart"></i>Jumlah Item Terjual</li>
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
                            <button type="button" class="btn btn-primary btn-sm daterangu pull-right"
                                data-toggle="tooltip" title="Date range">
                                <i class="fa fa-calendar"></i></button>
                            <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                                data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                                <i class="fa fa-minus"></i></button>
                        </div>
                        <li class="pull-left header"><i class="fa fa-bar-chart"></i>5 Produk Terlaris</li>
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
        ambilDonut();
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
    function ambilDonut(){
        $.ajax({
            url: '<?php echo base_url('/kasir/ambilDataDonut'); ?>',
            type: 'POST',
            success: function(response) {
                console.log(response);
                const products = response.map(item => item.produk);
                const totals = response.map(item => item.total_jumlah);
                var options = {
                        chart: {
                            type: 'polarArea',
                            height: 400,  // Tinggi chart
                            width: '100%',
                            toolbar: {
                                show: true,
                                tools: {
                                    download: true // Menampilkan tombol unduh di toolbar
                                },
                                autoSelected: 'zoom' // Pilihan default untuk toolbar
                            }
                        },
                        series: totals,
                        labels: products,
                        responsive: [{
                            breakpoint: 200,
                            options: {
                                chart: {
                                width: 200
                                },
                                legend: {
                                position: 'bottom'
                                }
                            }
                        }]
                    };
                var chart = new ApexCharts(document.querySelector("#sales-chart"), options);
                chart.render();
            }
        });
    }
</script>
<?= $this->endSection(); ?>