<?php

namespace App\Controllers;

use App\Models\SettingModel;
use CodeIgniter\Controller;

class Setting extends Controller
{
    public function index()
    {
        $settingModel = new SettingModel();
        $data['setting'] = $settingModel->findAll();
        return view('admin/setting', $data);
    }

    public function update()
    {
        $settingModel = new SettingModel();
        $data = [
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
        ];

        $logo = $this->request->getFile('path_logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $logoName = $logo->getRandomName();
            $logo->move(ROOTPATH . 'public/img', $logoName);
            $data['path_logo'] = 'img/' . $logoName;
        }

        $settingModel->update(1, $data);

        // Memuat ulang data setting dari database
        $updatedSetting = $settingModel->find(1);

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
