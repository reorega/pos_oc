<table class="table table-hover mt-2 table-bordered">
    <thead class="table">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pendapatan</th>
            <th>Pengeluaran</th>
            <th>Laba</th>
        </tr>
    </thead>
    <tbody>
        <?php $nilai = 1; ?>
        <?php foreach ($laporan as $lp): ?>
            <tr>
                <td><?= $nilai ?></td>
                <td><?= $lp['tanggal'] ?></td>
                <td><?= $lp['pendapatan'] ?></td>
                <td><?= $lp['pengeluaran'] ?></td>
                <td><?= $lp['hasil'] ?></td>
            </tr>
            <?php $nilai++; ?>
        <?php endforeach; ?>
    </tbody>
</table>