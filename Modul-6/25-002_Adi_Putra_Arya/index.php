<?php 
require "koneksi.php";
require "helper.php";
require "transaksiDetailProses.php"; // harus sebelum transaksiProses.php karena hitungTotal() dipakai di sana
require "transaksiProses.php";

$id_terpilih  = isset($_GET['id']) ? (int)$_GET['id'] : null;
$id_detail_terpilih  = isset($_GET['id_detail']) ? (int)$_GET['id_detail'] : null; // = barang_id pada baris detail yang sedang diedit
$aksi         = isset($_GET['aksi']) ? $_GET['aksi'] : null;
$notifikasi   = "";
$resultDetail = [];
$resultBarang = [];
$resultPelanggan = [];
$headerTransaksi = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST["hapus_id"])) {
		$notifikasi = hapusTransaksi($conn, $_POST["hapus_id"]);
		$aksi = '';
	} elseif (isset($_POST['hapus_detail_id'])) {
		// Dicek lebih awal dari aksi lain, supaya tombol Hapus detail tetap bekerja
		// walaupun halaman sedang dalam mode edit detail (aksi=editDetail di URL).
		$id_terpilih = (int)($_POST["transaksi_id"] ?? 0);
		$notifikasi = hapusDetailTransaksi($conn, $_POST);
		$aksi = "detailTransaksi";
	} elseif ($aksi == "tambahTransaksi") {
		$notifikasi = tambahTransaksi($conn, $_POST);
		$aksi = '';
	} elseif ($aksi == "editTransaksi") {
		$notifikasi = editTransaksi($conn, $_POST);
		$aksi = '';
	}elseif($aksi == "tambahDetail"){
		$id_terpilih = (int)($_POST["transaksi_id"] ?? 0);
		$notifikasi = tambahDetailTransaksi($conn, $_POST);
		$aksi = "detailTransaksi";
	}elseif($aksi == "editDetail"){
		$id_terpilih = (int)($_POST["transaksi_id"] ?? 0);
		$notifikasi = editDetailTransaksi($conn, $_POST);
		$aksi = "detailTransaksi";
	}
}

// Pelanggan hanya dibutuhkan saat form tambah / edit transaksi tampil (untuk dropdown).
if (in_array($aksi, ["tambahTransaksi", "editTransaksi"], true)) {
	$resultPelanggan = ambilPelanggan($conn);
}

// Data detail dimuat SETELAH proses POST di atas, jadi tampilan (termasuk total) selalu data terbaru.
if ($id_terpilih && in_array($aksi, ["detailTransaksi", "editDetail"], true)) {
	$headerTransaksi = ambilTransaksiById($conn, $id_terpilih);
	if ($headerTransaksi) {
		$resultDetail = ambilDetailTransaksi($conn, $id_terpilih);
		$resultBarang = ambilBarang($conn);
	} else {
		$notifikasi = "Transaksi dengan ID " . $id_terpilih . " tidak ditemukan.";
	}
}
$result = ambilTransaksi($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Hitung Data Transaksi</title>
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
	<?php if($aksi=="tambahTransaksi"):?>
		<h2>Tambah Transaksi</h2>
		<form method="post">
			<label>Tanggal:
				<input type="date" name="waktu_transaksi" value="<?= date('Y-m-d'); ?>" required>
			</label>
			<label>Pelanggan:
				<select name="pelanggan_id" required>
					<option value="">Pilih pelanggan</option>
					<?php foreach ($resultPelanggan as $p): ?>
						<option value="<?= e($p["id"]); ?>"><?= e($p["nama"]); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<label>Keterangan:
				<input type="text" name="keterangan">
			</label>
			<button type="submit">Simpan Transaksi</button>
			<a href="index.php">Batal</a>
		</form>
	<?php endif; ?>
	<div class="container">
		<h1>Data Transaksi</h1>
		<a href="?aksi=tambahTransaksi">tambah</a>
		<form method="post">
		<table cellspacing="0" cellpadding="5">
			<thead>
				<tr>
					<th>No</th>
					<th>ID</th>
					<th>Tanggal</th>
					<th>Pelanggan</th>
					<th>Keterangan</th>
					<th>Total</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				
				<?php $no = 1; ?>
				<?php foreach ($result as $data) : ?>
					<tr>
						<?php if ($aksi === 'editTransaksi' && $id_terpilih === (int)$data["id"]) : ?>
							<td><?= $no++; ?></td>
							<td><input type="text" value="<?= e($data["id"]); ?>" readonly></td>
							<td><input type="date" name="waktu_transaksi" value="<?= e($data["waktu_transaksi"]); ?>" required></td>
							<td>
								<select name="pelanggan_id" required>
									<?php foreach ($resultPelanggan as $p): ?>
										<option value="<?= e($p["id"]); ?>" <?= $p["id"] === $data["pelanggan_id"] ? "selected" : ""; ?>><?= e($p["nama"]); ?></option>
									<?php endforeach; ?>
								</select>
							</td>
							<td><input type="text" name="keterangan" value="<?= e($data["keterangan"]); ?>"></td>
							<td><?= rupiah($data["total"]); ?></td>
							<td>
								<input type="hidden" name="id" value="<?= (int)$data["id"]; ?>">
								<button type="submit">Simpan</button>
								<a href="index.php">Batal</a>
							</td>
						<?php else : ?>
							<td><?= $no++; ?></td>
							<td><?= e($data["id"]); ?></td>
							<td><?= e($data["waktu_transaksi"]); ?></td>
							<td><?= e($data["pelanggan"]); ?></td>
							<td><?= e($data["keterangan"]); ?></td>
							<td><?= rupiah($data["total"]); ?></td>
							<td align="center">
								<a href="?id=<?=(int)$data['id']; ?>&aksi=detailTransaksi">detail</a>
								<button type="submit" name="hapus_id" value="<?= (int)$data["id"]; ?>" onclick="return confirm('Hapus transaksi ini beserta semua detailnya?')">Hapus</button> |
								<a href="?id=<?= (int)$data["id"]; ?>&aksi=editTransaksi">Edit</a>
							</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</form>
	</div>
	<?php if($headerTransaksi && $id_terpilih && in_array($aksi, ["detailTransaksi", "editDetail"], true)){
		require "detailTransaksi.php";
	} ?>
</body>
</html>