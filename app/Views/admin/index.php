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
                    <a href="admin/kategori" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="admin/produk" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="admin/supplier" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="admin/users" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                            style="position: relative; height: 150px;"></div>
                    </div>
                </div>
                <!-- /.nav-tabs-custom -->

            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable" id="coba2" >
                <!-- Custom tabs (Charts with tabs)-->
                <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">
                        <div class="pull-right box-tools">
                        </div>
                        <li class="pull-left header"><i class="fa fa-bar-chart"></i>5 Produk Terlaris Dalam 30 Hari Terakhir</li>
                    </ul>
                    <div class="tab-content no-padding" id="coba" >
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="sales-chart"
                            style="position: relative; max-height: 300px;"></div>
                    </div>
                </div>
                <!-- /.nav-tabs-custom -->

            </section>
        </div>
    </section>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script src="<?= base_url('assets/js/apexcharts/dist/apexcharts.min.js');?>"></script>
<script src="<?= base_url('assets/js/html2canvas.min.js');?>"></script>
<script>
    /*
    function download(){
        html2canvas($('#coba2')[0]).then(function(canvas) {
                var a = document.createElement('a');
                a.href = canvas.toDataURL('image/png');
                a.download = 'chart.png';
                a.click();
            }).catch(function(error) {
             console.error('Error capturing chart:', error);
        });
    }
    function updateChartData(startDate, endDate) {
        var area = new Morris.Area({
            element   : 'revenue-chart',
            resize    : true,
            data      : [ ],
            xkey      : 'y',
            ykeys     : [
                'item',
            ],
            labels    : [
                'Jumlah item terjual',
            ],
            lineColors: ['#a0d0e0'],
            hideHover : 'auto'
           
        });
        $.ajax({
            url: '<?php echo base_url('/admin/ambilDataChart'); ?>',
            method: 'POST',
            data: {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            },
            dataType: 'json',
            success: function(response) {
                var chartData = response.map(function(item) {
                    return {
                        y: item.tanggal,
                        item: item.item
                    };
                });
                 area.setData(chartData);
            }
        });
    }
    function updateDonut(startDate, endDate){
        
        $.ajax({
            url: '<?php echo base_url('/admin/ambilDataDonut'); ?>',
            method: 'POST',
            data: {
                start_date: startDate.format('YYYY-MM-DD'),
                end_date: endDate.format('YYYY-MM-DD')
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                var chartData = response.map(function (item) {
                    return {
                        label: item.produk,
                        value: parseInt(item.total_jumlah)
                    };
                });
                console.log('Chart Data:', chartData);
                var donut = new Morris.Donut({
            element  : 'sales-chart',
            resize   : true,
            colors   : ['#3c8dbc', '#f56954', '#00a65a', '#f39c12', '#d2d6de'],
            data     : chartData,
            hideHover: 'auto',
            
        });
                
            },
            error: function (xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
        });
    }
    */
    $(document).ready(function() {
          /*  $('.daterange').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            }, function(start, end) {
                updateChartData(start, end);
            });
            
            $('.daterangu').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        }, function (start, end) {
            updateDonut(start, end);
        });

        // Initial load
       // updateChartData(moment().startOf('month'), moment().endOf('month'));
        updateDonut(moment().startOf('month'), moment().endOf('month'));
        /*
        $('#download').on('click', function() {
            html2canvas($('#coba2')[0]).then(function(canvas) {
                var a = document.createElement('a');
                a.href = canvas.toDataURL('image/png');
                a.download = 'chart.png';
                a.click();
            }).catch(function(error) {
             console.error('Error capturing chart:', error);
            });
        });
        */
        ambilChart();
        ambilDonut();
    });
    function ambilChart(){
        $.ajax({
                url: '<?php echo base_url('/admin/ambilDataChart'); ?>',
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
            url: '<?php echo base_url('/admin/ambilDataDonut'); ?>',
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