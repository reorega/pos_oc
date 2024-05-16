<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBarangMasukTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_barang_masuk' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'INT',
                'constraint' => 255,
            ],
            'nama_produk' => [
                'type' => 'INT',
                'constraint' => 255,
            ],
            'total_item' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'total_harga' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'diskon' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'bayar' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_barang_masuk');
        $this->forge->createTable('barang_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('barang_masuk');
    }
}
