<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\KategoriModel;

class Kategori extends Controller
{
    public function index()
    {
        $data['page_title'] = "Kategori";
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        return view('admin/kategori', $data);
    }

    public function tambahDataKategori()
    {
        $kategoriModel = new KategoriModel();
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ];
        $kategoriModel->insert($data);
        return redirect()->to('/admin/kategori');
    }

    public function editDataKategori()
    {
        $kategoriModel = new KategoriModel();
        $id = $this->request->getPost('id_kategori');
        $data = [
            'nama_kategori' => $this->request->getPost('edit_nama_kategori')
        ];
        $kategoriModel->update($id, $data);
        return redirect()->to('/admin/kategori');
    }

    public function hapusDataKategori()
    {
        $kategoriModel = new KategoriModel();
        $id_kategori = $this->request->getPost('id_kategori');
        $kategoriModel->delete($id_kategori);
        return redirect()->to('/admin/kategori');
    }
}
