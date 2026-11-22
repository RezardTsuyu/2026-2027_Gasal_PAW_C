<?php
$id = (int)($_GET['id'] ?? 0);
$sql = "SELECT id, nama_pelanggan, alamat, telepon FROM pelanggan WHERE id = ?";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Edit Pelanggan</h2>
<form method="post" action="?url=/api/pelanggan/edit">
    <input type="hidden" name="id" value="<?= e($result['id'] ?? ''); ?>">
    <label>Nama Pelanggan :
        <input type="text" name="nama_pelanggan" value="<?= e($result['nama_pelanggan'] ?? ''); ?>" placeholder="masukkan nama pelanggan..." required>
    </label>
    <label>Alamat :
        <input type="text" name="alamat" value="<?= e($result['alamat'] ?? ''); ?>">
    </label>
    <label>Telepon :
        <input type="text" name="telepon" value="<?= e($result['telepon'] ?? ''); ?>">
    </label>
    <button type="submit">Simpan</button>
</form>
