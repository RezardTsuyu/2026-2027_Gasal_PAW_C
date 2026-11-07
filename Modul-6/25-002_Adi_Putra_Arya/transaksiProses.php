<?php 
// Fungsi-fungsi untuk MASTER transaksi (tabel transaksi).
// Catatan: editTransaksi() memanggil hitungTotal() yang ada di transaksiDetailProses.php,
// jadi file tersebut harus di-require lebih dulu (lihat bagian atas index.php).

function ambilTransaksi($conn){
	// JOIN ke pelanggan karena transaksi hanya menyimpan pelanggan_id, sedangkan yang ditampilkan nama.
	$sql = "SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, t.pelanggan_id, p.nama AS pelanggan
			FROM transaksi t
			JOIN pelanggan p ON p.id = t.pelanggan_id
			ORDER BY t.id";
	try {
		return $conn->execute_query($sql)->fetch_all(MYSQLI_ASSOC);
	} catch (Exception $e) {
		echo "ERROR :". $e->getMessage();
		return [];
	}
}

// Satu transaksi (dipakai sebagai "kepala" di halaman detail).
function ambilTransaksiById($conn, $id){
	$sql = "SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, t.pelanggan_id, p.nama AS pelanggan
			FROM transaksi t
			JOIN pelanggan p ON p.id = t.pelanggan_id
			WHERE t.id = ?";
	try {
		$row = $conn->execute_query($sql, [$id])->fetch_assoc();
		return $row ?: null;
	} catch (Exception $e) {
		echo "ERROR :". $e->getMessage();
		return null;
	}
}

// Daftar pelanggan untuk dropdown pada form tambah/edit transaksi.
function ambilPelanggan($conn){
	try {
		return $conn->execute_query("SELECT id, nama FROM pelanggan ORDER BY nama")->fetch_all(MYSQLI_ASSOC);
	} catch (Exception $e) {
		echo "ERROR :". $e->getMessage();
		return [];
	}
}

function tambahTransaksi($conn, $data) {
    $tanggal    = trim($data["waktu_transaksi"] ?? "");
    $pelanggan  = trim($data["pelanggan_id"] ?? "");
    $keterangan = trim($data["keterangan"] ?? "");
    if ($tanggal === "" || $pelanggan === "") {
        return "ERROR : tanggal dan pelanggan wajib diisi.";
    }
    // total awal 0, nanti terisi otomatis saat detail transaksi ditambahkan
    $sqlInsert = "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (?, ?, 0, ?)";
    try {
        $conn->execute_query($sqlInsert, [$tanggal, $keterangan, $pelanggan]);
        return "transaksi berhasil ditambahkan";
    } catch (Throwable $e) {
        return "ERROR :" . $e->getMessage();
    }
}

function editTransaksi($conn, $data) {
    $id         = (int)($data["id"] ?? 0);
    $tanggal    = trim($data["waktu_transaksi"] ?? "");
    $pelanggan  = trim($data["pelanggan_id"] ?? "");
    $keterangan = trim($data["keterangan"] ?? "");
    if ($id < 1 || $tanggal === "" || $pelanggan === "") {
        return "ERROR : tanggal dan pelanggan wajib diisi.";
    }
    $sqlUpdate = "UPDATE transaksi SET waktu_transaksi = ?, keterangan = ?, pelanggan_id = ? WHERE id = ?";
    $conn->begin_transaction();
    try {
        $conn->execute_query($sqlUpdate, [$tanggal, $keterangan, $pelanggan, $id]);
        hitungTotal($conn, $id); // memastikan total selalu sama dengan jumlah harga x qty detailnya
        $conn->commit();
        return "data transaksi berhasil di update dengan ID: " . $id;
    } catch (Throwable $e) {
        $conn->rollback();
        return "ERROR :" . $e->getMessage();
    }
}

// transaksi_detail dan pembayaran berelasi ON DELETE CASCADE, jadi ikut terhapus otomatis
// (sesuai teks konfirmasi "beserta semua detailnya" di index.php).
function hapusTransaksi($conn, $id) {
    $id = (int)$id;
    try {
        $conn->execute_query("DELETE FROM transaksi WHERE id = ?", [$id]);
        return $conn->affected_rows > 0
            ? "Transaksi berhasil dihapus."
            : "Transaksi tidak ditemukan.";
    } catch (Throwable $e) {
        error_log($e->getMessage());
        return "ERROR :" . $e->getMessage();
    }
}
 ?>