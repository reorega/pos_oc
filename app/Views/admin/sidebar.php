<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Panel pengguna bilah sisi -->
        <div class="user-panel">
            <?php $session= session(); ?>
            <div class="pull-left image">
                <img src="<?php echo base_url('assets/fotoUser/').$session->foto_user; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $session->username;  ?></p>
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

            <li class="<?= isset($page_title) && $page_title == 'Dashboard' ? 'active' : '' ?>">
                <a href="<?=site_url('/admin')?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="header">MASTER</li>
            <li class="<?= isset($page_title) && $page_title == 'Kategori' ? 'active' : '' ?>">
                <a href="<?= base_url('admin/kategori'); ?>">
                    <i class="fa fa-cubes"></i> <span>Kategori</span>
                </a>
            </li>
            <li class="<?= isset($page_title) && $page_title == 'Produk' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/produk'); ?>">
                    <i class="fa fa-cube"></i> <span>Produk</span>
                </a>
            </li>
            <li class="<?= isset($page_title) && $page_title == 'Suplier' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/supplier'); ?>">
                    <i class="fa fa-truck"></i> <span>Supplier</span>
                </a>
            </li>
            <li class="header">TRANSAKSI</li>
            <li class="<?= isset($page_title) && $page_title == 'Barang_Masuk' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/barangmasuk'); ?>">
                    <i class="fa fa-download"></i> <span>Barang Masuk</span>
                </a>
            </li>
            <li class="<?= isset($page_title) && $page_title == 'Retur_Barang' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/returbarang'); ?>">
                    <i class="fa fa-recycle"></i> <span>Retur Barang</span>
                </a>
            </li>
            <li class="<?= isset($page_title) && $page_title == 'Penjualan' ? 'active' : '' ?>">
                <a href="<?= base_url('admin/penjualan'); ?>">
                    <i class="fa fa-money"></i> <span>Penjualan</span>
                </a>
            </li>
            <li class="header">REPORT</li>
            <li class="<?= isset($page_title) && $page_title == 'Laporan' ? 'active' : '' ?>">
                <a href="<?= base_url('admin/laporan'); ?>">
                    <i class="fa fa-file-pdf-o"></i> <span>Laporan</span>
                </a>
            </li>
            <li class="<?= isset($page_title) && $page_title == 'Laporan2' ? 'active' : '' ?>">
                <a href="<?= base_url('admin/laporan2'); ?>">
                    <i class="fa fa-file-pdf-o"></i> <span>Laporan Supplier</span>
                </a>
            </li>
            <li class="header">SISTEM</li>
            <li class="<?= isset($page_title) && $page_title == 'User' ? 'active' : '' ?>">
                <a href="<?= base_url('admin/users'); ?>">
                    <i class="fa fa-users"></i> <span>User</span>
                </a>
            </li>
            <li class="<?= isset($page_title) && $page_title == 'Setting' ? 'active' : '' ?>">
                <a href="<?= base_url('admin/setting'); ?>">
                    <i class="fa fa-cog"></i> <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>