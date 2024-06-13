<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table = 'barang_masuk'; // Sesuaikan dengan nama tabel di database Anda
    protected $primaryKey = 'id_barang_masuk'; // Sesuaikan dengan nama primary key di tabel barang masuk
    protected $allowedFields = ['id_supplier', 'id_produk', 'total_item', 'harga_beli', 'total_bayar', 'created_at', 'updated_at']; // Kolom yang diizinkan untuk dimasukkan atau diperbarui
    protected $useTimestamps = true; // Mengaktifkan penggunaan kolom created_at dan updated_at
    protected $createdField = 'created_at'; // Nama kolom created_at di tabel
    protected $updatedField = 'updated_at'; // Nama kolom updated_at di tabel

    // Function untuk melakukan pencarian berdasarkan kata kunci
    public function searchbarangmasuk($keyword)
    {
        $query = $this->db->table('barang_masuk'); // Sesuaikan dengan nama tabel Anda
        $query->select('barang_masuk.*, supplier.nama as supplier_name, produk.nama_produk as product_name'); // Sesuaikan dengan kolom yang ingin Anda pilih
        $query->join('supplier', 'supplier.id_supplier = barang_masuk.id_supplier'); // Sesuaikan dengan kondisi join Anda
        $query->join('produk', 'produk.id_produk = barang_masuk.id_produk'); // Sesuaikan dengan kondisi join Anda
        $query->like('supplier.nama', $keyword); // Sesuaikan dengan kolom yang ingin Anda cari
        $query->orLike('produk.nama_produk', $keyword); // Sesuaikan dengan kolom yang ingin Anda cari
        $result = $query->get()->getResultArray();
        return $result;
    }

    // Function untuk melakukan operasi join
    public function join()
    {
        $query = $this->db->table('barang_masuk'); // Sesuaikan dengan nama tabel Anda
        $query->select('barang_masuk.*, supplier.nama as supplier_name, produk.nama_produk as product_name'); // Sesuaikan dengan kolom yang ingin Anda pilih
        $query->join('supplier', 'supplier.id_supplier = barang_masuk.id_supplier'); // Sesuaikan dengan kondisi join Anda
        $query->join('produk', 'produk.id_produk = barang_masuk.id_produk'); // Sesuaikan dengan kondisi join Anda
        $result = $query->get()->getResultArray();
        return $result;
    }

    // Fungsi untuk mendapatkan data barang masuk
    public function getBarangMasuk()
    {
        return $this->select('barang_masuk.*, produk.nama_produk, produk.harga_beli')
                    ->join('produk', 'produk.id_produk = barang_masuk.id_produk')
                    ->findAll();
    }

    // Function untuk mencari kode berdasarkan kata kunci
    public function searchCode($keyword)
    {
        $query = $this->db->table('barang_masuk');
        $query->like('kode_produk', $keyword);
        $query->orLike('nama_produk', $keyword);
        $query->orLike('nama_kategori', $keyword);
        $query->orderBy('kode_produk', 'ASC');
        $result = $query->get()->getResultArray();
        return $result;
    }

    // Function untuk mengupdate stok di ProdukModel berdasarkan total_item
    public function updateStok($id_produk, $total_item)
    {
        // Load ProdukModel
        $produkModel = new ProdukModel();

        // Dapatkan stok saat ini
        $currentStok = $produkModel->find($id_produk)['stok'];

        // Hitung stok baru
        $newStok = $currentStok + $total_item;

        // Update stok di ProdukModel
        $produkModel->update($id_produk, ['stok' => $newStok]);
    }
    public function barangmasukPagination($perPage = 10, $page = 1)
    {
        $builder=$this->builder();
        
        $builder->select('barang_masuk.*, supplier.nama as supplier_name, produk.nama_produk as product_name')
        ->join('supplier', 'supplier.id_supplier = barang_masuk.id_supplier') 
        ->join('produk', 'produk.id_produk = barang_masuk.id_produk'); 

        return [
            'barangmasuk' => $this->paginate($perPage, 'default', $page),
            'pager' => $this->pager,
        ];
    }

    // Fungsi tambahan dapat ditambahkan di sini
}
