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
                <th>Kode Supplier</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nilai = $no ?? 1; ?>
            <?php foreach ($supplier as $sup) : ?>
            <tr class="text-center">
                <td><?= $nilai ?></td>
                <td><?= $sup['kode_supplier'] ?></td>
                <td><?= $sup['nama'] ?></td>
                <td><?= $sup['alamat'] ?></td>
                <td><?= $sup['telepon'] ?></td>
                <td>
                    <!-- Tombol Edit -->
                    <button type="button" class="btn btn-warning" onclick="bukaModalEdit('<?= $sup['id_supplier'] ?>')">
                        <i class="fa fa-pencil"></i> Edit
                    </button>
                    <div class="modal fade text-left" id="editData<?= $sup['id_supplier'] ?>" tabindex="-1"
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
                                    <form action="<?= site_url('/admin/editDataSupplier') ?>"
                                        enctype="multipart/form-data" class="formEditData">
                                        <input type="hidden" name="id_supplier" id="id<?= $sup['id_supplier'] ?>"
                                            value="<?= $sup['id_supplier'] ?>">
                                        <div class="form-group">
                                            <label for="editNamaSupplier<?= $sup['id_supplier'] ?>"
                                                class="form-label">Nama Supplier</label>
                                            <input type="text" class="form-control"
                                                id="editNamaSupplier<?= $sup['id_supplier'] ?>" name="nama"
                                                value="<?= $sup['nama'] ?>">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="editAlamat<?= $sup['id_supplier'] ?>"
                                                class="form-label">Alamat</label>
                                            <input type="text" class="form-control"
                                                id="editAlamat<?= $sup['id_supplier'] ?>" name="alamat"
                                                value="<?= $sup['alamat'] ?>">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="editTelepon<?= $sup['id_supplier'] ?>"
                                                class="form-label">Telepon</label>
                                            <input type="text" class="form-control"
                                                id="editTelepon<?= $sup['id_supplier'] ?>" name="telepon"
                                                value="<?= $sup['telepon'] ?>">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tombol Hapus -->
                    <button type="button" class="btn btn-danger" onclick="hapusData('<?= $sup['id_supplier'] ?>')">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
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
    $(document).ready(function() {
        // Handling form submissions
        $('.formEditData').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $('#responseMessage').empty();
                    $('.invalid-feedback').empty();
                    $('.is-invalid').removeClass('is-invalid');
                    if (response.success) {
                        $('.modal').modal('hide');
                        ambilData($('#page').val());
                        Swal.fire(
                            'Tersimpan!',
                            'Data berhasil diubah.',
                            'success'
                        );
                    } else {
                        $.each(response.errors, function(field, message) {
                            var element = $('[name=' + field + ']');
                            element.closest('.form-group').addClass('has-error');
                            element.closest('.form-group').addClass('has-feedback');
                            element.next('.invalid-feedback').text(message);
                            element.after(
                                '<span class="glyphicon glyphicon-warning-sign form-control-feedback text-danger"></span>'
                                );
                        });
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });

    function bukaModalEdit(id) {
        $('#editData' + id).modal('show');
        $('.invalid-feedback').empty();
        $('.form-group').removeClass('has-error');
        $('.form-group').removeClass('has-feedback');
        $('.form-group .glyphicon').remove();
        // Resetting form fields to original values if needed
        $('#editData' + id + ' [data-original-value]').each(function() {
            var originalValue = $(this).data('original-value');
            $(this).val(originalValue);
        });
    }
</script>