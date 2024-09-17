<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table = 'penjualan'; // Sesuaikan dengan nama tabel di database Anda
    protected $primaryKey = 'id_penjualan';
    protected $allowedFields = ['no_faktur', 'tanggal', 'total_item', 'total_harga', 'diterima', 'kembalian', 'user_id']; // Kolom yang diizinkan untuk dimasukkan atau diperbarui


    protected $useTimestamps = true; // Mengaktifkan penggunaan kolom created_at dan updated_at
    protected $createdField = 'created_at'; // Nama kolom created_at di tabel
    protected $updatedField = 'updated_at'; // Nama kolom updated_at di tabel
    public function cariData($keyword)
    {
        $query = $this->db->table('penjualan'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('*'); // Ganti 'nama_kolom' dengan nama kolom yang ingin Anda cari
        $query->where('no_faktur', $keyword); // Batasi hasil ke 1 baris
        $query->orderBy('no_faktur', 'ASC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function join()
    {
        $query = $this->db->table('penjualan'); // Ganti 'nama_tabel' dengan nama tabel Anda
        $query->select('penjualan.*,users.username');
        $query->join('users', 'users.id_user = penjualan.user_id');
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function laporanHarian($keyword)
    {
        $query = $this->db->table('penjualan');
        $query->select('penjualan.*,users.username');
        $query->join('users', 'users.id_user = penjualan.user_id');
        $query->orderBy('no_faktur', 'DESC'); // Ganti 'nama_kolom_terurut' dengan nama kolom yang ingin Anda urutkan
        $query->where("DATE(penjualan.created_at)", $keyword);
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function jumlahItem($keyword)
    {
        $query = $this->db->table('penjualan');
        $query->select('SUM(total_item) as item,SUM(total_harga) as harga,SUM(diterima) as diterima,SUM(kembalian) as kembalian');
        $query->where("DATE(created_at)", $keyword);
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function dataChart($startDate, $endDate)
    {
        $query = $this->db->table('penjualan');
        $query->select('DATE(created_at) as tanggal,SUM(total_item) as item,');
        $query->where('created_at >=', $startDate);
        $query->where('created_at <=', $endDate);
        $query->groupBy('tanggal');
        $result = $query->get()->getResultArray();
        return $result;
    }
    public function laporan($start_date, $end_date)
    {
        $sql = "
            WITH RECURSIVE date_sequence AS (
    SELECT DATE('$start_date') AS tanggal
    UNION ALL
    SELECT DATE_ADD(tanggal, INTERVAL 1 DAY)
    FROM date_sequence
    WHERE tanggal < '$end_date'
)
SELECT 
    ds.tanggal,
    COALESCE(SUM(p.pendapatan), 0) AS pendapatan,
    COALESCE(SUM(bm.pengeluaran), 0) AS pengeluaran,
    COALESCE(SUM(rtr.retur),0) AS retur,
    COALESCE(SUM(p.pendapatan), 0) - COALESCE(SUM(bm.pengeluaran), 0) - COALESCE(SUM(rtr.retur),0) AS hasil
FROM 
    date_sequence ds
LEFT JOIN (
    SELECT 
        DATE(p.created_at) AS tanggal, 
        SUM(p.total_harga) AS pendapatan 
    FROM 
        penjualan p
    INNER JOIN 
        penjualan_detail pd ON p.no_faktur = pd.no_faktur
    INNER JOIN 
        produk pr ON pd.produk_id = pr.id_produk
    WHERE 
        pr.suplier_id = 1 AND
        DATE(p.created_at) BETWEEN '$start_date' AND '$end_date'
    GROUP BY 
        tanggal
) p ON ds.tanggal = p.tanggal
LEFT JOIN (
    SELECT 
        DATE(created_at) AS tanggal, 
        SUM(total_bayar) AS pengeluaran
    FROM 
        barang_masuk
    WHERE 
        id_supplier = 1 AND
        DATE(created_at) BETWEEN '$start_date' AND '$end_date'
    GROUP BY 
        tanggal
) bm ON ds.tanggal = bm.tanggal
 LEFT JOIN (
    SELECT 
        DATE(created_at) AS tanggal, 
        SUM(harga_retur) AS retur
    FROM 
        retur_barang
    WHERE 
        supplier_id = 1 AND
        DATE(created_at) BETWEEN '$start_date' AND '$end_date'
    GROUP BY 
        tanggal
) rtr ON ds.tanggal = rtr.tanggal

GROUP BY 
    ds.tanggal
HAVING hasil != 0
ORDER BY 
    ds.tanggal;
        ";

        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;
    }
    public function dataPenjualan($start_date, $end_date, $perPage = 10, $page = 1)
    {
        $builder = $this->builder();
        $builder->select('penjualan.*,DATE(penjualan.created_at) as tanggal,users.username as user')
            ->join('users', 'users.id_user = penjualan.user_id')
            ->where('DATE(penjualan.created_at) >=', $start_date)
            ->where('DATE(penjualan.created_at) <=', $end_date);

        return [
            'penjualan' => $this->paginate($perPage, 'default', $page),
            'pager' => $this->pager,
        ];
    }
    public function totalLaporan($start_date,$end_date){
        $sql = "
        WITH RECURSIVE date_sequence AS (
            SELECT DATE('$start_date') AS tanggal
            UNION ALL
            SELECT DATE_ADD(tanggal, INTERVAL 1 DAY)
            FROM date_sequence
            WHERE tanggal < '$end_date'
        )
        SELECT 
            COALESCE(SUM(p.pendapatan), 0) AS total_pendapatan,
            COALESCE(SUM(bm.pengeluaran), 0) AS total_pengeluaran,
            COALESCE(SUM(rtr.retur), 0) AS total_retur,
            COALESCE(SUM(p.pendapatan), 0) - COALESCE(SUM(bm.pengeluaran), 0) - COALESCE(SUM(rtr.retur), 0) AS total_laba
        FROM 
            date_sequence ds
        LEFT JOIN (
            SELECT 
                DATE(p.created_at) AS tanggal, 
                SUM(p.total_harga) AS pendapatan 
            FROM 
                penjualan p
            INNER JOIN 
                penjualan_detail pd ON p.no_faktur = pd.no_faktur
            INNER JOIN 
                produk pr ON pd.produk_id = pr.id_produk
            WHERE 
                pr.suplier_id = 1 AND
                DATE(p.created_at) BETWEEN '$start_date' AND '$end_date'
            GROUP BY 
                DATE(p.created_at)
        ) p ON ds.tanggal = p.tanggal
        LEFT JOIN (
            SELECT 
                DATE(created_at) AS tanggal, 
                SUM(total_bayar) AS pengeluaran
            FROM 
                barang_masuk
            WHERE 
                id_supplier = 1 AND
                DATE(created_at) BETWEEN '$start_date' AND '$end_date'
            GROUP BY 
                DATE(created_at)
        ) bm ON ds.tanggal = bm.tanggal
        LEFT JOIN (
            SELECT 
                DATE(created_at) AS tanggal, 
                SUM(harga_retur) AS retur
            FROM 
                retur_barang
            WHERE 
                supplier_id = 1 AND
                DATE(created_at) BETWEEN '$start_date' AND '$end_date'
            GROUP BY 
                DATE(created_at)
        ) rtr ON ds.tanggal = rtr.tanggal;
         ";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;
    }
    public function laporan2($start_date, $end_date)
    {
        $sql = "
            WITH RECURSIVE date_sequence AS (
    SELECT DATE('$start_date') AS tanggal
    UNION ALL
    SELECT DATE_ADD(tanggal, INTERVAL 1 DAY)
    FROM date_sequence
    WHERE tanggal < '$end_date'
)
SELECT 
    ds.tanggal,
    COALESCE(SUM(p.pendapatan), 0) AS pendapatan,
    COALESCE(SUM(pn.pengeluaran), 0) AS pengeluaran,
    COALESCE(SUM(p.pendapatan), 0) - COALESCE(SUM(pn.pengeluaran), 0) AS hasil
FROM 
    date_sequence ds
LEFT JOIN (
    SELECT 
        DATE(p.created_at) AS tanggal, 
        SUM(p.total_harga) AS pendapatan 
    FROM 
        penjualan p
    INNER JOIN 
        penjualan_detail pd ON p.no_faktur = pd.no_faktur
    INNER JOIN 
        produk pr ON pd.produk_id = pr.id_produk
    WHERE 
        pr.suplier_id != 1 AND
        DATE(p.created_at) BETWEEN '$start_date' AND '$end_date'
    GROUP BY 
        tanggal
) p ON ds.tanggal = p.tanggal
LEFT JOIN (
            -- Query untuk mendapatkan pengeluaran dari penjumlahan harga_beli produk yang terjual
            SELECT 
                DATE(pn.created_at) AS tanggal,
                SUM(pr.harga_beli * pd.jumlah) AS pengeluaran
            FROM 
                penjualan pn
            INNER JOIN 
                penjualan_detail pd ON pn.no_faktur = pd.no_faktur
            INNER JOIN 
                produk pr ON pd.produk_id = pr.id_produk
            WHERE 
                pr.suplier_id != 1 AND
                DATE(pn.created_at) BETWEEN '$start_date' AND '$end_date'
            GROUP BY 
                DATE(pn.created_at)
        ) pn ON ds.tanggal = pn.tanggal

GROUP BY 
    ds.tanggal
HAVING hasil != 0
ORDER BY 
    ds.tanggal;
        ";

        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;
    }
    public function totalLaporan2($start_date,$end_date){
        $sql = "
        WITH RECURSIVE date_sequence AS (
            SELECT DATE('$start_date') AS tanggal
            UNION ALL
            SELECT DATE_ADD(tanggal, INTERVAL 1 DAY)
            FROM date_sequence
            WHERE tanggal < '$end_date'
        )
        SELECT 
            COALESCE(SUM(p.pendapatan), 0) AS total_pendapatan,
            COALESCE(SUM(pn.pengeluaran), 0) AS total_pengeluaran,
            COALESCE(SUM(p.pendapatan), 0) - COALESCE(SUM(pn.pengeluaran), 0) AS total_laba
        FROM 
            date_sequence ds
        LEFT JOIN (
            -- Query untuk mendapatkan pendapatan
            SELECT 
                DATE(p.created_at) AS tanggal, 
                SUM(p.total_harga) AS pendapatan 
            FROM 
                penjualan p
            INNER JOIN 
                penjualan_detail pd ON p.no_faktur = pd.no_faktur
            INNER JOIN 
                produk pr ON pd.produk_id = pr.id_produk
            WHERE 
                pr.suplier_id != 1 AND
                DATE(p.created_at) BETWEEN '$start_date' AND '$end_date'
            GROUP BY 
                DATE(p.created_at)
        ) p ON ds.tanggal = p.tanggal
        LEFT JOIN (
            -- Query untuk mendapatkan pengeluaran dari penjumlahan harga_beli produk yang terjual
            SELECT 
                DATE(pn.created_at) AS tanggal,
                SUM(pr.harga_beli * pd.jumlah) AS pengeluaran
            FROM 
                penjualan pn
            INNER JOIN 
                penjualan_detail pd ON pn.no_faktur = pd.no_faktur
            INNER JOIN 
                produk pr ON pd.produk_id = pr.id_produk
            WHERE 
                pr.suplier_id != 1 AND
                DATE(pn.created_at) BETWEEN '$start_date' AND '$end_date'
            GROUP BY 
                DATE(pn.created_at)
        ) pn ON ds.tanggal = pn.tanggal;
    ";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;
    }
    public function dashboardKasir(){
        $query = $this->db->table('penjualan');
        $query->select('DATE(created_at) as tanggal, SUM(total_item) as item, SUM(total_harga) AS omset, COUNT(no_faktur) AS jumlah_transaksi');
        $query->where("DATE(created_at) >=", date('Y-m-d'));
        $query->groupBy('tanggal');
        $result = $query->get()->getResultArray();
        if (empty($result)) {
            $result[] = [
                'tanggal' => date('Y-m-d'),
                'item' => 0,
                'omset' => 0,
                'jumlah_transaksi' => 0
            ];
        }
        return $result;
    }
}