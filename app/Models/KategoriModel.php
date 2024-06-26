<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function totalKategori()
    {
        return $this->countAll();
    }
    public function cariKode($keyword)
    {
        $query = $this->table('kategori');
        $query->like('nama_kategori', $keyword);
        $result = $query->get()->getResultArray();
        return $result;
    } 
}
