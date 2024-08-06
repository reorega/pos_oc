<style>
    .table-wrapper thead th {
        background-color: #343a40;
        color: #ffffff;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .no {
        width: 50px;
    }

    .table th {
        text-align: center;
    }
</style>

<div class="table-wrapper">
    <table class="table table-hover mt-2 table-bordered">
        <thead class="table">
            <tr>
                <th class="no">No</th>
                <th>Tanggal</th>
                <th>Faktur</th>
                <th>Jumlah Item Dijual</th>
                <th>Total Harga</th>
                <th>Kasir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nilai =$no ?? 1;?>
            <?php foreach ($penjualan as $pj) : ?>
            <tr class="text-center">
                <td><?= $nilai ?></td>
                <td><?= $pj['tanggal'] ?></td>
                <td><?= $pj['no_faktur'] ?></td>
                <td><?= $pj['total_item'] ?></td>
                <td><?= $pj['total_harga'] ?></td>
                <td><?= $pj['user'] ?></td>
                <td>
                    <button type="button" class="btn btn-info"
                        onclick="dataDetail('<?= $pj['no_faktur'] ?>')">
                        <i class="fa fa-eye"></i> Detail
                    </button>
                </td>
            </tr>
            <?php $nilai++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?=  $pager->links(); ?>
</div>
<div class="viewmodaldatadetail"></div>
<script>
    function dataDetail(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/penjualanDetail') ?>",
            data: {
                nofaktur: id,
            },
            dataType: "json",
            success: function(response) {
                $('.viewmodaldatadetail').html(response.viewModal).show();
                $('#modalDataDetail').modal('show');
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>