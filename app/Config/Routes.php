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
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Admin');

    // Users
    $routes->get('users', 'User');
    $routes->post('tambahData', 'User::tambahData');
    $routes->post('editData', 'User::editData');
    $routes->get('hapusDataUser/(:num)', 'User::hapusData/$1');
    $routes->post('ambilDataUsers', 'User::ambilDataUsers');

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


    // Pengeluaran
    $routes->get('pengeluaran', 'Pengeluaran');
    $routes->get('downloadpdf', 'Pengeluaran::downloadPDF'); // tambahkan rute untuk download PDF
    $routes->get('pengeluaranpdf', 'Pengeluaran::pengeluaranpdf'); // tambahkan rute untuk download PDF
   
    // Barang Masuk
    $routes->get('barangmasuk', 'BarangMasuk');
    $routes->post('tambahDataBarangMasuk', 'BarangMasuk::tambahDataBarangMasuk');
    $routes->post('editDataBarangMasuk', 'BarangMasuk::editDataBarangMasuk');
    $routes->post('hapusDataBarangMasuk/(:num)', 'BarangMasuk::hapusDataBarangMasuk/$1');

    // Cetak Barcode
    $routes->get('barcode/(:num)', 'Produk::barcode/$1'); // Rute untuk Barcode
    $routes->get('download/(:num)', 'Produk::download/$1'); // Rute untuk Download

    // Setting
    $routes->get('setting', 'Setting');
    $routes->post('update', 'Setting::update');

    //Laporan
    $routes->get('laporan', 'Laporan');
    $routes->post('ambilDataLaporan', 'Laporan::ambilData');
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

});