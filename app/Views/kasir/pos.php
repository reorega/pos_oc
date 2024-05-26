<?= $this->extend('layout/master')?>
<?= $this->section('content')?>
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
                    <input type="text" class="form-control form-control-sm" name="kodebarcodelangsung" id="kodebarcodelangsung"
                        autofocus>
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
                        style="text-align: right; color:blue; font-weight : bold; font-size:30pt;" value="0" readonly>
                </div>
                <div class="form-group">
                    <label for="jumlahpembayaran">Pembayaran</label>
                    <input type="number" class="form-control form-control-lg" name="jumlahpembayaran" id="jumlahpembayaran">
                </div>
                <div class="form-group">
                    <label for="kembalian">Total Kembalian</label>
                    <input type="number" class="form-control form-control-lg" name="kembalian" id="kembalian" value="0" readonly>
                </div>
                <div>
                    <button class="btn btn-danger" type="button" id="btnClearTransaksi">Clear Transaksi</button>&nbsp;
                    <button type="button" class="btn btn-success" id="btnSimpanPenjualan">Simpan Transaksi</button>
                </div>
            </div>
        </div>
    </div>
    <div class="viewmodal" style="display:none;"></div>
    <div class="viewmodalsimpanpenjualan" style="display:none;"></div>
</div>
        
        
    </section>
</div>
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
<script>
    $(document).ready(function(){
    $('body').addClass('sidebar-collapse');
    ambilData();
    ambilDataTotalHarga();
    $('#kodebarcode').keydown(function(e){
        if(e.keyCode==13){
            e.preventDefault();
            cekKode();
        }
    });
    $('#jumlahpembayaran').keydown(function(){
        hitungKembalian();
        console.log("tombol");

    });
    $('#btnSimpanPenjualan').on('click', function(){
       simpanPenjualan();
    });
    $('#jumlah').on('input', function() {
        cekStok();
    });
    $('#kodebarcodelangsung').keydown(function() {
        simpanTransaksiDetailScan();
    });
    $('#btnClearTransaksi').on('click', function(){
       clearPenjualan();
    });
});
function ambilData(){
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/ambilData') ?>",
        data: {
            nofaktur: $('#nofaktur').val(),
        },
        dataType: "json",
        success: function(response){
            if(response.data){
                $('.dataDetailPenjualan').html(response.data);
            }
            ambilDataTotalHarga();
        },
    });
}
function cekKode(){
    kode = $('#kodebarcode').val();
        if(kode.length==0){
            $.ajax({
            type: "post",
            url: "<?= site_url('kasir/cekKode') ?>",
            dataType: "json",
            success: function(response){
                $('.viewmodal').html(response.viewModal).show();
                $('#modalProduk').modal('show');
            },
            error: function(xhr, thrownError){
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        }else{
            $.ajax({
            type: "post",
            url: "<?= site_url('kasir/cekKodeIsi') ?>",
            data: {
                kode: $('#kodebarcode').val(),
            },
            dataType: "json",
            success: function(response){
                $('.viewmodal').html(response.viewModal).show();
                $('#modalProduk').modal('show');
            },
            error: function(xhr, thrownError){
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        }
}
function pilihProduk(kode_produk,nama_produk){
    $('#kodebarcode').val(kode_produk);
    $('#nama_produk').val(nama_produk);

    $('#modalProduk').modal('hide');

}
function simpanTransaksiDetail(kode){
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/simpanTransaksiDetail') ?>",
        data: {
            kode_produk: kode,
            no_faktur: $('#nofaktur').val(),
            jumlah: 1,
        },
        dataType: "json",
        success: function(response){
            ambilData();
            $('#kodebarcode').val('');
            $('#jumlah').val(1);
            $('#modalProduk').modal('hide');
        },
        error: function(xhr, thrownError){
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}
function hitungTotalHarga(nilai){
    var hargaSementara = parseInt($('#sub_total'+nilai).val());
    var totalHarga = parseInt($('#totalbayar').val());
    totalHarga+=hargaSementara;
    $('#totalbayar').val(totalHarga);
}
function ambilDataTotalHarga(){
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/ambilDataTotalHarga') ?>",
        data: {
            nofaktur: $('#nofaktur').val(),
        },
        dataType: "json",
        success: function(response){
            if(response.totalharga!=0){
                $('#totalbayar').val(response.totalharga);
            }
            else{
                $('#totalbayar').val(0);
            }
        },
    });
}
function hapusDataDetail(id){
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/hapusTransaksiDetail') ?>",
        data: {
            id_penjualan_detail: id,
        },
        dataType: "json",
        success: function(response){
            ambilData();
        },
        error: function(xhr, thrownError){
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });

}
function hitungKembalian(){
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/hitungKembalian') ?>",
        data: {
            totalbayar:$('#totalbayar').val(),
            jumlahbayar:$('#jumlahpembayaran').val(),
        },
        dataType: "json",
        success: function(response){
            if(response.kembalian){
                $('#kembalian').val(response.kembalian);
                console.log(response.totalbayar);
                console.log(response.jumlahbayar);



            }
        },
        error: function(xhr, thrownError){
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });

}
function simpanPenjualan(){
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/simpanTransaksi') ?>",
        data: {
            nofaktur:$('#nofaktur').val(),
            totalbayar:$('#totalbayar').val(),
            jumlahbayar:$('#jumlahpembayaran').val(),
            kembalian:$('#kembalian').val(),
        },
        dataType: "json",
        success: function(response){
            $('.viewmodalsimpanpenjualan').html(response.viewModal).show();
            $('#modalSimpanPenjualan').modal('show');
        },
        error: function(xhr, thrownError){
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}
function cetakNota(url, title) {
    console.log(url);
    console.log(title);

    popupCenter(url, title, 625, 500);
}
function popupCenter(url, title, width, height) {
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;
    var options = 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=' + width + ', height=' + height + ', top=' + top + ', left=' + left;
    window.open(url, title, options);
}
function cekStok(){
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/cekStok') ?>",
        data: {
            kodeProduk:$('#kodebarcode').val(),
            jumlah:$('#jumlah').val(),
        },
        dataType: "json",
        success: function(response){
            if (response.status === 'error') {
                $('#cekstok').html('<div style="color: red;">' + response.message + '</div>').show();
            } else {
                $('#cekstok').html('<div style="color: green;">' + response.message + '</div>').show();
            }
        },
        error: function(xhr, thrownError){
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}
function simpanTransaksiDetailScan(){
    jumlahUlang = 0;
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/simpanTransaksiDetail') ?>",
        data: {
            kode_produk: $('#kodebarcodelangsung').val(),
            no_faktur: $('#nofaktur').val(),
            jumlah: $('#jumlah').val(),
        },
        dataType: "json",
        success: function(response){
            jumlahUlang++;
            console.log(jumlahUlang);
            ambilData();
            ambilDataTotalHarga();
            $('#kodebarcodelangsung').val('')

        },
        error: function(xhr, thrownError){
        }
    });
}
function editSubtotal(id,kd,jmlh){
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/editSubtotal') ?>",
        data: {
            id_penjualan_detail: id,
            kode: kd,
            jumlah: jmlh,
            
        },
        dataType: "json",
        success: function(response){
            if(response.status=='error'){
                $('#cekstok2').html('<div style="color: red;">' + response.message + '</div>').show();
            }
            ambilData();
            ambilDataTotalHarga();    
        },
        error: function(xhr, thrownError){
            
        }
    });

}
function clearPenjualan(){
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/clearPenjualan') ?>",
        data: {
            nofaktur: $('#nofaktur').val(),
            
        },
        dataType: "json",
        success: function(response){
            ambilData();
            ambilDataTotalHarga();
            $('#jumlahpembayaran').val('');
            $('#kembalian').val(0)    
        },
        error: function(xhr, thrownError){
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}
</script>

<?= $this->endSection()?>
