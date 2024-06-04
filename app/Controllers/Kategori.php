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
        if ($search != "") {
            $data['kategori'] = $this->kategoriModel->cariKode($search);
        } else {
            $data['kategori'] = $this->kategoriModel->findAll();
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
        return redirect()->to('/admin/kategori');
    }

    public function editDataKategori()
    {
        $id = $this->request->getPost('id_kategori');
        $data = [
            'nama_kategori' => $this->request->getPost('edit_nama_kategori')
        ];
        $this->kategoriModel->update($id, $data);
        return redirect()->to('/admin/kategori');
    }

    public function hapusDataKategori()
    {
        $id_kategori = $this->request->getPost('id_kategori');
        $this->kategoriModel->delete($id_kategori);
        return redirect()->to('/admin/kategori');
    }
}

