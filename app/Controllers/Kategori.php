<?php

namespace App\Controllers;

use CodeIgniter\Controller;



class Kategori extends BaseController
{
    protected $kategoriValidationRules = [
        'nama_kategori' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kategori harus diisi',
            ]
        ],
    ];
    public function index()
    {
        $data['page_title'] = "Kategori";
        $setting= $this->loadConfigData();
        $data['setting'] = $setting;
        $data['kategori'] = $this->kategoriModel->findAll();
        return view('admin/kategori', $data);
    }

    public function ambilDataKategori()
    {
        $search = $this->request->getPost('search');
        $page = $this->request->getPost('page') ?? 1;
        $jumlahpagination = 3;
        $no = $page * $jumlahpagination - ($jumlahpagination - 1);
        $cacheKey = "kategori_data_{$search}_{$page}";
        if ($cachedData = cache($cacheKey)) {
            $data = $cachedData;
        } else {
            if ($search != "") {
                $data['kategori'] = $this->kategoriModel->cariKode($search);
                $data['search'] = "yes";
            } else {
                $data['kategori'] = $this->kategoriModel->paginate($jumlahpagination, 'default', $page);
                $data['pager'] = $this->kategoriModel->pager;
                $data['no'] = $no;
                $data['search'] = "no";
            }
            cache()->save($cacheKey, $data, 3600);
        }
        $table = view('admin/tablekategori', $data);
        return $this->response->setJSON(['table' => $table]);
    }
    
    public function tambahDataKategori()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate($this->kategoriValidationRules);
        if(!$valid){
            $errors = [];
            // Mengambil pesan kesalahan dari validator satu per satu
            foreach ($validation->getErrors() as $field => $message) {
                $errors[$field] = $message;
            }
            return $this->response->setJSON(['success' => false, 'errors' => $errors,]);
        }
        else{
            $data = [
                'nama_kategori' => $this->request->getPost('nama_kategori')
            ];
            $this->kategoriModel->insert($data);
            cache()->clean();
            return $this->response->setJSON(['success' => true]);
        }
    }
    public function editDataKategori()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate($this->kategoriValidationRules);
        if(!$valid){
            $errors = [];
            // Mengambil pesan kesalahan dari validator satu per satu
            foreach ($validation->getErrors() as $field => $message) {
                $errors[$field] = $message;
            }
            return $this->response->setJSON(['success' => false, 'errors' => $errors,]);
        }else{
            $id = $this->request->getPost('id');
            $data = [
                'nama_kategori' => $this->request->getPost('nama_kategori')
            ];
            $this->kategoriModel->update($id, $data);
            cache()->clean();
            return $this->response->setJSON(['success' => true]);
        }
    }

    public function hapusDataKategori()
    {
        $id_kategori = $this->request->getPost('id');
        $this->kategoriModel->delete($id_kategori);
        cache()->clean();
        $response = [
            'status' => 'success',              
        ];
        return $this->response->setJSON($response); 
    }
}

