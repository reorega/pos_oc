<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class User extends BaseController
{
    public function index(){
        $data['judul']="Halaman User";
        $data['users'] = $this->userModel->findAll();
        $setting= $this->loadConfigData();
        $data['setting'] = $setting;
        $data['page_title'] = "User";
        return view('/admin/user',$data);
    }

    public function ambilDataUsers(){
        $search = $this->request->getPost('search');
        $page = $this->request->getPost('page') ?? 1;
        $jumlahpagination = 5;
        $no = $page * $jumlahpagination - ($jumlahpagination - 1);
        $cacheKey = "users_data_{$search}_{$page}";
        if ($cachedData = cache($cacheKey)) {
            $data = $cachedData;
        } else {
            if ($search != "") {
                $data['users'] = $this->userModel->cariKode($search);
                $data['search'] = "yes";
            } else {
                $data['users'] = $this->userModel->paginate($jumlahpagination, 'default', $page);
                $data['pager'] = $this->userModel->pager;
                $data['no'] = $no;
                $data['search'] = "no";
            }
            cache()->save($cacheKey, $data, 3600);
        }
        $table = view('admin/tableuser', $data);
        return $this->response->setJSON(['table' => $table]);
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
        cache()->clean();
        $response = [
            'status' => 'success',              
        ];
        return $this->response->setJSON($response); 
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
        cache()->clean();
        $response = [
            'status' => 'success',              
        ];
        return $this->response->setJSON($response); 
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
            cache()->clean();
            $response = [
                'status' => 'success',              
            ];
            return $this->response->setJSON($response);
        }
    }

    public function profile(){
        $session= session();
        $id= $session->user_id;
        $data['profile'] = $this->userModel->find($id);
        $setting= $this->loadConfigData();
        $data['setting'] = $setting;
        return view('/profile',$data);
    }
    
    public function updateProfile(){
        $id=$this->request->getPost('id');
        $username=$this->request->getPost('username');
        $email=$this->request->getPost('email');
        $password=$this->request->getPost('password');
        $foto_user=$this->request->getFile('foto_user');
        $user=$this->userModel->find($id);
        
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
        return redirect()->to(base_url('/profile'))->with('success', 'Data berhasil diperbarui');
    }
}