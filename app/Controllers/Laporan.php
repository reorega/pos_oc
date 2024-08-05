<?php

namespace App\Controllers;

use App\Models\SettingModel;
use \Dompdf\Dompdf;

class Laporan extends BaseController
{
    public function index()
    {
        $setting = $this->loadConfigData();
        $data['setting'] = $setting;
        $data['page_title'] = "Laporan";
        $data['judul'] = "Omah Cokelat";
        return view('admin/laporan', $data);
    }
    public function ambilData()
    {
        $tanggalawal = $this->request->getPost('tanggalmulai');
        $tanggalakhir = $this->request->getPost('tanggalakhir');
        if ($tanggalawal != "") {
            $data = [
                'laporan' => $this->penjualanModel->laporan($tanggalawal, $tanggalakhir),
                'total' => $this->penjualanModel->totalLaporan($tanggalawal,$tanggalakhir),
            ];
        } else {
            $tanggalakhir = date('Y-m-d'); // Mendapatkan tanggal hari ini dalam format 'Y-m-d'
            $tanggalakhir_unix = strtotime($tanggalakhir); // Mengonversi tanggal menjadi UNIX timestamp
            $tanggalawal_unix = strtotime('-1 week', $tanggalakhir_unix); // Mengurangi satu minggu dari tanggal akhir
            $tanggalawal = date('Y-m-d', $tanggalawal_unix);
            $data = [
                'laporan' => $this->penjualanModel->laporan($tanggalawal, $tanggalakhir),
                'total' => $this->penjualanModel->totalLaporan($tanggalawal,$tanggalakhir),
            ];
        }
        $table = view('admin/tablelaporan', $data);
        return $this->response->setJSON(['table' => $table]);
    }
    public function cetakPdf()
    {
        $dompdf = new Dompdf();
        $tanggalawal = $this->request->getPost('tanggalmulai');
        $tanggalakhir = $this->request->getPost('tanggalakhir');
        $mode = $this->request->getPost('mode');
        $data['tanggalawal'] = $tanggalawal;
        $data['tanggalakhir'] = $tanggalakhir;
        if($mode==1){
            $data['data'] = $this->penjualanModel->laporan($tanggalawal, $tanggalakhir);
            $data['total'] = $this->penjualanModel->totalLaporan($tanggalawal,$tanggalakhir);
            $data['jenis'] = "Omah Cokelat";
        }else{
            $data['data'] = $this->penjualanModel->laporan2($tanggalawal, $tanggalakhir);
            $data['total'] = $this->penjualanModel->totalLaporan2($tanggalawal,$tanggalakhir);
            $data['jenis'] = "Supplier";
        }
        $html = view('admin/laporanpdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'Potrait');
        $dompdf->render();
        $dompdf->stream('LaporanLabaRugi.pdf', array(
            'Attachment' => false
        )
        );
    }
    public function laporanSupplier(){
        $setting = $this->loadConfigData();
        $data['setting'] = $setting;
        $data['page_title'] = "Laporan2";
        $data['judul'] = "Supplier";
        return view('admin/laporan', $data);
    }
    public function ambilData2()
    {
        $tanggalawal = $this->request->getPost('tanggalmulai');
        $tanggalakhir = $this->request->getPost('tanggalakhir');
        if ($tanggalawal != "") {
            $data = [
                'laporan' => $this->penjualanModel->laporan2($tanggalawal, $tanggalakhir),
                'total' => $this->penjualanModel->totalLaporan2($tanggalawal,$tanggalakhir),
            ];
        } else {
            $tanggalakhir = date('Y-m-d'); // Mendapatkan tanggal hari ini dalam format 'Y-m-d'
            $tanggalakhir_unix = strtotime($tanggalakhir); // Mengonversi tanggal menjadi UNIX timestamp
            $tanggalawal_unix = strtotime('-1 week', $tanggalakhir_unix); // Mengurangi satu minggu dari tanggal akhir
            $tanggalawal = date('Y-m-d', $tanggalawal_unix);
            $data = [
                'laporan' => $this->penjualanModel->laporan2($tanggalawal, $tanggalakhir),
                'total' => $this->penjualanModel->totalLaporan2($tanggalawal,$tanggalakhir),
            ];
        }
        $table = view('admin/tablelaporan', $data);
        return $this->response->setJSON(['table' => $table]);
    }
}