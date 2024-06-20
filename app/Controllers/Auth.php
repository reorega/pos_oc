<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\SettingModel;

class Auth extends Controller
{
    protected $userModel;

    public function __construct()
    {
        // Load model saat konstruktor dijalankan
        $this->userModel = new UserModel();
        $this->settingModel = new SettingModel();
    }

    public function process()
    {
        $session = session();
        // Jika sudah login, redirect ke halaman yang sesuai dengan level
        if ($session->isLoggedIn) {
            return redirect()->to($this->redirectBasedOnLevel($session->level));
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Mengecek email yang diinputkan apa sudah ada di database
        $user = $this->userModel->where('email', $email)->first();

        if ($user) {
            // mengecek password
            if ($password === $user['password']) {
                $setting = $this->settingModel->first();
                $session->set([
                    'isLoggedIn' => true,
                    'username' => $user['username'],
                    'level' => $user['level_users'],
                    'foto_user' => $user['foto_user'],
                    'user_id' => $user['id_user'],
                ]);
                return redirect()->to($this->redirectBasedOnLevel($user['level_users']));
            } else {
                // Password salah, kirim pesan kesalahan
                return redirect()->back()->with('error', 'Email atau password anda salah');
            }
        } else {
            // Email tidak ditemukan, kirim pesan kesalahan
            return redirect()->back()->with('error', 'Email tidak ditemukan. Silakan coba lagi.');
        }
    }
    private function redirectBasedOnLevel($level)
    {
        switch ($level) {
            case 1:
                return '/admin';
            case 2:
                return '/kasir';
            default:
                return '/';
        }
    }
    public function logout()
    {
        $session = session();
        $session->destroy(); // Hapus semua data sesi
        return redirect()->to('/'); // Redirect ke halaman login atau halaman utama
    }
}
