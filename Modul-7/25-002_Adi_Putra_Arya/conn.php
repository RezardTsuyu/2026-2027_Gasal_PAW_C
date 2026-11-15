<?php 
$servername = "localhost";
$username = "root";
$password = "";//kalau error kosongi 
$db="KampusDB";

try {
	$conn = mysqli_connect($servername,$username,$password,$db);
} catch (Exception $e) {
	die("Koneksi gagal ". $e->getMessage());
}
 ?>
