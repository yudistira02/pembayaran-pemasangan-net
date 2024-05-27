<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Laporan extends Migration
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
            'author' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'start_date' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'end_date' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['transaksi', 'jadwal'],
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
        $this->forge->createTable('laporan');
    }

    public function down()
    {
        $this->forge->dropTable('laporan');
    }
}
