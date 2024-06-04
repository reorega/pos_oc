<?php

namespace App\Controllers;

class Kasir extends BaseController
{
    public function index()
    { 
        
        $penjualan = $penjualanModel->dataChart();
        $setting= $this->loadConfigData();
        $data['setting'] = $setting;
        $data['penjualan'] = $penjualan;
        return view('kasir/index',$data);
    }
}