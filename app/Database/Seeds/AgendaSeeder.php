<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AgendaSeeder extends Seeder
{
    public function run()
    {
        // Truncate existing table
        $this->db->table('agenda_umum')->truncate();

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $twoDaysAgo = date('Y-m-d', strtotime('-2 days'));
        $threeDaysAgo = date('Y-m-d', strtotime('-3 days'));

        $month = date('m');
        $year = date('Y');

        $data = [
            [
                'nomor_agenda' => "B / 140 / 001 / {$month} / {$year}",
                'tanggal'      => $today,
                'nama'         => 'Bambang Suherman',
                'instansi'     => '3308091503880001',
                'alamat'       => 'Jl. Melati No. 14, RT 02 / RW 03, Kel. Bumirejo',
                'kategori'     => 'Surat Keterangan Usaha (SKU)',
                'keterangan'   => 'Permohonan Surat Keterangan Usaha (SKU) Toko Kelontong Berkah untuk kelengkapan administrasi pengajuan modal usaha KUR Bank BRI.',
                'status'       => 'Siap Diambil',
                'created_at'   => date('Y-m-d 08:30:00'),
                'updated_at'   => date('Y-m-d 09:15:00'),
            ],
            [
                'nomor_agenda' => "B / 140 / 002 / {$month} / {$year}",
                'tanggal'      => $today,
                'nama'         => 'Siti Aisyah Rahmadani',
                'instansi'     => '3308095407950003',
                'alamat'       => 'Jl. Kenanga No. 8, RT 01 / RW 04, Kel. Bumirejo',
                'kategori'     => 'Surat Pengantar SKCK',
                'keterangan'   => 'Permohonan Surat Pengantar SKCK Polsek Mungkid untuk kelengkapan persyaratan pendaftaran seleksi CPNS.',
                'status'       => 'Dalam Proses',
                'created_at'   => date('Y-m-d 09:00:00'),
                'updated_at'   => date('Y-m-d 09:00:00'),
            ],
            [
                'nomor_agenda' => "B / 140 / 003 / {$month} / {$year}",
                'tanggal'      => $yesterday,
                'nama'         => 'Dedi Hendrawan',
                'instansi'     => '3308091002900002',
                'alamat'       => 'Gang Manggis Blok C No. 5, RT 04 / RW 02, Kel. Bumirejo',
                'kategori'     => 'Surat Keterangan Domisili',
                'keterangan'   => 'Permohonan Surat Keterangan Domisili tempat tinggal sementara untuk persyaratan pendaftaran sekolah anak (PPDB Zonasi).',
                'status'       => 'Selesai',
                'created_at'   => date('Y-m-d 10:15:00', strtotime('-1 day')),
                'updated_at'   => date('Y-m-d 14:20:00', strtotime('-1 day')),
            ],
            [
                'nomor_agenda' => "B / 140 / 004 / {$month} / {$year}",
                'tanggal'      => $yesterday,
                'nama'         => 'Ibu Ratna Dewi',
                'instansi'     => '3308096211840004',
                'alamat'       => 'Jl. Flamboyan No. 25, RT 05 / RW 01, Kel. Bumirejo',
                'kategori'     => 'Surat Keterangan Tidak Mampu (SKTM)',
                'keterangan'   => 'Permohonan SKTM untuk persyaratan permohonan keringanan biaya pengobatan rawat inap di RSUD Kota.',
                'status'       => 'Selesai',
                'created_at'   => date('Y-m-d 11:00:00', strtotime('-1 day')),
                'updated_at'   => date('Y-m-d 13:45:00', strtotime('-1 day')),
            ],
            [
                'nomor_agenda' => "B / 140 / 005 / {$month} / {$year}",
                'tanggal'      => $twoDaysAgo,
                'nama'         => 'Agus Pratama',
                'instansi'     => '3308091809920001',
                'alamat'       => 'Jl. Merpati No. 3, RT 03 / RW 05, Kel. Bumirejo',
                'kategori'     => 'Surat Pengantar Nikah (N1-N4)',
                'keterangan'   => 'Permohonan berkas Formulir Pengantar Nikah (N1, N2, N4) untuk pendaftaran akad nikah ke Kantor Urusan Agama (KUA) Kecamatan.',
                'status'       => 'Selesai',
                'created_at'   => date('Y-m-d 08:45:00', strtotime('-2 days')),
                'updated_at'   => date('Y-m-d 15:30:00', strtotime('-2 days')),
            ],
            [
                'nomor_agenda' => "B / 140 / 006 / {$month} / {$year}",
                'tanggal'      => $threeDaysAgo,
                'nama'         => 'Hj. Mardiah',
                'instansi'     => '3308094506630002',
                'alamat'       => 'Jl. Dahlia No. 19, RT 02 / RW 01, Kel. Bumirejo',
                'kategori'     => 'Surat Keterangan Kematian',
                'keterangan'   => 'Permohonan Surat Keterangan Kematian almarhum H. Syamsuddin untuk pengurusan pensiun Taspen dan ahli waris.',
                'status'       => 'Selesai',
                'created_at'   => date('Y-m-d 09:30:00', strtotime('-3 days')),
                'updated_at'   => date('Y-m-d 11:00:00', strtotime('-3 days')),
            ],
            [
                'nomor_agenda' => "B / 140 / 007 / {$month} / {$year}",
                'tanggal'      => $threeDaysAgo,
                'nama'         => 'Rian Firmansyah',
                'instansi'     => '3308092208970005',
                'alamat'       => 'Jl. Anggrek Indah No. 42, RT 06 / RW 04, Kel. Bumirejo',
                'kategori'     => 'Surat Keterangan Belum Menikah',
                'keterangan'   => 'Permohonan Surat Keterangan Belum Pernah Menikah untuk syarat pengajuan KPR Perumahan Rakyat di Bank BTN.',
                'status'       => 'Selesai',
                'created_at'   => date('Y-m-d 13:00:00', strtotime('-3 days')),
                'updated_at'   => date('Y-m-d 15:00:00', strtotime('-3 days')),
            ],
        ];

        // Insert Batch
        $this->db->table('agenda_umum')->insertBatch($data);
    }
}
