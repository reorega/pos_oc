<table class="table table-hover mt-2 table-bordered">
    <thead class="table">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Faktur</th>
            <th>Jumlah Item Dijual</th>
            <th>Total Harga</th>
            <th>Kasir</th>
        </tr>
    </thead>
    <tbody>
       <?php $nilai =$no ?? 1;?>
       <?php foreach ($penjualan as $pj) : ?>
        <tr>
            <td><?= $nilai ?></td>
            <td><?= $pj['tanggal'] ?></td>
            <td><?= $pj['no_faktur'] ?></td>
            <td><?= $pj['total_item'] ?></td>
            <td><?= $pj['total_harga'] ?></td>
            <td><?= $pj['user'] ?></td>

        </tr>
        <?php $nilai++; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?=  $pager->links(); ?>
