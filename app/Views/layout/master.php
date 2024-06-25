<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Omah Cokelat Pacitan</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="icon" href="<?php echo base_url('/AdminLTE-2/dist/img/logo.png'); ?>" type="image/png">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/dist/css/AdminLTE.min.css'); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/dist/css/skins/_all-skins.min.css'); ?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/bower_components/morris.js/morris.css'); ?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/bower_components/jvectormap/jquery-jvectormap.css'); ?>">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'); ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/bower_components/bootstrap-daterangepicker/daterangepicker.css'); ?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/bower_components/select2/dist/css/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('/AdminLTE-2/bower_components/bootstrap-select-1.13.14/dist/css/bootstrap-select.min.css'); ?>">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
        .bootstrap-select .dropdown-menu {
            max-height: 100px; /* Tinggi maksimum dropdown untuk memicu scroll */
            overflow-y: auto;
        }
        .col-md-8 {
          max-height: 270px;
          overflow-y: scroll;
        }
        .col-md-8 .table thead {
          position: sticky;
          top: 0;
          z-index: 1;
        }
        
        
  
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- Program Header -->
    <?= view('layout/header'); ?>
    <!-- Program Header -->
    <?php
    $session = session();
    if($session->level==1){
       echo view('admin/sidebar'); 
    }else{
        echo view('kasir/sidebar'); 
    }
    ?>
    <!-- Program Sidebar -->
    <!-- Program Sidebar -->

    <!-- Program isi utama pada dashboard -->
    <?= $this->renderSection('content'); ?>
    <!-- Program isi utama pada dashboard -->

    <!-- Program Footer -->
    <?= view('layout/footer'); ?>
    <!-- Program Footer -->

    <!-- Kontrol Bilah Sisi -->
    <aside class="control-sidebar control-sidebar-dark" style="display: none;">
      <!-- Create the tabs -->
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-theme-demo-options-tab" data-toggle="tab"><i class="fa fa-sliders"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gear"></i></a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab"></div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Konten Tab Statistik</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
          <form method="post">
            <h3 class="control-sidebar-heading">Pengaturan Umum</h3>
            <div class="form-group">
              <label class="control-sidebar-subheading">
                Penggunaan panel laporan
                <input type="checkbox" class="pull-right" checked>
              </label>
              <p>
                Beberapa informasi tentang opsi pengaturan umum ini
              </p>
            </div>
            <div class="form-group">
              <label class="control-sidebar-subheading">
                Izinkan pengalihan email
                <input type="checkbox" class="pull-right" checked>
              </label>
              <p>
                Tersedia rangkaian opsi lainnya
              </p>
            </div>
            <div class="form-group">
              <label class="control-sidebar-subheading">
                Paparkan nama penulis di postingan
                <input type="checkbox" class="pull-right" checked>
              </label>
              <p>
                Izinkan pengguna untuk menampilkan namanya di postingan blog
              </p>
            </div>
          </form>
        </div>
      </div>
    </aside>

    <div class="control-sidebar-bg"></div>
  </div>
  <!-- jQuery 3 -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/jquery-ui/jquery-ui.min.js'); ?>"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
  <!-- Morris.js charts -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/raphael/raphael.min.js'); ?>"></script>
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/morris.js/morris.min.js'); ?>"></script>
  <!-- Sparkline -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js'); ?>"></script>
  <!-- jvectormap -->
  <script src="<?php echo base_url('/AdminLTE-2/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
  <script src="<?php echo base_url('/AdminLTE-2/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
  <!-- jQuery Knob Chart -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/jquery-knob/dist/jquery.knob.min.js'); ?>"></script>
  <!-- daterangepicker -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/moment/min/moment.min.js'); ?>"></script>
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
  <!-- datepicker -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="<?php echo base_url('/AdminLTE-2/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
  <!-- Slimscroll -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/fastclick/lib/fastclick.js'); ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url('/AdminLTE-2/dist/js/adminlte.min.js'); ?>"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?php echo base_url('/AdminLTE-2/dist/js/pages/dashboard.js'); ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo base_url('/AdminLTE-2/dist/js/demo.js'); ?>"></script>
  <!-- Select2 -->
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>
  <script src="<?php echo base_url('/AdminLTE-2/bower_components/bootstrap-select-1.13.14/dist/js/bootstrap-select.min.js'); ?>"></script>
  <!-- Inisialisasi Select2 -->
</body>

</html>
