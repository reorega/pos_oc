<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Sesuaikan dengan nama tabel di database Anda
    protected $primaryKey = 'id'; // Sesuaikan dengan nama primary key di tabel pengguna

    protected $allowedFields = ['email','username', 'password', 'level_users']; // Kolom yang diizinkan untuk dimasukkan atau diperbarui

    protected $useTimestamps = true; // Mengaktifkan penggunaan kolom created_at dan updated_at

    protected $createdField = 'created_at'; // Nama kolom created_at di tabel
    protected $updatedField = 'updated_at'; // Nama kolom updated_at di tabel

    // Fungsi untuk mendapatkan data pengguna berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
    public function viewUser(){
        return $this->where('level_users', 2)->findAll();
    }
}
