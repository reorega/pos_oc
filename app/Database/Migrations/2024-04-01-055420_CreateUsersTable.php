<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'username'      => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'email'         => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'password'      => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'level_user'    => [
                'type'              => 'INT',
                'constraint'        => 1,
                'default'           => 2,
            ],
            'foto_user'     => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
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
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
