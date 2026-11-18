<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        // 1. Membuat Tabel Users untuk 3 Role (Warga, Admin, Pejabat)
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
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'warga', // Pilihan: 'warga', 'admin', 'pejabat'
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
        $this->forge->createTable('users');

        // 2. Menambahkan kolom user_id dan disetujui_oleh ke tabel agenda_umum
        $fields = [
            'user_id' => [
                'type'       => 'INTEGER',
                'null'       => true,
                'after'      => 'id'
            ],
            'disetujui_oleh' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'status'
            ]
        ];
        $this->forge->addColumn('agenda_umum', $fields);
    }

    public function down()
    {
        $this->forge->dropTable('users');
        $this->forge->dropColumn('agenda_umum', ['user_id', 'disetujui_oleh']);
    }
}