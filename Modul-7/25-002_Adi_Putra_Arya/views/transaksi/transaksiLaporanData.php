<?php
/**
 * Helper laporan penjualan.
 * Dipakai oleh transaksiLaporan.php (tampilan + cetak)
 * dan transaksiLaporanExcel.php (ekspor .xls) supaya query-nya hanya ada di satu tempat.
 */

/**
 * Cek apakah string adalah tanggal valid berformat YYYY-MM-DD.
 */
function tanggalValid(string $tgl): bool
{
    $d = DateTime::createFromFormat('Y-m-d', $tgl);
    return $d && $d->format('Y-m-d') === $tgl;
}

/**
 * Ambil data laporan untuk rentang tanggal [$mulai, $selesai] (inklusif).
 *
 * @return array{
 *   rekap: array<int, array{tanggal: string, total_harian: int}>,
 *   jumlah_pelanggan: int,
 *   total_pendapatan: int
 * }
 */
function ambilLaporan(mysqli $conn, string $mulai, string $selesai): array
{
    // 1) Agregasi total pendapatan per hari  -> bahan grafik + tabel rekap
    $sql = "SELECT tanggal, SUM(total) AS total_harian
            FROM transaksi
            WHERE tanggal BETWEEN ? AND ?
            GROUP BY tanggal
            ORDER BY tanggal ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $mulai, $selesai);
    $stmt->execute();
    $rekap = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // 2) Ringkasan kumulatif: pelanggan unik + total pendapatan keseluruhan
    $sql = "SELECT COUNT(DISTINCT pelanggan) AS jumlah_pelanggan,
                   COALESCE(SUM(total), 0)   AS total_pendapatan
            FROM transaksi
            WHERE tanggal BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $mulai, $selesai);
    $stmt->execute();
    $ringkasan = $stmt->get_result()->fetch_assoc();

    return [
        'rekap'            => $rekap,
        'jumlah_pelanggan' => (int)$ringkasan['jumlah_pelanggan'],
        'total_pendapatan' => (int)$ringkasan['total_pendapatan'],
    ];
}
