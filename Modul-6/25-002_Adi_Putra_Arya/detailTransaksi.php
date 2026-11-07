<?php
// ID barang yang SUDAH ada di detail transaksi ini. Barang-barang ini tidak boleh dipilih lagi
// (di dropdown dibuat disabled), sehingga barang yang sama tidak bisa diinput dua kali.
$barangTerpakai = array_map('intval', array_column($resultDetail, 'barang_id'));
$masihAdaBarang = count($resultBarang) > count($barangTerpakai);
?>
<h2>Data Detail transaksi dari ID : <?= (int)$id_terpilih ?></h2>
<p>
	Tanggal: <strong><?= e($headerTransaksi["waktu_transaksi"]); ?></strong> |
	Pelanggan: <strong><?= e($headerTransaksi["pelanggan"]); ?></strong> |
	Keterangan: <strong><?= e($headerTransaksi["keterangan"]); ?></strong>
</p>
<form method="POST">
	<input type="hidden" name="transaksi_id" value="<?= (int)$id_terpilih; ?>">
<?php if ($aksi === "editDetail"): ?>
	<input type="hidden" name="barang_id_lama" value="<?= (int)$id_detail_terpilih; ?>">
<?php endif; ?>
<table>
	<thead>
		<tr>
			<th>No</th>
			<th>kode</th>
			<th>nama barang</th>
			<th>harga</th>
			<th>qty</th>
			<th>subtotal</th>
			<th>aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php if(empty($resultDetail))  :?>
			<tr><td colspan="7" align="center">Belum ada detail barang untuk transaksi ini.</td></tr>
		<?php else: ?>
			<?php $no=1; ?>
			<?php foreach ($resultDetail as $data): ?>
				<tr>
					<?php if ((int)$data["barang_id"] === (int)$id_detail_terpilih && $aksi==="editDetail"): ?>
							<td><?= $no++; ?></td>
							<td><?= e($data["kode_barang"]); ?></td>
							<td>
								<select name="barang_id" required>
									<option value="">Pilih barang</option>
									<?php foreach ($resultBarang as $dataBarang): ?>
										<?php
											$idBarang   = (int)$dataBarang["id"];
											$barangIni  = ($idBarang === (int)$data["barang_id"]);
											// barang yang dipakai baris LAIN tidak boleh dipilih; barang baris ini sendiri tetap boleh
											$dipakaiLain = in_array($idBarang, $barangTerpakai, true) && !$barangIni;
										?>
										<option value="<?= $idBarang; ?>" <?= $barangIni ? "selected" : ""; ?> <?= $dipakaiLain ? "disabled" : ""; ?>>
											<?= e($dataBarang["nama_barang"]); ?> (<?= rupiah($dataBarang["harga"]); ?>)<?= $dipakaiLain ? " - sudah ada di detail" : ""; ?>
										</option>
									<?php endforeach ?>
								</select>
							</td>
							<td><?= rupiah($data["harga"]); ?></td>
							<td><input type="number" id="qty" name="qty" min="1" value="<?= (int)$data["qty"]; ?>" required></td>
							<td><?= rupiah($data["subtotal"]); ?></td>
							<td>
								<button type="submit">Simpan</button>
								<a href="index.php?id=<?= (int)$id_terpilih; ?>&aksi=detailTransaksi">Batal</a>
							</td>
					<?php else: ?>
							<td><?= $no++ ;?></td>
							<td><?= e($data['kode_barang']);?></td>
							<td><?= e($data['nama_barang']);?></td>
							<td><?= rupiah($data['harga']);?></td>
							<td><?= (int)$data['qty'];?></td>
							<td><?= rupiah($data['subtotal']);?></td>
							<td align="center">
								<a href="index.php?id=<?= (int)$id_terpilih; ?>&id_detail=<?= (int)$data['barang_id']; ?>&aksi=editDetail">edit</a>
								<button type="submit" name="hapus_detail_id" value="<?= (int)$data["barang_id"]; ?>" onclick="return confirm('Hapus barang ini dari detail transaksi?')">Hapus</button>
							</td>
					<?php endif ?>
				</tr>	
			<?php endforeach ;?>
		<?php endif; ?>
	</tbody>
	<tfoot>
		<tr class="total-row">
			<td colspan="5" align="right"><strong>Total transaksi (tersimpan di tabel transaksi)</strong></td>
			<td colspan="2"><strong><?= rupiah($headerTransaksi["total"]); ?></strong></td>
		</tr>
	</tfoot>
</table>
</form>
<h3>Tambah Barang untuk transaksi ID: <?= (int)$id_terpilih ?></h3>
<?php if (!$masihAdaBarang): ?>
	<p>Semua barang sudah dimasukkan ke transaksi ini.</p>
<?php else: ?>
<form action="index.php?aksi=tambahDetail" method="post">
	<input type="hidden" name="transaksi_id" value="<?= (int)$id_terpilih; ?>">
	<label for="barang_id">barang :</label>
	<select name="barang_id" id="barang_id" required>
		<option value="">Pilih barang</option>
		<?php foreach ($resultBarang as $dataBarang): ?>
			<?php $sudahDipakai = in_array((int)$dataBarang['id'], $barangTerpakai, true); ?>
			<option value="<?= (int)$dataBarang['id'];?>" <?= $sudahDipakai ? "disabled" : ""; ?>>
				<?= e($dataBarang['nama_barang']);?> (<?= rupiah($dataBarang['harga']); ?>)<?= $sudahDipakai ? " - sudah ada di detail" : ""; ?>
			</option>	
		<?php endforeach ?>
	</select>
	<label for="qty_tambah">qty :</label>
	<input type="number" id="qty_tambah" name="qty" min="1" value="1" required>
	<button type="submit">tambah</button>
</form>
<?php endif; ?>