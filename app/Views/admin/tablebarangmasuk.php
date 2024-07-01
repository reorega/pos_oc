<style>
    .table-wrapper thead th {
        background-color: #343a40;
        color: #ffffff;
        position: sticky;
        top: 0;
        z-index: 1;
    }
</style>

<div class="table-wrapper">
    <table class="table table-hover mt-2 table-bordered">
        <thead class="table">
            <tr>
                <th>No</th>
                <th>Supplier</th>
                <th>Produk</th>
                <th>Total Item</th>
                <th>Harga Barang</th>
                <th>Total Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nilai = $no ?? 1; ?>
            <?php foreach ($barangmasuk as $key => $brg) : ?>
            <tr>
                <td><?= $nilai ?></td>
                <td><?= $brg['supplier_name'] ?></td>
                <td><?= $brg['product_name'] ?></td>
                <td><?= $brg['total_item'] ?></td>
                <td><?= 'Rp ' . number_format($brg['harga_beli'], 0, ',', '.') ?></td>
                <td><?= 'Rp ' . number_format($brg['total_bayar'], 0, ',', '.') ?></td>
                <td>
                    <!-- Modal Previews -->
                    <button type="button" class="btn btn-info" data-toggle="modal"
                        data-target="#infoData<?= $brg['id_barang_masuk'] ?>">
                        <i class="fa fa-eye"></i> Detail
                    </button>
                    <div class="modal fade" id="infoData<?= $brg['id_barang_masuk'] ?>" tabindex="-1"
                        aria-labelledby="infoDataLabel<?= $brg['id_barang_masuk'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="infoDataLabel<?= $brg['id_barang_masuk'] ?>">Detail Data
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Supplier</th>
                                                <th>Produk</th>
                                                <th>Total Item</th>
                                                <th>Harga Barang</th>
                                                <th>Total Bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= $nilai ?></td>
                                                <td><?= $brg['supplier_name'] ?></td>
                                                <td><?= $brg['product_name'] ?></td>
                                                <td><?= $brg['total_item'] ?></td>
                                                <td><?= 'Rp ' . number_format($brg['harga_beli'], 0, ',', '.') ?></td>
                                                <td><?= 'Rp ' . number_format($brg['total_bayar'], 0, ',', '.') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Edit -->
                    <!-- Modal Hapus -->
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#hapusData<?= $brg['id_barang_masuk'] ?>">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                    <div class="modal fade" id="hapusData<?= $brg['id_barang_masuk'] ?>" tabindex="-1"
                        aria-labelledby="hapusDataLabel<?= $brg['id_barang_masuk'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusDataLabel<?= $brg['id_barang_masuk'] ?>">Konfirmasi
                                        Hapus</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Anda Yakin Menghapus Data Barang Masuk?</p>
                                </div>
                                <div class="modal-footer">
                                    <form id="formHapus<?= $brg['id_barang_masuk'] ?>" action="" method="">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="hapusData('<?= $brg['id_barang_masuk'] ?>')">Hapus Data</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal Hapus -->
                </td>
            </tr>
            <?php $nilai++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($search == "no") : ?>
    <?= $pager->links(); ?>
    <?php endif; ?>
</div>