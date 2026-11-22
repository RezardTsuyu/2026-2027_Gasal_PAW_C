<?php
$transaksi_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($transaksi_id > 0) {
    $sql = "SELECT td.id, td.transaksi_id, t.pelanggan, b.nama_barang, b.harga, td.qty, (b.harga * td.qty) AS subtotal
            FROM transaksi_detail td
            JOIN transaksi t ON td.transaksi_id = t.id
            JOIN barang b ON td.barang_id = b.id
            WHERE td.transaksi_id = $transaksi_id
            ORDER BY td.id ASC";
} else {
    $sql = "SELECT td.id, td.transaksi_id, t.pelanggan, b.nama_barang, b.harga, td.qty, (b.harga * td.qty) AS subtotal
            FROM transaksi_detail td
            JOIN transaksi t ON td.transaksi_id = t.id
            JOIN barang b ON td.barang_id = b.id
            ORDER BY td.id DESC";
}

try {
    $result = $conn->query($sql);
    $detail = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Daftar Detail Transaksi <?= $transaksi_id > 0 ? "(Transaksi #$transaksi_id)" : ""; ?></h2>
<a href="?url=/transaksiDetail/add<?= $transaksi_id > 0 ? "&transaksi_id=$transaksi_id" : ""; ?>">
    tambah
</a>
<?php if (empty($detail)): ?>
    <p style="margin-top: 1rem; color: #64748b;">Belum ada data detail transaksi.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">No</th>
                <th>ID</th>
                <th>ID Transaksi</th>
                <th>Pelanggan</th>
                <th>Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($detail as $row): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars((string)$row['id']); ?></td>
                    <td>#<?= htmlspecialchars((string)$row['transaksi_id']); ?></td>
                    <td><?= htmlspecialchars((string)$row['pelanggan']); ?></td>
                    <td><?= htmlspecialchars((string)$row['nama_barang']); ?></td>
                    <td>Rp <?= number_format((float)$row['harga'], 0, ',', '.'); ?></td>
                    <td><?= (int)$row['qty']; ?></td>
                    <td>Rp <?= number_format((float)$row['subtotal'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="?url=/transaksiDetail/edit&id=<?= $row['id']; ?>">Edit</a>
                        <a href="?url=/api/transaksiDetail/delete&id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus detail ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
