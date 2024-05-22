<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanDetailModel extends Model
{
    protected $table = 'penjualan_detail'; // Sesuaikan dengan nama tabel di database Anda
    protected $primaryKey = 'id_penjualan_detail'; // Sesuaikan dengan nama primary key di tabel pengguna

    protected $allowedFields = ['penjualan_id','no_faktur','produk_id','kode_produk','harga_jual','jumlah','diskon','sub_total','total_sementara']; // Kolom yang diizinkan untuk dimasukkan atau diperbarui

    protected $useTimestamps = true; // Mengaktifkan penggunaan kolom created_at dan updated_at

    protected $createdField = 'created_at'; // Nama kolom created_at di tabel
    protected $updatedField = 'updated_at'; // Nama kolom updated_at di tabel
    public function cariData($keyword){
        $query = $this->db->table('penjualan_detail'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('*'); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari
        $query->where('no_faktur',$keyword); // Batasi hasil ke 1 baris
        $query->orderBy('no_faktur', 'ASC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function cariDataKode($keyword,$keyword2){
        $query = $this->db->table('penjualan_detail'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('*'); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari
        $query->where('kode_produk',$keyword); // Batasi hasil ke 1 baris
        $query->where('no_faktur',$keyword2); // Batasi hasil ke 1 baris
        $query->orderBy('id_penjualan_detail', 'DESC'); 
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function join($keyword)
    {
        $query = $this->db->table('penjualan_detail'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('penjualan_detail.*, produk.nama_produk as produk');
        $query->join('produk', 'produk.id_produk = penjualan_detail.produk_id');
        $query->where('no_faktur',$keyword); // Batasi hasil ke 1 baris
        $query->orderBy('no_faktur', 'ASC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $result=$query->get()->getResultArray();
        return $result;
    }
    public function cariDataTotalHarga($keyword){
        $query = $this->db->table('penjualan_detail'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('id_penjualan_detail,total_sementara'); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari
        $query->where('no_faktur',$keyword); // Batasi hasil ke 1 baris
        $query->orderBy('id_penjualan_detail', 'DESC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $query->limit(1);
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function cariDataTerbesar(){
        $query = $this->db->table('penjualan_detail'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('*'); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari // Batasi hasil ke 1 baris
        $query->orderBy('id_penjualan_detail', 'DESC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $query->limit(1);
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function jumlahItem($keyword){
        $query = $this->db->table('penjualan_detail');
        $query->select('SUM(jumlah) as jumlah');
        $query->where('no_faktur',$keyword);
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function laporanHarian($keyword){
        $query = $this->db->table('penjualan_detail');
        $query->select('penjualan_detail.*, produk.nama_produk as produk');
        $query->join('produk', 'produk.id_produk = penjualan_detail.produk_id');
        $query->where("DATE(penjualan_detail.created_at)", $keyword);
        $query->orderBy('no_faktur', 'ASC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $result = $query->get()->getResultArray();
        return $result;
    } 
    public function jumlahItem2($keyword){
        $query = $this->db->table('penjualan_detail');
        $query->select('SUM(jumlah) as jumlah,SUM(sub_total) as total');
        $query->where("DATE(created_at)", $keyword);
        $result = $query->get()->getResultArray();
        return $result;
    }
}