<?= $this->extend('layout/master') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card card-default color-palette-box my-3">
            <div class="card-header">
                <h3 class="card-title">
                    Transaksi
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nofaktur">Faktur</label>
                            <input type="text" class="form-control form-control-sm" style="color:red;font-weight:bold;"
                                name="nofaktur" id="nofaktur" readonly value="<?= $faktur; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" readonly
                                value="<?= date('Y-m-d'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="kodebarcodelangsung">Scan Barcode</label>
                            <input type="text" class="form-control form-control-sm" name="kodebarcodelangsung"
                                id="kodebarcodelangsung" autofocus>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="kodebarcode">Cari Produk</label>
                            <input type="text" class="form-control form-control-sm" name="kodebarcode" id="kodebarcode"
                                autofocus>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 dataDetailPenjualan">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="totalbayar">Total Bayar</label>
                            <input type="text" class="form-control form-control-lg" name="totalbayar" id="totalbayar"
                                style="text-align: right; color:blue; font-weight : bold; font-size:30pt;" value="Rp 0"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="jumlahpembayaran">Pembayaran</label>
                            <input type="text" class="form-control form-control-lg" name="jumlahpembayaran"
                                id="jumlahpembayaran">
                        </div>
                        <div class="form-group">
                            <label for="kembalian">Total Kembalian</label>
                            <input type="text" class="form-control form-control-lg" name="kembalian" id="kembalian"
                                value="Rp 0" readonly>
                        </div>
                        <div>
                            <button class="btn btn-danger" type="button" id="btnClearTransaksi">Clear
                                Transaksi</button>&nbsp;
                            <button type="button" class="btn btn-success" id="btnSimpanPenjualan">Simpan
                                Transaksi</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="viewmodal" style="display:none;"></div>
            <div class="viewmodalsimpanpenjualan" style="display:none;"></div>
        </div>
    </section>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/sweetalert2.js'); ?>"></script>
<script>
$(document).ready(function() {
    $('body').addClass('sidebar-collapse');
    ambilData();
    ambilDataTotalHarga();

    $('#kodebarcode').keydown(function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            cekKode();
        }
    });

    $('#jumlahpembayaran').on('input', function() {
        let jumlahPembayaran = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(formatRupiah(jumlahPembayaran));
        hitungKembalian();
    });

    $('#btnSimpanPenjualan').on('click', function() {
        simpanPenjualan();
    });

    $('#kodebarcodelangsung').keydown(function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            simpanTransaksiDetailScan();
        }
    });

    $('#btnClearTransaksi').on('click', function() {
        clearPenjualan();
    });
});

function formatRupiah(angka) {
    let isNegative = angka < 0;
    angka = Math.abs(angka);

    let reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    
    return (isNegative ? '- Rp ' : 'Rp ') + ribuan;
}

function ambilData() {
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/ambilData') ?>",
        data: {
            nofaktur: $('#nofaktur').val(),
        },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.dataDetailPenjualan').html(response.data);
            }
            ambilDataTotalHarga();
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function cekKode() {
    let kode = $('#kodebarcode').val();
    let url = kode.length === 0 ? "<?= site_url('kasir/cekKode') ?>" : "<?= site_url('kasir/cekKodeIsi') ?>";
    let data = kode.length === 0 ? {} : { kode: kode };

    $.ajax({
        type: "post",
        url: url,
        data: data,
        dataType: "json",
        success: function(response) {
            if (response.status === 'error') {
                Swal.fire({ title: "Error!", text: "Stok Produk tersebut kosong!", icon: "info" });
            }
            $('.viewmodal').html(response.viewModal).show();
            $('#modalProduk').modal('show');
            $('#kodebarcode').val('');
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function pilihProduk(kode_produk, nama_produk) {
    $('#kodebarcode').val(kode_produk);
    $('#nama_produk').val(nama_produk);
    $('#modalProduk').modal('hide');
}

function simpanTransaksiDetail(kode) {
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/simpanTransaksiDetail') ?>",
        data: {
            kode_produk: kode,
            no_faktur: $('#nofaktur').val(),
            jumlah: 1,
        },
        dataType: "json",
        success: function(response) {
            ambilData();
            $('#kodebarcode').val('');
            $('#modalProduk').modal('hide');
            $('#kodebarcodelangsung').focus();
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function hitungTotalHarga(nilai) {
    let hargaSementara = parseInt($('#sub_total' + nilai).val().replace(/[^0-9]/g, ''), 10);
    let totalHarga = parseInt($('#totalbayar').val().replace(/[^0-9]/g, ''), 10) || 0;
    totalHarga += hargaSementara;
    $('#totalbayar').val(formatRupiah(totalHarga));
}

function ambilDataTotalHarga() {
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/ambilDataTotalHarga') ?>",
        data: { nofaktur: $('#nofaktur').val() },
        dataType: "json",
        success: function(response) {
            $('#totalbayar').val(formatRupiah(response.totalharga || 0));
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function hapusDataDetail(id) {
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/hapusTransaksiDetail') ?>",
        data: {
            id_penjualan_detail: id,
        },
        dataType: "json",
        success: function(response) {
            ambilData();
            $('#kodebarcodelangsung').focus();
            hitungKembalian();
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function hitungKembalian() {
    let totalBayar = $('#totalbayar').val().replace(/[^0-9]/g, '');
    let jumlahBayar = $('#jumlahpembayaran').val().replace(/[^0-9]/g, '');
    
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/hitungKembalian') ?>",
        data: {
            totalbayar: totalBayar,
            jumlahbayar: jumlahBayar
        },
        dataType: "json",
        success: function(response) {
            if (response.kembalian) {
                $('#kembalian').val(formatRupiah(response.kembalian));
            }
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function simpanPenjualan() {
    if ($('#jumlahpembayaran').val() === "") {
        Swal.fire({ title: "Error!", text: "Belum ada pembayaran!", icon: "info" });
    } else {
        $.ajax({
            type: "post",
            url: "<?= site_url('kasir/simpanTransaksi') ?>",
            data: {
                nofaktur: $('#nofaktur').val(),
                totalbayar: $('#totalbayar').val().replace(/[^0-9]/g, ''),
                jumlahbayar: $('#jumlahpembayaran').val().replace(/[^0-9]/g, ''),
                kembalian: $('#kembalian').val().replace(/[^0-9]/g, '')
            },
            dataType: "json",
            success: function(response) {
                $('.viewmodalsimpanpenjualan').html(response.viewModal).show();
                $('#modalSimpanPenjualan').modal('show');
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
}

function cetakNota(url, title) {
    popupCenter(url, title, 625, 500);
}

function popupCenter(url, title, width, height) {
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;
    var options =
        'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=' +
        width + ', height=' + height + ', top=' + top + ', left=' + left;
    window.open(url, title, options);
}

function cekStok2(id, kode, jumlah) {
    if(jumlah == ""){
        jumlah=0;
    }
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/cekStok') ?>",
        data: {
            kodeProduk: kode,
            jumlah: jumlah,
        },
        dataType: "json",
        success: function(response) {
            if (response.status === 'error') {
                $('#cekstok2'+kode).html('<div style="color: red;">' + response.message + '</div>').show();
            } else {
                $('#cekstok2'+kode).html('<div style="color: green;">' + response.message + '</div>').show();
                editSubtotal(id, kode, jumlah);
            }
        },
        error: function(xhr, thrownError) {
            // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function simpanTransaksiDetailScan() {
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/simpanTransaksiDetail') ?>",
        data: {
            kode_produk: $('#kodebarcodelangsung').val(),
            no_faktur: $('#nofaktur').val(),
            jumlah: 1,
        },
        dataType: "json",
        success: function(response) {
            if (response.status == 'error') {
                Swal.fire({ title: "Error!", text: "Stok Produk tersebut kosong!", icon: "info" });
            }
            if (response.status == 'kosong') {
                Swal.fire({ title: "Error!", text: "Produk Tidak Ditemukan", icon: "info" });
            }
            ambilData();
            ambilDataTotalHarga();
            $('#kodebarcodelangsung').val('');
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function editSubtotal(id, kd, jmlh) {
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/editSubtotal') ?>",
        data: {
            id_penjualan_detail: id,
            kode: kd,
            jumlah: jmlh,
        },
        dataType: "json",
        success: function(response) {
            ambilData();
            ambilDataTotalHarga();
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function clearPenjualan() {
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/clearPenjualan') ?>",
        data: {
            nofaktur: $('#nofaktur').val(),
        },
        dataType: "json",
        success: function(response) {
            ambilData();
            ambilDataTotalHarga();
            $('#jumlahpembayaran').val('');
            $('#kembalian').val('Rp 0');
            $('#kodebarcodelangsung').focus();
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}
</script>
<?= $this->endSection() ?>