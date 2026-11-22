<?php
$sql = "SELECT * FROM pelanggan ORDER BY id DESC";
try {
    $result = $conn->query($sql);
    $pelanggan = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Daftar Pelanggan</h2>
<a href="?url=/pelanggan/add">
    tambah
</a>
<?php if (empty($pelanggan)): ?>
    <p style="margin-top: 1rem; color: #64748b;">Belum ada data pelanggan.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">No</th>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($pelanggan as $row): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= e($row['id']); ?></td>
                    <td><?= e($row['nama_pelanggan']); ?></td>
                    <td><?= e($row['alamat']); ?></td>
                    <td><?= e($row['telepon']); ?></td>
                    <td>
                        <a href="?url=/pelanggan/edit&id=<?= (int)$row['id']; ?>">Edit</a>
                        <a href="?url=/api/pelanggan/delete&id=<?= (int)$row['id']; ?>" onclick="return confirm('Yakin ingin menghapus pelanggan ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
