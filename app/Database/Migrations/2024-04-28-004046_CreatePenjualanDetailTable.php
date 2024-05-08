<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenjualanDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penjualan_detail'            => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'no_faktur'      => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
            ],
            'produk_id'            => [
                'type'              => 'INT',
                'constraint'        => 5,
            ],
            'kode_produk'      => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
            ],
            'harga_jual'      => [
                'type'              => 'INT',
                'constraint'        => 50,
            ],
            'jumlah'      => [
                'type'              => 'INT',
                'constraint'        => 50,
            ],
            'diskon'            => [
                'type'              => 'FLOAT',
                'constraint'        => 3,
                'default'           => 0,
            ],
            'sub_total'            => [
                'type'              => 'INT',
                'constraint'        => 255,
            ],
            'total_sementara'            => [
                'type'              => 'INT',
                'constraint'        => 255,
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
        $this->forge->addPrimaryKey('id_penjualan_detail',true);
        $this->forge->createTable('penjualan_detail');
    }

    public function down()
    {
        $this->forge->dropTable('penjualan_detail');
    }
}
