<!DOCTYPE html>
<html>
<head>
    <title>Data Pengeluaran</title>
    <style>
        /* Tambahkan gaya CSS Anda di sini */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Data Pengeluaran</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Produk</th>
                <th>Total Item</th>
                <th>Harga Beli</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($BarangMasuks as $key => $pengeluaran) : ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= date('d F Y', strtotime($pengeluaran['created_at'])) ?></td>
                    <td><?= $pengeluaran['id_supplier'] ?></td> <!-- Mengambil nama supplier -->
                    <td><?= $pengeluaran['id_produk'] ?></td> <!-- Mengambil nama produk -->
                    <td><?= $pengeluaran['total_item'] ?></td>
                    <td><?= 'Rp ' . number_format($pengeluaran['harga_beli'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
