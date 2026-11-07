<?php 
$servername = "localhost";
$username = "root";
$password = "";
$db="penjualan";

try {
	// Kalau dipanggil dari database.php (yang mendefinisikan TANPA_DB), koneksi dibuat tanpa memilih
	// database, sebab database "penjualan" bisa saja belum ada. Untuk halaman lain, database langsung dipilih.
	$conn = mysqli_connect($servername, $username, $password, defined('TANPA_DB') ? null : $db);
	mysqli_set_charset($conn, "utf8mb4");
} catch (Exception $e) {
	die("Koneksi gagal ". $e->getMessage());
}
 ?>