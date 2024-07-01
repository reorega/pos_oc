<style>
    .table-wrapper thead th {
        background-color: #343a40;
        color: #ffffff;
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>

<div class="modal fade" id="modalDataDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Data Detail</h4>
            </div>
            <div class="modal-body">
                <div class="table-wrapper">
                    <table class="table table-hover mt-2 table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Diskon</th>
                                <th>Harga Jual</th>
                                <th>Qty</th>
                                <th>SubTotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nilai =1;?>
                            <?php foreach ($detail as $pdk) : ?>
                            <tr>
                                <td><?= $pdk['kode_produk'] ?></td>
                                <td><?= $pdk['produk'] ?></td>
                                <td><?= $pdk['diskon'] ?></td>
                                <td>RP <?= number_format($pdk['harga_jual'],0,',','.') ?></td>
                                <td><?= $pdk['jumlah'] ?></td>
                                <td>RP <?= number_format($pdk['sub_total'],0,',','.') ?></td>
                            </tr>
                            <?php $nilai++; ?>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>