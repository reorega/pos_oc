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
                <th>Username</th>
                <th>Level</th>
                <th>Foto User</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nilai = $no ?? 1; ?>
            <?php foreach ($users as $user) : ?>
            <?php if ($user['level_users'] != 1): ?>
            <tr class="text-center">
                <td><?= $nilai ?></td>
                <td><?= ($user['username']) ?></td>
                <?php $level = ($user['level_users'] == 2) ? "Kasir" : "Unknown"; ?>
                <td><?= ($level) ?></td>
                <td>
                    <img src="<?= base_url('/assets/fotoUser/' . ($user['foto_user'])); ?>" width="50" height="50">
                </td>
                <td>
                    <button type="button" class="btn btn-warning" onclick="bukaModalEdit('<?= ($user['id_user']) ?>')">
                        <i class="fa fa-pencil"></i> Edit
                    </button>
                    <!-- Modal for editing data -->
                    <div class="modal fade text-left" id="editData<?= ($user['id_user']) ?>" tabindex="-1"
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
                                    <form id="formEditData<?= $user['id_user'] ?>"
                                        action="<?= base_url('/admin/editData') ?>" method="post"
                                        enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="inputUserName<?= $user['id_user'] ?>">Username</label>
                                            <input type="text" class="form-control"
                                                id="inputUserName<?= $user['id_user'] ?>" name="username"
                                                value="<?= $user['username'] ?>">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail<?= $user['id_user'] ?>">Email</label>
                                            <input type="email" class="form-control"
                                                id="inputEmail<?= $user['id_user'] ?>" name="email"
                                                value="<?= $user['email'] ?>">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword<?= $user['id_user'] ?>">Password</label>
                                            <input type="password" class="form-control"
                                                id="inputPassword<?= $user['id_user'] ?>" name="password"
                                                value="<?= $user['password'] ?>">
                                            <p class="invalid-feedback text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile<?= $user['id_user'] ?>">Foto User</label>
                                            <input class="form-control" type="file" id="formFile<?= $user['id_user'] ?>"
                                                name="foto_user"
                                                onchange="previewEditFoto(this, 'editFotoPreview<?= $user['id_user'] ?>')">
                                            <br>
                                            <img id="editFotoPreview<?= $user['id_user'] ?>"
                                                src="<?= base_url('/assets/fotoUser/' . $user['foto_user']) ?>"
                                                alt="Foto User" style="max-height: 150px;">
                                        </div>
                                        <input type="hidden" name="id" value="<?= $user['id_user'] ?>">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" onclick="hapusData('<?= ($user['id_user']) ?>')">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                </td>
            </tr>
            <?php $nilai++; ?>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($search == "no") : ?>
    <?= $pager->links(); ?>
    <?php endif; ?>
</div>

<script>
function bukaModalEdit(id_user) {
    $.ajax({
        type: "POST",
        url: "<?= site_url('/admin/getUserData') ?>",
        data: { id: id_user },
        dataType: "json",
        success: function(response) {
            $('#inputUserName' + id_user).val(response.user.username);
            $('#inputEmail' + id_user).val(response.user.email);
            $('#inputPassword' + id_user).val(response.user.password);
            $('#editFotoPreview' + id_user).attr('src', '<?= base_url('assets/fotoUser/') ?>' + response.user.foto_user).show();
            $('#editData' + id_user).modal('show');
        },
        error: function(xhr, thrownError) {
            console.error('Error:', xhr.status, xhr.responseText, thrownError);
            alert('Failed to fetch user data. Please try again.');
        }
    });
}

$('form[id^="formEditData"]').on('submit', function(e) {
    e.preventDefault();
    const formId = $(this).attr('id');
    const userId = formId.replace('formEditData', '');
    $.ajax({
        url: '<?= base_url('/admin/editData') ?>',
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#editData' + userId).modal('hide');
                ambilData($('#page').val());
                Swal.fire(
                    'Tersimpan!',
                    'Data berhasil diperbarui.',
                    'success'
                );
            } else {
                $('.invalid-feedback').empty(); // Clear previous errors
                $('.form-group').removeClass('has-error has-feedback'); // Remove previous error classes
                $.each(response.errors, function(field, message) {
                    var element = $('[name=' + field + ']');
                    element.closest('.form-group').addClass('has-error has-feedback');
                    element.next('.invalid-feedback').text(message);
                });
            }
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
});

function previewEditFoto(input, idPreview) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#' + idPreview).attr('src', e.target.result).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
