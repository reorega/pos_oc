<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Panel pengguna bilah sisi -->
        <div class="user-panel">
            <?php $session = session(); ?>
            <div class="pull-left image">
                <img src="<?php echo base_url('assets/fotoUser/') . $session->foto_user; ?>" class="img-circle"
                    alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $session->username; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Program Pencarian -->
        <!-- <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form> -->
        <!-- /.Program Pencarian -->

        <!-- Program Sidebar -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
                <a href="<?= site_url('/kasir') ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="header">Aplikasi</li>
            <li class="<?= isset($page_title) && $page_title == 'Kategori' ? 'active' : '' ?>">
                <a href="<?= base_url('kasir/laporanHarian'); ?>">
                    <i class="fa fa-cubes"></i> <span>Laporan Harian</span>
                </a>
            </li>
            <li class="<?= isset($page_title) && $page_title == 'Pos' ? 'active' : '' ?>">
                <a href="<?= base_url('kasir/pos'); ?>">
                    <i class="fa fa-cube"></i> <span>Transaksi</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>