<?php

namespace App\Controllers;

use App\Models\AgendaModel;
use App\Models\PendudukModel;

class MonitoringController extends BaseController
{
    protected $agendaModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->agendaModel = new AgendaModel();
        $this->pendudukModel = new PendudukModel();
    }

    /**
     * Dashboard Monitoring & Laporan Eksekutif untuk Pejabat / Lurah
     */
    public function index()
    {
        // Proteksi role: Hanya role pejabat dan admin yang dapat mengakses
        if (!in_array(session()->get('role'), ['pejabat', 'admin'])) {
            return redirect()->to('/agenda')->with('error', 'Akses ditolak. Halaman Monitoring & Laporan khusus Pejabat dan Admin.');
        }

        $periode = $this->request->getGet('periode') ?: 'bulan_ini';
        $kategori = $this->request->getGet('kategori');
        $status = $this->request->getGet('status');
        $persetujuan = $this->request->getGet('persetujuan');
        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');

        // Tentukan rentang tanggal otomatis berdasarkan filter periode
        $now = date('Y-m-d');
        if ($periode === 'bulan_ini' && empty($tgl_awal)) {
            $tgl_awal = date('Y-m-01');
            $tgl_akhir = date('Y-m-t');
        } elseif ($periode === 'triwulan' && empty($tgl_awal)) {
            $tgl_awal = date('Y-m-d', strtotime('-3 months'));
            $tgl_akhir = $now;
        } elseif ($periode === 'tahun_ini' && empty($tgl_awal)) {
            $tgl_awal = date('Y-01-01');
            $tgl_akhir = date('Y-12-31');
        }

        $builder = $this->agendaModel->builder();

        if (!empty($tgl_awal) && !empty($tgl_akhir)) {
            $builder->where('tanggal >=', $tgl_awal)
                    ->where('tanggal <=', $tgl_akhir);
        } elseif (!empty($tgl_awal)) {
            $builder->where('tanggal >=', $tgl_awal);
        } elseif (!empty($tgl_akhir)) {
            $builder->where('tanggal <=', $tgl_akhir);
        }

        if (!empty($kategori)) {
            $builder->where('kategori', $kategori);
        }

        if (!empty($status)) {
            $builder->where('status', $status);
        }

        if ($persetujuan === 'sudah') {
            $builder->where('disetujui_oleh IS NOT NULL');
            $builder->where('disetujui_oleh !=', '');
        } elseif ($persetujuan === 'belum') {
            $builder->groupStart()
                    ->where('disetujui_oleh IS NULL')
                    ->orWhere('disetujui_oleh', '')
                    ->groupEnd();
        }

        $daftarSurat = $builder->orderBy('tanggal', 'DESC')
                               ->orderBy('id', 'DESC')
                               ->get()
                               ->getResultArray();

        // Hitung Analitik & Statistik Periode
        $total = count($daftarSurat);
        $selesai = 0;
        $siapAmbil = 0;
        $proses = 0;
        $sudahDisetujui = 0;
        $belumDisetujui = 0;

        // Distribusi Kategori Surat
        $kategoriCount = [];

        foreach ($daftarSurat as $s) {
            $st = $s['status'] ?? '';
            if ($st === 'Selesai') {
                $selesai++;
            } elseif ($st === 'Siap Diambil') {
                $siapAmbil++;
            } else {
                $proses++;
            }

            if (!empty($s['disetujui_oleh'])) {
                $sudahDisetujui++;
            } else {
                $belumDisetujui++;
            }

            $kat = $s['kategori'] ?: 'Lainnya';
            if (!isset($kategoriCount[$kat])) {
                $kategoriCount[$kat] = 0;
            }
            $kategoriCount[$kat]++;
        }

        // Urutkan kategori terpopuler
        arsort($kategoriCount);

        $persenEfektivitas = $total > 0 ? round((($selesai + $siapAmbil) / $total) * 100) : 100;
        $persenDisetujui = $total > 0 ? round(($sudahDisetujui / $total) * 100) : 0;

        // Kategori standar untuk dropdown filter
        $standardCategories = [
            'Surat Keterangan Usaha (SKU)',
            'Surat Keterangan Domisili',
            'Surat Keterangan Tidak Mampu (SKTM)',
            'Surat Pengantar SKCK',
            'Surat Pengantar Nikah (N1-N4)',
            'Surat Keterangan Kelahiran',
            'Surat Keterangan Kematian',
            'Surat Keterangan Belum Menikah',
            'Surat Keterangan Pindah',
            'Surat Keterangan Penghasilan',
            'Surat Keterangan Ahli Waris',
            'Surat Keterangan Lainnya',
        ];

        $data = [
            'title'             => 'Monitoring & Laporan Pelayanan Surat - Kelurahan Bumirejo',
            'daftarSurat'       => $daftarSurat,
            'categories'        => $standardCategories,
            'filters'           => [
                'periode'     => $periode,
                'tgl_awal'    => $tgl_awal,
                'tgl_akhir'   => $tgl_akhir,
                'kategori'    => $kategori,
                'status'      => $status,
                'persetujuan' => $persetujuan,
            ],
            'stats'             => [
                'total'             => $total,
                'selesai'           => $selesai,
                'siapAmbil'         => $siapAmbil,
                'proses'            => $proses,
                'sudahDisetujui'    => $sudahDisetujui,
                'belumDisetujui'    => $belumDisetujui,
                'persenEfektivitas' => $persenEfektivitas,
                'persenDisetujui'   => $persenDisetujui,
            ],
            'kategoriCount'     => $kategoriCount,
        ];

        return view('monitoring/index', $data);
    }

    /**
     * Sahkan / Setujui Surat oleh Pejabat (Lurah Bumirejo)
     */
    public function sahkan($id)
    {
        if (!in_array(session()->get('role'), ['pejabat', 'admin'])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Akses ditolak.']);
            }
            return redirect()->to('/monitoring')->with('error', 'Akses ditolak.');
        }

        $agenda = $this->agendaModel->find($id);
        if (!$agenda) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data surat tidak ditemukan.']);
            }
            return redirect()->to('/monitoring')->with('error', 'Data surat tidak ditemukan.');
        }

        $namaPejabat = session()->get('nama') ?: 'Muhammad Nur (Lurah Bumirejo)';

        $this->agendaModel->update($id, [
            'disetujui_oleh' => $namaPejabat,
            'status'         => ($agenda['status'] === 'Dalam Proses' || $agenda['status'] === 'Direncanakan') ? 'Siap Diambil' : $agenda['status'],
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Surat ' . $agenda['nomor_agenda'] . ' telah resmi disahkan dan disetujui oleh ' . $namaPejabat . '.',
            ]);
        }

        return redirect()->to('/monitoring')->with('success', 'Surat No. ' . $agenda['nomor_agenda'] . ' berhasil disahkan.');
    }

    /**
     * Batalkan Pengesahan Surat
     */
    public function batalSahkan($id)
    {
        if (!in_array(session()->get('role'), ['pejabat', 'admin'])) {
            return redirect()->to('/monitoring')->with('error', 'Akses ditolak.');
        }

        $this->agendaModel->update($id, [
            'disetujui_oleh' => null,
        ]);

        return redirect()->to('/monitoring')->with('success', 'Pengesahan surat telah dibatalkan.');
    }

    /**
     * Cetak Laporan Rekapitulasi Eksekutif (Print View)
     */
    public function cetak()
    {
        if (!in_array(session()->get('role'), ['pejabat', 'admin'])) {
            return redirect()->to('/agenda')->with('error', 'Akses ditolak.');
        }

        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir = $this->request->getGet('tgl_akhir');
        $kategori = $this->request->getGet('kategori');
        $status = $this->request->getGet('status');

        $builder = $this->agendaModel->builder();

        if (!empty($tgl_awal) && !empty($tgl_akhir)) {
            $builder->where('tanggal >=', $tgl_awal)
                    ->where('tanggal <=', $tgl_akhir);
        }

        if (!empty($kategori)) {
            $builder->where('kategori', $kategori);
        }

        if (!empty($status)) {
            $builder->where('status', $status);
        }

        $agenda = $builder->orderBy('tanggal', 'ASC')->get()->getResultArray();

        $data = [
            'title'     => 'Laporan Eksekutif Pelayanan Surat - Kelurahan Bumirejo',
            'agenda'    => $agenda,
            'tgl_awal'  => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'kategori'  => $kategori,
            'pejabat'   => session()->get('nama') ?: 'Muhammad Nur',
        ];

        return view('monitoring/cetak', $data);
    }
}
