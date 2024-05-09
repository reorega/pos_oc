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
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tanggal">Aksi</label>
                    <div class="input-group">
                        <button class="btn btn-danger btn-sm" type="button" id="btnHapusTransaksi">
                            <i class="fa fa-trash"></i>
                        </button>&nbsp;
                        <button class="btn btn-success" type="button" id="btnSimpanTransaksi">
                            <i class="fa fa-save"></i>
                        </button>&nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="kodebarcode">Kode Produk</label>
                    <input type="text" class="form-control form-control-sm" name="kodebarcode" id="kodebarcode"
                        autofocus>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" class="form-control form-control-sm " name="nama_produk" id="nama_produk"
                        disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="jml">Jumlah</label>
                    <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah" value="1">
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
                    <input type="number" class="form-control form-control-lg" name="kembalian" id="kembalian" readonly>
                </div>
                <div>
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
    $('#btnSimpanTransaksi').on('click', function(){
       //console.log("Tombol diklik");
        
        simpanTransaksiDetail();
        //var kode_produk= $('#kodebarcode').val();
        //var no_faktur= $('#nofaktur').val();
        //var jumlah = $('#jumlah').val();
       // console.log(no_faktur);

    });
    $('#btnSimpanPenjualan').on('click', function(){
       simpanPenjualan();
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
function simpanTransaksiDetail(){
    jumlahUlang = 0;
    $.ajax({
        type: "post",
        url: "<?= site_url('kasir/simpanTransaksiDetail') ?>",
        data: {
            kode_produk: $('#kodebarcode').val(),
            no_faktur: $('#nofaktur').val(),
            jumlah: $('#jumlah').val(),
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
            if(response.totalharga){
                $('#totalbayar').val(response.totalharga);
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

</script>

<?= $this->endSection()?>