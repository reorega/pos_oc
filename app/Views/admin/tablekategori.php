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
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nilai = $no ?? 1;?>
            <?php foreach ($kategori as $kat) : ?>
            <tr class="text-center">
                <td><?= $nilai ?></td>
                <td><?= $kat['nama_kategori'] ?></td>
                <td>
                    <button type="button" class="btn btn-warning" onclick="bukaModalEdit('<?= $kat['id_kategori'] ?>')">
                        <i class="fa fa-pencil"></i> Edit
                    </button>
                    <div class="modal fade text-left" id="editData<?= $kat['id_kategori'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="exampleModalLabel">Edit Data</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="<?= site_url('/admin/editDataKategori') ?>" enctype="multipart/form-data" method="post" class="formEditData">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <label for="editNamaKategori<?= $kat['id_kategori'] ?>" class="control-label">Nama Kategori</label>
                                            <input type="text" class="form-control" id="editNamaKategori<?= $kat['id_kategori'] ?>" name="nama_kategori" value="<?= $kat['nama_kategori'] ?>" data-original-value="<?= $kat['nama_kategori'] ?>">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <input type="hidden" name="id" value="<?= $kat['id_kategori'] ?>">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="hapusData('<?= $kat['id_kategori'] ?>')">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                </td>
            </tr>
            <?php $nilai++ ;?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($search == "no") : ?>
    <?= $pager->links(); ?>
    <?php endif; ?>
</div>
<script>
    $(document).ready(function () {
        $('.formEditData').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    $('.invalid-feedback').empty();
                    $('.form-group').removeClass('has-error has-feedback');
                    $('.form-group .glyphicon').remove();

                    if (response.success) {
                        $('.modal').modal('hide');
                        ambilData($('#page').val());
                        Swal.fire('Tersimpan!', 'Data berhasil diubah.', 'success');
                    } else {
                        $.each(response.errors, function (field, message) {
                            var element = $('[name=' + field + ']');
                            element.closest('.form-group').addClass('has-error has-feedback');
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

    function bukaModalEdit(id) {
        $('#editData' + id).modal('show');
        $('.invalid-feedback').empty();
        $('.form-group').removeClass('has-error has-feedback');
        $('.form-group .glyphicon').remove();
        $('#editData' + id + ' [data-original-value]').each(function() {
            var originalValue = $(this).data('original-value');
            $(this).val(originalValue);
        });
    }

    function hapusData(id) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Kamu tidak dapat mengembalikan datanya.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('/admin/hapusDataKategori') ?>",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(response) {
                        ambilData($('#page').val());
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }
</script>
