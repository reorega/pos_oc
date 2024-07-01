<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReturBarangTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_retur_barang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'produk_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'supplier_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'harga_retur' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_retur_barang', true);
        $this->forge->createTable('retur_barang');
    }

    public function down()
    {
        $this->forge->dropTable('retur_barang');
    }
}
