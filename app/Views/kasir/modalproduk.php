<style>
    .table-wrapper thead th {
        background-color: #343a40;
        color: #ffffff;
        position: sticky;
        top: 0;
        z-index: 1;
    }
    .batas{
        max-height: 450px;
        overflow-y: scroll;
    }
    .kode {
        width: 105px;
    }

    .harga {
        width: 90px;
    }
</style>

<div class="modal fade" id="modalProduk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Data Produk</h4>
            </div>
            <div class="modal-body">
                <div class="table-wrapper batas">
                <?php if($produk != null): ?>
                    <table class="table table-hover mt-2 table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th class="kode">Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Diskon</th>
                                <th class="harga">Harga Jual</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produk as $pdk) : ?>
                            <tr>
                                <td><?= $pdk['kode_produk'] ?></td>
                                <td><?= $pdk['nama_produk'] ?></td>
                                <td><?= number_format($pdk['diskon'],0,',','.') ?>%</td>
                                <td>Rp <?= number_format($pdk['harga_jual'],0,',','.') ?></td>
                                <td><?= $pdk['stok'] ?></td>
                                <td><button class="btn btn-success btn-pilih" type="button" id="button-addon2"
                                        onclick="simpanTransaksiDetail('<?= $pdk['kode_produk'] ?>')">Pilih</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>                               
                    <h3 class="text-danger text-center">Produk Tidak Ditemukan</h3>                         
                <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondaryda " data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>