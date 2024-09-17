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
                <th>Nama Supplier</th>
                <th>Nama Produk</th>
                <th>Total Item</th>
                <th>Harga Barang</th>
                <th>Total Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nilai = $no ?? 1; ?>
            <?php foreach ($barangmasuk as $brg) : ?>
            <tr class="text-center">
                <td><?= $nilai ?></td>
                <td><?= $brg['supplier_name'] ?></td>
                <td><?= $brg['product_name'] ?></td>
                <td><?= $brg['total_item'] ?></td>
                <td><?= 'Rp ' . number_format($brg['harga_beli'], 0, ',', '.') ?></td>
                <td><?= 'Rp ' . number_format($brg['total_bayar'], 0, ',', '.') ?></td>
                <td>
                    <button type="button" class="btn btn-info" data-toggle="modal"
                        data-target="#infoData<?= $brg['id_barang_masuk'] ?>">
                        <i class="fa fa-eye"></i> Detail
                    </button>
                    <!-- Detail Modal -->
                    <div class="modal fade" id="infoData<?= $brg['id_barang_masuk'] ?>" tabindex="-1"
                        aria-labelledby="infoDataLabel<?= $brg['id_barang_masuk'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title text-left" id="infoDataLabel<?= $brg['id_barang_masuk'] ?>">
                                        Detail Data</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Supplier</th>
                                                <th>Nama Produk</th>
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
                    <button type="button" class="btn btn-warning" onclick="bukaModalEdit('<?= $brg['id_barang_masuk'] ?>')">
                        <i class="fa fa-pencil"></i> Edit
                    </button>
                    <!-- Edit Modal -->
                    <div class="modal fade text-left" id="editData<?= $brg['id_barang_masuk'] ?>" tabindex="-1" aria-labelledby="editDataLabel<?= $brg['id_barang_masuk'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="editDataLabel<?= $brg['id_barang_masuk'] ?>">Edit Data</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= site_url('/admin/editDataBarangMasuk') ?>" enctype="multipart/form-data" class="formEditData">
                                        <div class="form-group">
                                            <label for="stok_sebelumnya_edit<?= $brg['id_barang_masuk'] ?>" class="form-label">Stok Sebelumnya</label>
                                            <input type="text" class="form-control" id="stok_sebelumnya_edit<?= $brg['id_barang_masuk'] ?>" name="stok_sebelumnya" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="editTotalItem<?= $brg['id_barang_masuk'] ?>" class="form-label">Total Item</label>
                                            <input type="number" class="form-control" id="editTotalItem<?= $brg['id_barang_masuk'] ?>" name="total_item" value="<?= $brg['total_item'] ?>">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $brg['id_barang_masuk'] ?>">
                                        <input type="hidden" name="product_id" id="editProductId<?= $brg['id_barang_masuk'] ?>" value="<?= $brg['id_produk'] ?>">

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="hapusData('<?= $brg['id_barang_masuk'] ?>')">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                    <!-- Delete Modal -->
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

<script>
$(document).ready(function () {
    // Fetch and display previous stock when opening the edit modal
    $('#editData<?= $brg['id_barang_masuk'] ?>').on('shown.bs.modal', function () {
        var id = $(this).find('input[name="id"]').val();
        var productId = $(this).find('input[name="product_id"]').val();
        if (productId) {
            $.ajax({
                url: '<?= site_url('/admin/getProductStock') ?>',
                type: 'POST',
                data: { product_id: productId },
                dataType: 'json',
                success: function (response) {
                    $('#stok_sebelumnya_edit' + id).val(response.stok_sebelumnya);
                },
                error: function (xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        } else {
            $('#stok_sebelumnya_edit' + id).val('');
        }
    });

    $('.formEditData').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                $('#responseMessage').empty();
                $('.invalid-feedback').empty();
                $('.is-invalid').removeClass('is-invalid');
                if (response.success == true) {
                    $('.modal').modal('hide');
                    ambilData($('#page').val());
                    Swal.fire(
                        'Tersimpan!',
                        'Data berhasil diubah.',
                        'success'
                    );
                } else {
                    $.each(response.errors, function (field, message) {
                        var element = $('[name=' + field + ']');
                        element.closest('.form-group').addClass('has-error');
                        element.closest('.form-group').addClass('has-feedback');
                        element.next('.invalid-feedback').text(message);
                        element.after('<span class="glyphicon glyphicon-warning-sign form-control-feedback text-danger"></span>');
                    });
                }
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});

    function bukaModalEdit(id){
        $('#editData' + id).modal('show');
        $('.invalid-feedback').empty();
        $('.form-group').removeClass('has-error');
        $('.form-group').removeClass('has-feedback');
        $('.form-group .glyphicon').remove();
        $('#editData' + id + ' [data-original-value]').each(function() {
            var originalValue = $(this).data('original-value');
            $(this).val(originalValue);
        });
    }
</script>