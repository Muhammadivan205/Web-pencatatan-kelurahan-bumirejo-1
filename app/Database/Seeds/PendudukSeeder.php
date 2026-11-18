<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PendudukSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            [
                'nik'                 => '3308090202020002',
                'nama'                => 'Muhammad Nur',
                'rt'                  => '001',
                'rw'                  => '001',
                'dusun'               => 'Bumirejo',
                'jenis_kelamin'       => 'Laki-laki',
                'status_kependudukan' => 'Warga Tetap',
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'nik'                 => '3308092408990001',
                'nama'                => 'Muhammad Ivan Rizki Pratama',
                'rt'                  => '001',
                'rw'                  => '004',
                'dusun'               => 'Bumirejo Asri',
                'jenis_kelamin'       => 'Laki-laki',
                'status_kependudukan' => 'Warga Tetap',
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'nik'                 => '3308095504950002',
                'nama'                => 'Siti Aminah, S.Pd',
                'rt'                  => '002',
                'rw'                  => '003',
                'dusun'               => 'Krajan',
                'jenis_kelamin'       => 'Perempuan',
                'status_kependudukan' => 'Warga Tetap',
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'nik'                 => '3308091207880003',
                'nama'                => 'Bambang Supriyadi',
                'rt'                  => '005',
                'rw'                  => '001',
                'dusun'               => 'Jetis',
                'jenis_kelamin'       => 'Laki-laki',
                'status_kependudukan' => 'Warga Tetap',
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'nik'                 => '3308091501750004',
                'nama'                => 'Budi Santoso',
                'rt'                  => '003',
                'rw'                  => '002',
                'dusun'               => 'Gentan',
                'jenis_kelamin'       => 'Laki-laki',
                'status_kependudukan' => 'Warga Tetap',
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'nik'                 => '3308096203850005',
                'nama'                => 'Sri Wahyuni',
                'rt'                  => '001',
                'rw'                  => '001',
                'dusun'               => 'Krajan',
                'jenis_kelamin'       => 'Perempuan',
                'status_kependudukan' => 'Warga Tetap',
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'nik'                 => '3308090510900006',
                'nama'                => 'Joko Prasetyo',
                'rt'                  => '004',
                'rw'                  => '003',
                'dusun'               => 'Jetis',
                'jenis_kelamin'       => 'Laki-laki',
                'status_kependudukan' => 'Warga Tetap',
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'nik'                 => '3308094808920007',
                'nama'                => 'Rina Kusuma Dewi',
                'rt'                  => '002',
                'rw'                  => '002',
                'dusun'               => 'Bumirejo Asri',
                'jenis_kelamin'       => 'Perempuan',
                'status_kependudukan' => 'Warga Tetap',
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
        ];

        $this->db->table('penduduk_bumirejo')->insertBatch($data);
    }
}
