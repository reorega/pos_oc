<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ReturBarang extends BaseController
{
    public function index()
    {
        $data['judul'] = "Halaman Retur Barang";
        $data['page_title'] = "Retur Barang";
        $data['suppliers'] = $this->supplierModel->findAll(); // Ambil semua data supplier
        $data['produk'] = $this->produkModel->findAll(); // Ambil semua data produk
        $data['setting'] = $this->loadConfigData(); // Load data konfigurasi
        return view('admin/returbarang', $data);
    }
    
    public function ambilDataReturBarang()
    {
        $search = $this->request->getPost('search');
        $page = $this->request->getPost('page') ?? 1;
        $jumlahpagination = 5;
        $no = $page * $jumlahpagination - ($jumlahpagination - 1);
        
        if ($search != "") {
            $data = [
                'returbarang' => $this->returbarangModel->searchReturBarang($search), // perbaikan nama method
                'supplier' => $this->supplierModel->findAll(),
                'produk' => $this->produkModel->findAll(),
                'search' => "yes",
            ];
        } else {
            $cari = $this->returbarangModel->returbarangPagination($jumlahpagination, $page);
            $data = [
                'returbarang' => $cari['returbarang'],
                'pager' => $cari['pager'],
                'suppliers' => $this->supplierModel->findAll(),
                'produk' => $this->produkModel->findAll(),
                'no' => $no,
                'search' => "no",
            ];
        }
        
        // Load view untuk tabel retur barang
        $table = view('admin/tablereturbarang', $data);
        return $this->response->setJSON(['table' => $table]);
    }

    public function tambahDataReturBarang()
    {
        // Retrieve input data from the form
        $id_produk = $this->request->getPost('produk_id'); // perbaikan nama input
        $jumlah = (int) $this->request->getPost('total_item'); // perbaikan nama input

        // Retrieve product data including the supplier_id
        $produkData = $this->produkModel->find($id_produk);
        $supplier_id = $produkData['suplier_id'];
        $harga_retur = $produkData['harga_beli'] * $jumlah;

        $stok_baru = $produkData['stok']-$jumlah;
        $data['stok'] = $stok_baru;
        $this->produkModel->update($id_produk,$data);

        // Prepare data for insertion
        $data = [
            'supplier_id' => $supplier_id, // perbaikan variabel
            'produk_id' => $id_produk,
            'jumlah' => $jumlah,
            'harga_retur' => $harga_retur,
            'keterangan' => $this->request->getPost('keterangan'), // assuming keterangan comes from the form
        ];

        // Insert data into the database
        $this->returbarangModel->insert($data);

        cache()->clean();
        $response = ['status' => 'success'];
        return $this->response->setJSON($response); 
    }

    public function editDataReturBarang()
    {
        // Retrieve input data from the form
        $id_retur_barang = $this->request->getPost('id_retur_barang');
        $id_produk = $this->request->getPost('produk_id'); // perbaikan nama input
        $jumlah = (int) $this->request->getPost('jumlah');

        // Retrieve product data including the supplier_id
        $produkData = $this->produkModel->find($id_produk);
        $supplier_id = $produkData['suplier_id']; // perbaikan variabel
        $harga_retur = $produkData['harga_beli'] * $jumlah;

        $retun_data = $this->returbarangModel->find($id_retur_barang);

        $stok_baru = ($produkData['stok']+$retun_data['jumlah'])-$jumlah;
        $data['stok'] = $stok_baru;
        $this->produkModel->update($id_produk,$data);

        // Prepare data for update
        $data = [
            'supplier_id' => $supplier_id,
            'produk_id' => $id_produk,
            'jumlah' => $jumlah,
            'harga_retur' => $harga_retur,
            'keterangan' => $this->request->getPost('keterangan'), // assuming keterangan comes from the form
        ];

        // Update data in the database
        $this->returbarangModel->update($id_retur_barang, $data);

        cache()->clean();
        $response = ['status' => 'success'];
        return $this->response->setJSON($response);  
    }

    public function hapusDataReturBarang()
    {
        // Retrieve data of the retur barang to get id_produk and jumlah
        $id_retur_barang = $this->request->getPost('id');
        $returData = $this->returbarangModel->find($id_retur_barang);
        $id_produk = $returData['produk_id'];
        $jumlah = $returData['jumlah'];
        $produkData = $this->produkModel->find($id_produk);

        $stok_baru = $produkData['stok']+$jumlah;
        $data['stok'] = $stok_baru;
        $this->produkModel->update($id_produk,$data);

        // Delete the retur barang data from the database
        $this->returbarangModel->delete($id_retur_barang);

        cache()->clean();
        $response = ['status' => 'success'];
        return $this->response->setJSON($response); 
    }
}
