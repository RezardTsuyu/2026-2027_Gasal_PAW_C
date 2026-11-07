<?php 
// Fungsi-fungsi untuk data barang (dipakai barang.php).

// Daftar barang + nama supplier + berapa kali barang dipakai di transaksi_detail.
function ambilDaftarBarang($conn){
	$sql = "SELECT b.id, b.kode_barang, b.nama_barang, b.harga, b.stok, s.nama AS supplier,
				(SELECT COUNT(*) FROM transaksi_detail td WHERE td.barang_id = b.id) AS dipakai
			FROM barang b
			JOIN supplier s ON s.id = b.supplier_id
			ORDER BY b.id";
	try {
		return $conn->execute_query($sql)->fetch_all(MYSQLI_ASSOC);
	} catch (Exception $e) {
		echo "ERROR :". $e->getMessage();
		return [];
	}
}

// TUGAS 3: hapus barang HANYA jika belum dipakai di transaksi_detail.
function hapusBarang($conn, $id){
	$id = (int)$id;
	try {
		// 1. Pastikan barangnya ada
		$barang = $conn->execute_query("SELECT nama_barang FROM barang WHERE id = ?", [$id])->fetch_assoc();
		if (!$barang) {
			return "Barang tidak ditemukan.";
		}

		// 2. Cek data terkait: pernahkah barang ini dimasukkan ke detail transaksi?
		$dipakai = $conn->execute_query(
			"SELECT transaksi_id FROM transaksi_detail WHERE barang_id = ? ORDER BY transaksi_id", [$id]
		)->fetch_all(MYSQLI_ASSOC);

		if (count($dipakai) > 0) {
			// Sudah dipakai -> JANGAN dihapus, tampilkan notifikasi
			$daftar = implode(", ", array_column($dipakai, "transaksi_id"));
			return "Barang \"" . $barang["nama_barang"] . "\" tidak dapat dihapus karena masih digunakan pada transaksi (ID transaksi: " . $daftar . ").";
		}

		// 3. Belum dipakai -> boleh dihapus seperti biasa
		$conn->execute_query("DELETE FROM barang WHERE id = ?", [$id]);
		return $conn->affected_rows > 0
			? "Barang \"" . $barang["nama_barang"] . "\" berhasil dihapus."
			: "Barang tidak ditemukan.";
	} catch (Throwable $e) {
		// Jaring pengaman: kalau ada transaksi baru yang memakai barang ini di antara langkah 2 dan 3,
		// foreign key (ON DELETE RESTRICT) tetap menolak penghapusan. Kode error 1451 = masih direferensikan.
		if ((int)$e->getCode() === 1451) {
			return "Barang tidak dapat dihapus karena masih digunakan pada transaksi.";
		}
		return "ERROR :" . $e->getMessage();
	}
}
?>