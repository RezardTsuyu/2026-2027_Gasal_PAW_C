<?php 
require "koneksi.php";
require "helper.php";
require "barangProses.php";

$notifikasi = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_id'])) {
	$notifikasi = hapusBarang($conn, $_POST['hapus_id']);
}
$result = ambilDaftarBarang($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Data Barang</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="nav">
		<a href="index.php">Transaksi</a>
		<a href="barang.php">Data Barang</a>
	</div>
	<?php if (!empty($notifikasi)): ?>
		<p class="notif"><strong><?= e($notifikasi); ?></strong></p>
	<?php endif; ?>
	<div class="container">
		<h1>Data Barang</h1>
		<form method="post">
		<table cellspacing="0" cellpadding="5">
			<thead>
				<tr>
					<th>No</th>
					<th>Kode</th>
					<th>Nama Barang</th>
					<th>Harga</th>
					<th>Stok</th>
					<th>Supplier</th>
					<th>Dipakai di</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1; ?>
				<?php foreach ($result as $data) : ?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= e($data["kode_barang"]); ?></td>
						<td><?= e($data["nama_barang"]); ?></td>
						<td><?= rupiah($data["harga"]); ?></td>
						<td><?= (int)$data["stok"]; ?></td>
						<td><?= e($data["supplier"]); ?></td>
						<td align="center"><?= (int)$data["dipakai"]; ?> transaksi</td>
						<td align="center">
							<button type="submit" name="hapus_id" value="<?= (int)$data["id"]; ?>" onclick="return confirm('Hapus barang ini?')">Hapus</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</form>
	</div>
</body>
</html>