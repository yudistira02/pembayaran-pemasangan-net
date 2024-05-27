<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Jadwal extends Migration
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
            'teknisi_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'pelanggan_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'ticket_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => null
            ],
            'waktu_pemasangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => null
            ],
            'bukti_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => null
            ],
            'foto_pelanggan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => null
            ],
            'type_jadwal' => [
                'type' => 'ENUM',
                'constraint' => ['instalasi_baru', 'perbaikan'],
                'default' => 'instalasi_baru',
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
                'on_update' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
}
