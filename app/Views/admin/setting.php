<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content">
        <?php
            $pengaturan = $setting[0];
        ?>
        <h3>Pengaturan</h3>
        <div class="box">
            <div class="card">
                <div class="card-body">
                    <form action="/admin/update" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                                value="<?= $pengaturan['nama_perusahaan'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="path_logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="path_logo" name="path_logo"
                                value="<?= $pengaturan['path_logo'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="<?= $pengaturan['alamat'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon"
                                value="<?= $pengaturan['telepon'] ?>">
                        </div>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>