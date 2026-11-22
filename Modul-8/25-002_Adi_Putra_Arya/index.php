<?php
ob_start();
require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/auth.php';
$url = isset($_GET['url']) && $_GET['url'] !== '' ? $_GET['url'] : '/';

// ===== Rute tanpa navbar: login, proses login, logout =====
if ($url === '/login') {
    wajibTamu();                 // sudah login -> tidak boleh ke halaman login
    require __DIR__ . '/views/auth/login.php';
    exit;
}
if ($url === '/api/login') {
    wajibTamu();
    require __DIR__ . '/actions/auth/apiLogin.php';
    exit;
}
if ($url === '/api/logout') {
    require __DIR__ . '/actions/auth/apiLogout.php';
    exit;
}

// ===== Semua rute lain: wajib login, data master khusus owner =====
wajibLogin();
if (routeKhususOwner($url)) {
    wajibLevel(1);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi</title>
    <link rel="stylesheet" href="style.css">
    <script src="
    https://cdn.jsdelivr.net/npm/chart.js@4.6.1/dist/chart.umd.min.js
    "></script>
</head>
<body>
    <nav>
        <a href="?url=/">Home</a>
        <?php if ($_SESSION['level'] === 1): ?>
            <div class="dropdown">
                <a href="#">Data Master &#9662;</a>
                <div class="submenu">
                    <a href="?url=/barang">Data Barang</a>
                    <a href="?url=/supplier">Data Supplier</a>
                    <a href="?url=/pelanggan">Data Pelanggan</a>
                    <a href="?url=/user">Data User</a>
                </div>
            </div>
        <?php endif; ?>
        <a href="?url=/transaksi">Transaksi</a>
        <a href="?url=/transaksi/laporan">Laporan</a>
        <div class="dropdown kanan">
            <a href="#"><?= e($_SESSION['nama_user']); ?> &#9662;</a>
            <div class="submenu">
                <a href="?url=/api/logout">Logout</a>
            </div>
        </div>
    </nav>
    <main>
        <?php
            tampilFlash();
            require __DIR__ . '/proses.php';
        ?>
    </main>
</body>
</html>
