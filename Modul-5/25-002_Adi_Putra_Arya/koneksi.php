<?php
// koneksi.php - koneksi ke database db_tp_paw dan fungsi bantu

// jika terjadi error query/koneksi, mysqli melempar exception (dapat di-catch)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_tp_paw";

try {
    $koneksi = mysqli_connect($host, $user, $pass, $db);
    mysqli_set_charset($koneksi, "utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Koneksi database gagal: " . $e->getMessage()
        . "<br>Pastikan MySQL sudah Start dan file db_tp_paw.sql sudah di-import.");
}

// ---------------- fungsi bantu ----------------

// mengamankan teks sebelum dicetak ke HTML (mencegah XSS)
function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, "UTF-8");
}

// mengambil input teks dari $_GET / $_POST, spasi di awal dan akhir dibuang
function ambil($sumber, $kunci)
{
    if (isset($sumber[$kunci]) && is_string($sumber[$kunci])) {
        return trim($sumber[$kunci]);
    }
    return "";
}

// mengambil id (angka bulat) dari $_GET / $_POST, hasil 0 jika tidak valid
function ambil_id($sumber)
{
    $id = ambil($sumber, "id");
    return ctype_digit($id) ? (int) $id : 0;
}

// validasi form supplier, hasilnya array pesan kesalahan (kosong = valid)
function validasi_supplier($nama, $telp, $alamat)
{
    $error = array();

    if ($nama === "") {
        $error["nama"] = "Nama wajib diisi.";
    } elseif (strlen($nama) > 100) {
        $error["nama"] = "Nama maksimal 100 karakter.";
    }

    if ($telp === "") {
        $error["telp"] = "Telp wajib diisi.";
    } elseif (!preg_match('/^[0-9]{6,12}$/', $telp)) {
        $error["telp"] = "Telp harus berupa angka 6 sampai 12 digit.";
    }

    if ($alamat === "") {
        $error["alamat"] = "Alamat wajib diisi.";
    }

    return $error;
}
