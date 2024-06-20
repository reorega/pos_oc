<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content">
        <h2 class="active">Pengaturan Profile</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <form action="<?= base_url('/updateProfile') ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div id="success-message" class="alert alert-info alert-dismissible"
                                style="display: <?= session()->getFlashdata('success') ? 'block' : 'none' ?>;">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <i class="icon fa fa-check"></i> Perubahan berhasil disimpan,silahkan login kembali untuk menerapkan perubahan
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-lg-2 control-label">Username</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="<?= $profile['username'] ?>" required>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="foto" class="col-lg-2 control-label">Foto User</label>
                                <div class="col-lg-6">
                                    <input type="file" class="form-control" id="foto" name="foto_user"
                                        onchange="previewLogo(this)">
                                    <span class="help-block with-errors"></span>
                                    <br>
                                    <?php if (!empty($profile['foto_user'])) : ?>
                                    <img id="logoPreview" src="<?= base_url('assets/fotoUser/').$profile['foto_user'] ?>"
                                        alt="Logo Perusahaan" style="max-height: 180px;">
                                    <?php else : ?>
                                    <img id="logoPreview" src="" alt="Logo Perusahaan"
                                        style="max-height: 180px; display: none;">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-lg-2 control-label">email</label>
                                <div class="col-lg-6">
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?= $profile['email'] ?>" required>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="passworrd" class="col-lg-2 control-label">Password</label>
                                <div class="col-lg-6">
                                    <input type="password" class="form-control" id="password" name="password"
                                     value="<?= $profile['password'] ?>" required placeholder="Masukan password baru">
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?= $profile['id_user'] ?>">
                        </div>
                        <div class="box-footer text-right">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    // Fungsi untuk menampilkan pesan sukses
    function showSuccessMessage() {
        document.getElementById('success-message').style.display = 'block';
        setTimeout(function() {
            document.getElementById('success-message').style.display = 'none';
        }, 3000); // Pesan akan hilang setelah 3 detik
    }
    // Panggil fungsi showSuccessMessage jika terdapat pesan sukses
    if ('<?= session()->getFlashdata('
        success ') ?>') {
        showSuccessMessage();
    }

    function previewLogo(input) {
        const preview = document.getElementById('logoPreview');
        const file = input.files[0];
        const reader = new FileReader();
        reader.onloadend = function() {
            preview.src = reader.result;
        }
        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
</script>
<?= $this->endSection() ?>
