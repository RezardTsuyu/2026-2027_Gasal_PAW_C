<?php
$sql = "SELECT * FROM supplier ORDER BY id DESC";
try {
    $result = $conn->query($sql);
    $supplier = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Daftar Supplier</h2>
<a href="?url=/supplier/add">
    tambah
</a>
<?php if (empty($supplier)): ?>
    <p style="margin-top: 1rem; color: #64748b;">Belum ada data supplier.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">No</th>
                <th>ID</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($supplier as $row): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= e($row['id']); ?></td>
                    <td><?= e($row['nama_supplier']); ?></td>
                    <td><?= e($row['alamat']); ?></td>
                    <td><?= e($row['telepon']); ?></td>
                    <td>
                        <a href="?url=/supplier/edit&id=<?= (int)$row['id']; ?>">Edit</a>
                        <a href="?url=/api/supplier/delete&id=<?= (int)$row['id']; ?>" onclick="return confirm('Yakin ingin menghapus supplier ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
