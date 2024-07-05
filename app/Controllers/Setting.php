<?php

namespace App\Controllers;


use CodeIgniter\Controller;

class Setting extends BaseController
{
    public function index()
    {
        $setting= $this->loadConfigData();
        $data['pengaturans'] = $this->settingModel->findAll();
        $data['setting'] = $setting;
        return view('admin/setting', $data);
    }

    public function update()
    {
        $nama_perusahaan = ucwords(strtolower($this->request->getPost('nama_perusahaan')));
    
        $data = [
            'nama_perusahaan' => $nama_perusahaan,
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
        ];
    
        // Proses menyimpan logo jika ada yang diunggah
        $logo = $this->request->getFile('path_logo');
        if ($logo->getSize() > 0) {
            // Jika ada file baru yang diunggah
            
            // Mendapatkan data lama untuk menghapus logo lama
            $oldSetting = $this->settingModel->find(1);
            
            // Hapus file logo lama
            if (file_exists(ROOTPATH . 'public/' . $oldSetting['path_logo'])) {
                unlink(ROOTPATH . 'public/' . $oldSetting['path_logo']);
            }
    
            // Gunakan nama file asli dari logo baru
            $logoName = $logo->getClientName();
            $logo->move(ROOTPATH . 'public/img', $logoName);
            $data['path_logo'] = 'img/' . $logoName;
        } else {
            // Jika tidak ada file yang diunggah, gunakan path logo yang sudah ada di database
            $oldSetting = $this->settingModel->find(1);
            $data['path_logo'] = $oldSetting['path_logo'];
        }
    
        $this->settingModel->update(1, $data);
    
        // Memuat ulang data setting dari database
        $updatedSetting = $this->settingModel->find(1);
    
        // Memperbarui sesi dengan data yang baru
        $session = session();
        $session->set([
            'nama_perusahaan' => $updatedSetting['nama_perusahaan'],
            'path_logo' => $updatedSetting['path_logo'],
            'alamat' => $updatedSetting['alamat'],
            'telepon' => $updatedSetting['telepon']
        ]);
    
        return redirect()->to(base_url('admin/setting'))->with('success', 'Data berhasil diperbarui');
    }
    
}
