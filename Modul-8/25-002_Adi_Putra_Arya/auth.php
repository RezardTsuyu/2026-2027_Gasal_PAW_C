<?php
// Dipanggil paling awal oleh index.php (dan file yang diakses langsung).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Apakah user sudah login?
function sudahLogin(): bool
{
    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

// Proteksi halaman: belum login -> dikembalikan ke halaman login.
// $root dipakai file yang berada di sub-folder (contoh: '../../').
function wajibLogin(string $root = ''): void
{
    if (!sudahLogin()) {
        setFlash('Silakan login terlebih dahulu.', 'error');
        header('Location: ' . $root . 'index.php?url=/login');
        exit;
    }
}

// Halaman login: yang sudah login tidak boleh membukanya lagi.
function wajibTamu(): void
{
    if (sudahLogin()) {
        header('Location: index.php?url=/');
        exit;
    }
}

// Hak akses berdasarkan level (1 = owner, 2 = kasir).
function wajibLevel(int $level, string $root = ''): void
{
    wajibLogin($root);
    if ($_SESSION['level'] !== $level) {
        setFlash('Anda tidak berhak mengakses halaman tersebut.', 'error');
        header('Location: ' . $root . 'index.php?url=/');
        exit;
    }
}

// Route data master hanya boleh dibuka owner.
function routeKhususOwner(string $url): bool
{
    foreach (['barang', 'supplier', 'pelanggan', 'user'] as $m) {
        if ($url === "/$m"
            || strpos($url, "/$m/") === 0
            || strpos($url, "/api/$m/") === 0) {
            return true;
        }
    }
    return false;
}

function namaLevel($level): string
{
    return (int)$level === 1 ? 'Owner' : 'Kasir';
}

// Pesan satu kali tampil (disimpan di session).
function setFlash(string $pesan, string $tipe = 'ok'): void
{
    $_SESSION['flash'] = ['pesan' => $pesan, 'tipe' => $tipe];
}

function tampilFlash(): void
{
    if (!isset($_SESSION['flash'])) {
        return;
    }
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    echo '<p class="alert ' . e($f['tipe']) . '">' . e($f['pesan']) . '</p>';
}

// Escape output agar aman dari XSS.
function e($teks): string
{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}
