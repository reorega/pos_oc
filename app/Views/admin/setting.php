<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content">
        <?php
            $pengaturan = $pengaturans[0];
        ?>
        <h2 class="active">Pengaturan</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <form action="/admin/update" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div id="success-message" class="alert alert-info alert-dismissible"
                                style="display: <?= session()->getFlashdata('success') ? 'block' : 'none' ?>;">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <i class="icon fa fa-check"></i> Perubahan berhasil disimpan
                            </div>
                            <div class="form-group row">
                                <label for="nama_perusahaan" class="col-lg-2 control-label">Nama Perusahaan</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                                        value="<?= $pengaturan['nama_perusahaan'] ?>" required>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="path_logo" class="col-lg-2 control-label">Logo Perusahaan</label>
                                <div class="col-lg-6">
                                    <input type="file" class="form-control" id="path_logo" name="path_logo"
                                        onchange="previewLogo(this)">
                                    <span class="help-block with-errors"></span>
                                    <br>
                                    <?php if (!empty($pengaturan['path_logo'])) : ?>
                                    <img id="logoPreview" src="<?= base_url().$pengaturan['path_logo'] ?>"
                                        alt="Logo Perusahaan" style="max-height: 180px;">
                                    <?php else : ?>
                                    <img id="logoPreview" src="" alt="Logo Perusahaan"
                                        style="max-height: 180px; display: none;">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="alamat" class="col-lg-2 control-label">Alamat</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                        value="<?= $pengaturan['alamat'] ?>" required>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon" class="col-lg-2 control-label">Telepon</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="telepon" name="telepon"
                                        value="<?= $pengaturan['telepon'] ?>" required>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
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