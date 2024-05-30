<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table = 'barang_masuk'; // Adjust with your database table name
    protected $primaryKey = 'id_barang_masuk'; // Adjust with your table's primary key name
    protected $allowedFields = ['id_supplier', 'id_produk', 'total_item', 'harga_beli','total_bayar', 'created_at', 'updated_at']; // Allowed fields for insertion or update
    protected $useTimestamps = true; // Activate the usage of created_at and updated_at columns
    protected $createdField = 'created_at'; // Name of created_at column in the table
    protected $updatedField = 'updated_at'; // Name of updated_at column in the table

    // Function to search for data based on keyword
    public function search($keyword)
    {
        $query = $this->db->table('barang_masuk'); // Adjust with your table name
        $query->like('kode_produk', $keyword); // Adjust with the column you want to search
        $query->orderBy('kode_produk', 'DESC'); // Adjust with the column you want to sort
        $query->limit(1); // Limit the result to 1 row
        $result = $query->get()->getResultArray();
        return $result;
    }

    // Function to perform a join operation
    public function join()
    {
        $query = $this->db->table('barang_masuk'); // Adjust with your table name
        $query->select('barang_masuk.*, supplier.nama as supplier_name, produk.nama_produk as product_name'); // Adjust with the columns you want to select
        $query->join('supplier', 'supplier.id_supplier = barang_masuk.id_supplier'); // Adjust with your join condition
        $query->join('produk', 'produk.id_produk = barang_masuk.id_produk'); // Adjust with your join condition
        $query->join('kategori', 'kategori.id_kategori = barang_masuk.id_kategori'); // Adjust with your join condition
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function getBarangMasuk()
    {
        return $this->select('barang_masuk.*, produk.nama_produk, produk.harga_beli')
                    ->join('produk', 'produk.id_produk = barang_masuk.produk_id')
                    ->findAll();
    }

    // Function to search for codes based on keyword
    public function searchCode($keyword)
    {
        $query = $this->db->table('barang_masuk');
        $query->like('kode_produk', $keyword);
        $query->orLike('nama_produk', $keyword);
        $query->orLike('nama_kategori', $keyword);
        $query->orderBy('kode_produk', 'ASC');
        $result = $query->get()->getResultArray();
        return $result;
    }

    // Function to update stock in ProdukModel based on total_item
    public function updateStock($id_produk, $total_item)
    {
        // Load ProdukModel
        $produkModel = new ProdukModel();

        // Get current stock
        $currentStock = $produkModel->find($id_produk)['stok'];

        // Calculate new stock
        $newStock = $currentStock + $total_item;

        // Update stock in ProdukModel
        $produkModel->update($id_produk, ['stok' => $newStock]);
    }
    
    // Additional functions can be added here
}
