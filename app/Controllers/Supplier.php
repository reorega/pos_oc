<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Supplier extends BaseController
{
    protected $supplierValidationRules = [
        'nama' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama supplier harus diisi',
            ]
        ],
        'alamat' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Alamat harus diisi',
            ]
        ],
        'telepon' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'No telepon harus diisi',
            ]
        ]
    ];
    
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
        $validation = \Config\Services::validation();
        $valid = $this->validate($this->supplierValidationRules);
        if(!$valid){
            $errors = [];
            foreach ($validation->getErrors() as $field => $message) {
                $errors[$field] = $message;
            }
            return $this->response->setJSON(['success' => false, 'errors' => $errors,]);
        }else{
            try {
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
                cache()->clean();
                $response = ['success' => true];
            } catch (\Exception $e) {
                $response = ['status' => 'error', 'message' => $e->getMessage()];
            }
            return $this->response->setJSON($response);
        }
    }
    
    public function editDataSupplier(){
        $validation = \Config\Services::validation();
        $valid = $this->validate($this->supplierValidationRules);
        if(!$valid){
            $errors = [];
            // Mengambil pesan kesalahan dari validator satu per satu
            foreach ($validation->getErrors() as $field => $message) {
                $errors[$field] = $message;
            }
            return $this->response->setJSON(['success' => false, 'errors' => $errors,]);
        }else{
            $id = $this->request->getPost('id_supplier');
            $alamat = $this->request->getPost('alamat');
            $cari=$this->supplierModel->find($id);
            if($alamat != $cari['alamat']){
                $existingCount = $this->supplierModel->where('alamat', $alamat)->countAllResults();
                $kodeSupplier = strtoupper(substr($alamat, 0, 3)) . sprintf('%03d', $existingCount + 1);
            }else{
                $kodeSupplier=$cari['kode_supplier'];
            }
        
            $data = [
                'kode_supplier' => $kodeSupplier,
                'nama' => $this->request->getPost('nama'),
                'alamat' => $alamat,
                'telepon' => $this->request->getPost('telepon')
            ];
            $this->supplierModel->update($id, $data);
            cache()->clean();
            $response = [
                'success' => true,
                'id' => $id,              
            ];
            return $this->response->setJSON($response);
        }
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
