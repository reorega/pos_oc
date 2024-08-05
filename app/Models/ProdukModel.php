<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk'; // Sesuaikan dengan nama tabel di database Anda
    protected $primaryKey = 'id_produk'; // Sesuaikan dengan nama primary key di tabel pengguna
    protected $allowedFields = ['kategori_id', 'suplier_id', 'kode_produk', 'nama_produk', 'harga_beli', 'diskon', 'harga_jual', 'stok']; // Kolom yang diizinkan untuk dimasukkan atau diperbarui
    protected $useTimestamps = true; // Mengaktifkan penggunaan kolom created_at dan updated_at
    protected $createdField = 'created_at'; // Nama kolom created_at di tabel
    protected $updatedField = 'updated_at'; // Nama kolom updated_at di tabel
    public function cariData($keyword)
    {
        $query = $this->db->table('produk'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->like('kode_produk', $keyword); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari
        $query->orderBy('kode_produk', 'DESC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $query->limit(1); // Batasi hasil ke 1 baris
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function join()
    {
        $query = $this->db->table('produk'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('produk.*, supplier.nama as suplier, kategori.nama_kategori as kategori');
        $query->join('supplier', 'supplier.id_supplier = produk.suplier_id');
        $query->join('kategori', 'kategori.id_kategori = produk.kategori_id');
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function cariKode2($keyword)
    {
        $query = $this->db->table('produk');
        $query->select('produk.*, supplier.nama as suplier, kategori.nama_kategori as kategori');
        $query->join('supplier', 'supplier.id_supplier = produk.suplier_id');
        $query->join('kategori', 'kategori.id_kategori = produk.kategori_id');
        // Pertama, cari berdasarkan kode_produk yang cocok sebagian dengan keyword
        $query->like('kode_produk', $keyword);
        // Kedua, cari berdasarkan nama_produk yang cocok sebagian dengan keyword
        $query->orLike('produk.nama_produk', $keyword);
        $query->orLike('supplier.nama', $keyword);
        $query->orLike('kategori.nama_kategori', $keyword);
        // Terakhir, urutkan hasil berdasarkan kode_produk secara descending
        $query->orderBy('kode_produk', 'ASC');
        // Eksekusi query dan ambil hasilnya
        $result = $query->get()->getResultArray();
        return $result;
    }

    public function cariKode($keyword)
    {
        $query = $this->db->table('produk');
        // Pertama, cari berdasarkan kode_produk yang cocok sebagian dengan keyword
        // Kedua, cari berdasarkan nama_produk yang cocok sebagian dengan keyword
        $query->like('nama_produk', $keyword);
        // Terakhir, urutkan hasil berdasarkan kode_produk secara descending
        $query->where('stok !=', 0);
        // Eksekusi query dan ambil hasilnya
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function cariKode3($keyword)
    {
        $query = $this->db->table('produk');
        $query->select();
        $query->where('kode_produk', $keyword);
        $result = $query->get()->getResultArray();
        if (empty($result)) {
            return 'kosong';
        }
        return $result;
    }
    public function totalProduk()
    {
        return $this->countAll();
    }
    public function cekStok($keyword)
    {
        $query = $this->db->table('produk'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('stok'); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari
        $query->where('kode_produk', $keyword); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari
        $result = $query->get()->getRow();
        $stok = $result->stok;
        return $stok;
    }
    public function produkPagination($perPage = 10, $page = 1)
    {
        $builder = $this->builder();

        $builder->select('produk.*, supplier.nama as suplier, kategori.nama_kategori as kategori')
            ->join('supplier', 'supplier.id_supplier = produk.suplier_id')
            ->join('kategori', 'kategori.id_kategori = produk.kategori_id');

        return [
            'produk' => $this->paginate($perPage, 'default', $page),
            'pager' => $this->pager,
        ];
    }
}