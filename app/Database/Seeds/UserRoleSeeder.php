<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nik'        => '3308090101010001',
                'nama'       => 'Administrator Kelurahan',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nik'        => '3308090202020002',
                'nama'       => 'Muhammad Nur (Lurah Bumirejo)',
                'password'   => password_hash('pejabat123', PASSWORD_DEFAULT),
                'role'       => 'pejabat',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nik'        => '3308092408990001',
                'nama'       => 'Muhammad Ivan Rizki Pratama',
                'password'   => password_hash('warga123', PASSWORD_DEFAULT),
                'role'       => 'warga',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}