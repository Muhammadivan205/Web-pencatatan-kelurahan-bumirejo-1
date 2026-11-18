<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVerificationToUsersTable extends Migration
{
    public function up()
    {
        $fields = [
            'status_verifikasi' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default'    => 'Terverifikasi',
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['status_verifikasi', 'no_hp', 'alamat']);
    }
}
