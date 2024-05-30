<?php

namespace App\Controllers;
use \App\Models\PenjualanModel;
class Kasir extends BaseController
{
    public function index()
    { 
        $penjualanModel = new PenjualanModel();
        $penjualan = $penjualanModel->dataChart();
        $data['penjualan'] = $penjualan;
        return view('kasir/index',$data);
    }
}