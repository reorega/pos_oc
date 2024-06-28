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
                    <td><?= $nilai ?></td>
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
