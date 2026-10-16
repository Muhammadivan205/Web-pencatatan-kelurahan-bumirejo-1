<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $table            = 'agenda_umum';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nomor_agenda',
        'tanggal',
        'nama',
        'instansi',
        'alamat',
        'kategori',
        'keterangan',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'tanggal'    => 'required|valid_date',
        'nama'       => 'required|min_length[2]|max_length[255]',
        'instansi'   => 'required|min_length[5]|max_length[255]',
        'alamat'     => 'required',
        'keterangan' => 'required',
    ];

    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama pemohon wajib diisi.',
            'min_length' => 'Nama pemohon minimal 2 karakter.',
        ],
        'instansi' => [
            'required'   => 'Nomor KTP / NIK pemohon wajib diisi.',
            'min_length' => 'Nomor KTP / NIK minimal 5 digit/karakter.',
        ],
        'alamat' => [
            'required'   => 'Alamat pemohon wajib diisi.',
        ],
        'tanggal' => [
            'required'   => 'Tanggal permohonan surat wajib ditentukan.',
            'valid_date' => 'Format tanggal tidak valid.',
        ],
        'keterangan' => [
            'required'   => 'Keterangan permohonan surat yang diminta wajib diisi.',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Generate automatic format for Nomor Surat / Registrasi
     * Format: B / 140 / {No. Urut} / {Bulan} / {Tahun}
     * Contoh: B / 140 / 001 / 10 / 2026 (atau bulan 12: B / 140 / 001 / 12 / 2026)
     */
    public function generateNomorAgenda($tanggal = null)
    {
        $date = $tanggal ? strtotime($tanggal) : time();
        $year = date('Y', $date);
        $month = date('m', $date);

        // Ambil semua nomor_agenda untuk menentukan nomor urut tertinggi
        $builder = $this->db->table($this->table);
        $records = $builder->select('nomor_agenda')->get()->getResultArray();

        $maxNumber = 0;
        foreach ($records as $r) {
            $num = $r['nomor_agenda'] ?? '';
            // Deteksi format B / 140 / (nomor) / ...
            if (preg_match('/B\s*\/\s*140\s*\/\s*(\d+)/i', $num, $matches)) {
                $seq = (int)$matches[1];
                if ($seq > $maxNumber) {
                    $maxNumber = $seq;
                }
            } elseif (preg_match('/\/(\d{3,})$/', $num, $matches)) {
                // Legacy format SRT/YYYY/MM/(nomor)
                $seq = (int)$matches[1];
                if ($seq > $maxNumber) {
                    $maxNumber = $seq;
                }
            }
        }

        if ($maxNumber === 0) {
            $totalCount = count($records);
            $nextSeq = $totalCount + 1;
        } else {
            $nextSeq = $maxNumber + 1;
        }

        $nextNumberFormatted = str_pad($nextSeq, 3, '0', STR_PAD_LEFT);
        return "B / 140 / " . $nextNumberFormatted . " / " . $month . " / " . $year;
    }

    /**
     * Helper to retrieve statistics summary & analytics
     */
    public function getStats()
    {
        $total = $this->countAllResults();
        $today = $this->where('tanggal', date('Y-m-d'))->countAllResults();
        $selesai = $this->where('status', 'Selesai')->countAllResults();
        $siapAmbil = $this->where('status', 'Siap Diambil')->countAllResults();
        $proses = $this->whereIn('status', ['Direncanakan', 'Dalam Proses', 'Sedang Diproses'])->countAllResults();
        $batal = $this->where('status', 'Dibatalkan')->countAllResults();

        $percentSelesai = $total > 0 ? round((($selesai + $siapAmbil) / $total) * 100) : 0;

        return [
            'total'          => $total,
            'today'          => $today,
            'selesai'        => $selesai,
            'siapAmbil'      => $siapAmbil,
            'proses'         => $proses,
            'batal'          => $batal,
            'percentSelesai' => $percentSelesai,
        ];
    }
}
