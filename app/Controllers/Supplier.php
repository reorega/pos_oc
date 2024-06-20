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

    public function ambilDataSupplier(){
        $search = $this->request->getPost('search');
        $page = $this->request->getPost('page') ?? 1;
        $jumlahpagination = 5;
        $no = $page * $jumlahpagination - ($jumlahpagination - 1);
        $cacheKey = "supplier_data_{$search}_{$page}";

        if ($cachedData = cache($cacheKey)) {
            $data = $cachedData;
        } else {
            if ($search != "") {
                $data['supplier'] = $this->supplierModel->cariKode($search);
                $data['search'] = "yes";
            } else {
                $data['supplier'] = $this->supplierModel->paginate($jumlahpagination, 'default', $page);
                $data['pager'] = $this->supplierModel->pager;
                $data['no'] = $no;
                $data['search'] = "no";
            }
            cache()->save($cacheKey, $data, 3600); // Cache for 1 hour
        }

        $table = view('admin/tablesupplier', $data);
        return $this->response->setJSON(['table' => $table]);
    }

    public function tambahDataSupplier(){
        $alamat = $this->request->getPost('alamat');
        $existingCount = $this->supplierModel->like('alamat', $alamat)->countAllResults();
        $kodeSupplier = strtoupper(substr($alamat, 0, 3)) . sprintf('%03d', $existingCount + 1);
        
        $data = [
            'kode_supplier' => $kodeSupplier,
            'nama' => $this->request->getPost('suplier'),
            'alamat' => $alamat,
            'telepon' => $this->request->getPost('telepon')
        ];
        $this->supplierModel->insert($data);
        cache()->clean();
        $response = [
            'status' => 'success',              
        ];
        return $this->response->setJSON($response); 
    }

    public function editDataSupplier(){
        $id = $this->request->getPost('id');
        $alamat = $this->request->getPost('alamat');
        $existingCount = $this->supplierModel->where('alamat', $alamat)->countAllResults();
        $kodeSupplier = strtoupper(substr($alamat, 0, 3)) . sprintf('%03d', $existingCount + 1);
        
        $data = [
            'kode_supplier' => $kodeSupplier,
            'nama' => $this->request->getPost('suplier'),
            'alamat' => $alamat,
            'telepon' => $this->request->getPost('telepon')
        ];
        $this->supplierModel->update($id, $data);
        cache()->clean();
        $response = [
            'status' => 'success',
            'id' => $id,              
        ];
        return $this->response->setJSON($response); 
    }

    public function hapusDataSupplier()
    {
        $id_supplier = $this->request->getPost('id');
        $this->supplierModel->delete($id_supplier);
        cache()->clean();
        $response = [
            'status' => 'success',              
        ];
        return $this->response->setJSON($response);
    }
}
