<h2>Halaman Beranda</h2>
<p style="margin-top: 0.5rem; color: #475569;">
    Selamat datang, <strong><?= e($_SESSION['nama_user']); ?></strong>!
    Anda login sebagai <strong><?= namaLevel($_SESSION['level']); ?></strong>
    (level <?= (int)$_SESSION['level']; ?>).
</p>
<p style="margin-top: 0.5rem; color: #475569;">
    Menu yang dapat Anda akses:
    <?= $_SESSION['level'] === 1
        ? 'Home, Data Master, Transaksi, dan Laporan.'
        : 'Home, Transaksi, dan Laporan.'; ?>
</p>
