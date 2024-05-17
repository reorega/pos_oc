<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel;
use App\Models\PosModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;


class Pos extends Controller
{
    public function __construct()
    {
        // Load model saat konstruktor dijalankan
        $this->produkModel = new ProdukModel();
        $this->suplierModel = new SupplierModel();
        $this->kategoriModel = new KategoriModel();
        $this->posModel = new PosModel();
        $this->penjualanDetailModel =new PenjualanDetailModel();
        $this->penjualanModel =new PenjualanModel();
        
    }
    public function index(){
        $data['produk'] = $this->produkModel->findAll();
        $data['faktur']=$this->buatFaktur();
        $data['judul']="Halaman POS";
        $data['page_title']="POS";
        return view('/kasir/pos',$data);
    }
    public function buatFaktur(){
        $tanggal = date('Y-m-d');
        $query = $this->posModel->cariFaktur($tanggal);
        $hurufDepan="FOC";
        if ($query) {
            $kode=$query[0];
            $no_urut = (int)substr($kode['nofaktur'],-4);
            $no_urut++;
        }else{
            $no_urut=1;
        }
        $no_urut = sprintf('%04d',$no_urut);
        $nofaktur=$hurufDepan.date('dmy',strtotime($tanggal)).$no_urut;
        return $nofaktur;   
        //$msg=['no_faktur'=>$nofaktur];
        //echo json_encode($msg);
    }
    public function ambilData(){
        $nofaktur=$this->request->getPost('nofaktur');
        $query = $this->penjualanDetailModel->cariData($nofaktur);        
        $data=[
            'datadetail' => $query
        ];
        $msg=[
            'data' => view('kasir/detailpos',$data)
        ];

        echo json_encode($msg);
    }
    public function ambilDataTotalHarga(){
        $nofaktur=$this->request->getPost('nofaktur');
        $query = $this->penjualanDetailModel->cariDataTotalHarga($nofaktur);        
        if($query){
            $harga=$query[0];
            $response = [
                'status' => 'success',
                'totalharga' => $harga['total_sementara'],                   
        ];
            return $this->response->setJSON($response);
        }else{
            $harga=$query[0];
            $response = [
                'status' => 'success',
                'totalharga' => 0,                   
        ];
            return $this->response->setJSON($response);
        }
    }
    public function hitungKembalian(){
        $totalbayar=$this->request->getPost('totalbayar');
        $jumlahbayar=$this->request->getPost('jumlahbayar');
        $totalbayar = intval($totalbayar);
        $jumlahbayar = intval($jumlahbayar);
        $kembalian=$jumlahbayar-$totalbayar;
        if($jumlahbayar==$totalbayar){
            $kembalian="0";
        }          
        $response = [
            'status' => 'success',
            'kembalian' => $kembalian,
            'totalbayar'=> $totalbayar,
            'jumlahbayar' => $jumlahbayar,                   
        ];
            return $this->response->setJSON($response);
        
    }
    public function viewProduk(){
        if($this->request->isAJAX()){
            $data['produk'] = $this->produkModel->findAll();
            $msg=[
                'viewModal' => view('kasir/modalproduk',$data)
            ];
            echo json_encode($msg);
        }
        
    }
    public function cekKode(){
        if($this->request->isAJAX()){
            $kode=$this->request->getPost('kode');
            $data['produk'] = $this->produkModel->cariKode($kode);
            $msg=[
                'viewModal' => view('kasir/modalproduk',$data)
            ];
            echo json_encode($msg);
        }
        
    }
    public function simpanTransaksiDetail(){
        $session=session();
        $kode_produk=$this->request->getPost('kode_produk');
        $jumlah=$this->request->getPost('jumlah');
        $no_faktur=$this->request->getPost('no_faktur');
        $query=$this->produkModel->where('kode_produk',$kode_produk)->first();
        if($query){
            $harga=$query['harga_jual'];
            $diskon=$query['diskon']; 
            $subTotal=$this->subTotal($no_faktur,$harga,$diskon,$jumlah);
            $totalSementara=$this->totalSementara($no_faktur,$subTotal);
            $diskon=$query['diskon'];
            $id_produk=$query['id_produk'];
            $harga_jual=$query['harga_jual'];
            $data = [
                'no_faktur' => $no_faktur,
                'produk_id' => $id_produk,
                'kode_produk' => $kode_produk,
                'harga_jual' => $harga_jual,
                'diskon' => $diskon,
                'jumlah' => $jumlah,
                'sub_total' => $subTotal ,
                'total_sementara' => $totalSementara ,
            ];
            $simpan=$this->penjualanDetailModel->insert($data);
            if($simpan){
                $response = [
                    'status' => 'success',
                    'totalharga' => $totalSementara,                   
            ];
                return $this->response->setJSON($response);
            }
        }   
    }
    public function hapusTransaksiDetail(){
        $id=$this->request->getPost('id_penjualan_detail');
        $cari=$this->penjualanDetailModel->find($id);
        $thargahapus=$cari['sub_total'];
        $data=$this->penjualanDetailModel->cariDataTerbesar();
        $dterbesar=$data[0];
        $hapus=$this->penjualanDetailModel->delete($id);
        $tsementara=$dterbesar['total_sementara']-$thargahapus;
        $data = [
            'total_sementara' => $tsementara,
        ];
        $update=$this->penjualanDetailModel->update($dterbesar['id_penjualan_detail'],$data);
        if($hapus){
            $response = [
                'status' => 'success',                  
        ];
            return $this->response->setJSON($response);
        }
    }
    public function simpanTransaksi(){
        $session=session();
        $iduser=$session->user_id;
        $no_faktur=$this->request->getPost('nofaktur');
        $totalbayar=$this->request->getPost('totalbayar');
        $jumlahbayar=$this->request->getPost('jumlahbayar');
        $kembalian=$this->request->getPost('kembalian');
        $query=$this->penjualanDetailModel->jumlahItem($no_faktur);
        if($query){
            $jumlahitem=$query[0];
            $data = [
                'no_faktur' => $no_faktur,
                'total_item' => $jumlahitem['jumlah'],
                'total_harga' => $totalbayar,
                'diterima' => $jumlahbayar,
                'kembalian' => $kembalian,
                'user_id' => $iduser,
            ];
            $simpan=$this->penjualanModel->insert($data);
            $data['nofaktur']=$no_faktur;
            if($simpan){
                $msg=[
                    'viewModal' => view('kasir/modalsimpanpenjualan',$data),
                ];
                echo json_encode($msg);
            }
        }   
    }
    public function subTotal($faktur,$harga,$diskon,$qty){
        $nofaktur=$faktur;
        $harga_jual=$harga;
        $diskon_produk=$diskon;
        $jumlah=$qty;
        $query=$this->penjualanDetailModel->find($nofaktur);
        //$query2=$this->produkModel->find($kodeproduk);
        $harga=$harga_jual*$jumlah-($harga_jual*$diskon_produk);
        $subsementara=$harga;
        if($query){
            foreach ($query as $q) :
                $subsementara+=$q['sub_total'];
            endforeach;
        }
         return $subsementara;
    }
    public function totalSementara($faktur,$sTotal){
        $subTotal=$sTotal;
        $nofaktur=$faktur;
        $totalHarga=0;
        $query=$this->penjualanDetailModel->cariData($nofaktur);
        if($query){
            if($query){
                foreach ($query as $q) :
                    $totalHarga+=$q['sub_total'];
                endforeach;
            }
        }
        $totalHarga+=$subTotal;
        return $totalHarga;
    }
    public function cetakNota($nofaktur){
        $data = [
            'penjualan' => $this->penjualanModel->cariData($nofaktur),
            'detail' => $this->penjualanDetailModel->join($nofaktur),
        ];
        return view('kasir/nota',$data);

    }

}
