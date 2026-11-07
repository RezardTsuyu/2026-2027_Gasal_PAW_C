<?php 
// Fungsi-fungsi untuk DETAIL transaksi (tabel transaksi_detail).
// Kunci tabel ini adalah gabungan (transaksi_id, barang_id), jadi satu baris detail
// dikenali lewat pasangan transaksi_id + barang_id (tidak ada kolom id sendiri).

function ambilDetailTransaksi($conn,$id_terpilih){
	$sql = "SELECT td.transaksi_id, td.barang_id, b.kode_barang, b.nama_barang, td.harga, td.qty, (td.harga * td.qty) AS subtotal
			FROM transaksi_detail td
			JOIN barang b ON b.id = td.barang_id
			WHERE td.transaksi_id = ?
			ORDER BY b.nama_barang";
	try {
		return $conn->execute_query($sql,[$id_terpilih])->fetch_all(MYSQLI_ASSOC);
	} catch (Exception $e) {
		echo "ERROR :". $e->getMessage();
		return [];
	}
}

// Semua barang untuk pilihan dropdown.
function ambilBarang($conn){
	$sql = "SELECT id, kode_barang, nama_barang, harga, stok FROM barang ORDER BY nama_barang;";
	try {
		return $conn->execute_query($sql)->fetch_all(MYSQLI_ASSOC);
	} catch (Exception $e) {
		echo "ERROR :". $e->getMessage();
		return [];
	}
}

// Apakah barang ini sudah tercatat di detail transaksi tersebut?
function barangSudahAdaDiDetail($conn, $transaksi_id, $barang_id){
	$sql = "SELECT 1 FROM transaksi_detail WHERE transaksi_id = ? AND barang_id = ?";
	return $conn->execute_query($sql, [$transaksi_id, $barang_id])->num_rows > 0;
}

// Harga barang diambil dari database (bukan dari form) supaya tidak bisa dimanipulasi dari browser.
function ambilHargaBarang($conn, $barang_id){
	$row = $conn->execute_query("SELECT harga FROM barang WHERE id = ?", [$barang_id])->fetch_assoc();
	return $row ? (int)$row['harga'] : null;
}

// TUGAS 4: hitung ulang total = jumlah (harga x qty) seluruh detail milik satu transaksi,
// lalu simpan ke kolom transaksi.total.
// Fungsi ini sengaja TIDAK menangkap exception: kalau gagal, pemanggil (yang sedang membuka
// transaksi database) bisa melakukan rollback sehingga detail dan total selalu konsisten.
function hitungTotal($conn,$id_terpilih){
	$sql = "SELECT COALESCE(SUM(harga * qty), 0) AS total FROM transaksi_detail WHERE transaksi_id = ?";
	$sqlUpdate = "UPDATE transaksi SET total = ? WHERE id = ?";
	$total = (int)$conn->execute_query($sql, [$id_terpilih])->fetch_assoc()["total"];
	$conn->execute_query($sqlUpdate, [$total, $id_terpilih]);
}

function tambahDetailTransaksi($conn,$data){
	$transaksi_id = (int)($data['transaksi_id'] ?? 0);
	$barang_id    = (int)($data['barang_id'] ?? 0);
	$qty          = (int)($data['qty'] ?? 0);

	if ($transaksi_id < 1 || $barang_id < 1 || $qty < 1) {
		return "ERROR : barang wajib dipilih dan qty minimal 1.";
	}
	try {
		// TUGAS 2 (sisi server): dropdown yang disabled belum cukup karena request bisa dipalsukan,
		// jadi barang yang sama tetap ditolak di sini.
		if (barangSudahAdaDiDetail($conn, $transaksi_id, $barang_id)) {
			return "Barang tersebut sudah ada di detail transaksi ini dan tidak boleh diinput dua kali.";
		}
		$harga = ambilHargaBarang($conn, $barang_id);
		if ($harga === null) {
			return "ERROR : barang tidak ditemukan.";
		}
		$conn->begin_transaction();
		$conn->execute_query(
			"INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?, ?, ?, ?)",
			[$transaksi_id, $barang_id, $harga, $qty]
		);
		hitungTotal($conn, $transaksi_id);
		$conn->commit();
		return "Detail transaksi berhasil ditambahkan, total transaksi sudah diperbarui.";
	} catch (Throwable $e) {
		$conn->rollback();
		if ((int)$e->getCode() === 1062) { // duplicate key: primary key (transaksi_id, barang_id) bentrok
			return "Barang tersebut sudah ada di detail transaksi ini dan tidak boleh diinput dua kali.";
		}
		return "ERROR :" . $e->getMessage();
	}
}

function editDetailTransaksi($conn, $data){
	$transaksi_id = (int)($data['transaksi_id'] ?? 0);
	$barang_lama  = (int)($data['barang_id_lama'] ?? 0);
	$barang_baru  = (int)($data['barang_id'] ?? 0);
	$qty          = (int)($data['qty'] ?? 0);

	if ($transaksi_id < 1 || $barang_lama < 1 || $barang_baru < 1 || $qty < 1) {
		return "ERROR : barang wajib dipilih dan qty minimal 1.";
	}
	try {
		$conn->begin_transaction();
		if ($barang_baru !== $barang_lama) {
			// Barang diganti: barang baru tidak boleh sudah ada di baris detail yang lain.
			if (barangSudahAdaDiDetail($conn, $transaksi_id, $barang_baru)) {
				$conn->rollback();
				return "Barang tersebut sudah ada di detail transaksi ini dan tidak boleh diinput dua kali.";
			}
			$harga = ambilHargaBarang($conn, $barang_baru);
			if ($harga === null) {
				$conn->rollback();
				return "ERROR : barang tidak ditemukan.";
			}
			$conn->execute_query(
				"UPDATE transaksi_detail SET barang_id = ?, harga = ?, qty = ? WHERE transaksi_id = ? AND barang_id = ?",
				[$barang_baru, $harga, $qty, $transaksi_id, $barang_lama]
			);
		} else {
			// Barang sama: hanya qty yang berubah, harga lama (harga saat transaksi) dipertahankan.
			$conn->execute_query(
				"UPDATE transaksi_detail SET qty = ? WHERE transaksi_id = ? AND barang_id = ?",
				[$qty, $transaksi_id, $barang_lama]
			);
		}
		hitungTotal($conn, $transaksi_id);
		$conn->commit();
		return "Detail transaksi berhasil diperbarui, total transaksi sudah diperbarui.";
	} catch (Throwable $e) {
		$conn->rollback();
		if ((int)$e->getCode() === 1062) {
			return "Barang tersebut sudah ada di detail transaksi ini dan tidak boleh diinput dua kali.";
		}
		return "ERROR :" . $e->getMessage();
	}
}

function hapusDetailTransaksi($conn, $data){
	$transaksi_id = (int)($data['transaksi_id'] ?? 0);
	$barang_id    = (int)($data['hapus_detail_id'] ?? 0); // nilai tombol Hapus = barang_id pada baris tersebut
	try {
		$conn->begin_transaction();
		$conn->execute_query("DELETE FROM transaksi_detail WHERE transaksi_id = ? AND barang_id = ?", [$transaksi_id, $barang_id]);
		hitungTotal($conn, $transaksi_id);
		$conn->commit();
		return "Detail transaksi berhasil dihapus, total transaksi sudah diperbarui.";
	} catch (Throwable $e) {
		$conn->rollback();
		return "ERROR :" . $e->getMessage();
	}
}
?>