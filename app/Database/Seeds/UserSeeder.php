<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nik'        => '1111111111111111',
                'nama'       => 'Admin Kelurahan',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nik'        => '2222222222222222',
                'nama'       => 'Bapak Lurah',
                'password'   => password_hash('pejabat123', PASSWORD_DEFAULT),
                'role'       => 'pejabat',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nik'        => '3333333333333333',
                'nama'       => 'Warga Biasa',
                'password'   => password_hash('warga123', PASSWORD_DEFAULT),
                'role'       => 'warga',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}