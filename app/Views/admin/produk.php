<?= $this->extend('layout/master')?>
<?= $this->section('content')?>
<div class="content-wrapper">
  <section class="content">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">
        <i class="fa fa-plus-square"></i>
    </button>
    <br><br>
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
                        <form action="<?= base_url('admin/tambahDataProduk');?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="kategori_id" class="form-label">Nama Kategori : </label>
                                <select class="form-control" aria-label="Default select example" name="kategori_id">
                                    <option selected disabled>Pilih Kategori Produk</option>
                                    <?php foreach ($kategori as $ktg) : ?>
                                        <option value="<?= $ktg['id_kategori']; ?>"><?= $ktg['nama_kategori']?></option>
                                    <?php endforeach; ?>                                   
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="suplier_id" class="form-label">Nama Suplier : </label>
                                <select class="form-control" aria-label="Default select example" name="suplier_id">
                                    <option selected disabled>Pilih Suplier</option>
                                    <?php foreach ($suplier as $sp) : ?>
                                        <option value="<?= $sp['id_supplier']; ?>"><?= $sp['nama']?></option>
                                    <?php endforeach; ?>                                   
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_produk" class="form-label">Nama Produk : </label>
                                <input type="text" class="form-control" id="inputUserName" name="nama_produk" >
                            </div>
                            <div class="form-group">
                                <label for="diskon" class="form-label">Diskon : </label>
                                <input type="number" class="form-control" id="inputUserName" name="diskon" step="0.01">
                            </div>
                            <div class="form-group">
                                <label for="harga_jual" class="form-label">Harga Jual : </label>
                                <input type="number" class="form-control" id="inputUserName" name="harga_jual" >
                            </div>
                            <div class="form-group">
                                <label for="stok" class="form-label">Stok : </label>
                                <input type="number" class="form-control" id="inputUserName" name="stok" >
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<table class="table table-hover mt-2 table-bordered">
  <thead class="table">
    <tr>
      <td>Kode Produk</td>
      <td>Nama Produk</td>
      <td>Diskon</td>
      <td>Harga Jual</td>
      <td>Stok</td>
      <td>Aksi</td>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($produk as $pdk) : ?>
        <tr>
            <td><?= $pdk['kode_produk'] ?></td>
            <td><?= $pdk['nama_produk'] ?></td>
            <td><?= $pdk['diskon'] ?></td>
            <td><?= $pdk['harga_jual'] ?></td>
            <td><?= $pdk['stok'] ?></td>
            <td>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#infoData<?= $pdk['id_produk'] ?>">
                  <i class="fa fa-eye"></i>
                </button>
                <div class="modal fade" id="infoData<?= $pdk['id_produk'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                          <h4 class="modal-title" id="exampleModalLabel">Info Data</h4>
                        </div>
                        <div class="modal-body">
                                <div class="form-group">
                                    <label for="" class="form-label">ID Produk : <?= $pdk['id_produk'] ?></label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Nama Kategori : <?= $pdk['kategori'] ?></label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Nama Suplier : <?= $pdk['suplier'] ?></label>                  
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Kode Produk : <?= $pdk['kode_produk'] ?></label>                  
                                </div>
                                <div class="form-group">
                                    <label for="nama_produk" class="form-label">Nama Produk : <?= $pdk['nama_produk'] ?></label>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="diskon" class="form-label">Diskon : <?= $pdk['diskon'] ?></label>
                                </div>
                                <div class="form-group">
                                    <label for="harga_jual" class="form-label">Harga Jual : <?= $pdk['harga_jual'] ?></label>
                                </div>
                                <div class="form-group">
                                    <label for="stok" class="form-label">Stok : <?= $pdk['stok'] ?></label>
                                </div>                         
                                <input type="hidden" name="id_produk" value="<?= $pdk['id_produk']?>">     
                        </div>
                      </div>
                    </div>
                  </div>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editData<?= $pdk['id_produk'] ?>">
                  <i class="fa fa-pencil"></i>
                </button>
                  <div class="modal fade" id="editData<?= $pdk['id_produk'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                          <h4 class="modal-title" id="exampleModalLabel">Edit Data</h4>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('/admin/editDataProduk');?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="kategori_id" class="form-label">Nama Kategori : </label>
                                    <select class="form-control" aria-label="Default select example" name="kategori_id">
                                        <option value="" <?= ($pdk['kategori_id']==0) ? 'selected' : ''; ?>>Pilih Kategori Produk</option>
                                        <?php foreach ($kategori as $ktg) : ?>
                                            <option value="<?= $ktg['id_kategori']; ?>" <?= ($ktg['id_kategori'] == $pdk['kategori_id']) ? 'selected' : ''; ?>><?= $ktg['nama_kategori']?></option>
                                        <?php endforeach; ?>                                   
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="suplier_id" class="form-label">Nama Suplier : </label>
                                    <select class="form-control" aria-label="Default select example" name="suplier_id">
                                        <?php foreach ($suplier as $sp) : ?>
                                            <option value="<?= $sp['id_supplier']; ?>" <?= ($sp['id_supplier'] == $pdk['suplier_id']) ? 'selected' : ''; ?>><?= $sp['nama']?></option>
                                        <?php endforeach; ?>                                   
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_produk" class="form-label">Nama Produk : </label>
                                    <input type="text" class="form-control" id="inputUserName" name="nama_produk"  value="<?= $pdk['nama_produk'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="diskon" class="form-label">Diskon : </label>
                                    <input type="number" class="form-control" id="inputUserName" name="diskon" value="<?= $pdk['diskon'] ?>" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label for="harga_jual" class="form-label">Harga Jual : </label>
                                    <input type="number" class="form-control" id="inputUserName" name="harga_jual" value="<?= $pdk['harga_jual'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="stok" class="form-label">Stok : </label>
                                    <input type="number" class="form-control" id="inputUserName" name="stok" value="<?= $pdk['stok'] ?>">
                                </div>                         
                                <input type="hidden" name="id_produk" value="<?= $pdk['id_produk']?>">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusData<?= $pdk['id_produk'] ?>">
                  <i class="fa fa-trash"></i>
                </button>
                <div class="modal fade " id="hapusData<?= $pdk['id_produk'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                          <h4 class="modal-title " id="exampleModalLabel">Hapus Data</h4>
                        </div>
                        <div class="modal-body">
                          <div>
                            <p class="">Anda Yakin Menghapus Data Produk <?= $pdk['nama_produk']?></p>
                          </div> 
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <a href="<?= base_url('/admin/hapusDataProduk/' . $pdk['id_produk']);?>" class="btn btn-danger">Hapus Data</a>
                        </div>
                      </div>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>

</section>


</div>
<?= $this->endSection()?>

