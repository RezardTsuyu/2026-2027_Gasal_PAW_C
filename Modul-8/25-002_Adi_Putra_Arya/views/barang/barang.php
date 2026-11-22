<?php
$sql = "SELECT * FROM barang ORDER BY id DESC";
try {
    $result = $conn->query($sql);
    $barang = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Daftar barang</h2>
<a href="?url=/barang/add">
    tambah
</a>
<?php if (empty($barang)): ?>
    <p style="margin-top: 1rem; color: #64748b;">Belum ada data barang.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">No</th>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($barang as $row): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars((string)$row['id']); ?></td>
                    <td><?= htmlspecialchars((string)$row['nama_barang']); ?></td>
                    <td>Rp <?= number_format((float)$row['harga'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="?url=/barang/edit&id=<?= $row['id']; ?>">Edit</a>
                        <a href="?url=/api/barang/delete&id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus barang ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
