<?php
// supplier_hapus.php - menghapus supplier (dipanggil setelah klik OK pada popup)
require_once "koneksi.php";

$status = "gagal";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = ambil_id($_POST);

    try {
        $stmt = mysqli_prepare($koneksi, "DELETE FROM supplier WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $status = (mysqli_stmt_affected_rows($stmt) > 0) ? "hapus" : "gagal";
    } catch (mysqli_sql_exception $e) {
        // 1451 = masih dipakai foreign key (supplier punya data barang)
        $status = ($e->getCode() == 1451) ? "dipakai" : "gagal";
    }
}

header("Location: index.php?status=" . $status);
exit;
