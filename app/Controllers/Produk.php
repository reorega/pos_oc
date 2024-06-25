<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use Dompdf\Dompdf;


class Produk extends BaseController
{
    public function index()
    {
        $data['judul'] = "Halaman Produk";
        $data['page_title'] = "Produk";
        $data['suplier'] = $this->suplierModel->findAll();
        $data['kategori'] = $this->kategoriModel->findAll();
        $setting = $this->loadConfigData();
        $data['setting'] = $setting;
        return view('/admin/produk', $data);
    }
    public function ambilDataProduk()
    {
        $search = $this->request->getPost('search');
        $page = $this->request->getPost('page') ?? 1;
        $jumlahpagination = 5;
        $no = $page * $jumlahpagination - ($jumlahpagination - 1);
        if ($search != "") {
            $data = [
                'produk' => $this->produkModel->cariKode2($search),
                'suplier' => $this->suplierModel->findAll(),
                'kategori' => $this->kategoriModel->findAll(),
                'search' => "yes",
            ];
        } else {
            $cari = $this->produkModel->produkPagination($jumlahpagination, $page);
            $data = [
                'produk' => $cari['produk'],
                'pager' => $cari['pager'],
                'suplier' => $this->suplierModel->findAll(),
                'kategori' => $this->kategoriModel->findAll(),
                'no' => $no,
                'search' => "no",
            ];
        }
        $table = view('admin/tableproduk', $data);
        return $this->response->setJSON(['table' => $table]);
    }
    public function tambahData()
    {
        $kategori_id = $this->request->getPost('kategori');
        $kode_produk = $this->createKode($kategori_id);
        $data = [
            'kategori_id' => $kategori_id,
            'suplier_id' => $this->request->getPost('suplier'),
            'kode_produk' => $kode_produk,
            'nama_produk' => $this->request->getPost('produk'),
            'harga_beli' => $this->request->getPost('hargabeli'),
            'diskon' => $this->request->getPost('diskon'),
            'harga_jual' => $this->request->getPost('hargajual'),
            'stok' => $this->request->getPost('stok'),
        ];
        $this->produkModel->insert($data);
        cache()->clean();
        $response = [
            'status' => 'success',
        ];
        return $this->response->setJSON($response);
    }
    public function editData()
    {
        $id = $this->request->getPost('id');
        $produkbyid = $this->produkModel->find($id);
        $kategori_id = $this->request->getPost('kategori');
        if ($kategori_id != $produkbyid['kategori_id']) {
            $kode = $this->createKode($kategori_id);

        } else {
            $kode = $produkbyid['kode_produk'];
        }
        $data = [
            'kategori_id' => $kategori_id,
            'suplier_id' => $this->request->getPost('suplier'),
            'kode_produk' => $kode,
            'nama_produk' => $this->request->getPost('produk'),
            'harga_beli' => $this->request->getPost('hargabeli'),
            'diskon' => $this->request->getPost('diskon'),
            'harga_jual' => $this->request->getPost('hargajual'),
            'stok' => $this->request->getPost('stok'),
        ];
        $this->produkModel->update($id, $data);
        cache()->clean();
        $response = [
            'status' => 'success',
        ];
        return $this->response->setJSON($response);
    }
    public function hapusData()
    {
        $id = $this->request->getPost('id');
        $this->produkModel->delete($id);
        cache()->clean();
        $response = [
            'status' => 'success',
        ];
        return $this->response->setJSON($response);
    }
    protected function createKode($kategori)
    {
        $kategoriBaru = $this->kategoriModel->find($kategori);
        $hurufdepan = substr($kategoriBaru['nama_kategori'], 0, 3);    // Mengambil huruf depan 0=start, 3=jml karakter yg diambil
        $hurufdepanbesar = strtoupper($hurufdepan);         // Menjadikan huruf besar     
        $result = $this->produkModel->cariData($hurufdepanbesar);
        if ($result) {
            $kode = $result[0];
            $no_urutproduk = (int) substr($kode['kode_produk'], 3);
            $no_urutproduk++;
        } else {
            $no_urutproduk = 1;
        }
        $no_urutproduk = sprintf('%04d', $no_urutproduk);
        $kodeProduk = $hurufdepanbesar . $no_urutproduk;
        return $kodeProduk;
    }
    public function barcode($id_produk)
    {
        $data['kode'] = $this->produkModel->find($id_produk);
        if (isset($data['kode']['kode_produk'])) {
            $html = view('admin/download', $data);
            // Panggil fungsi PdfGenerator
            $this->PdfGenerator($html, 'code_produk-' . $data['kode']['kode_produk'], 'A4', 'portrait');
        } else {
            // Handle jika data tidak ditemukan
            return "Produk tidak ditemukan";
        }
    }
    function PdfGenerator($html, $filename, $paper, $orientasi)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper($paper, $orientasi);
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream($filename, array(
            'Attachment' => false
        )
        );
    }
}
