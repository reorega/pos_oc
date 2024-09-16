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
        $data['page_title'] = "Dashboard";
        $endDate = new \DateTime();
        $startDate = new \DateTime();
        $endDate->modify('+1 days');
        $startDate->modify('-30 days');
        $dataPenjualan = $this->penjualanDetailModel->dataDonut($startDate->format('Y-m-d'), $endDate->format('Y-m-d'));
        $data['gaya'] = $dataPenjualan;

        $setting= $this->loadConfigData();
        $data['setting'] = $setting;
        $data['page_title'] = "Dashboard";
        return view('admin/index', $data);
    }
    public function downloadChart(){
        $imgData = $this->request->getPost('imgData');
        
        // Hapus prefix base64
        $imgData = str_replace('data:image/png;base64,', '', $imgData);
        $imgData = str_replace(' ', '+', $imgData);

        // Decode base64 menjadi data biner
        $data = base64_decode($imgData);

        // Tentukan nama file
        $fileName = 'chart_' . time() . '.png';

        // Tentukan path untuk menyimpan file sementara
        $filePath = WRITEPATH . 'uploads/' . $fileName; // Ganti dengan ROOTPATH jika sesuai

        // Simpan data biner ke file
        $bytes_written = file_put_contents($filePath, $data);
        if ($bytes_written === false) {
            throw new \Exception('Failed to write file to ' . $filePath);
        }

        // Kirim file sebagai response download
        return $this->response->setHeader('Content-Type', 'image/png')
                              ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
                              ->setHeader('Content-Transfer-Encoding', 'binary')
                              ->setBody(file_get_contents($filePath));
    }
}