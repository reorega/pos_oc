<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index() 
    {
        $kategoriModel = new \App\Models\KategoriModel();
        $totalKategori = $kategoriModel->totalKategori();
        $data['totalKategori'] = $totalKategori;

        $produkModel = new \App\Models\ProdukModel();
        $totalProduk = $produkModel->totalProduk();
        $data['totalProduk'] = $totalProduk;

        $supplierModel = new \App\Models\SupplierModel();
        $totalSupplier = $supplierModel->totalSupplier();
        $data['totalSupplier'] = $totalSupplier;

        $userModel = new \App\Models\UserModel();
        $totalUser = $userModel->totalUser();
        $data['totalUser'] = $totalUser;

        $penjualanModel = new \App\Models\PenjualanModel();
        $penjualan = $penjualanModel->dataChart();
        $data['penjualan'] = $penjualan;

        return view('admin/index', $data);
    }
}