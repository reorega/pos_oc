<?php
namespace App\Controllers;

use \Dompdf\Dompdf;
use CodeIgniter\Controller;


class Penjualan extends BaseController
{


    public function laporanHarian()
    {
        $data['judul'] = "Halaman Laporan";
        $data['page_title'] = "Laporan";
        $tanggal = date('Y-m-d');
        $setting = $this->loadConfigData();
        $data['setting'] = $setting;
        $data['data'] = $this->penjualanModel->laporanHarian($tanggal);
        return view('/kasir/laporanharian', $data);
    }
    public function laporanHarianDetail()
    {
        $no_faktur = $this->request->getpost('nofaktur');
        $data['detail'] = $this->penjualanDetailModel->join($no_faktur);
        $msg = [
            'viewModal' => view('kasir/modaldetail', $data)
        ];
        echo json_encode($msg);
    }
    public function printPdf()
    {
        $dompdf = new Dompdf();
        $tanggal = date('Y-m-d');
        $data['data'] = $this->penjualanDetailModel->laporanHarian($tanggal);
        $data['total'] = $this->penjualanDetailModel->jumlahItem2($tanggal);
        $html = view('kasir/laporanharianpdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'Potrait');
        $dompdf->render();
        $dompdf->stream(
            'LaporanHarian.pdf',
            array(
                'Attachment' => false
            )
        );
    }
    public function printPdf2()
    {
        $dompdf = new Dompdf();
        $tanggal = date('Y-m-d');
        $data['data'] = $this->penjualanModel->laporanHarian($tanggal);
        $data['total'] = $this->penjualanModel->jumlahItem($tanggal);
        $html = view('kasir/laporanharianpdf2', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'Potrait');
        $dompdf->render();
        $dompdf->stream(
            'LaporanHarian2.pdf',
            array(
                'Attachment' => false
            )
        );
    }
    public function dataChart()
    {
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $dataPenjualan = $this->penjualanModel->dataChart($startDate, $endDate);
        return $this->response->setJSON($dataPenjualan);
    }
    public function index(){
        $data['judul']="Halaman Penjualan";
        $data['page_title']="Penjualan";
        $setting= $this->loadConfigData();
        $data['setting'] = $setting;
        return view('/admin/penjualan',$data); 
    }

public function dataPenjualan(){
        $tanggalawal=$this->request->getPost('tanggalmulai');
        $tanggalakhir=$this->request->getPost('tanggalakhir');
        $page = $this->request->getPost('page') ?? 1;
        $jumlahpagination = 5;
        $no = $page * $jumlahpagination - ($jumlahpagination - 1);
        if($tanggalawal != ""){
            $olah_data = $this->penjualanModel->dataPenjualan($tanggalawal,$tanggalakhir,$jumlahpagination,$page);
            $data=[
                'penjualan' => $olah_data['penjualan'],
                'pager' => $olah_data['pager'],
                'no' => $no,  
            ];
        }else
        {
            $tanggalakhir = date('Y-m-d'); // Mendapatkan tanggal hari ini dalam format 'Y-m-d'
            $tanggalakhir_unix = strtotime($tanggalakhir); // Mengonversi tanggal menjadi UNIX timestamp
            $tanggalawal_unix = strtotime('-1 week', $tanggalakhir_unix); // Mengurangi satu minggu dari tanggal akhir
            $tanggalawal = date('Y-m-d', $tanggalawal_unix);
            $olah_data = $this->penjualanModel->dataPenjualan($tanggalawal,$tanggalakhir,$jumlahpagination,$page);
            $data=[
                'penjualan' => $olah_data['penjualan'],
                'pager' => $olah_data['pager'],
                'no' => $no,              
            ];
        }
        $table = view('admin/tablepenjualan', $data);
        return $this->response->setJSON(['table' => $table]);
    }
}