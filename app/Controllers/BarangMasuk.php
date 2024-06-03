<?php

namespace App\Controllers;

use App\Models\BarangMasukModel;
use App\Models\SupplierModel;
use App\Models\ProdukModel;
use CodeIgniter\Controller;

class BarangMasuk extends Controller
{
    public function __construct()
    {
        $this->produkModel = new ProdukModel(); // Initialize the produkModel
    }

    public function index()
    {
        $BarangMasukModel = new BarangMasukModel();
        $supplierModel = new SupplierModel();

        // Mendapatkan nomor halaman saat ini
        $currentPage = $this->request->getVar('page_barangmasuk') ? $this->request->getVar('page_barangmasuk') : 1;

        // Mendapatkan semua data dari model dengan paginasi
        $data['BarangMasuks'] = $BarangMasukModel->paginate(5, 'barangmasuk');
        $data['pager'] = $BarangMasukModel->pager;

        // Ambil semua data supplier dan produk
        $data['suppliers'] = $supplierModel->findAll();
        $data['produks'] = $this->produkModel->findAll();

        // Ubah ID supplier dan produk menjadi nama supplier dan produk
        foreach ($data['BarangMasuks'] as &$BarangMasuk) {
            $supplier = $supplierModel->find($BarangMasuk['id_supplier']);
            $produk = $this->produkModel->find($BarangMasuk['id_produk']);
            $BarangMasuk['nama_supplier'] = $supplier ? $supplier['nama'] : 'Supplier not found';
            $BarangMasuk['nama_produk'] = $produk ? $produk['nama_produk'] : 'Product not found';
        }

        $data['currentPage'] = $currentPage;

        return view('admin/barangmasuk', $data);
    }

    public function tambahDataBarangMasuk()
    {
        $model = new BarangMasukModel();

        // Retrieve input data from the form
        $id_supplier = $this->request->getPost('id_supplier');
        $id_produk = $this->request->getPost('produk_id');
        $total_item = (int)$this->request->getPost('total_item');

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
        $model->insert($data);

        $this->updateStock($id_produk, $total_item);

        // Redirect to the BarangMasuk page with success message
        return redirect()->to('admin/barangmasuk')->with('success', 'Data barang masuk berhasil ditambahkan.');
    }

        private function updateStock($id_produk, $total_item)
    {
        // Memuat ProdukModel
        $produkModel = new ProdukModel();

        // Periksa apakah produk dengan ID yang diberikan ada
        $produk = $produkModel->find($id_produk);
        if ($produk) {
            // Dapatkan stok saat ini
            $stokSekarang = $produk['stok'];

            // Hitung stok baru
            $stokBaru = $stokSekarang + $total_item;

            // Perbarui stok di ProdukModel
            $produkModel->update($id_produk, ['stok' => $stokBaru]);
        } else {
            // Tangani jika produk tidak ada
            // Anda dapat mencatat kesalahan atau tidak melakukan apa-apa tergantung pada kebutuhan Anda
        }
    }


    public function editDataBarangMasuk()
    {
        $model = new BarangMasukModel();

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
        $total_item = $transaction['total_item'];

        // Delete the transaction data from the database
        $model->delete($id_barang_masuk);

        // Update stock in ProdukModel by subtracting the total_item of the deleted transaction
        $this->updateStock($id_produk, -$total_item);

        // Redirect to the BarangMasuk page with success message
        return redirect()->to('admin/barangmasuk')->with('success', 'Data barang masuk berhasil dihapus.');
    }
   public function ambilDataBarangMasuk()
{
    $BarangMasukModel = new BarangMasukModel();
    $supplierModel = new SupplierModel();

    // Mendapatkan nilai pencarian dari request
    $search = $this->request->getPost('search');

    // Mendapatkan semua data dari model dengan atau tanpa pencarian
    $BarangMasuks = $search ? $BarangMasukModel->search($search) : $BarangMasukModel->findAll();

    // Ubah ID supplier menjadi nama supplier
    foreach ($BarangMasuks as &$BarangMasuk) {
        $supplier = $supplierModel->find($BarangMasuk['id_supplier']);
        $BarangMasuk['nama_supplier'] = $supplier ? $supplier['nama'] : 'Supplier not found';
        $produk = $this->produkModel->find($BarangMasuk['id_produk']); // Tambahkan baris ini
        $BarangMasuk['nama_produk'] = $produk ? $produk['nama_produk'] : 'Product not found';
    }

    // Tampilkan data dalam bentuk tabel
    $data['table'] = view('admin/tablebarangmasuk', ['BarangMasuks' => $BarangMasuks]);

    // Encode data ke dalam format JSON
    return $this->response->setJSON($data);
}

    
}
