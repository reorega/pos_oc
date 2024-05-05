<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdukTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_produk'            => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'kategori_id'            => [
                'type'              => 'INT',
                'constraint'        => 5,
                'null'              => true,
            ],
            'suplier_id'            => [
                'type'              => 'INT',
                'constraint'        => 5,
                'null'              => true,
            ],
            'kode_produk'      => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'nama_produk'      => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'diskon'            => [
                'type'              => 'TiNYINT',
                'constraint'        => 3,
                'default'           => 0,
            ],
            'harga_jual'            => [
                'type'              => 'INT',
                'constraint'        => 5,
            ],
            'stok'            => [
                'type'              => 'INT',
                'constraint'        => 10,
                'default'           => 0,
            ],
            'created_at'    => [
                'type'              => 'TIMESTAMP',
                'null'              => true,
            ],
            'updated_at'    => [
                'type'              => 'TIMESTAMP',
                'null'              => true,
            ],
        ]);
        $this->forge->addKey('id_produk');
        $this->forge->createTable('produk');
    }

    public function down()
    {
        $this->forge->dropTable('produk');
    }
}
