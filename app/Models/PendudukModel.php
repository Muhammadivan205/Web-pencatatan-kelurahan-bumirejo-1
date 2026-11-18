<?php

namespace App\Models;

use CodeIgniter\Model;

class PendudukModel extends Model
{
    protected $table            = 'penduduk_bumirejo';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nik', 'nama', 'rt', 'rw', 'dusun', 'jenis_kelamin', 'status_kependudukan'];
    protected $useTimestamps    = true;

    /**
     * Kode Wilayah Kemendagri untuk Kelurahan Bumirejo, Kec. Mungkid, Kab. Magelang:
     * 33 = Jawa Tengah
     * 08 = Kabupaten Magelang
     * 09 = Kecamatan Mungkid
     */
    public const KODE_WILAYAH_BUMIREJO = '330809';

    /**
     * Memverifikasi apakah suatu NIK merupakan warga asli/resmi Kelurahan Bumirejo
     * 
     * @param string $nik
     * @return array ['valid' => bool, 'alasan' => string, 'data' => ?array]
     */
    public function validasiWargaBumirejo(string $nik): array
    {
        $nikBersih = trim(preg_replace('/[^0-9]/', '', $nik));

        // 1. Validasi Panjang NIK
        if (strlen($nikBersih) !== 16) {
            return [
                'valid'  => false,
                'status' => 'DITOLAK_FORMAT',
                'alasan' => 'Format NIK tidak valid. NIK harus terdiri dari tepat 16 digit angka.',
                'data'   => null,
            ];
        }

        // 2. Validasi Kode Wilayah (330809)
        if (!str_starts_with($nikBersih, self::KODE_WILAYAH_BUMIREJO)) {
            return [
                'valid'  => false,
                'status' => 'DITOLAK_LUAR_WILAYAH',
                'alasan' => 'Ditolak Otomatis: NIK terdeteksi di luar wilayah Kecamatan Mungkid / Kabupaten Magelang (Kode wilayah NIK bukan 330809).',
                'data'   => null,
            ];
        }

        // 3. Validasi ke Database Induk Kependudukan Bumirejo
        $penduduk = $this->where('nik', $nikBersih)->first();

        if (!$penduduk) {
            return [
                'valid'  => false,
                'status' => 'DITOLAK_TIDAK_TERDAFTAR',
                'alasan' => 'Ditolak Otomatis: NIK ' . $nikBersih . ' tidak terdaftar dalam Buku Induk Kependudukan Kelurahan Bumirejo. Demi mencegah penyalahgunaan surat, pelayanan hanya untuk warga sah Bumirejo.',
                'data'   => null,
            ];
        }

        return [
            'valid'  => true,
            'status' => 'WARGA_SAH',
            'alasan' => 'Warga sah terverifikasi di Buku Induk Penduduk Kelurahan Bumirejo (RT ' . $penduduk['rt'] . ' / RW ' . $penduduk['rw'] . ', Dusun ' . $penduduk['dusun'] . ').',
            'data'   => $penduduk,
        ];
    }
}
