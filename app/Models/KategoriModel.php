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

    public function getKategori($id_kategori = null)
    {
        if ($id_kategori === null) {
            return $this->findAll();
        }

        return $this->find($id_kategori);
    }

    public function tambahKategori($data)
    {
        return $this->insert($data);
    }

    public function updateKategori($id_kategori, $data)
    {
        return $this->update($id_kategori, $data);
    }

    public function hapusKategori($id_kategori)
    {
        return $this->delete($id_kategori);
    }
}
