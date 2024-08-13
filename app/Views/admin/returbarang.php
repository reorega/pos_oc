<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tabel Retur Barang
        </h1>
    </section>
    <input type="hidden" id="page" value="1">
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-9">
                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="bukaModalTambah()">
                            <i class="fa fa-plus-square"></i> Tambah Data
                        </button>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon bg-primary"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Pencarian">
                        </div>
                    </div>
                </div>
                <br>
                <div class="dataReturBarang"></div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah Data Retur Barang -->
<div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('admin/tambahDataReturBarang') ?>" method="post" id="formTambahData">
                    <div class="form-group">
                        <label for="produk_id" class="form-label">Nama Produk</label>
                        <select class="form-control selectpicker" name="produk_id" id="produk" data-live-search="true">
                            <option selected disabled>Pilih Produk</option>
                            <?php foreach ($produk as $pdk) : ?>
                                <option value="<?= $pdk['id_produk']; ?>"><?= $pdk['nama_produk'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="invalid-feedback text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label for="inputJumlah" class="form-label">Jumlah Retur</label>
                        <input type="text" class="form-control" id="inputJumlah" name="jumlah">
                        <p class="invalid-feedback text-danger"></p>
                    </div>
                    <div class="form-group">
                        <label for="inputKeterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="inputKeterangan" name="keterangan">
                        <p class="invalid-feedback text-danger"></p>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/sweetalert2.js'); ?>"></script>
<script>
    $(document).ready(function() {
        var page = $('#page').val();
        ambilData();
        $('#search').keyup(function() {
            ambilData();
        });
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            ambilData(page);
        });

        $('#formTambahData').on('submit', function (e) {
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

                    if (response.success) {
                        $('#tambahData').modal('hide');
                        ambilData($('#page').val());
                        Swal.fire(
                            'Tersimpan!',
                            'Data berhasil ditambahkan.',
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

    function ambilData(page = 1) {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/ambilDataReturBarang') ?>",
            data: {
                search: $('#search').val(),
                page: page,
            },
            dataType: "json",
            success: function(response) {
                if (response.table) {
                    $('.dataReturBarang').html(response.table);
                    $('#page').val(page);
                    $('.selectpicker').selectpicker();
                }
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function tambahData() {
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/tambahDataReturBarang') ?>",
            data: {
                produk_id: $('#produk').val(), 
                total_item: $('#inputJumlah').val(),
                keterangan: $('#inputKeterangan').val(), 
            },
            dataType: "json",
            success: function (response) {
                ambilData($('#page').val());
                $('#tambahData').modal('hide');
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function editData(id_retur_barang) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/admin/editDataReturBarang') ?>",
            data: {
                id_retur_barang: id_retur_barang,
                produk_id: $('#editProduk' + id_retur_barang).val(),
                jumlah: $('#editJumlah' + id_retur_barang).val(),
                keterangan: $('#editKeterangan' + id_retur_barang).val(),
            },
            dataType: "json",
            success: function (response) {
                ambilData($('#page').val());
                $('#editData' + id_retur_barang).modal('hide');
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function hapusData(id_retur_barang) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "kamu tidak dapat mengembalikan datanya",
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
            url: "<?= site_url('/admin/hapusDataReturBarang') ?>",
            data: {
                id: id_retur_barang,
            },
            dataType: "json",
                    success: function (response) {
                        if(response.success){
                            Swal.fire(
                            'Berhasil!',
                            'Data berhasil dihapus',
                            'success'
                        );
                        ambilData($('#page').val());
                        $('#hapusData' + id_retur_barang).modal('hide');
                        }
                    },
                    error: function (xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }

    function bukaModalTambah() {
        $('#tambahData').modal('show');
        $('.invalid-feedback').empty();
        $('.is-invalid').removeClass('is-invalid');
    }
</script>
<?= $this->endSection() ?>
