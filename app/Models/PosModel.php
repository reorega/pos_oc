<?php

namespace App\Models;

use CodeIgniter\Model;

class PosModel extends Model
{
    protected $table = 'penjualan '; // Sesuaikan dengan nama tabel di database Anda
    protected $primaryKey = 'id_penjualan'; // Sesuaikan dengan nama primary key di tabel pengguna
    protected $allowedFields = ['no_faktur','total_item','total_harga','diskon','total_bayar','diterima','kembalian','users_id']; // Kolom yang diizinkan untuk dimasukkan atau diperbarui
    protected $useTimestamps = true; // Mengaktifkan penggunaan kolom created_at dan updated_at
    protected $createdField = 'created_at'; // Nama kolom created_at di tabel
    protected $updatedField = 'updated_at'; // Nama kolom updated_at di tabel
    public function cariFaktur($keyword){
        $query = $this->db->table('penjualan');
        $query->select('no_faktur as nofaktur');
        $query->orderBy('no_faktur', 'DESC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $query->where("DATE(created_at)", $keyword);
        $result = $query->get()->getResultArray();
        return $result;
    }    

}