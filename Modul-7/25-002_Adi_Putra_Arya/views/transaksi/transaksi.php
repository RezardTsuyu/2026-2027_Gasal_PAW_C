<?php
$sql = "SELECT id, tanggal, pelanggan, total FROM transaksi ORDER BY id DESC";
try {
    $result = $conn->query($sql);
    $transaksi = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Daftar Transaksi</h2>
<a href="?url=/transaksi/add">
    tambah
</a>
<a href="?url=/transaksi/laporan">laporan</a>
<?php if (empty($transaksi)): ?>
    <p style="margin-top: 1rem; color: #64748b;">Belum ada data transaksi.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">No</th>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($transaksi as $row): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars((string)$row['id']); ?></td>
                    <td><?= htmlspecialchars((string)$row['tanggal']); ?></td>
                    <td><?= htmlspecialchars((string)$row['pelanggan']); ?></td>
                    <td>Rp <?= number_format((float)$row['total'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="?url=/transaksiDetail&id=<?= $row['id']; ?>">Detail</a>
                        <a href="?url=/transaksi/edit&id=<?= $row['id']; ?>">Edit</a>
                        <a href="?url=/api/transaksi/delete&id=<?= $row['id']; ?>">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
