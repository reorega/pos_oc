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
}