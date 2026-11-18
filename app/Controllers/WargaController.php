<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AgendaModel;
use App\Models\PendudukModel;

class WargaController extends BaseController
{
    protected $userModel;
    protected $agendaModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->agendaModel = new AgendaModel();
        $this->pendudukModel = new PendudukModel();
    }

    /**
     * Halaman Utama: Daftar Warga & Status Verifikasi Kependudukan
     */
    public function index()
    {
        // Proteksi: Hanya role admin yang dapat mengakses
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/agenda')->with('error', 'Akses ditolak. Fitur Verifikasi Warga hanya untuk Admin.');
        }

        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $builder = $this->userModel->where('role', 'warga');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nik', $search)
                    ->orLike('nama', $search)
                    ->orLike('no_hp', $search)
                    ->orLike('alamat', $search)
                    ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('status_verifikasi', $status);
        }

        $wargaList = $builder->orderBy('created_at', 'DESC')
                             ->orderBy('id', 'DESC')
                             ->findAll();

        // Cross-check setiap akun dengan Buku Induk Penduduk Bumirejo
        $bukanWargaCount = 0;
        foreach ($wargaList as &$w) {
            $w['total_surat'] = $this->agendaModel->where('user_id', $w['id'])->countAllResults();
            $cek = $this->pendudukModel->validasiWargaBumirejo($w['nik']);
            $w['validasi_kependudukan'] = $cek;
            if (!$cek['valid']) {
                $bukanWargaCount++;
            }
        }

        // Hitung statistik verifikasi
        $totalWarga = $this->userModel->where('role', 'warga')->countAllResults();
        $menunggu = $this->userModel->where('role', 'warga')->where('status_verifikasi', 'Menunggu Verifikasi')->countAllResults();
        $terverifikasi = $this->userModel->where('role', 'warga')->where('status_verifikasi', 'Terverifikasi')->countAllResults();
        $ditolak = $this->userModel->where('role', 'warga')->where('status_verifikasi', 'Ditolak')->countAllResults();

        // Ambil data master penduduk Bumirejo untuk referensi admin
        $masterPenduduk = $this->pendudukModel->orderBy('nama', 'ASC')->findAll();

        $data = [
            'title'          => 'Verifikasi & Validasi Warga Bumirejo - Kelurahan Bumirejo',
            'warga'          => $wargaList,
            'masterPenduduk' => $masterPenduduk,
            'filters'        => [
                'search' => $search,
                'status' => $status,
            ],
            'stats'          => [
                'total'         => $totalWarga,
                'menunggu'      => $menunggu,
                'terverifikasi' => $terverifikasi,
                'ditolak'       => $ditolak,
                'bukan_warga'   => $bukanWargaCount,
            ],
        ];

        return view('warga/index', $data);
    }

    /**
     * API Cek NIK Real-time (AJAX)
     */
    public function cekNik($nik = '')
    {
        $nik = $nik ?: $this->request->getGet('nik');
        if (empty($nik)) {
            return $this->response->setJSON([
                'valid'  => false,
                'status' => 'KOSONG',
                'alasan' => 'NIK tidak boleh kosong.',
                'data'   => null,
            ]);
        }

        $hasil = $this->pendudukModel->validasiWargaBumirejo($nik);
        return $this->response->setJSON($hasil);
    }

    /**
     * Tambah Akun Warga Baru oleh Admin (Dengan Validasi Otomatis)
     */
    public function store()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/agenda')->with('error', 'Akses ditolak.');
        }

        $nik = trim($this->request->getPost('nik'));

        // VALIDASI OTOMATIS: Cek apakah NIK merupakan warga asli Bumirejo
        $cekWarga = $this->pendudukModel->validasiWargaBumirejo($nik);
        if (!$cekWarga['valid']) {
            return redirect()->back()->withInput()->with('error', $cekWarga['alasan']);
        }

        $rules = [
            'nik' => [
                'rules'  => 'required|exact_length[16]|numeric|is_unique[users.nik]',
                'errors' => [
                    'required'     => 'NIK wajib diisi.',
                    'exact_length' => 'NIK harus tepat 16 digit angka.',
                    'numeric'      => 'NIK hanya boleh berupa angka.',
                    'is_unique'    => 'NIK tersebut sudah terdaftar dalam sistem pengguna.',
                ],
            ],
            'nama' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Alamat otomatis dari buku induk jika form alamat dikosongkan
        $alamat = $this->request->getPost('alamat');
        if (empty($alamat) && $cekWarga['data']) {
            $p = $cekWarga['data'];
            $alamat = 'RT ' . $p['rt'] . ' / RW ' . $p['rw'] . ', Dusun ' . $p['dusun'] . ', Kelurahan Bumirejo';
        }

        $data = [
            'nik'               => $nik,
            'nama'              => $this->request->getPost('nama'),
            'password'          => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'              => 'warga',
            'status_verifikasi' => 'Terverifikasi', // Otomatis terverifikasi karena terbukti warga sah
            'no_hp'             => $this->request->getPost('no_hp'),
            'alamat'            => $alamat,
        ];

        $this->userModel->insert($data);

        return redirect()->to('/warga')->with('success', 'Warga sah Bumirejo a.n. "' . esc($data['nama']) . '" berhasil diverifikasi dan ditambahkan.');
    }

    /**
     * Update Status Verifikasi (Setujui / Tolak / Tunda)
     */
    public function updateStatus($id)
    {
        if (session()->get('role') !== 'admin') {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Akses ditolak.']);
            }
            return redirect()->to('/agenda')->with('error', 'Akses ditolak.');
        }

        $warga = $this->userModel->find($id);
        if (!$warga) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data warga tidak ditemukan.']);
            }
            return redirect()->to('/warga')->with('error', 'Data warga tidak ditemukan.');
        }

        $statusBaru = $this->request->getPost('status_verifikasi');
        $validStatus = ['Terverifikasi', 'Menunggu Verifikasi', 'Ditolak'];

        if (!in_array($statusBaru, $validStatus)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Status tidak valid.']);
            }
            return redirect()->to('/warga')->with('error', 'Status tidak valid.');
        }

        // Jika mau disetujui, pastikan dicek keabsahannya
        if ($statusBaru === 'Terverifikasi') {
            $cek = $this->pendudukModel->validasiWargaBumirejo($warga['nik']);
            if (!$cek['valid']) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => 'Tidak dapat menyetujui akun ini! ' . $cek['alasan'],
                    ]);
                }
                return redirect()->to('/warga')->with('error', 'Gagal setujui: ' . $cek['alasan']);
            }
        }

        $this->userModel->update($id, [
            'status_verifikasi' => $statusBaru,
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Status verifikasi warga ' . $warga['nama'] . ' berhasil diubah menjadi ' . $statusBaru . '.',
            ]);
        }

        return redirect()->to('/warga')->with('success', 'Status verifikasi warga berhasil diperbarui.');
    }

    /**
     * Update Data Warga
     */
    public function update($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/agenda')->with('error', 'Akses ditolak.');
        }

        $warga = $this->userModel->find($id);
        if (!$warga) {
            return redirect()->to('/warga')->with('error', 'Data warga tidak ditemukan.');
        }

        $nikBaru = trim($this->request->getPost('nik'));

        // Cek validasi warga jika NIK diubah
        if ($nikBaru !== $warga['nik']) {
            $cekWarga = $this->pendudukModel->validasiWargaBumirejo($nikBaru);
            if (!$cekWarga['valid']) {
                return redirect()->back()->withInput()->with('error', $cekWarga['alasan']);
            }
        }

        $rules = [
            'nama' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.',
                ],
            ],
        ];

        if ($nikBaru !== $warga['nik']) {
            $rules['nik'] = [
                'rules'  => 'required|exact_length[16]|numeric|is_unique[users.nik]',
                'errors' => [
                    'required'     => 'NIK wajib diisi.',
                    'exact_length' => 'NIK harus tepat 16 digit.',
                    'numeric'      => 'NIK hanya boleh berupa angka.',
                    'is_unique'    => 'NIK tersebut sudah digunakan akun lain.',
                ],
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'nik'               => $nikBaru,
            'nama'              => $this->request->getPost('nama'),
            'status_verifikasi' => $this->request->getPost('status_verifikasi') ?: $warga['status_verifikasi'],
            'no_hp'             => $this->request->getPost('no_hp'),
            'alamat'            => $this->request->getPost('alamat'),
        ];

        $passwordBaru = $this->request->getPost('password');
        if (!empty($passwordBaru)) {
            $updateData['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/warga')->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Reset Password Warga ke Default
     */
    public function resetPassword($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/agenda')->with('error', 'Akses ditolak.');
        }

        $warga = $this->userModel->find($id);
        if (!$warga) {
            return redirect()->to('/warga')->with('error', 'Data warga tidak ditemukan.');
        }

        $defaultPassword = 'warga' . substr($warga['nik'], -4);
        if (strlen($defaultPassword) < 6) {
            $defaultPassword = 'warga123';
        }

        $this->userModel->update($id, [
            'password' => password_hash($defaultPassword, PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/warga')->with('success', 'Password warga ' . $warga['nama'] . ' berhasil direset menjadi: ' . $defaultPassword);
    }

    /**
     * Hapus Akun Warga
     */
    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/agenda')->with('error', 'Akses ditolak.');
        }

        $warga = $this->userModel->find($id);
        if (!$warga) {
            return redirect()->to('/warga')->with('error', 'Data warga tidak ditemukan.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/warga')->with('success', 'Akun warga ' . $warga['nama'] . ' berhasil dihapus.');
    }
}
