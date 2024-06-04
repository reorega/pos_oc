<?php

namespace App\Controllers;
use App\Models\SettingModel;

class Admin extends BaseController
{
    public function index() 
    {

        $totalKategori = $this->kategoriModel->totalKategori();
        $data['totalKategori'] = $totalKategori;


        $totalProduk = $this->produkModel->totalProduk();
        $data['totalProduk'] = $totalProduk;


        $totalSupplier = $this->supplierModel->totalSupplier();
        $data['totalSupplier'] = $totalSupplier;


        $totalUser = $this->userModel->totalUser();
        $data['totalUser'] = $totalUser;

        $penjualan = $this->penjualanModel->dataChart();
        $data['penjualan'] = $penjualan;

        $setting= $this->loadConfigData();
        $data['setting'] = $setting;
        $data['page_title'] = "Dashboard";
        return view('admin/index', $data);
    }
}