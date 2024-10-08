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
        <thead class="thead-dark">
            <tr>
                <th class="no">No</th>
                <th>Nama Produk</th>
                <th>Nama Supplier</th>
                <th>Jumlah Retur</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nilai = $no ?? 1; ?>
            <?php foreach ($returbarang as $rtb) : ?>
            <tr class="text-center">
                <td><?= $nilai ?></td>
                <td><?= $rtb['product_name'] ?></td>
                <td><?= $rtb['supplier_name'] ?></td>
                <td><?= $rtb['jumlah'] ?></td>
                <td><?= $rtb['keterangan'] ?></td>
                <td>
                    <!-- Button detail -->
                    <button type="button" class="btn btn-info" data-toggle="modal"
                        data-target="#infoData<?= $rtb['id_retur_barang'] ?>">
                        <i class="fa fa-eye"></i> Detail
                    </button>

                    <!-- Modal detail -->
                    <div class="modal fade" id="infoData<?= $rtb['id_retur_barang'] ?>" tabindex="-1"
                        aria-labelledby="infoDataLabel<?= $rtb['id_retur_barang'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title text-left" id="infoDataLabel<?= $rtb['id_retur_barang'] ?>">
                                        Detail Data
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Produk</th>
                                                <th>Nama Supplier</th>
                                                <th>Jumlah Retur</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= $nilai ?></td>
                                                <td><?= $rtb['product_name'] ?></td>
                                                <td><?= $rtb['supplier_name'] ?></td>
                                                <td><?= $rtb['jumlah'] ?></td>
                                                <td><?= $rtb['keterangan'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal detail -->

                    <!-- Button edit -->
                    <button type="button" class="btn btn-warning" onclick="bukaModalEdit('<?= $rtb['id_retur_barang'] ?>')">
                        <i class="fa fa-pencil"></i> Edit
                    </button>
                    <!-- Modal edit -->
                    <div class="modal fade text-left" id="editData<?= $rtb['id_retur_barang'] ?>" tabindex="-1"
                        aria-labelledby="editDataLabel<?= $rtb['id_retur_barang'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="editDataLabel<?= $rtb['id_retur_barang'] ?>">Edit Data</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= site_url('/admin/editDataReturBarang') ?>" enctype="multipart/form-data" class="formEditData">
                                    <input type="hidden" name="id" value="<?= $rtb['id_retur_barang'] ?>"  id="retur<?= $rtb['id_retur_barang'] ?>" >
                                    <input type="hidden" name="produk_id" value="<?= $rtb['produk_id'] ?>" id="produk<?= $rtb['id_retur_barang'] ?>" >
                                        <div class="form-group">
                                            <label for="stokLama" class="form-label">Stok Produk Sebelum Diretur</label>
                                            <input type="text" class="form-control" id="stokLama<?= $rtb['id_retur_barang'] ?>" value="<?= $rtb['stok_lama'] + $rtb['jumlah'] ?>" data-original-value="<?= $rtb['stok_lama'] + $rtb['jumlah'] ?>" readonly > 
                                        </div>
                                        <div class="form-group">
                                            <label for="editJumlah" class="form-label">Jumlah Retur</label>
                                            <input type="text" class="form-control editJumlah" id="editJumlah<?= $rtb['id_retur_barang'] ?>" name="jumlah" value="<?= $rtb['jumlah'] ?>" data-original-value="<?= $rtb['jumlah'] ?>" > 
                                            <p class="cekstok2"></p>
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="editKeterangan<?= $rtb['id_retur_barang'] ?>" class="form-label">Keterangan</label>
                                            <input type="text" class="form-control" id="editKeterangan<?= $rtb['id_retur_barang'] ?>" name="keterangan" value="<?= $rtb['keterangan'] ?>" data-original-value="<?= $rtb['keterangan'] ?>" >
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <!-- Hidden input for the ID -->
                                        <input type="hidden" name="id" value="<?= $rtb['id_retur_barang'] ?>">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal edit -->

                    <!-- Button hapus -->
                    <button type="button" class="btn btn-danger" onclick="hapusData('<?= $rtb['id_retur_barang'] ?>')">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                </td>
            </tr>
            <?php $nilai++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($search == "no") : ?>
    <?= $pager->links() ?>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function () {
        $('.editJumlah').on('keyup', function () {
            var id = $(this).attr('id').replace('editJumlah', ''); // Mendapatkan ID retur
            cekStokEdit(id); // Memanggil fungsi cekStokEdit
        });
        $('.formEditData').on('submit', function (e) {
            e.preventDefault();
            var form = $(this); // Referensi ke form yang disubmit
            var id = form.find('.editJumlah').attr('id').replace('editJumlah', ''); 
            console.log(id);
            if(parseInt($('#editJumlah'+id).val()) > parseInt($('#stokLama'+id).val())){
                Swal.fire({
                    title: "Error!",
                    text: "Jumlah barang yang diretur melebihi stok!!!",
                    icon: "error"
                });
            }else{
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
            }
        });
    });

    function bukaModalEdit(id){
        $('#editData' + id).modal('show');
        $('.invalid-feedback').empty();
        $('.cekstok2').empty();
        $('.form-group').removeClass('has-error');
        $('.form-group').removeClass('has-feedback');
        $('.form-group .glyphicon').remove();
        $('#editData' + id + ' [data-original-value]').each(function() {
            var originalValue = $(this).data('original-value');
            $(this).val(originalValue);
        });
    }

    function cekStokEdit(id){
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/cekStokEditReturBarang') ?>",
            data: {
                id_retur: $('#retur'+id).val(),
                produk_id: $('#produk'+id).val(), 
                jumlah_retur: $('#editJumlah'+id).val()
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'gagal') {
                    $('.cekstok2').html('<div style="color: red;">' + response.message + '</div>').show();
                } else {
                    $('.cekstok2').html('<div style="color: green;">' + response.message + '</div>').show();
                }
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>