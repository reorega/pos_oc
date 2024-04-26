<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\KategoriModel;

class Kategori extends Controller
{
    protected $kategoriModel;

    public function __construct()
    {
        // Load model saat konstruktor dijalankan
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data['judul'] = "Halaman Kategori";
        $data['kategori'] = $this->kategoriModel->findAll();
        return view('/admin/kategori', $data);
    }

    public function tambahDataKategori()
    {
    // Validasi input jika diperlukan
    $validation = \Config\Services::validation();
    $validation->setRules([
        'nama_kategori' => 'required',
        // Tambahkan aturan validasi lainnya jika diperlukan
    ]);

    if ($this->request->getMethod() == 'post') {
        // Jika data telah dikirim melalui form
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            // Jika validasi berhasil, simpan data ke dalam database
            $data = [
                'nama_kategori' => $this->request->getPost('nama_kategori'),
                // Tambahkan data lainnya jika diperlukan
            ];

            $inserted = $this->kategoriModel->tambahKategori($data);

            if ($inserted) {
                return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan.');
            } else {
                return redirect()->to('/admin/kategori')->with('error', 'Gagal menambahkan kategori.');
            }
        }
    }

    return redirect()->to('/admin/kategori');
    }


    public function editDataKategori()
{
    // Ambil ID kategori dari formulir yang dikirim
    $id_kategori = $this->request->getPost('id_kategori');

    // Validasi apakah ID kategori valid
    if ($id_kategori === null || !$kategori = $this->kategoriModel->find($id_kategori)) {
        return redirect()->to('/admin/kategori')->with('error', 'Kategori tidak ditemukan.');
    }

    // Validasi input jika diperlukan
    $validation = \Config\Services::validation();
    $validation->setRules([
        'edit_nama_kategori' => 'required',
        // Tambahkan aturan validasi lainnya jika diperlukan
    ]);

    if ($this->request->getMethod() == 'post') {
        // Jika data telah dikirim melalui form
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            // Jika validasi berhasil, update data ke dalam database
            $data = [
                'nama_kategori' => $this->request->getPost('edit_nama_kategori'),
                // Tambahkan data lainnya jika diperlukan
            ];

            // Panggil metode updateKategori dari model untuk menyimpan perubahan
            $updated = $this->kategoriModel->updateKategori($id_kategori, $data);

            if ($updated) {
                // Jika berhasil menyimpan, arahkan kembali ke halaman kategori dengan pesan sukses
                return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil diupdate.');
            } else {
                // Jika gagal menyimpan, arahkan kembali ke halaman kategori dengan pesan error
                return redirect()->to('/admin/kategori')->with('error', 'Gagal menyimpan perubahan kategori.');
            }
        }
    }

    // Kembalikan tampilan jika metode bukan POST
    return redirect()->to('/admin/kategori');
}



public function hapusDataKategori()
{
    // Ambil ID kategori dari data yang dikirimkan
    $id_kategori = $this->request->getPost('id_kategori');

    // Validasi apakah ID kategori valid
    if ($id_kategori === null || !$kategori = $this->kategoriModel->find($id_kategori)) {
        return redirect()->to('/admin/kategori')->with('error', 'Kategori tidak ditemukan.');
    }

    // Cek apakah kategori memiliki keterkaitan dengan data lain
    // Misalnya, cek apakah ada barang atau produk yang terkait dengan kategori ini
    // Jika ada, Anda bisa memutuskan apakah akan menghapus kategori atau tidak

    // Jika kategori tidak memiliki keterkaitan dengan data lain, lanjutkan penghapusan
    $this->kategoriModel->delete($id_kategori);

    return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus.');
}


}