<?php

namespace App\Controllers;

class Kasir extends BaseController
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
        $data['page_title'] = "Dashboard";

        $setting = $this->loadConfigData();
        $data['setting'] = $setting;
        return view('kasir/index', $data);
    }
}