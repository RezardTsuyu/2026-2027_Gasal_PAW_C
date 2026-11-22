<?php
$sql = "SELECT id, username, nama_user, level FROM user ORDER BY id DESC";
try {
    $result = $conn->query($sql);
    $user = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Daftar User</h2>
<a href="?url=/user/add">
    tambah
</a>
<?php if (empty($user)): ?>
    <p style="margin-top: 1rem; color: #64748b;">Belum ada data user.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">No</th>
                <th>ID</th>
                <th>Username</th>
                <th>Nama User</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($user as $row): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= e($row['id']); ?></td>
                    <td><?= e($row['username']); ?></td>
                    <td><?= e($row['nama_user']); ?></td>
                    <td><?= (int)$row['level']; ?> - <?= namaLevel($row['level']); ?></td>
                    <td>
                        <a href="?url=/user/edit&id=<?= (int)$row['id']; ?>">Edit</a>
                        <a href="?url=/api/user/delete&id=<?= (int)$row['id']; ?>" onclick="return confirm('Yakin ingin menghapus user ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
