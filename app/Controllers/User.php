<?php

namespace App\Controllers;

use CodeIgniter\Controller;



class User extends BaseController
{
    
    public function index(){
        $data['judul']="Halaman User";
        $data['users'] = $this->userModel->viewUser();
        $setting= $this->loadConfigData();
        $data['setting'] = $setting;
        return view('/admin/user',$data);
    }
    public function tambahData(){
        $foto_user = $this->request->getFile('foto_user');
        if ($foto_user->getSize() > 0) {
            $nama_file = $foto_user->getClientName();
            $foto_user->move(ROOTPATH . 'public/assets/fotoUser',$nama_file);
        }else{
            $nama_file ="user.jpg";
        }
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'foto_user' => $nama_file,
            'password' => $this->request->getPost('password'),
        ];

        $this->userModel->insert($data);
        return redirect()->to('/admin/users');
    }
    public function editData(){
        $id = $this->request->getPost('id');
        $user=$this->userModel->find($id);//mencari data sesuai id
        $foto_user = $this->request->getFile('foto_user');
        if ($foto_user->getSize() > 0) {
            // Jika ada file baru yang diunggah
            
            unlink(ROOTPATH . 'public/assets/fotoUser/' . $user['foto_user']); // Hapus foto lama
            
            $nama_file = $foto_user->getClientName(); // Menggunakan nama file baru
            $foto_user->move(ROOTPATH . 'public/assets/fotoUser',$nama_file);
        } else {
            // Jika tidak ada file baru yang diunggah
            $nama_file = $user['foto_user']; // Gunakan foto lama
        }
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'foto_user' => $nama_file,
            'password' => $this->request->getPost('password'),
        ];
        $this->userModel->update($id,$data);
        return redirect()->to('/admin/users');
    }
    public function hapusData($id=null){
        $user = $this->userModel->find($id);
        if($user){
            if($user['foto_user']!=null){
                if($user['foto_user']!="user.jpg"){
                    unlink(ROOTPATH . 'public/assets/fotoUser/' . $user['foto_user']); // Hapus foto lama
                } 
            }
            $this->userModel->delete($id);
            return redirect()->to('/admin/users')->with('success', 'User has been deleted successfully.');
        }else{
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }
 
    }
}