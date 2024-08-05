<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ReturBarang extends BaseController
{
    protected $returbarangValidationRules = [
        'produk_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Produk harus dipilih',
            ]
        ],
        'jumlah' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'Total item harus diisi',
                'numeric' => 'Total item harus berupa angka',
            ]
        ],
        'keterangan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Keterangan item harus diisi',
            ]
        ],
    ];

    public function index()
    {
        $data['judul'] = "Halaman Retur Barang";
        $data['page_title'] = "Retur_Barang";
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
        $validation = \Config\Services::validation();
        $valid = $this->validate($this->returbarangValidationRules);

        if (!$valid) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['success' => false, 'errors' => $errors]);
        } else {
            $id_produk = $this->request->getPost('produk_id');
            $jumlah = (int) $this->request->getPost('jumlah');
            $produkData = $this->produkModel->find($id_produk);
            $supplier_id = $produkData['suplier_id'];
            $harga_retur = $produkData['harga_beli'] * $jumlah;

            $stok_baru = $produkData['stok'] - $jumlah;
            $data['stok'] = $stok_baru;
            $this->produkModel->update($id_produk, $data);

            $data = [
                'supplier_id' => $supplier_id,
                'produk_id' => $id_produk,
                'jumlah' => $jumlah,
                'harga_retur' => $harga_retur,
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            // Insert data into the database
            $this->returbarangModel->insert($data);
            cache()->clean();

            return $this->response->setJSON(['success' => true]);
        }
    }

    public function editDataReturBarang()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate($this->returbarangValidationRules);

        if (!$valid) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['success' => false, 'errors' => $errors]);
        } else {
            $id_retur_barang = $this->request->getPost('id');
            $id_produk = $this->request->getPost('produk_id');
            $jumlah = (int) $this->request->getPost('jumlah');

            $produkData = $this->produkModel->find($id_produk);
            $supplier_id = $produkData['suplier_id'];
            $harga_retur = $produkData['harga_beli'] * $jumlah;

            $retun_data = $this->returbarangModel->find($id_retur_barang);

            $stok_baru = ($produkData['stok'] + $retun_data['jumlah']) - $jumlah;
            $data['stok'] = $stok_baru;
            $this->produkModel->update($id_produk, $data);

            // Prepare data for update
            $data = [
                'supplier_id' => $supplier_id,
                'produk_id' => $id_produk,
                'jumlah' => $jumlah,
                'harga_retur' => $harga_retur,
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            // Update data in the database
            $this->returbarangModel->update($id_retur_barang, $data);

            cache()->clean();

            return $this->response->setJSON(['success' => true]);
        }
    }

    public function hapusDataReturBarang()
    {
        // Retrieve data of the retur barang to get id_produk and jumlah
        $id_retur_barang = $this->request->getPost('id');
        $returData = $this->returbarangModel->find($id_retur_barang);
        $id_produk = $returData['produk_id'];
        $jumlah = $returData['jumlah'];
        $produkData = $this->produkModel->find($id_produk);

        $stok_baru = $produkData['stok'] + $jumlah;
        $data['stok'] = $stok_baru;
        $this->produkModel->update($id_produk, $data);

        // Delete the retur barang data from the database
        $this->returbarangModel->delete($id_retur_barang);

        cache()->clean();

        return $this->response->setJSON(['status' => 'success']);
    }
}
