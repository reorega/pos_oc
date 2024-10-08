<style>
  thead tr{
    background-color: #343a40;
    color: #ffffff;
    position: sticky;
    top: 0;
    z-index: 1;
  }
</style>

<div class="table-wrapper">
  <table class="table table-hover mt-2 table-bordered">
    <thead class="table">
      <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Diskon</th>
        <th>Harga Jual</th>
        <th>Qty</th>
        <th>SubTotal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $nilai =1;?>
      <?php foreach ($datadetail as $pdk) : ?>
      <tr>
        <td><?= $nilai;  ?></td>
        <td><?= $pdk['produk'] ?></td>
        <td><?= number_format($pdk['diskon'],0,',','.') ?>%</td>
        <td>Rp <?= number_format($pdk['harga_jual'],0,",",".") ?></td>
        <td>
          <div class="row">
            <div class="col-md-3">
              <input type="text" class="form-control form-control-sm" name="jumlahdetail" id="jumlahdetail"
                value="<?= $pdk['jumlah'] ?>"
                oninput="cekStok2('<?= $pdk['id_penjualan_detail'] ?>','<?= $pdk['kode_produk'] ?>',this.value)">
              <div id="cekstok2<?= $pdk['kode_produk'] ?>" style="display:none;"></div>
            </div>
          </div>
        </td>
        <td>Rp <?= number_format($pdk['sub_total'],0,",",".") ?></td>
        <td>
          <button class="btn btn-danger btn-sm btnhapus" type="button" id="btnHapusTransaksi<?=$nilai?>"
            onclick="hapusDataDetail('<?= $pdk['id_penjualan_detail'] ?>')">
            <i class="fa fa-trash"></i>
          </button>
        </td>
      </tr>
      <?php $nilai++; ?>
      <?php endforeach;?>
    </tbody>
  </table>
</div>