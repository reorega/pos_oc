<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BarangMasuk extends BaseController
{
    protected $barangmasukValidationRules = [
        'product_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Produk harus dipilih',
            ]
        ],
        'total_item' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'Total item harus diisi',
                'numeric' => 'Total item harus berupa angka',
            ]
        ],
    ];

    public function index()
    {
        $data['judul'] = "Halaman Barang Masuk";
        $data['page_title'] = "Barang Masuk";
        $data['suppliers'] = $this->supplierModel->findAll(); // Ambil semua data supplier
        $data['produk'] = $this->produkModel->findAll(); // Ambil semua data produk
        $setting = $this->loadConfigData();
        $data['setting'] = $setting; // Load data konfigurasi
        return view('/admin/barangmasuk', $data);
    }

    public function ambilDataBarangMasuk()
    {
        $search = $this->request->getPost('search');
        $page = $this->request->getPost('page') ?? 1;
        $jumlahpagination = 5;
        $no = $page * $jumlahpagination - ($jumlahpagination - 1);
        if ($search != "") {
            $data = [
                'barangmasuk' => $this->barangmasukModel->searchbarangmasuk($search),
                'suppliers' => $this->supplierModel->findAll(),
                'produk' => $this->produkModel->findAll(),
                'search' => "yes",
            ];
        } else {
            $cari = $this->barangmasukModel->barangmasukPagination($jumlahpagination, $page);
            $data = [
                'barangmasuk' => $cari['barangmasuk'],
                'pager' => $cari['pager'],
                'suppliers' => $this->supplierModel->findAll(),
                'produk' => $this->produkModel->findAll(),
                'no' => $no,
                'search' => "no",
            ];
        }
        $table = view('admin/tablebarangmasuk', $data);
        return $this->response->setJSON(['table' => $table]);
    }

    public function tambahDataBarangMasuk()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate($this->barangmasukValidationRules);

        if (!$valid) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['success' => false, 'errors' => $errors]);
        } else {
            $id_produk = $this->request->getPost('product_id');
            $cariProduk = $this->produkModel->find($id_produk);
            $id_supplier = $cariProduk['suplier_id'];
            $total_item = (int) $this->request->getPost('total_item');
            $harga_beli = $cariProduk['harga_beli'];
            $total_bayar = $harga_beli * $total_item;

            $data = [
                'id_supplier' => $id_supplier,
                'id_produk' => $id_produk,
                'total_item' => $total_item,
                'harga_beli' => $harga_beli,
                'total_bayar' => $total_bayar,
            ];

            $this->barangmasukModel->insert($data);
            $this->updateStok($id_produk, $total_item);
            cache()->clean();

            return $this->response->setJSON(['success' => true ]);
        }
    }

    public function editDataBarangMasuk()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate($this->barangmasukValidationRules);

        if (!$valid) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['success' => false, 'errors' => $errors]);
        } else {
            $id_barang_masuk = $this->request->getPost('id');
            $id_produk = $this->request->getPost('product_id');
            $total_item = $this->request->getPost('total_item');

            $produkData = $this->produkModel->find($id_produk);
            $id_supplier = $produkData['suplier_id'];
            $harga_beli = $produkData['harga_beli'];
            $total_bayar = $harga_beli * $total_item;

            $data = [
                'id_supplier' => $id_supplier,
                'id_produk' => $id_produk,
                'total_item' => $total_item,
                'harga_beli' => $harga_beli,
                'total_bayar' => $total_bayar
            ];

            $previousTransaction = $this->barangmasukModel->find($id_barang_masuk);
            $previousTotalItem = $previousTransaction['total_item'];
            $this->barangmasukModel->update($id_barang_masuk, $data);
            $this->updateStok($id_produk, $total_item - $previousTotalItem);
            cache()->clean();

            return $this->response->setJSON(['success' => true ]);
        }
    }

    public function getProductStock()
    {
        $productId = $this->request->getPost('product_id');
        
        if ($productId) {
            $product = $this->produkModel->find($productId);
            
            if ($product) {
                return $this->response->setJSON(['stok_sebelumnya' => $product['stok']]);
            }
        }
        
        return $this->response->setJSON(['stok_sebelumnya' => 0]);
    }    

    public function hapusDataBarangMasuk()
    {
        $id_barang_masuk = $this->request->getPost('id');
        $transaction = $this->barangmasukModel->find($id_barang_masuk);
        $id_produk = $transaction['id_produk'];
        $total_item = $transaction['total_item'];

        $this->barangmasukModel->delete($id_barang_masuk);
        $this->updateStok($id_produk, -$total_item);
        cache()->clean();

        return $this->response->setJSON(['status' => 'success']);
    }

    private function updateStok($id_produk, $total_item)
    {
        $currentStok = $this->produkModel->find($id_produk)['stok'];
        $newStok = $currentStok + $total_item;
        $this->produkModel->update($id_produk, ['stok' => $newStok]);
    }
}
