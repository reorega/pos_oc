<?php

use CodeIgniter\Router\RouteCollection;
use App\Filters\Auth;
use App\Filters\Admin;
use App\Filters\Kasir;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/auth', 'Auth::process');
$routes->get('/logout', 'Auth::logout');

$routes->get('profile', 'User::profile');
$routes->post('updateProfile', 'User::updateProfile');


$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Admin');
    $routes->get('downloadChart', 'Admin::downloadChart');

    // Users
    $routes->get('users', 'User');
    $routes->post('tambahData', 'User::tambahData');
    $routes->post('editData', 'User::editData');
    $routes->post('hapusDataUser', 'User::hapusData');
    $routes->post('ambilDataUsers', 'User::ambilDataUsers');
    $routes->post('getUserData', 'User::getUserData');

    // Kategori
    $routes->get('kategori', 'Kategori');
    $routes->post('tambahDataKategori', 'Kategori::tambahDataKategori');
    $routes->post('editDataKategori', 'Kategori::editDataKategori');
    $routes->post('hapusDataKategori', 'Kategori::hapusDataKategori');
    $routes->post('ambilDataKategori', 'Kategori::ambilDataKategori');

    // Supplier
    $routes->get('supplier', 'Supplier');
    $routes->post('tambahDataSupplier', 'Supplier::tambahDataSupplier');
    $routes->post('editDataSupplier', 'Supplier::editDataSupplier');
    $routes->post('hapusDataSupplier', 'Supplier::hapusDataSupplier');
    $routes->post('ambilDataSupplier', 'Supplier::ambilDataSupplier');

    // Produk 
    $routes->get('produk', 'Produk');
    $routes->post('tambahDataProduk', 'Produk::tambahData');
    $routes->post('editDataProduk', 'Produk::editData');
    $routes->post('hapusDataProduk', 'Produk::hapusData');
    $routes->post('ambilDataProduk', 'Produk::ambilDataProduk');

    // Barang Masuk
    $routes->get('barangmasuk', 'BarangMasuk');
    $routes->post('tambahDataBarangMasuk', 'BarangMasuk::tambahDataBarangMasuk');
    $routes->post('editDataBarangMasuk', 'BarangMasuk::editDataBarangMasuk');
    $routes->post('hapusDataBarangMasuk', 'BarangMasuk::hapusDataBarangMasuk');
    $routes->post('ambilDataBarangMasuk', 'BarangMasuk::ambilDataBarangMasuk');

    //Retur Barang
    $routes->get('returbarang', 'ReturBarang');
    $routes->post('tambahDataReturBarang', 'ReturBarang::tambahDataReturBarang');
    $routes->post('editDataReturBarang', 'ReturBarang::editDataReturBarang');
    $routes->post('hapusDataReturBarang', 'ReturBarang::hapusDataReturBarang');
    $routes->post('ambilDataReturBarang', 'ReturBarang::ambilDataReturBarang');

    // Cetak Barcode
    $routes->get('barcode/(:num)', 'Produk::barcode/$1'); // Rute untuk Barcode
    $routes->get('download/(:num)', 'Produk::download/$1'); // Rute untuk Download

    // Setting
    $routes->get('setting', 'Setting');
    $routes->post('update', 'Setting::update');

    //Laporan
    $routes->get('laporan', 'Laporan');
    $routes->get('laporan2', 'Laporan::laporanSupplier');
    $routes->post('ambilDataLaporan', 'Laporan::ambilData');
    $routes->post('ambilDataLaporan2', 'Laporan::ambilData2');
    $routes->post('cetakLaporanPdf', 'Laporan::cetakPdf');

    //Penjualan
    $routes->get('penjualan', 'Penjualan');
    $routes->post('penjualanDetail', 'Penjualan::detailPenjualan');
    $routes->post('ambilDataPenjualan', 'Penjualan::dataPenjualan');
    $routes->post('ambilDataChart', 'Penjualan::dataChart');
    $routes->post('ambilDataDonut', 'Penjualan::dataDonut');
});

$routes->group('kasir', ['filter' => 'kasir'], function ($routes) {
    $routes->get('/', 'Kasir');
    // rute pos
    $routes->get('pos', 'Pos');
    $routes->post('buatFaktur', 'Pos::buatFaktur');
    $routes->post('ambilData', 'Pos::ambilData');
    $routes->post('ambilDataTotalHarga', 'Pos::ambilDataTotalHarga');
    $routes->post('cekKode', 'Pos::viewProduk');
    $routes->post('cekKodeIsi', 'Pos::cekKode');
    $routes->post('cekStok', 'Pos::cekStok');
    $routes->post('simpanTransaksiDetail', 'Pos::simpanTransaksiDetail');
    $routes->post('hapusTransaksiDetail', 'Pos::hapusTransaksiDetail');
    $routes->post('hitungKembalian', 'Pos::hitungKembalian');
    $routes->post('simpanTransaksi', 'Pos::simpanTransaksi');
    $routes->get('cetakNota/(:any)', 'Pos::cetakNota/$1');
    $routes->post('editSubtotal', 'Pos::editSubtotal');
    $routes->post('clearPenjualan', 'Pos::clearPenjualan');
    // rute laporan harian
    $routes->get('laporanHarian', 'Penjualan::laporanHarian');
    $routes->post('laporanHarianDetail', 'Penjualan::laporanHarianDetail');
    $routes->get('printPdf', 'Penjualan::printPdf');
    $routes->get('printPdf2', 'Penjualan::printPdf2');
    $routes->post('ambilDataChart', 'Penjualan::dataChart');
    $routes->post('ambilDataDonut', 'Penjualan::dataDonut');
});