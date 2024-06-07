<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BarangMasuk extends BaseController
{
    public function index()
    {
        $data['judul'] = "Halaman BarangMasuk";
        $data['page_title'] = "BarangMasuk";
        $data['barangmasuk'] = $this->barangmasukModel->join(); // Menggunakan method join dari PembelianModel untuk mendapatkan data pembelian
        $data['suppliers'] = $this->supplierModel->findAll(); // Ambil semua data supplier
        $data['produk'] = $this->produkModel->findAll(); // Ambil semua data produk
        $data['setting'] = $this->loadConfigData(); // Load data konfigurasi
        return view('/admin/barangmasuk', $data);
    }

    public function tambahDataBarangMasuk()
    {
        // Retrieve input data from the form
        $id_supplier = $this->request->getPost('id_supplier');
        $id_produk = $this->request->getPost('produk_id');
        $total_item = (int) $this->request->getPost('total_item');

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

        $this->updateStock($id_produk, $total_item);

        // Redirect to the BarangMasuk page with success message
        return redirect()->to('admin/barangmasuk')->with('success', 'Data barang masuk berhasil ditambahkan.');
    }

    private function updateStock($id_produk, $total_item)
    {
        // Get current stock
        $currentStock = $this->produkModel->find($id_produk)['stok'];

        // Calculate new stock
        $newStock = $currentStock + $total_item;

        // Update stock in ProdukModel
        $this->produkModel->update($id_produk, ['stok' => $newStock]);
    }

    public function editDataBarangMasuk()
    {
        // Retrieve input data from the form
        $id_barang_masuk = $this->request->getPost('id_barang_masuk');
        $id_supplier = $this->request->getPost('id_supplier');
        $id_produk = $this->request->getPost('produk_id');
        $total_item = $this->request->getPost('total_item');

        // Retrieve product data including the purchase price
        $produkData = $this->produkModel->find($id_produk);
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
        $this->updateStock($id_produk, $total_item - $previousTotalItem);

        // Redirect to the BarangMasuk page with success message
        return redirect()->to('admin/barangmasuk')->with('success', 'Data barang masuk berhasil diubah.');
    }

    public function hapusDataBarangMasuk($id_barang_masuk)
    {
        // Retrieve data of the transaction to get id_produk and total_item
        $transaction = $this->barangmasukModel->find($id_barang_masuk);
        $id_produk = $transaction['id_produk'];
        $total_item = $transaction['total_item'];

        // Delete the transaction data from the database
        $this->barangmasukModel->delete($id_barang_masuk);

        // Update stock in ProdukModel by subtracting the total_item of the deleted transaction
        $this->updateStock($id_produk, -$total_item);

        // Redirect to the BarangMasuk page with success message
        return redirect()->to('admin/barangmasuk')->with('success', 'Data barang masuk berhasil dihapus.');
    }

    public function ambilDataBarangMasuk()
    {
        $search = $this->request->getPost('search');
        if ($search != "") {
            // Cari pembelian berdasarkan kode produk atau nama produk
            $data = [
                'barangmasuk' => $this->barangmasukModel->searchbarangmasuk($search),
                'suppliers' => $this->supplierModel->findAll(),
                'produk' => $this->produkModel->findAll(),
            ];
        } else {
            // Jika tidak ada kata kunci pencarian, ambil semua data pembelian
            $data = [
                'barangmasuk' => $this->barangmasukModel->join(),
                'suppliers' => $this->supplierModel->findAll(),
                'produk' => $this->produkModel->findAll(),
            ];
        }
        // Load view untuk tabel pembelian
        $table = view('admin/tablebarangmasuk', $data);
        return $this->response->setJSON(['table' => $table]);
    }
}