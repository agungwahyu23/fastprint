<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bootstrap demo</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<h1>Data Produk</h1>
		<a href="<?= site_url('product/create') ?>" class="btn btn-primary">Tambah Data</a>
		<table class="table mt-4">
			<thead>
				<tr>
					<th scope="col">Nama Produk</th>
					<th scope="col">Harga</th>
					<th scope="col">Kategori</th>
					<th scope="col">Status</th>
					<th scope="col">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($products as $key => $value) {?>
					<tr>
						<td><?= $value['nama_produk'] ?></td>
						<td><?= $value['harga'] ?></td>
						<td><?= $value['nama_kategori'] ?></td>
						<td><?= $value['nama_status'] ?></td>
						<td>
							<a href="<?= site_url('product/edit/'.$value['id_produk']) ?>" class="btn btn-sm btn-warning">Edit</a>
							<a href="<?= site_url('product/delete/'.$value['id_produk']) ?>" onclick="return confirm('Yakin hapus data?');" class="btn btn-sm btn-danger">Hapus</a>
						</td>
					</tr>
				<?php } ?>
				
			</tbody>
		</table>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js">
	</script>
</body>

</html>