<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class User extends Controller
{
    protected $userModel;

    public function __construct()
    {
        // Load model saat konstruktor dijalankan
        $this->userModel = new UserModel();
    }
    public function index(){
        $data['judul']="Halaman User";
        $data['users'] = $this->userModel->viewUser();
        return view('/admin/user',$data);
    }

}