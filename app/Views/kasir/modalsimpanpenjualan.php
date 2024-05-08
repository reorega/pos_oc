<div class="modal fade" id="modalSimpanPenjualan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Transaksi Berhasil Disimpan</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="cetakNota('<?= base_url('kasir/cetakNota/').$nofaktur; ?>','Nota')">Cetak Struk</button>
                <a href="<?= base_url('kasir/pos'); ?>" class="btn btn-success">Transaksi Baru</a>
            </div>
        </div>
    </div>                        
</div>