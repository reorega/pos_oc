<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    protected $allowedFields = ['kode_supplier','nama', 'alamat', 'telepon', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $useSoftDeletes = false;

    public function totalSupplier()
    {
        return $this->countAll();
    }
    public function cariKode($keyword)
    {
        $query = $this->table('supplier');
        $query->like('nama', $keyword);
        $query->orLike('kode_supplier', $keyword);
        $query->orLike('alamat', $keyword);
        $query->orLike('telepon', $keyword);
        $query->orderBy('kode_supplier', 'ASC');
        $result = $query->get()->getResultArray();
        return $result;
    }   
}
