<?php
namespace App\Controllers;

use CodeIgniter\Controller;



class Pos extends BaseController
{

    public function index()
    {
        $data['produk'] = $this->produkModel->findAll();
        $data['faktur'] = $this->buatFaktur();
        $data['judul'] = "Halaman POS";
        $data['page_title'] = "POS";
        $setting = $this->loadConfigData();
        $data['setting'] = $setting;
        return view('/kasir/pos', $data);
    }
    public function buatFaktur()
    {
        $tanggal = date('Y-m-d');
        $query = $this->posModel->cariFaktur($tanggal);
        $hurufDepan = "FOC";
        if ($query) {
            $kode = $query[0];
            $no_urut = (int) substr($kode['nofaktur'], -4);
            $no_urut++;
        } else {
            $no_urut = 1;
        }
        $no_urut = sprintf('%04d', $no_urut);
        $nofaktur = $hurufDepan . date('dmy', strtotime($tanggal)) . $no_urut;
        return $nofaktur;
        //$msg=['no_faktur'=>$nofaktur];
        //echo json_encode($msg);
    }
    public function ambilData()
    {
        $nofaktur = $this->request->getPost('nofaktur');
        $query = $this->penjualanDetailModel->join($nofaktur);
        $data = [
            'datadetail' => $query
        ];
        $msg = [
            'data' => view('kasir/detailpos', $data)
        ];

        echo json_encode($msg);
    }
    public function ambilDataTotalHarga()
    {
        $nofaktur = $this->request->getPost('nofaktur');
        $totalHarga = 0;
        $data = $this->penjualanDetailModel->cariData($nofaktur);
        if ($data) {
            foreach ($data as $item) {
                // Misalnya, Anda memiliki field 'sub_total' dalam data yang didapat
                $totalHarga += $item['sub_total'];
            }


        }
        $response = [
            'status' => 'success',
            'totalharga' => $totalHarga,
        ];
        return $this->response->setJSON($response);
    }
    public function hitungKembalian()
    {
        $totalbayar = $this->request->getPost('totalbayar');
        $jumlahbayar = $this->request->getPost('jumlahbayar');
        $totalbayar = intval($totalbayar);
        $jumlahbayar = intval($jumlahbayar);
        $kembalian = $jumlahbayar - $totalbayar;
        if ($jumlahbayar == $totalbayar) {
            $kembalian = "0";
        }
        $response = [
            'status' => 'success',
            'kembalian' => $kembalian,
            'totalbayar' => $totalbayar,
            'jumlahbayar' => $jumlahbayar,
        ];
        return $this->response->setJSON($response);

    }
    public function viewProduk()
    {
        if ($this->request->isAJAX()) {
            $produk = $this->produkModel->where('stok !=', 0)->findAll();
            $data['produk'] = $produk;
            $msg = [
                'viewModal' => view('kasir/modalproduk', $data)
            ];
            echo json_encode($msg);    
        }

    }
    public function cekKode()
    {
        if ($this->request->isAJAX()) {
            $kode = $this->request->getPost('kode');
            $produk = $this->produkModel->cariKode($kode);
            $data['produk'] = $produk;
            $msg = [
                'viewModal' => view('kasir/modalproduk', $data)
            ];
            echo json_encode($msg);
        }

    }
    public function simpanTransaksiDetail()
    {

        $kode_produk = $this->request->getPost('kode_produk');
        $jumlah = $this->request->getPost('jumlah');
        $no_faktur = $this->request->getPost('no_faktur');
        $cekstok = $this->produkModel->cekStok($kode_produk);
        /*$cariProduk= $this->produkModel->cariKode3($kode_produk);
        if($cariProduk=="kosong"){
            $response = [
                'status' => 'kosong',
            ];
            return $this->response->setJSON($response);
        }*/
        if ($cekstok == 0) {
            $response = [
                'status' => 'error',
            ];
            return $this->response->setJSON($response);
        }
        $cek = $this->penjualanDetailModel->cariDataKode($kode_produk, $no_faktur);
        $query = $this->produkModel->where('kode_produk', $kode_produk)->first();
        if ($cek) {
            $dataitem = $cek[0];
            $jumlahbr = $dataitem['jumlah'] + $jumlah;
            $data = [
                'jumlah' => $jumlahbr,
                'sub_total' => $this->subTotal($kode_produk, $jumlahbr),
            ];
            $this->penjualanDetailModel->update($dataitem['id_penjualan_detail'], $data);
        } else {
            $diskon = $query['diskon'];
            $subTotal = $this->subTotal($kode_produk, $jumlah);
            $id_produk = $query['id_produk'];
            $harga_jual = $query['harga_jual'];
            $data = [
                'no_faktur' => $no_faktur,
                'produk_id' => $id_produk,
                'kode_produk' => $kode_produk,
                'harga_jual' => $harga_jual,
                'diskon' => $diskon,
                'jumlah' => $jumlah,
                'sub_total' => $subTotal,
            ];
            $simpan = $this->penjualanDetailModel->insert($data);
        }
        $response = [
            'status' => 'success',
        ];
        return $this->response->setJSON($response);
    }
    public function hapusTransaksiDetail()
    {
        $id = $this->request->getPost('id_penjualan_detail');
        $cari = $this->penjualanDetailModel->find($id);
        $thargahapus = $cari['sub_total'];
        $data = $this->penjualanDetailModel->cariDataTerbesar();
        $dterbesar = $data[0];
        $hapus = $this->penjualanDetailModel->delete($id);
        $tsementara = $dterbesar['total_sementara'] - $thargahapus;       
        $data = [
            'total_sementara' => $tsementara,
        ];
        $update = $this->penjualanDetailModel->update($dterbesar['id_penjualan_detail'], $data);
        if ($hapus) {
            $response = [
                'status' => 'success',
            ];
            return $this->response->setJSON($response);
        }
    }
    public function simpanTransaksi()
    {
        $session = session();
        $iduser = $session->user_id;
        $no_faktur = $this->request->getPost('nofaktur');
        $totalbayar = $this->request->getPost('totalbayar');
        $jumlahbayar = $this->request->getPost('jumlahbayar');
        $kembalian = $this->request->getPost('kembalian');
        $cari=$this->penjualanDetailModel->where('no_faktur',$no_faktur)->findAll();
        foreach ($cari as $cr) {
            $produk=$this->produkModel->find($cr['produk_id']);
            $stokbr = $produk['stok']-$cr['jumlah'];
            $data2=[
                'id_produk'=>$cr['produk_id'],
                'stok'=>$stokbr,
            ];
            $this->produkModel->update($cr['produk_id'],$data2);
        }
        $query = $this->penjualanDetailModel->jumlahItem($no_faktur);
        if ($query) {
            $jumlahitem = $query[0];
            $data = [
                'no_faktur' => $no_faktur,
                'total_item' => $jumlahitem['jumlah'],
                'total_harga' => $totalbayar,
                'diterima' => $jumlahbayar,
                'kembalian' => $kembalian,
                'user_id' => $iduser,
            ];
            $simpan = $this->penjualanModel->insert($data);
            $data['nofaktur'] = $no_faktur;
            if ($simpan) {
                $msg = [
                    'viewModal' => view('kasir/modalsimpanpenjualan', $data),
                ];
                echo json_encode($msg);
            }
        }
    }
    public function subTotal($kd, $jmlh)
    {
        $kode_produk = $kd;
        $jumlah = $jmlh;
        $subsementara = 1;
        $query = $this->produkModel->where('kode_produk', $kode_produk)->first();
        if ($query) {
            $harga_jual = $query['harga_jual'];
            $diskon_produk = $query['diskon'];
            $subsementara = $harga_jual * $jumlah - ($harga_jual * $diskon_produk);
        }
        return $subsementara;
    }
    public function cetakNota($nofaktur)
    {
        $setting = $this->loadConfigData();
        $data = [
            'penjualan' => $this->penjualanModel->cariData($nofaktur),
            'detail' => $this->penjualanDetailModel->join($nofaktur),
            'setting' => $setting,
        ];
        return view('kasir/nota', $data);

    }
    public function cekStok()
    {
        $kodeProduk = $this->request->getPost('kodeProduk');
        $quantity = $this->request->getPost('jumlah');
        $stock = $this->produkModel->cekStok($kodeProduk);
        if ($quantity > $stock) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Jumlah melebihi stok.']);
        }
        return $this->response->setJSON(['status' => 'success', 'message' => 'Stok mencukupi.']);
    }
    public function clearPenjualan()
    {
        $no_faktur = $this->request->getPost('nofaktur');
        $query = $this->penjualanDetailModel->where('no_faktur', $no_faktur)->delete();
        $response = [
            'status' => 'success',
        ];
        return $this->response->setJSON($response);

    }
    public function editSubtotal()
    {
        $no_faktur = $this->request->getPost('nofaktur');
        $id = $this->request->getPost('id_penjualan_detail');
        $kode_barcode = $this->request->getPost('kode');
        $jumlah = $this->request->getPost('jumlah');
        $subtotal = $this->subTotal($kode_barcode, $jumlah);
        $data = [
            'jumlah' => $jumlah,
            'sub_total' => $subtotal,
        ];
        $update = $this->penjualanDetailModel->update($id, $data);
        if ($update) {
            $response = [
                'status' => 'success',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Jumlah tidak boleh kosong.',
            ];
        }
        return $this->response->setJSON($response);
    }
}
