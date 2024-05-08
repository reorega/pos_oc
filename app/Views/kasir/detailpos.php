<table class="table table-hover mt-2 table-bordered">
  <thead class="table-dark">
    <tr>
      <td>Kode Produk</td>
      
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
                <td><?= $pdk['kode_produk'] ?></td>
                <td><?= $pdk['diskon'] ?></td>
                <td><?= $pdk['harga_jual'] ?></td>
                <td><?= $pdk['jumlah'] ?></td>
                <td><?= $pdk['sub_total'] ?></td>
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
