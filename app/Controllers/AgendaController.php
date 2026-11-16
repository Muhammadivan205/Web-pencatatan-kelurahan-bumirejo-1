<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgendaModel;

class AgendaController extends BaseController
{
    protected $agendaModel;

    public function __construct()
    {
        $this->agendaModel = new AgendaModel();
    }

    /**
     * READ: Halaman Utama Dashboard & Daftar Agenda Umum
     */
    public function index()
    {
        $search   = $this->request->getGet('search');
        $kategori = $this->request->getGet('kategori');
        $status   = $this->request->getGet('status');
        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir= $this->request->getGet('tgl_akhir');

        $builder = $this->agendaModel;

        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->orLike('alamat', $search)
                ->orLike('keterangan', $search)
                ->orLike('nomor_agenda', $search)
                ->orLike('instansi', $search)
                ->groupEnd();
        }

        if ($kategori) {
            $builder->where('kategori', $kategori);
        }

        if ($status) {
            $builder->where('status', $status);
        }

        if ($tgl_awal && $tgl_akhir) {
            $builder->where("tanggal >=", $tgl_awal)
                    ->where("tanggal <=", $tgl_akhir);
        } elseif ($tgl_awal) {
            $builder->where("tanggal >=", $tgl_awal);
        } elseif ($tgl_akhir) {
            $builder->where("tanggal <=", $tgl_akhir);
        }

        $agendaList = $builder->orderBy('tanggal', 'DESC')
                             ->orderBy('id', 'DESC')
                             ->findAll();

        $stats = $this->agendaModel->getStats();

        // Standard letter categories
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

        // Unique categories from database
        $db = \Config\Database::connect();
        $categoriesQuery = $db->table('agenda_umum')
                             ->select('kategori')
                             ->distinct()
                             ->get()
                             ->getResultArray();
        $dbCategories = array_filter(array_column($categoriesQuery, 'kategori'));
        $categories = array_values(array_unique(array_merge($standardCategories, $dbCategories)));

        $data = [
            'title'          => 'Buku Pencatatan Pelayanan Surat Warga - Kelurahan Bumirejo',
            'agenda'         => $agendaList,
            'stats'          => $stats,
            'categories'     => $categories,
            'filters'        => [
                'search'   => $search,
                'kategori' => $kategori,
                'status'   => $status,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir'=> $tgl_akhir,
            ],
            'auto_no_agenda' => $this->agendaModel->generateNomorAgenda(),
        ];

        return view('agenda/index', $data);
    }

    /**
     * CREATE: Form Halaman Tambah Pencatatan Surat
     */
    public function create()
    {
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
            'title'          => 'Catat Permohonan Surat Baru - Kelurahan Bumirejo',
            'auto_no_agenda' => $this->agendaModel->generateNomorAgenda(),
            'categories'     => $standardCategories,
        ];

        return view('agenda/create', $data);
    }

    /**
     * CREATE: Proses Simpan Data Pencatatan Surat (Store)
     */
    public function store()
    {
        $nomorAgenda = $this->request->getPost('nomor_agenda');
        $tanggal     = $this->request->getPost('tanggal');

        if (empty($nomorAgenda)) {
            $nomorAgenda = $this->agendaModel->generateNomorAgenda($tanggal);
        }

        $nama = $this->request->getPost('nama');
        $kategori = $this->request->getPost('kategori') ?: 'Surat Keterangan Lainnya';

        $data = [
            'nomor_agenda' => $nomorAgenda,
            'tanggal'      => $tanggal ?: date('Y-m-d'),
            'nama'         => $nama,
            'instansi'     => $this->request->getPost('instansi'),
            'alamat'       => $this->request->getPost('alamat'),
            'kategori'     => $kategori,
            'keterangan'   => $this->request->getPost('keterangan'),
            'status'       => $this->request->getPost('status') ?? 'Dalam Proses',
        ];

        if (!$this->agendaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->agendaModel->errors());
        }

        return redirect()->to('/agenda')->with('success', 'Permohonan surat warga a.n. "' . esc($nama) . '" berhasil dicatat!');
    }

    /**
     * UPDATE: Halaman Form Edit Pencatatan Surat
     */
    public function edit($id)
    {
        $agenda = $this->agendaModel->find($id);
        if (!$agenda) {
            return redirect()->to('/agenda')->with('error', 'Data pencatatan surat tidak ditemukan.');
        }

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
            'title'      => 'Edit Pencatatan Surat - ' . $agenda['nomor_agenda'],
            'agenda'     => $agenda,
            'categories' => $standardCategories,
        ];

        return view('agenda/edit', $data);
    }

    /**
     * UPDATE: Proses Perbarui Data Pencatatan Surat (Update)
     */
    public function update($id)
    {
        $existing = $this->agendaModel->find($id);
        if (!$existing) {
            return redirect()->to('/agenda')->with('error', 'Data pencatatan surat tidak ditemukan.');
        }

        $nama = $this->request->getPost('nama');
        $kategori = $this->request->getPost('kategori') ?: ($existing['kategori'] ?? 'Surat Keterangan Lainnya');

        $data = [
            'id'           => $id,
            'nomor_agenda' => $this->request->getPost('nomor_agenda') ?? $existing['nomor_agenda'],
            'tanggal'      => $this->request->getPost('tanggal'),
            'nama'         => $nama,
            'instansi'     => $this->request->getPost('instansi'),
            'alamat'       => $this->request->getPost('alamat'),
            'kategori'     => $kategori,
            'keterangan'   => $this->request->getPost('keterangan'),
            'status'       => $this->request->getPost('status') ?: $existing['status'],
        ];

        if (!$this->agendaModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->agendaModel->errors());
        }

        return redirect()->to('/agenda')->with('success', 'Data pencatatan surat a.n. "' . esc($nama) . '" berhasil diperbarui!');
    }

    /**
     * UPDATE: Quick Status Change (AJAX)
     */
    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        $existing = $this->agendaModel->find($id);
        
        if (!$existing) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan'])->setStatusCode(404);
        }

        $this->agendaModel->update($id, ['status' => $status]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Status pelayanan surat berhasil diperbarui']);
    }

    /**
     * DELETE: Hapus Data Pencatatan Surat
     */
    public function delete($id)
    {
        $existing = $this->agendaModel->find($id);
        if ($existing) {
            $this->agendaModel->delete($id);
            return redirect()->to('/agenda')->with('success', 'Data pencatatan surat berhasil dihapus!');
        }

        return redirect()->to('/agenda')->with('error', 'Data pencatatan surat tidak ditemukan.');
    }

    /**
     * READ: Endpoint JSON Detail Pencatatan Surat
     */
    public function getDetail($id)
    {
        $item = $this->agendaModel->find($id);
        if (!$item) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan'])->setStatusCode(404);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $item]);
    }

    /**
     * READ: Halaman Dedicated Detail Pencatatan Surat
     */
    public function detailView($id)
    {
        $agenda = $this->agendaModel->find($id);
        if (!$agenda) {
            return redirect()->to('/agenda')->with('error', 'Data pencatatan surat tidak ditemukan.');
        }

        $data = [
            'title'  => 'Detail Pencatatan Surat - ' . $agenda['nomor_agenda'],
            'agenda' => $agenda,
        ];

        return view('agenda/detail', $data);
    }

    /**
     * PRINT: Halaman Pratinjau Cetak Buku Register Pelayanan Surat
     */
    public function print()
    {
        $search   = $this->request->getGet('search');
        $kategori = $this->request->getGet('kategori');
        $status   = $this->request->getGet('status');
        $tgl_awal = $this->request->getGet('tgl_awal');
        $tgl_akhir= $this->request->getGet('tgl_akhir');

        $builder = $this->agendaModel;

        if ($search) {
            $builder->groupStart()
                ->like('nama', $search)
                ->orLike('alamat', $search)
                ->orLike('keterangan', $search)
                ->orLike('nomor_agenda', $search)
                ->orLike('instansi', $search)
                ->groupEnd();
        }

        if ($kategori) {
            $builder->where('kategori', $kategori);
        }

        if ($status) {
            $builder->where('status', $status);
        }

        if ($tgl_awal && $tgl_akhir) {
            $builder->where("tanggal >=", $tgl_awal)
                    ->where("tanggal <=", $tgl_akhir);
        }

        $agendaList = $builder->orderBy('tanggal', 'ASC')->findAll();

        $data = [
            'title'     => 'Cetak Buku Register Pelayanan Surat Warga - Kelurahan Bumirejo',
            'agenda'    => $agendaList,
            'filters'   => [
                'tgl_awal' => $tgl_awal,
                'tgl_akhir'=> $tgl_akhir,
                'kategori' => $kategori,
            ],
            'print_date'=> date('d F Y'),
        ];

        return view('agenda/print', $data);
    }
}
