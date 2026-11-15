<?php
// Skrip ini dipanggil langsung (bukan lewat router index.php), jadi load koneksi sendiri.
require __DIR__ . '/../../conn.php';
require_once __DIR__ . '/transaksiLaporanData.php';

$tglMulai   = $_GET['tanggal_mulai']   ?? '';
$tglSelesai = $_GET['tanggal_selesai'] ?? '';

// Validasi dulu SEBELUM mengirim header unduhan,
// supaya kalau input salah pengguna tidak mengunduh file kosong.
if (!tanggalValid($tglMulai) || !tanggalValid($tglSelesai) || $tglMulai > $tglSelesai) {
    http_response_code(400);
    exit('Rentang tanggal tidak valid. Kembali ke halaman laporan dan pilih tanggal terlebih dahulu.');
}

try {
    $laporan = ambilLaporan($conn, $tglMulai, $tglSelesai);
} catch (Exception $e) {
    http_response_code(500);
    exit('ERROR : ' . htmlspecialchars($e->getMessage()));
}

// ===== HTTP Response Header: memberi tahu browser bahwa ini file Excel yang harus diunduh =====
$namaFile = "laporan_penjualan_{$tglMulai}_sampai_{$tglSelesai}.xls";
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $namaFile . '"');
header('Pragma: no-cache');
header('Expires: 0');
?>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table border="1">
        <tr>
            <td colspan="3"><b>Rekap Laporan Penjualan</b></td>
        </tr>
        <tr>
            <td colspan="3">Periode: <?= htmlspecialchars($tglMulai); ?> sampai <?= htmlspecialchars($tglSelesai); ?></td>
        </tr>
        <tr>
            <th>No</th>
            <th>Total Pendapatan</th>
            <th>Tanggal Transaksi</th>
        </tr>
        <?php if (empty($laporan['rekap'])): ?>
            <tr>
                <td colspan="3">Tidak ada transaksi pada periode ini.</td>
            </tr>
        <?php else: ?>
            <?php $no = 1; foreach ($laporan['rekap'] as $row): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <!-- angka asli (bukan teks "Rp ...") agar bisa dijumlah / diolah di Excel -->
                    <td style="mso-number-format:'\#\,\#\#0';"><?= (int)$row['total_harian']; ?></td>
                    <td style="mso-number-format:'\@';"><?= htmlspecialchars($row['tanggal']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <tr>
            <td colspan="2"><b>Jumlah Pelanggan Unik</b></td>
            <td><?= $laporan['jumlah_pelanggan']; ?> Orang</td>
        </tr>
        <tr>
            <td colspan="2"><b>Total Pendapatan Keseluruhan</b></td>
            <td style="mso-number-format:'\#\,\#\#0';"><?= $laporan['total_pendapatan']; ?></td>
        </tr>
    </table>
</body>
</html>
