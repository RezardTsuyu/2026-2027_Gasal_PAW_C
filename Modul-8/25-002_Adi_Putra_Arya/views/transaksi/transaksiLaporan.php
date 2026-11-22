<?php
require_once __DIR__ . '/transaksiLaporanData.php';

// Filter dikirim lewat GET supaya hasil laporan bisa di-refresh / di-bookmark
$tglMulai   = $_GET['tanggal_mulai']   ?? '';
$tglSelesai = $_GET['tanggal_selesai'] ?? '';

$sudahFilter = ($tglMulai !== '' || $tglSelesai !== '');
$error       = '';
$laporan     = null;

if ($sudahFilter) {
    if (!tanggalValid($tglMulai) || !tanggalValid($tglSelesai)) {
        $error = 'Tanggal mulai dan tanggal selesai harus diisi dengan benar.';
    } elseif ($tglMulai > $tglSelesai) {
        $error = 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai.';
    } else {
        try {
            $laporan = ambilLaporan($conn, $tglMulai, $tglSelesai);
        } catch (Exception $e) {
            $error = 'ERROR : ' . $e->getMessage();
        }
    }
}

// Data untuk Chart.js: sumbu X = tanggal, sumbu Y = total pendapatan hari itu
$labels    = [];
$dataTotal = [];
if ($laporan) {
    foreach ($laporan['rekap'] as $row) {
        $labels[]    = $row['tanggal'];
        $dataTotal[] = (int)$row['total_harian'];
    }
}

// Link ekspor Excel membawa filter yang sedang aktif
$urlExcel = 'views/transaksi/transaksiLaporanExcel.php?' . http_build_query([
    'tanggal_mulai'   => $tglMulai,
    'tanggal_selesai' => $tglSelesai,
]);
?>
<h2>Laporan Penjualan</h2>

<!-- ===== Form filter rentang tanggal (tidak ikut tercetak) ===== -->
<form method="GET" action="index.php" class="filter-laporan no-print">
    <input type="hidden" name="url" value="/transaksi/laporan">
    <label>Tanggal mulai :
        <input type="date" name="tanggal_mulai" value="<?= htmlspecialchars($tglMulai); ?>" required>
    </label>
    <label>Tanggal selesai :
        <input type="date" name="tanggal_selesai" value="<?= htmlspecialchars($tglSelesai); ?>" required>
    </label>
    <button type="submit">Tampilkan</button>
</form>

<?php if ($error !== ''): ?>
    <p class="pesan-error no-print"><?= htmlspecialchars($error); ?></p>
<?php elseif (!$sudahFilter): ?>
    <p class="pesan-info no-print">Pilih rentang tanggal lalu tekan <strong>Tampilkan</strong> untuk melihat laporan.</p>
<?php elseif ($laporan !== null && empty($laporan['rekap'])): ?>
    <p class="pesan-info">
        Tidak ada transaksi pada periode
        <strong><?= htmlspecialchars($tglMulai); ?></strong> sampai
        <strong><?= htmlspecialchars($tglSelesai); ?></strong>.
    </p>
<?php elseif ($laporan !== null): ?>

    <h3 class="judul-periode">
        Rekap Laporan Penjualan
        <small><?= htmlspecialchars($tglMulai); ?> sampai <?= htmlspecialchars($tglSelesai); ?></small>
    </h3>

    <!-- ===== Tombol Cetak & Excel (tidak ikut tercetak) ===== -->
    <div class="aksi-laporan no-print">
        <button type="button" onclick="window.print()">Cetak</button>
        <a href="<?= htmlspecialchars($urlExcel); ?>">Excel</a>
    </div>

    <!-- ===== Grafik batang ===== -->
    <div class="chart-wrap">
        <canvas id="grafikPenjualan"></canvas>
    </div>
    <script>
        new Chart(document.getElementById('grafikPenjualan'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels); ?>,
                datasets: [{
                    label: 'Total Pendapatan',
                    data: <?= json_encode($dataTotal); ?>,
                    backgroundColor: 'rgba(2, 132, 199, 0.65)',
                    borderColor: '#0284c7',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false, // supaya grafik langsung tergambar penuh saat dicetak
                scales: {
                    x: { title: { display: true, text: 'Tanggal Transaksi' } },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Total Pendapatan (Rp)' },
                        ticks: { callback: (v) => v.toLocaleString('id-ID') }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (ctx) => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    </script>

    <!-- ===== Tabel rekapitulasi ===== -->
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">No</th>
                <th>Total Pendapatan</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($laporan['rekap'] as $row): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>Rp <?= number_format((float)$row['total_harian'], 0, ',', '.'); ?></td>
                    <td><?= htmlspecialchars(date('d M Y', strtotime($row['tanggal']))); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- ===== Card ringkasan total kumulatif ===== -->
    <div class="kartu-ringkasan">
        <div class="kartu">
            <span class="kartu-judul">Jumlah Pelanggan Unik</span>
            <span class="kartu-nilai"><?= number_format($laporan['jumlah_pelanggan'], 0, ',', '.'); ?> Orang</span>
        </div>
        <div class="kartu">
            <span class="kartu-judul">Total Pendapatan Keseluruhan</span>
            <span class="kartu-nilai">Rp <?= number_format($laporan['total_pendapatan'], 0, ',', '.'); ?></span>
        </div>
    </div>

<?php endif; ?>
