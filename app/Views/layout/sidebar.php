<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Panel pengguna bilah sisi -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('public/AdminLTE-2/dist/img/logo.png'); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Administrator</p>
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
            <li class="active treeview">
                <a href="<?=site_url('home')?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="header">MASTER</li>
            <li>
                <a href="<?= base_url('admin/kategori'); ?>">
                    <i class="fa fa-cubes"></i> <span>Kategori</span>
                </a>
            </li>
            <li>
            <a href="<?= base_url('admin/produk'); ?>">
                    <i class="fa fa-cube"></i> <span>Produk</span>
                </a>
            </li>
            <li>
            <a href="<?= base_url('admin/supplier'); ?>">
                    <i class="fa fa-truck"></i> <span>Suplier</span>
                </a>
            </li>
            <li class="header">TRANSAKSI</li>
            <li>
                <a href="#">
                    <i class="fa fa-money"></i> <span>Pengeluaran</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-download"></i> <span>Pembelian</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-upload"></i> <span>Penjualan</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Aktif</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Baru</span>
                </a>
            </li>
            <li class="header">REPORT</li>
            <li>
                <a href="#">
                    <i class="fa fa-file-pdf-o"></i> <span>Laporan</span>
                </a>
            </li>
            <li class="header">SISTEM</li>
            <li>
                <a href="<?= base_url('admin/users'); ?>">
                    <i class="fa fa-users"></i> <span>User</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-cog"></i> <span>Settings</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>