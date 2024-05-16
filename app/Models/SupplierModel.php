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
}
