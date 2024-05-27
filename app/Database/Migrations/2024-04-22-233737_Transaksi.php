<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Transaksi extends Migration
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
                'type' => 'INT',
                'constraint' => 11,
            ],
            'total' => [
                'type' => 'BIGINT',
                'constraint' => 255
            ],
            'kategori_pembayaran' => [
                'type' => 'ENUM',
                'constraint' => ['pasang_baru', 'bulanan'],
            ],
            'type_pembayaran' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '0',
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
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
