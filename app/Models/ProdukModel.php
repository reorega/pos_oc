<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk'; // Sesuaikan dengan nama tabel di database Anda
    protected $primaryKey = 'id_produk'; // Sesuaikan dengan nama primary key di tabel pengguna
    protected $allowedFields = ['kategori_id','suplier_id','kode_produk','nama_produk','diskon','harga_jual','stok']; // Kolom yang diizinkan untuk dimasukkan atau diperbarui
    protected $useTimestamps = true; // Mengaktifkan penggunaan kolom created_at dan updated_at
    protected $createdField = 'created_at'; // Nama kolom created_at di tabel
    protected $updatedField = 'updated_at'; // Nama kolom updated_at di tabel
    public function cariData($keyword){
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
        $result=$query->get()->getResultArray();
        return $result;
    }
    public function cariKode($keyword) {
        $query = $this->db->table('produk');
        // Pertama, cari berdasarkan kode_produk yang cocok sebagian dengan keyword
        $query->like('kode_produk', $keyword);
        // Kedua, cari berdasarkan nama_produk yang cocok sebagian dengan keyword
        $query->orLike('nama_produk', $keyword);
        // Terakhir, urutkan hasil berdasarkan kode_produk secara descending
        $query->orderBy('kode_produk', 'ASC');
        // Eksekusi query dan ambil hasilnya
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function cariProdukKode($keyword){
        
    }   
    public function totalProduk()
    {
        return $this->countAll();
    }
    public function cekStok($keyword){
        $query = $this->db->table('produk'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('stok'); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari
        $query->where('kode_produk', $keyword); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari
        $result = $query->get()->getRow();
        $stok = $result->stok;
        return $stok;
    } 
}