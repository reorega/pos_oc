<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table = 'penjualan'; // Sesuaikan dengan nama tabel di database Anda
    protected $primaryKey = 'id_penjualan';
    protected $allowedFields = ['no_faktur','tanggal','total_item','total_harga','diterima','kembalian','user_id']; // Kolom yang diizinkan untuk dimasukkan atau diperbarui


    protected $useTimestamps = true; // Mengaktifkan penggunaan kolom created_at dan updated_at
    protected $createdField = 'created_at'; // Nama kolom created_at di tabel
    protected $updatedField = 'updated_at'; // Nama kolom updated_at di tabel
    public function cariData($keyword){
        $query = $this->db->table('penjualan'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('*'); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari
        $query->where('no_faktur',$keyword); // Batasi hasil ke 1 baris
        $query->orderBy('no_faktur', 'ASC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function join()
    {
        $query = $this->db->table('penjualan'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('penjualan.*,users.username');
        $query->join('users', 'users.id_user = penjualan.user_id');
        $result=$query->get()->getResultArray();
        return $result;
    }
    public function laporanHarian($keyword){
        $query = $this->db->table('penjualan');
        $query->select('penjualan.*,users.username');
        $query->join('users', 'users.id_user = penjualan.user_id');
        $query->orderBy('no_faktur', 'DESC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $query->where("DATE(penjualan.created_at)", $keyword);
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function jumlahItem($keyword){
        $query = $this->db->table('penjualan');
        $query->select('SUM(total_item) as item,SUM(total_harga) as harga,SUM(diterima) as diterima,SUM(kembalian) as kembalian');
        $query->where("DATE(created_at)", $keyword);
        $result = $query->get()->getResultArray();
        return $result;
    }   
}