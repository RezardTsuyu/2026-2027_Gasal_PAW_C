<?php
$id = (int)($_GET['id'] ?? 0);
$sql = "SELECT id, nama_supplier, alamat, telepon FROM supplier WHERE id = ?";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Edit Supplier</h2>
<form method="post" action="?url=/api/supplier/edit">
    <input type="hidden" name="id" value="<?= e($result['id'] ?? ''); ?>">
    <label>Nama Supplier :
        <input type="text" name="nama_supplier" value="<?= e($result['nama_supplier'] ?? ''); ?>" placeholder="masukkan nama supplier..." required>
    </label>
    <label>Alamat :
        <input type="text" name="alamat" value="<?= e($result['alamat'] ?? ''); ?>">
    </label>
    <label>Telepon :
        <input type="text" name="telepon" value="<?= e($result['telepon'] ?? ''); ?>">
    </label>
    <button type="submit">Simpan</button>
</form>
