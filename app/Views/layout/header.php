<header class="main-header">
  <!-- Logo -->
  <a href="http://localhost:8080/admin" class="logo">
    <?php
      $session = session();
    ?>
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>OC</b></span>
    <!-- logo for regular state and mobile devices -->
    <span><b><?=$setting['nama_perusahaan'];?></b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <?php $session = session(); ?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?php echo base_url('assets/fotoUser/').$session->foto_user;?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?= $session->username;  ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?php echo base_url('assets/fotoUser/').$session->foto_user; ?>" class="img-circle" alt="User Image">
              <p><?= $session->role; ?> - <?= $session->username;  ?></p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo base_url('/profile');?>" class="btn btn-default btn-flat">Profil</a>
              </div>
              <div class="pull-right">
                <a href="<?= base_url('logout');  ?>" class="btn btn-default btn-flat">Log Out</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>