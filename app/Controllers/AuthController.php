<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PendudukModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Jika sudah login, langsung arahkan ke dashboard/halaman utama sesuai role
        if (session()->get('logged_in')) {
            return $this->redirectBasedOnRole(session()->get('role'));
        }
        return view('auth/login');
    }

    public function processLogin()
    {
        $session = session();
        $model = new UserModel();

        $nik = trim($this->request->getPost('nik'));
        $password = $this->request->getPost('password');

        $user = $model->where('nik', $nik)->first();

        if ($user) {
            if ($user['role'] === 'warga' && ($user['status_verifikasi'] ?? 'Terverifikasi') === 'Menunggu Verifikasi') {
                $session->setFlashdata('error', 'Akun Anda sedang dalam proses verifikasi oleh Admin Kelurahan.');
                return redirect()->to('/login');
            }

            if ($user['role'] === 'warga' && ($user['status_verifikasi'] ?? 'Terverifikasi') === 'Ditolak') {
                $session->setFlashdata('error', 'Akun Anda telah ditolak/dinonaktifkan oleh Admin Kelurahan.');
                return redirect()->to('/login');
            }

            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id'        => $user['id'],
                    'nik'       => $user['nik'],
                    'nama'      => $user['nama'],
                    'role'      => $user['role'],
                    'logged_in' => true
                ];
                $session->set($sessionData);
                return $this->redirectBasedOnRole($user['role']);
            } else {
                $session->setFlashdata('error', 'Password salah!');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'NIK tidak ditemukan!');
            return redirect()->to('/login');
        }
    }

    /**
     * Halaman Registrasi Akun Baru (Semua Role: Warga, Admin, Pejabat)
     */
    public function register()
    {
        if (session()->get('logged_in')) {
            return $this->redirectBasedOnRole(session()->get('role'));
        }
        return view('auth/register');
    }

    /**
     * Proses Pendaftaran Akun Baru (Role: Warga, Admin, Pejabat)
     */
    public function processRegister()
    {
        $nik = trim($this->request->getPost('nik'));
        $role = $this->request->getPost('role') ?: 'warga';

        // Validasi Role
        $validRoles = ['warga', 'admin', 'pejabat'];
        if (!in_array($role, $validRoles)) {
            $role = 'warga';
        }

        // 1. VALIDASI KHUSUS JIKA DAFTAR SEBAGAI WARGA
        $namaWarga = '';
        $alamatResmi = '';
        if ($role === 'warga') {
            $pendudukModel = new PendudukModel();
            $cek = $pendudukModel->validasiWargaBumirejo($nik);

            if (!$cek['valid']) {
                return redirect()->back()->withInput()->with('error', $cek['alasan'] . ' Pendaftaran akun warga ditolak karena sistem ini khusus untuk warga yang berdomisili sah di Kelurahan Bumirejo.');
            }

            $dataPenduduk = $cek['data'];
            $namaWarga = $dataPenduduk['nama'];
            $alamatResmi = 'RT ' . $dataPenduduk['rt'] . ' / RW ' . $dataPenduduk['rw'] . ', Dusun ' . $dataPenduduk['dusun'] . ', Kel. Bumirejo';
        } else {
            // Untuk Admin & Pejabat
            $namaWarga = trim($this->request->getPost('nama'));
            $alamatResmi = trim($this->request->getPost('alamat')) ?: 'Kantor Kelurahan Bumirejo';

            if (empty($namaWarga) || strlen($namaWarga) < 3) {
                return redirect()->back()->withInput()->with('error', 'Nama lengkap beserta gelar dinas wajib diisi (minimal 3 karakter).');
            }
        }

        // 2. VALIDASI FORM & ATURAN INPUT
        $rules = [
            'nik' => [
                'rules'  => 'required|exact_length[16]|numeric|is_unique[users.nik]',
                'errors' => [
                    'required'     => 'NIK (16 digit) wajib diisi.',
                    'exact_length' => 'NIK harus tepat 16 digit angka.',
                    'numeric'      => 'NIK hanya boleh berupa angka.',
                    'is_unique'    => 'NIK tersebut sudah terdaftar dalam sistem. Silakan langsung login.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.',
                ],
            ],
            'password_confirm' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches'  => 'Konfirmasi password tidak cocok dengan password.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->insert([
            'nik'               => $nik,
            'nama'              => $namaWarga,
            'password'          => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'              => $role,
            'status_verifikasi' => 'Terverifikasi',
            'no_hp'             => $this->request->getPost('no_hp'),
            'alamat'            => $alamatResmi,
        ]);

        $roleLabel = [
            'warga'   => 'Warga Kelurahan Bumirejo',
            'admin'   => 'Administrator Kelurahan',
            'pejabat' => 'Pejabat / Pimpinan Kelurahan',
        ];

        return redirect()->to('/login')->with('success', 'Pendaftaran Akun ' . ($roleLabel[$role] ?? 'Pengguna') . ' a.n. "' . esc($namaWarga) . '" berhasil! Silakan masuk ke sistem.');
    }

    private function redirectBasedOnRole($role)
    {
        if ($role === 'admin') {
            return redirect()->to('/agenda'); // Admin diarahkan ke buku agenda utama
        } elseif ($role === 'pejabat') {
            return redirect()->to('/monitoring'); // Pejabat diarahkan ke monitoring laporan
        } else {
            return redirect()->to('/riwayat'); // Warga diarahkan ke riwayat permohonan surat
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil keluar.');
    }
}
