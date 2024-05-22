<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranModel extends Model
{
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';
    protected $allowedFields = ['id_supplier', 'id_produk', 'total_item', 'harga_beli', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getWithSupplier()
    {
        // Join dengan tabel supplier untuk mendapatkan nama supplier
        return $this->select('barang_masuk.*, supplier.nama as nama_supplier')
                    ->join('supplier', 'supplier.id_supplier = barang_masuk.id_supplier')
                    ->findAll();
    }

    public function getWithProduct()
    {
        // Join dengan tabel produk untuk mendapatkan nama produk
        return $this->select('barang_masuk.*, produk.nama_produk as nama_produk')
                    ->join('produk', 'produk.id_produk = barang_masuk.id_produk')
                    ->findAll();
    }
}
