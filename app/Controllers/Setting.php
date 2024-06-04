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
