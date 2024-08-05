<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class User extends BaseController
{
    protected $userValidationRules = [
        'username' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Username harus diisi',
            ]
        ],
        'email' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Email harus diisi',
            ]
        ],
        'password' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Password harus diisi',
            ]
        ]
    ];

    public function index()
    {
        $data['judul'] = "Halaman User";
        $data['users'] = $this->userModel->findAll();
        $setting= $this->loadConfigData();
        $data['setting'] = $setting;
        $data['page_title'] = "User";
        return view('/admin/user',$data);
    }

    public function getUserData()
    {
        $id = $this->request->getPost('id');
        $model = new \App\Models\UserModel();
        $user = $model->find($id);
        return $this->response->setJSON(['user' => $user]);
    }

    public function ambilDataUsers()
    {
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

    public function tambahData()
    {
        $validation = \Config\Services::validation();
        if (!$this->validate($this->userValidationRules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $foto_user = $this->request->getFile('foto_user');
        $nama_file = $foto_user->isValid() ? $foto_user->getRandomName() : "user.jpg";

        if ($foto_user->isValid()) {
            $foto_user->move(ROOTPATH . 'public/assets/fotoUser', $nama_file);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'foto_user' => $nama_file,
        ];

        $this->userModel->insert($data);
        cache()->clean();

        return $this->response->setJSON(['success' => true]);
    }

    public function editData()
    {
        $validation = \Config\Services::validation();
        if (!$this->validate($this->userValidationRules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $id = $this->request->getPost('id');
        $user = $this->userModel->find($id);
        $foto_user = $this->request->getFile('foto_user');
        $nama_file = $user['foto_user'];

        if ($foto_user->isValid()) {
            if ($user['foto_user'] != "user.jpg") {
                unlink(ROOTPATH . 'public/assets/fotoUser/' . $user['foto_user']);
            }
            $nama_file = $foto_user->getRandomName();
            $foto_user->move(ROOTPATH . 'public/assets/fotoUser', $nama_file);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'foto_user' => $nama_file,
        ];

        $this->userModel->update($id, $data);
        cache()->clean();

        return $this->response->setJSON(['success' => true]);
    }

    public function hapusData($id = null)
    {
        if ($id) {
            $user = $this->userModel->find($id);
            if ($user) {
                if ($user['foto_user'] != "user.jpg") {
                    unlink(ROOTPATH . 'public/assets/fotoUser/' . $user['foto_user']);
                }

                $this->userModel->delete($id);
                cache()->clean();

                return $this->response->setJSON(['success' => true]);
            }
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Data not found']);
    }

    public function profile()
    {
        $session = session();
        $id = $session->get('user_id');
        $data['profile'] = $this->userModel->find($id);
        $data['setting'] = $this->loadConfigData();
        return view('profile', $data);
    }

    public function updateProfile()
    {
        $id = $this->request->getPost('id');
        $user = $this->userModel->find($id);
        $foto_user = $this->request->getFile('foto_user');
        $nama_file = $user['foto_user'];

        if ($foto_user->isValid()) {
            if ($user['foto_user'] != "user.jpg") {
                unlink(ROOTPATH . 'public/assets/fotoUser/' . $user['foto_user']);
            }
            $nama_file = $foto_user->getRandomName();
            $foto_user->move(ROOTPATH . 'public/assets/fotoUser', $nama_file);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'foto_user' => $nama_file,
        ];

        $this->userModel->update($id, $data);
        return redirect()->to(base_url('/profile'))->with('success', 'Data berhasil diperbarui');
    }
}