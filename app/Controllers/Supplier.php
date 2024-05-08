<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\SupplierModel;

class Supplier extends Controller
{
    public function index()
    {
        $data['page_title']="Suplier";
        $supplierModel = new SupplierModel();
        $data['supplier'] = $supplierModel->findAll();
        return view('admin/supplier', $data);
    }

    public function tambahDataSupplier()
{
    $supplierModel = new SupplierModel();
    $alamat = $this->request->getPost('alamat');
    $existingCount = $supplierModel->like('alamat', $alamat)->countAllResults();
    $kodeSupplier = strtoupper(substr($alamat, 0, 3)) . sprintf('%03d', $existingCount + 1);
    
    $data = [
        'kode_supplier' => $kodeSupplier,
        'nama' => $this->request->getPost('nama'),
        'alamat' => $alamat,
        'telepon' => $this->request->getPost('telepon')
    ];
    $supplierModel->insert($data);
    return redirect()->to('/admin/supplier');
}

public function editDataSupplier()
{
    $supplierModel = new SupplierModel();
    $id = $this->request->getPost('id_supplier');
    $alamat = $this->request->getPost('edit_alamat');
    $existingCount = $supplierModel->where('alamat', $alamat)->countAllResults();
    $kodeSupplier = strtoupper(substr($alamat, 0, 3)) . sprintf('%03d', $existingCount + 1);
    
    $data = [
        'kode_supplier' => $kodeSupplier,
        'nama' => $this->request->getPost('edit_nama'),
        'alamat' => $alamat,
        'telepon' => $this->request->getPost('edit_telepon')
    ];
    $supplierModel->update($id, $data);
    return redirect()->to('/admin/supplier');
}

    public function hapusDataSupplier()
    {
        $supplierModel = new SupplierModel();
        $id_supplier = $this->request->getPost('id_supplier');
        $supplierModel->delete($id_supplier);
        return redirect()->to('/admin/supplier');
    }
}
