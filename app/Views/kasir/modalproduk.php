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
                <table class="table table-hover mt-2 table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <td>Kode Produk</td>
                            <td>Nama Produk</td>
                            <td>Diskon</td>
                            <td>Harga Jual</td>
                            <td>Stok</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produk as $pdk) : ?>   
                            <tr>
                                <td><?= $pdk['kode_produk'] ?></td>
                                <td><?= $pdk['nama_produk'] ?></td>
                                <td><?= $pdk['diskon'] ?></td>
                                <td><?= $pdk['harga_jual'] ?></td>
                                <td><?= $pdk['stok'] ?></td>
                                <td><button class="btn btn-success btn-pilih" type="button" id="button-addon2" onclick="pilihProduk('<?= $pdk['kode_produk'] ?>', '<?= $pdk['nama_produk'] ?>')">Pilih</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>  
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>                        
</div>