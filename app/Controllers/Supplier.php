<?php

namespace App\Controllers;

use CodeIgniter\Controller;



class Supplier extends BaseController
{
    public function index()
    {
        $data['page_title']="Suplier";
        $setting= $this->loadConfigData();
        $data['supplier'] = $this->supplierModel->findAll();
        $data['setting'] = $setting;
        return view('admin/supplier', $data);
    }

    public function ambilDataSupplier()
    {
        $search = $this->request->getPost('search');
        if ($search != "") {
            $data['supplier'] = $this->supplierModel->cariKode($search);
        } else {
            $data['supplier'] = $this->supplierModel->findAll();
        }
        $table = view('admin/tablesupplier', $data);
        return $this->response->setJSON(['table' => $table]);
    }

    public function tambahDataSupplier()
{
    $alamat = $this->request->getPost('alamat');
    $existingCount = $this->supplierModel->like('alamat', $alamat)->countAllResults();
    $kodeSupplier = strtoupper(substr($alamat, 0, 3)) . sprintf('%03d', $existingCount + 1);
    
    $data = [
        'kode_supplier' => $kodeSupplier,
        'nama' => $this->request->getPost('nama'),
        'alamat' => $alamat,
        'telepon' => $this->request->getPost('telepon')
    ];
    $this->supplierModel->insert($data);
    return redirect()->to('/admin/supplier');
}

public function editDataSupplier()
{
    $id = $this->request->getPost('id_supplier');
    $alamat = $this->request->getPost('edit_alamat');
    $existingCount = $this->supplierModel->where('alamat', $alamat)->countAllResults();
    $kodeSupplier = strtoupper(substr($alamat, 0, 3)) . sprintf('%03d', $existingCount + 1);
    
    $data = [
        'kode_supplier' => $kodeSupplier,
        'nama' => $this->request->getPost('edit_nama'),
        'alamat' => $alamat,
        'telepon' => $this->request->getPost('edit_telepon')
    ];
    $this->supplierModel->update($id, $data);
    return redirect()->to('/admin/supplier');
}

    public function hapusDataSupplier()
    {
        $id_supplier = $this->request->getPost('id_supplier');
        $this->supplierModel->delete($id_supplier);
        return redirect()->to('/admin/supplier');
    }
}
