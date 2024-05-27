<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Pelanggan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'pelanggan_id' => [
                'type' => 'BIGINT',
                'constraint' => 11,
                'null' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nomor_whatsapp' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'geolocation' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'foto_diri' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'paket' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '0',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pelanggan');
    }

    public function down()
    {
        $this->forge->dropTable('pelanggan');
    }
}
