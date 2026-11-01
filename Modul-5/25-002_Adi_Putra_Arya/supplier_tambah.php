<?php
// supplier_tambah.php - halaman tambah supplier (form dan proses ada di file ini)
require_once "koneksi.php";

$nama = $telp = $alamat = "";
$error = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama   = ambil($_POST, "nama");
    $telp   = ambil($_POST, "telp");
    $alamat = ambil($_POST, "alamat");

    $error = validasi_supplier($nama, $telp, $alamat);

    if (count($error) == 0) {
        $stmt = mysqli_prepare($koneksi,
            "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);
        mysqli_stmt_execute($stmt);

        header("Location: index.php?status=tambah");
        exit;
    }
}

$aksi    = "supplier_tambah.php";
$tombol  = "Simpan";
require_once "header.php";
?>
<div class="judul">
    <h2>Tambah Data Master Supplier Baru</h2>
</div>

<?php require "form_supplier.php"; ?>

</div>
</body>
</html>
