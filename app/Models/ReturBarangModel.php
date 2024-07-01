<?php

namespace App\Models;

use CodeIgniter\Model;

class ReturBarangModel extends Model
{
    protected $table = 'retur_barang'; // Nama tabel di database
    protected $primaryKey = 'id_retur_barang'; // Nama primary key di tabel
    protected $allowedFields = ['produk_id', 'supplier_id', 'jumlah', 'harga_retur', 'keterangan', 'created_at', 'updated_at']; // Kolom yang diizinkan untuk dimasukkan atau diperbarui
    protected $useTimestamps = true; // Aktifkan penggunaan kolom created_at dan updated_at
    protected $createdField = 'created_at'; // Nama kolom created_at di tabel
    protected $updatedField = 'updated_at'; // Nama kolom updated_at di tabel

    // Function untuk melakukan pencarian berdasarkan kata kunci
    public function searchReturBarang($keyword)
    {
        $query = $this->db->table($this->table); // Tabel retur_barang
        $query->select('retur_barang.*, supplier.nama as supplier_name, produk.nama_produk as product_name'); // Pilih kolom yang diperlukan
        $query->join('supplier', 'supplier.id_supplier = retur_barang.supplier_id'); // Join dengan tabel supplier
        $query->join('produk', 'produk.id_produk = retur_barang.produk_id'); // Join dengan tabel produk
        $query->like('supplier.nama', $keyword); // Cari berdasarkan nama supplier
        $query->orLike('produk.nama_produk', $keyword); // Atau cari berdasarkan nama produk
        $result = $query->get()->getResultArray();
        return $result;
    }

    // Function untuk mendapatkan data retur barang dengan informasi supplier dan produk
    public function getReturBarang()
    {
        return $this->select('retur_barang.*, produk.nama_produk, produk.harga_beli')
                    ->join('produk', 'produk.id_produk = retur_barang.produk_id')
                    ->findAll();
    }

    // Function untuk melakukan pagination pada data retur barang
    public function returbarangPagination($perPage = 10, $page = 1)
    {
        $query = $this->select('retur_barang.*, supplier.nama as supplier_name, produk.nama_produk as product_name')
                      ->join('supplier', 'supplier.id_supplier = retur_barang.supplier_id')
                      ->join('produk', 'produk.id_produk = retur_barang.produk_id');

        return [
            'returbarang' => $query->paginate($perPage, 'default', $page),
            'pager' => $this->pager,
        ];
    }

    // Function untuk mencari kode produk atau nama produk berdasarkan kata kunci
    public function searchCode($keyword)
    {
        $query = $this->db->table($this->table); // Tabel retur_barang
        $query->like('kode_produk', $keyword); // Cari berdasarkan kode produk
        $query->orLike('nama_produk', $keyword); // Atau cari berdasarkan nama produk
        $query->orLike('nama_kategori', $keyword); // Atau cari berdasarkan nama kategori
        $query->orderBy('kode_produk', 'ASC'); // Urutkan berdasarkan kode produk secara ascending
        $result = $query->get()->getResultArray();
        return $result;
    }

}
