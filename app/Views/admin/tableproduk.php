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
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Beli</th>
                <th>Diskon</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nilai = $no ?? 1; ?>
            <?php foreach ($produk as $pdk) : ?>
            <tr class="text-center">
                <td><?= $nilai ?></td>
                <td><?= $pdk['kode_produk'] ?></td>
                <td><?= $pdk['nama_produk'] ?></td>
                <td><?= $pdk['kategori'] ?></td>
                <td><?= 'Rp ' . number_format($pdk['harga_beli'], 0, ',', '.') ?></td>
                <td><?= number_format($pdk['diskon'],0,',','.') ?>%</td>
                <td><?= 'Rp ' . number_format($pdk['harga_jual'], 0, ',', '.') ?></td>
                <td><?= $pdk['stok'] ?></td>
                <td>
                    <button type="button" class="btn btn-success"
                        onclick="window.open('<?= base_url('/admin/barcode/' . $pdk['id_produk']) ?>', '_blank')">
                        <i class="fa fa-barcode"></i> Barcode
                    </button>
                    <button type="button" class="btn btn-info" data-toggle="modal"
                        data-target="#infoData<?= $pdk['id_produk'] ?>">
                        <i class="fa fa-eye"></i> Detail
                    </button>
                    <!-- Detail Modal -->
                    <div class="modal fade" id="infoData<?= $pdk['id_produk'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title text-left" id="exampleModalLabel">Detail Data</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Produk</th>
                                                <th>Kategori</th>
                                                <th>Nama Supplier</th>
                                                <th>Nama Produk</th>
                                                <th>Harga Beli</th>
                                                <th>Diskon</th>
                                                <th>Harga Jual</th>
                                                <th>Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= $nilai ?></td>
                                                <td><?= $pdk['kode_produk'] ?></td>
                                                <td><?= $pdk['kategori'] ?></td>
                                                <td><?= $pdk['suplier'] ?></td>
                                                <td><?= $pdk['nama_produk'] ?></td>
                                                <td><?= 'Rp ' . number_format($pdk['harga_beli'], 0, ',', '.') ?></td>
                                                <td><?= number_format($pdk['diskon'],0,',','.') ?>%</td>
                                                <td><?= 'Rp ' . number_format($pdk['harga_jual'], 0, ',', '.') ?></td>
                                                <td><?= $pdk['stok'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-warning" onclick="bukaModalEdit('<?= $pdk['id_produk'] ?>')">
                        <i class="fa fa-pencil"></i> Edit
                    </button>
                    <!-- Edit Modal -->
                    <div class="modal fade text-left" id="editData<?= $pdk['id_produk'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="exampleModalLabel">Edit Data</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= site_url('/admin/editDataProduk') ?>" enctype="multipart/form-data" class="formEditData">
                                        <div class="form-group">
                                            <label for="kategori_id" class="control-label">Nama Kategori</label>
                                            <select class="form-control selectpicker" name="kategori_id"
                                                data-live-search="true" id="editKategori<?= $pdk['id_produk'] ?>"
                                                data-original-value="<?= $pdk['kategori_id'] ?>">
                                                <option value="" <?= ($pdk['kategori_id'] == 0) ? 'selected' : ''; ?>>
                                                    Pilih Kategori Produk</option>
                                                <?php foreach ($kategori as $ktg) : ?>
                                                <option value="<?= $ktg['id_kategori']; ?>"
                                                    <?= ($ktg['id_kategori'] == $pdk['kategori_id']) ? 'selected' : ''; ?>>
                                                    <?= $ktg['nama_kategori'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="suplier_id" class="control-label">Nama Supplier</label>
                                            <select class="form-control selectpicker" name="suplier_id"
                                                data-live-search="true" id="editSuplier<?= $pdk['id_produk'] ?>"
                                                data-original-value="<?= $pdk['suplier_id'] ?>">
                                                <?php foreach ($suplier as $sp) : ?>
                                                <option value="<?= $sp['id_supplier']; ?>"
                                                    <?= ($sp['id_supplier'] == $pdk['suplier_id']) ? 'selected' : ''; ?>>
                                                    <?= $sp['nama'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_produk" class="control-label">Nama Produk</label>
                                            <input type="text" class="form-control"
                                                id="editNamaProduk<?= $pdk['id_produk'] ?>" name="nama_produk"
                                                value="<?= $pdk['nama_produk'] ?>"
                                                data-original-value="<?= $pdk['nama_produk'] ?>">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="harga_beli" class="control-label">Harga Beli</label>
                                            <input type="text" class="form-control" 
                                            id="editHargaBeli<?= $pdk['id_produk'] ?>" name="harga_beli" 
                                            value="<?= 'Rp ' . number_format($pdk['harga_beli'], 0, ',', '.') ?>" 
                                            data-original-value="<?= $pdk['harga_beli'] ?>" onkeyup="formatCurrency(this)">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="diskon" class="control-label">Diskon</label>
                                            <input type="text" class="form-control"
                                                id="editDiskon<?= $pdk['id_produk'] ?>" name="diskon"
                                                value="<?= $pdk['diskon'] ?>" step="0.01" oninput="formatDiskon(this)"
                                                data-original-value="<?= $pdk['diskon'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="harga_jual" class="control-label">Harga Jual</label>
                                            <input type="text" class="form-control" 
                                            id="editHargaJual<?= $pdk['id_produk'] ?>" name="harga_jual" 
                                            value="<?= 'Rp ' . number_format($pdk['harga_jual'], 0, ',', '.') ?>" 
                                            data-original-value="<?= $pdk['harga_jual'] ?>" onkeyup="formatCurrency(this)">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $pdk['id_produk'] ?>" >
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="hapusData('<?= $pdk['id_produk'] ?>')">
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
    function formatCurrency(input) {
        let value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
        if (value) {
            value = parseInt(value, 10);
            input.value = 'Rp ' + value.toLocaleString('id-ID'); // Format as currency
        } else {
            input.value = '';
        }
    }

            $(document).ready(function () {
            $('.formEditData').on('submit', function (e) {
                e.preventDefault();

        // Hapus simbol mata uang sebelum kirim
        let hargaBeli = $('#editHargaBeli<?= $pdk['id_produk'] ?>').val().replace(/[^0-9]/g, '');
        let hargaJual = $('#editHargaJual<?= $pdk['id_produk'] ?>').val().replace(/[^0-9]/g, '');

        // Set nilai input yang sudah dibersihkan
        $('#editHargaBeli<?= $pdk['id_produk'] ?>').val(hargaBeli);
        $('#editHargaJual<?= $pdk['id_produk'] ?>').val(hargaJual);

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
        $('#editData'+ id).modal('show');
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