<style>
    .table-wrapper {
        max-height: 530px;
        overflow-y: auto;
    }

    .table-wrapper table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-wrapper table th,
    .table-wrapper table td {
        border: 1px solid #dddddd;
        padding: 8px;
        text-align: center;
        vertical-align: middle;
    }

    .table-wrapper table td.no {
        width: 50px;
    }

    .table-wrapper thead th {
        background-color: #343a40;
        color: #fff;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>

<div class="table-wrapper">
    <table class="table table-hover mt-2 table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pendapatan</th>
                <th>Pengeluaran</th>
                <th>Laba</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan)): ?>
            <?php $nilai = 1; ?>
            <?php foreach ($laporan as $lp): ?>
            <tr>
                <td class="no"><?= $nilai ?></td>
                <td><?= date('d-m-Y', strtotime($lp['tanggal'])) ?></td>
                <td><?= 'Rp ' . number_format($lp['pendapatan'], 2, ',', '.') ?></td>
                <td><?= 'Rp ' . number_format($lp['pengeluaran'], 2, ',', '.') ?></td>
                <td><?= 'Rp ' . number_format($lp['hasil'], 2, ',', '.') ?></td>
            </tr>
            <?php $nilai++; ?>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Tidak ada data laporan untuk periode ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>