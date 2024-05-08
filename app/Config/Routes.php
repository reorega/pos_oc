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
    $routes->get('users', 'User');
    $routes->post('tambahData', 'User::tambahData');
    $routes->post('editData', 'User::editData');
    $routes->get('hapusDataUser/(:num)', 'User::hapusData/$1');

    // crud Kategori
    $routes->get('kategori', 'Kategori');
    $routes->post('tambahDataKategori', 'Kategori::tambahDataKategori');
    $routes->post('editDataKategori', 'Kategori::editDataKategori');
    $routes->post('hapusDataKategori', 'Kategori::hapusDataKategori');

    // crud Supplier
    $routes->get('supplier', 'Supplier');
    $routes->post('tambahDataSupplier', 'Supplier::tambahDataSupplier');
    $routes->post('editDataSupplier', 'Supplier::editDataSupplier');
    $routes->post('hapusDataSupplier', 'Supplier::hapusDataSupplier');

    //crud produk 
    $routes->get('produk', 'Produk');
    $routes->post('tambahDataProduk', 'Produk::tambahData');
    $routes->post('editDataProduk', 'Produk::editData');
    $routes->get('hapusDataProduk/(:num)', 'Produk::hapusData/$1');
});

$routes->group('kasir', ['filter' => 'kasir'], function ($routes) {
    $routes->get('/', 'Kasir');
    // Tambahkan rute-rute user di sini
});