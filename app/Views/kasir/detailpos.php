<table class="table table-hover mt-2 table-bordered">
  <thead class="table">
    <tr>
      <td>No</td>
      <td>Nama Produk</td>
      <td>Diskon</td>
      <td>Harga Jual</td>
      <td>Qty</td>
      <td>SubTotal</td>
      <td>Aksi</td>
    </tr>
  </thead>
  <tbody>
    <?php $nilai =1;?>
        <?php foreach ($datadetail as $pdk) : ?>
            <tr>
                <td><?= $nilai;  ?></td>
                <td><?= $pdk['produk'] ?></td>
                <td><?= $pdk['diskon'] ?></td>
                <td><?= number_format($pdk['harga_jual'],0,",",".") ?></td>
                <td>
                  <div class="row">
                      <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="jumlahdetail" id="jumlahdetail" value="<?= $pdk['jumlah'] ?>" oninput="cekStok2('<?= $pdk['id_penjualan_detail'] ?>','<?= $pdk['kode_produk'] ?>',this.value)">
                        <div id="cekstok2" style="display:none;"></div>
                      </div>
                  </div>
                </td>
                <td><?= number_format($pdk['sub_total'],0,",",".") ?></td>
                <td>
                  <button class="btn btn-danger btn-sm btnhapus" type="button" id="btnHapusTransaksi<?=$nilai?>" onclick="hapusDataDetail('<?= $pdk['id_penjualan_detail'] ?>')">
                    <i class="fa fa-trash"></i>
                  </button>
                </td>

            </tr>
           <?php $nilai++; ?>
        <?php endforeach;?>
    </tbody>
</table>
