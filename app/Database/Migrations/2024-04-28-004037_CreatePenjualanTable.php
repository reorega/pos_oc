<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenjualanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penjualan'            => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'no_faktur'      => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'total_item'            => [
                'type'              => 'INT',
                'constraint'        => 5,
                'null'              => true,
            ],
            'total_harga'            => [
                'type'              => 'INT',
                'constraint'        => 50,
                'null'              => true,
            ],
            'diterima'            => [
                'type'              => 'INT',
                'constraint'        => 50,
                'default'           => 0,
            ],
            'kembalian'            => [
                'type'              => 'INT',
                'constraint'        => 50,
            ],
            'user_id'            => [
                'type'              => 'INT',
                'constraint'        => 10,
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
        $this->forge->addPrimaryKey('id_penjualan',true);
        $this->forge->createTable('penjualan');
    }

    public function down()
    {
        $this->forge->dropTable('penjualan');
    }
}
