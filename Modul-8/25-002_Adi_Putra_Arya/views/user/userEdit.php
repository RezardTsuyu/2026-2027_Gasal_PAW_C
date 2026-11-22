<?php
$id = (int)($_GET['id'] ?? 0);
$sql = "SELECT id, username, nama_user, level FROM user WHERE id = ?";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Edit User</h2>
<form method="post" action="?url=/api/user/edit" autocomplete="off">
    <input type="hidden" name="id" value="<?= e($result['id'] ?? ''); ?>">
    <label>Username :
        <input type="text" name="username" value="<?= e($result['username'] ?? ''); ?>" required>
    </label>
    <label>Password (kosongkan jika tidak diganti) :
        <input type="password" name="password" minlength="6" placeholder="password baru...">
    </label>
    <label>Nama User :
        <input type="text" name="nama_user" value="<?= e($result['nama_user'] ?? ''); ?>" required>
    </label>
    <label>Level :
        <select name="level" required>
            <option value="1" <?= ($result['level'] ?? 2) == 1 ? 'selected' : ''; ?>>1 - Owner</option>
            <option value="2" <?= ($result['level'] ?? 2) == 2 ? 'selected' : ''; ?>>2 - Kasir</option>
        </select>
    </label>
    <button type="submit">Simpan</button>
</form>
