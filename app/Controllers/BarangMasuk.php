<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BarangMasuk extends BaseController
{
    public function index()
    {
        $data['judul'] = "Halaman BarangMasuk";
        $data['page_title'] = "BarangMasuk";
        $data['suppliers'] = $this->supplierModel->findAll(); // Ambil semua data supplier
        $data['produk'] = $this->produkModel->findAll(); // Ambil semua data produk
        $setting= $this->loadConfigData();
        $data['setting'] = $setting; // Load data konfigurasi
        return view('/admin/barangmasuk', $data);
    }
    
    public function ambilDataBarangMasuk()
    {
        $search=$this->request->getPost('search');
        $page = $this->request->getPost('page') ?? 1;
        $jumlahpagination = 5;
        $no = $page * $jumlahpagination - ($jumlahpagination - 1);
        if($search != ""){           
            $data = [
                'barangmasuk' => $this->barangmasukModel->searchbarangmasuk($search),
                'suppliers' => $this->supplierModel->findAll(),
                'produk' => $this->produkModel->findAll(),
                'search' => "yes",
            ];
        } else 
        {
            $cari = $this->barangmasukModel->barangmasukPagination($jumlahpagination,$page);
            $data=[
                'barangmasuk' => $cari['barangmasuk'] ,
                'pager' => $cari['pager'],
                'suppliers' => $this->supplierModel->findAll(),
                'produk' => $this->produkModel->findAll(),
                'no' => $no,
                'search' => "no",
            ];
        }
        // Load view untuk tabel pembelian
        $table = view('admin/tablebarangmasuk', $data);
        return $this->response->setJSON(['table' => $table]);
    }

    public function tambahDataBarangMasuk()
    {
        // Retrieve input data from the form
       // $id_supplier = $this->request->getPost('supplier');
        $id_produk = $this->request->getPost('produk');
        $cariProduk= $this->produkModel->find($id_produk);
        $id_supplier = $cariProduk['suplier_id'];
        $total_item = (int) $this->request->getPost('totalitem');

        // Retrieve product data including the purchase price
        $produkData = $this->produkModel->find($id_produk);
        $harga_beli = $produkData['harga_beli'];
        $total_bayar = $harga_beli * $total_item;

        // Check if id_supplier is provided
        if (empty($id_supplier)) {
            // Redirect back with error message if id_supplier is empty
            return redirect()->back()->withInput()->with('error', 'Please select a supplier.');
        }

        // Prepare data for insertion
        $data = [
            'id_supplier' => $id_supplier,
            'id_produk' => $id_produk,
            'total_item' => $total_item,
            'harga_beli' => $harga_beli,
            'total_bayar' => $total_bayar,
        ];

        // Insert data into the database
        $this->barangmasukModel->insert($data);

        $this->updateStok($id_produk, $total_item);
        cache()->clean();
        $response = [
            'status' => 'success',              
        ];
        return $this->response->setJSON($response); 
      }

    private function updateStok($id_produk, $total_item)
    {
        // Get current stock
        $currentStok = $this->produkModel->find($id_produk)['stok'];

        // Calculate new stock
        $newStok = $currentStok + $total_item;

        // Update stock in ProdukModel
        $this->produkModel->update($id_produk, ['stok' => $newStok]);
    }

    public function editDataBarangMasuk()
    {
        // Retrieve input data from the form
        $id_barang_masuk = $this->request->getPost('id');
        $id_produk = $this->request->getPost('produk');
        $total_item = $this->request->getPost('totalitem');

        $produkData = $this->produkModel->find($id_produk);
        $id_supplier = $produkData['suplier_id'];
        $harga_beli = $produkData['harga_beli'];
        $total_bayar = $harga_beli * $total_item;


        // Prepare data for update
        $data = [
            'id_supplier' => $id_supplier,
            'id_produk' => $id_produk,
            'total_item' => $total_item,
            'harga_beli' => $harga_beli,
            'total_bayar' => $total_bayar
        ];

        // Find the previous total_item
        $previousTransaction = $this->barangmasukModel->find($id_barang_masuk);
        $previousTotalItem = $previousTransaction['total_item'];
        // Update data in the database
        $this->barangmasukModel->update($id_barang_masuk, $data);
        // Update stock in ProdukModel by subtracting the previous total_item and adding the new total_item
        $this->updateStok($id_produk, $total_item - $previousTotalItem);
        cache()->clean();
        $response = [
            'status' => 'success',              
        ];
        return $this->response->setJSON($response);  
    }

    public function hapusDataBarangMasuk()
    {
        // Retrieve data of the transaction to get id_produk and total_item
        $id_barang_masuk = $this->request->getPost('id');
        $transaction = $this->barangmasukModel->find($id_barang_masuk);
        $id_produk = $transaction['id_produk'];
        $total_item = $transaction['total_item'];

        // Delete the transaction data from the database
        $this->barangmasukModel->delete($id_barang_masuk);

        // Update stock in ProdukModel by subtracting the total_item of the deleted transaction
        $this->updateStok($id_produk, -$total_item);
        cache()->clean();
        $response = [
            'status' => 'success',              
        ];
        return $this->response->setJSON($response); 
    }

}