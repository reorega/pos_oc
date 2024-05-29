<?php

namespace App\Controllers;

use App\Models\BarangMasukModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel;
use App\Models\ProdukModel;
use CodeIgniter\Controller;

class BarangMasuk extends Controller
{
    
public function index()
{
    $BarangMasukModel = new BarangMasukModel();
    $supplierModel = new SupplierModel();
    $produkModel = new ProdukModel();
    $kategoriModel = new KategoriModel(); // Tambahkan pemanggilan model kategori

    // Mendapatkan nomor halaman saat ini
    $currentPage = $this->request->getVar('page_barangmasuk') ? $this->request->getVar('page_barangmasuk') : 1;

    // Mendapatkan semua data dari model dengan paginasi
    $data['BarangMasuks'] = $BarangMasukModel->paginate(10, 'barangmasuk');
    $data['pager'] = $BarangMasukModel->pager;

    // Ambil semua data supplier, produk, dan kategori
    $data['suppliers'] = $supplierModel->findAll();
    $data['produks'] = $produkModel->findAll();
    $data['kategoris'] = $kategoriModel->findAll(); // Ambil semua data kategori

    // Ubah ID supplier, produk, dan kategori menjadi nama supplier, produk, dan kategori
    foreach ($data['BarangMasuks'] as &$BarangMasuk) {
        $supplier = $supplierModel->find($BarangMasuk['id_supplier']);
        $produk = $produkModel->find($BarangMasuk['id_produk']);
        $kategori = $kategoriModel->find($BarangMasuk['id_kategori']);
        $BarangMasuk['nama_supplier'] = $supplier ? $supplier['nama'] : 'Supplier not found';
        $BarangMasuk['nama_produk'] = $produk ? $produk['nama_produk'] : 'Product not found';
        $BarangMasuk['nama_kategori'] = $kategori ? $kategori['nama_kategori'] : 'Kategori not found';
    }

    return view('admin/barangmasuk', $data);
}

    public function tambahDataBarangMasuk()
    {
        $model = new BarangMasukModel();

        // Retrieve input data from the form
        $id_supplier = $this->request->getPost('id_supplier');
        $id_produk = $this->request->getPost('produk_id');
        $id_kategori = $this->request->getPost('kategori_id');
        $total_item = $this->request->getPost('total_item');
        $harga_beli = $this->request->getPost('harga_beli');

        // Check if id_supplier is provided
        if (empty($id_supplier)) {
            // Redirect back with error message if id_supplier is empty
            return redirect()->back()->withInput()->with('error', 'Please select a supplier.');
        }

        // Prepare data for insertion
        $data = [
            'id_supplier' => $id_supplier,
            'id_produk' => $id_produk,
            'id_kategori' => $id_kategori,
            'total_item' => $total_item,
            'harga_beli' => $harga_beli,

            // Add other fields here if needed
        ];

        // Insert data into the database
        $model->insert($data);

        $this->updateStock($id_produk, $total_item);

        // Redirect to the BarangMasuk page with success message
        return redirect()->to('admin/barangmasuk')->with('success', 'Data barang masuk berhasil ditambahkan.');
    }

    // Function to update stock in ProdukModel based on total_item
    private function updateStock($id_produk, $total_item)
    {
        // Load ProdukModel
        $produkModel = new ProdukModel();

        // Get current stock
        $currentStock = $produkModel->find($id_produk)['stok'];

        // Calculate new stock
        $newStock = $currentStock + $total_item;

        // Update stock in ProdukModel
        $produkModel->update($id_produk, ['stok' => $newStock]);
    }

    public function editDataBarangMasuk()
    {
        $model = new BarangMasukModel();

        // Retrieve input data from the form
        $id_barang_masuk = $this->request->getPost('id_barang_masuk');
        $id_supplier = $this->request->getPost('id_supplier');
        $id_produk = $this->request->getPost('produk_id');
        $id_kategori = $this->request->getPost('kategori_id');
        $total_item = $this->request->getPost('total_item');
        $harga_beli = $this->request->getPost('harga_beli');

        // Prepare data for update
        $data = [
            'id_supplier' => $id_supplier,
            'id_produk' => $id_produk,
            'id_kategori' => $id_kategori,
            'total_item' => $total_item,
            'harga_beli' => $harga_beli,
            // Add other fields here if needed
        ];

        // Find the previous total_item
    $previousTransaction = $model->find($id_barang_masuk);
    $previousTotalItem = $previousTransaction['total_item'];

    // Update data in the database
    $model->update($id_barang_masuk, $data);

    // Update stock in ProdukModel by subtracting the previous total_item and adding the new total_item
    $this->updateStock($id_produk, $total_item - $previousTotalItem);

    // Redirect to the BarangMasuk page with success message
    return redirect()->to('admin/barangmasuk')->with('success', 'Data barang masuk berhasil diubah.');
}

public function hapusDataBarangMasuk($id_barang_masuk)
{
    $model = new BarangMasukModel();

    // Retrieve data of the transaction to get id_produk and total_item
    $transaction = $model->find($id_barang_masuk);
    $id_produk = $transaction['id_produk'];
    $id_kategori = $transaction['id_kategori'];
    $total_item = $transaction['total_item'];
    $harga_beli = $transaction['harga_beli'];

    // Delete the transaction data from the database
    $model->delete($id_barang_masuk);

    // Update stock in ProdukModel by subtracting the total_item of the deleted transaction
    $this->updateStock($id_produk, -$total_item);

    // Redirect to the BarangMasuk page with success message
    return redirect()->to('admin/barangmasuk')->with('success', 'Data barang masuk berhasil dihapus.');
}
}
