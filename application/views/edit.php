<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error {
            color: red;
            font-size: 0.875em;
        }
    </style>
</head>
<body>
    <h2 class="text-center">Form Edit </h2>
  <div class="container">
  	<form action="<?= site_url('product/update') ?>" method="POST" enctype="multipart/form-data">
      <input type="hidden" class="form-control" id="id_produk" value="<?= $product->id_produk ?>" name="id_produk">
  		<div class="row mt-4">
  			<div class="col-md-6 col-lg-6 col-sm-12 mt-3">
  				<label for="nama_produk">Nama Produk</label>
  				<input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Produk" value="<?= $product->nama_produk ?>">
                <div class="error"><?php echo form_error('nama_produk'); ?></div>
  			</div>
  			<div class="col-md-6 col-lg-6 col-sm-12 mt-3">
  				<label for="harga">Harga</label>
  				<input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?= $product->harga ?>">
                  <div class="error"><?php echo form_error('harga'); ?></div>
  			</div>
  			<div class="col-md-6 col-lg-6 col-sm-12 mt-3">
  				<label for="kategori_id">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select">
                    <?php foreach ($kategori as $key => $value) { ?>
                        <option value="<?= $value['id_kategori'] ?>"
                        <?= $value['id_kategori'] == $product->kategori_id ? "selected" : null ?>
                        >
                            <?= $value['nama_kategori'] ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="error"><?php echo form_error('kategori_id'); ?></div>
  			</div>
  			<div class="col-md-6 col-lg-6 col-sm-12 mt-3">
              <label for="status_id">Status</label>
                <select name="status_id" id="status_id" class="form-select">
                    <?php foreach ($status as $key => $value) { ?>
                        <option value="<?= $value['id_status'] ?>"
                        <?= $value['id_status'] == $product->status_id ? 'selected' : null ?>
                        >
                            <?= $value['nama_status'] ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="error"><?php echo form_error('status_id'); ?></div>
  			</div>
  		</div>
  		<button type="submit" class="btn btn-primary mt-3">Simpan</button>
  		<a href="<?= base_url('product/index') ?>" class="btn btn-warning mt-3">Batal</a>
  	</form>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>