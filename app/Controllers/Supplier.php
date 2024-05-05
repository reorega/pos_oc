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
    $data = [
        'nama' => $this->request->getVar('nama'),
        'alamat' => $this->request->getVar('alamat'),
        'telepon' => $this->request->getVar('telepon')
    ];
    $supplierModel->insert($data);
    return redirect()->to('/admin/supplier');
}

public function editDataSupplier()
{
    $supplierModel = new SupplierModel();
    $id = $this->request->getVar('id_supplier');
    $data = [
        'nama' => $this->request->getVar('edit_nama'),
        'alamat' => $this->request->getVar('edit_alamat'),
        'telepon' => $this->request->getVar('edit_telepon')
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
