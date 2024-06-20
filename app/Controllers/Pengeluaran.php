<?php

namespace App\Controllers;

use App\Models\BarangMasukModel;
use App\Models\SupplierModel;
use App\Models\ProdukModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\Controller;

class Pengeluaran extends Controller
{
    public function index()
    {
        $barangMasukModel = new BarangMasukModel();
        $supplierModel = new SupplierModel();
        $produkModel = new ProdukModel();

        // Get all data from the model
        $data['BarangMasuks'] = $barangMasukModel->findAll();

        // Get all suppliers and products
        $data['suppliers'] = $supplierModel->findAll();
        $data['produks'] = $produkModel->findAll();
        
        // Replace ID with the name for supplier and product
        foreach ($data['BarangMasuks'] as &$barangMasuk) {
            $supplier = $supplierModel->find($barangMasuk['id_supplier']);
            $produk = $produkModel->find($barangMasuk['id_produk']);
            $barangMasuk['nama_supplier'] = $supplier ? $supplier['nama'] : 'Supplier not found';
            $barangMasuk['nama_produk'] = $produk ? $produk['nama_produk'] : 'Product not found';
        }

        // Load the view with the data
        return view('admin/pengeluaran', $data);
    }
    
    public function downloadPDF()
    {
        $barangMasukModel = new BarangMasukModel();
        $data['BarangMasuks'] = $barangMasukModel->findAll();

        // Load Dompdf library
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Render HTML content
        $html = view('admin/pengeluaranpdf', $data);
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF
        $dompdf->render();

        // Output PDF to browser
        $dompdf->stream('laporan_pengeluaran.pdf', array('Attachment' => 0));
    }


}
