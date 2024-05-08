<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel;

class Produk extends Controller
{
    protected $produkModel;
    protected $supplierModel;
    protected $kategoriModel;
    public function __construct()
    {
        // Load model saat konstruktor dijalankan
        $this->produkModel = new ProdukModel();
        $this->suplierModel = new SupplierModel();
        $this->kategoriModel = new KategoriModel();
    }
    public function index(){
        $data['judul']="Halaman Produk";
        $data['page_title']="Produk";
        $data['produk'] = $this->produkModel->join();
        $data['suplier'] = $this->suplierModel->findAll();
        $data['kategori'] = $this->kategoriModel->findAll();
        return view('/admin/produk',$data);
    }
    public function tambahData(){
        $kategori_id=$this->request->getPost('kategori_id');
        $kode_produk=$this->createKode($kategori_id);
        $data = [
            'kategori_id' => $kategori_id,
            'suplier_id' => $this->request->getPost('suplier_id'),
            'kode_produk' => $kode_produk,
            'nama_produk' => $this->request->getPost('nama_produk'),
            'diskon' => $this->request->getPost('diskon'),
            'harga_jual' => $this->request->getPost('harga_jual'),
            'stok' => $this->request->getPost('stok'),
        ];
        $this->produkModel->insert($data);
        return redirect()->to('/admin/produk');
    }
    public function editData(){
        $id = $this->request->getPost('id_produk');
        $produkbyid = $this->produkModel->find($id);
        $kategori_id=$this->request->getPost('kategori_id');
        if($kategori_id!=$produkbyid['kategori_id']){
            $kode= $this->createKode($kategori_id);
            
        }else{
            $kode=$produkbyid['kode_produk'];
        }
        $data = [
            'kategori_id' => $this->request->getPost('kategori_id'),
            'suplier_id' => $this->request->getPost('suplier_id'),
            'kode_produk' => $kode,
            'nama_produk' => $this->request->getPost('nama_produk'),
            'diskon' => $this->request->getPost('diskon'),
            'harga_jual' => $this->request->getPost('harga_jual'),
            'stok' => $this->request->getPost('stok'),
        ];
        $this->produkModel->update($id,$data);
        return redirect()->to('/admin/produk');
    }
    public function hapusData($id=null){
        $this->produkModel->delete($id);
        return redirect()->to('/admin/produk');
    }
    protected function createKode($kategori){
        $kategoriBaru=$this->kategoriModel->find($kategori);
        $hurufdepan = substr($kategoriBaru['nama_kategori'],0,3);    // Mengambil huruf depan 0=start, 3=jml karakter yg diambil
        $hurufdepanbesar = strtoupper($hurufdepan);         // Menjadikan huruf besar     
        $result=$this->produkModel->cariData($hurufdepanbesar);
        if ($result) {
            $kode=$result[0];
            $no_urutproduk = (int)substr($kode['kode_produk'],3);
            $no_urutproduk++;
        }else{
            $no_urutproduk=1;
        }
        $no_urutproduk = sprintf('%04d',$no_urutproduk);
        $kodeProduk=$hurufdepanbesar.$no_urutproduk;    
        return $kodeProduk;
    }
}
