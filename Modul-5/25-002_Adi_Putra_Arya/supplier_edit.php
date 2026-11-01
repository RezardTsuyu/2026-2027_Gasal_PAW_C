<?php
// supplier_edit.php - halaman edit supplier (form dan proses ada di file ini)
require_once "koneksi.php";

$id = ambil_id($_GET);

// mengambil data lama supplier yang akan diedit
$stmt = mysqli_prepare($koneksi, "SELECT nama, telp, alamat FROM supplier WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {                       // id tidak ditemukan
    header("Location: index.php?status=gagal");
    exit;
}

$nama   = $data["nama"];
$telp   = $data["telp"];
$alamat = $data["alamat"];
$error  = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama   = ambil($_POST, "nama");
    $telp   = ambil($_POST, "telp");
    $alamat = ambil($_POST, "alamat");

    $error = validasi_supplier($nama, $telp, $alamat);

    if (count($error) == 0) {
        $stmt = mysqli_prepare($koneksi,
            "UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);
        mysqli_stmt_execute($stmt);

        header("Location: index.php?status=edit");
        exit;
    }
}

$aksi    = "supplier_edit.php?id=" . $id;
$tombol  = "Update";
require_once "header.php";
?>
<div class="judul">
    <h2>Edit Data Master Supplier</h2>
</div>

<?php require "form_supplier.php"; ?>

</div>
</body>
</html>
