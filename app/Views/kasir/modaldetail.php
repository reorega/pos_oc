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
            <table class="table table-hover mt-2 table-bordered">
                <thead class="table-dark">
                    <tr>
                    <td>Kode Produk</td>
                    <td>Nama Produk</td>
                    <td>Diskon</td>
                    <td>Harga Jual</td>
                    <td>Qty</td>
                    <td>SubTotal</td>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>                        
</div>