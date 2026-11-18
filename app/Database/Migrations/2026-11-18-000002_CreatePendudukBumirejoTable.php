<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePendudukBumirejoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'unique'     => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'rt' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
                'default'    => '001',
            ],
            'rw' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
                'default'    => '001',
            ],
            'dusun' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'Krajan',
            ],
            'jenis_kelamin' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
                'default'    => 'Laki-laki',
            ],
            'status_kependudukan' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => 'Warga Tetap',
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

        $this->forge->addKey('id', true);
        $this->forge->createTable('penduduk_bumirejo');
    }

    public function down()
    {
        $this->forge->dropTable('penduduk_bumirejo');
    }
}
