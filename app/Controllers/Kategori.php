<?php

namespace App\Controllers;

use CodeIgniter\Controller;



class Kategori extends BaseController
{
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
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ];
        $this->kategoriModel->insert($data);
        cache()->clean();
        $response = [
            'status' => 'success',              
        ];
        return $this->response->setJSON($response); 
    }

    public function editDataKategori()
    {
        $id = $this->request->getPost('id');
        $data = [
            'nama_kategori' => $this->request->getPost('edit_nama_kategori')
        ];
        $this->kategoriModel->update($id, $data);
        cache()->clean();
        $response = [
            'status' => 'success',              
        ];
        return $this->response->setJSON($response); 
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

