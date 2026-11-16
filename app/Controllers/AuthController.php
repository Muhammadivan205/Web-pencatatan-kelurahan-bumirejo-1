<?php

namespace App\Controllers;

use App\Models\UserModel;

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

        $nik = $this->request->getPost('nik');
        $password = $this->request->getPost('password');

        $user = $model->where('nik', $nik)->first();

        if ($user) {
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

    private function redirectBasedOnRole($role)
    {
        if ($role === 'admin') {
            return redirect()->to('/agenda'); // Admin diarahkan ke buku agenda utama
        } elseif ($role === 'pejabat') {
            return redirect()->to('/agenda'); // Pejabat diarahkan ke monitoring laporan
        } else {
            return redirect()->to('/agenda'); // Warga diarahkan ke halaman permohonan surat
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil keluar.');
    }
}