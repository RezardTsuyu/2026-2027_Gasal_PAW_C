<?php
$id = $_GET['id'] ?? 0;
$sql = "SELECT id, nama_barang, harga FROM barang WHERE id = ?";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Edit Barang</h2>
<form method="post" action="?url=/api/barang/edit">
    <input type="hidden" name="id" value="<?= $result['id'] ?? ''; ?>">
    <label>Nama Barang :
        <input type="text" name="nama_barang" value="<?= htmlspecialchars($result['nama_barang'] ?? ''); ?>" placeholder="masukkan nama barang..." required>
    </label>    
    <label>Harga :
        <input type="number" name="harga" value="<?= $result['harga'] ?? 0; ?>" min="0" required>
    </label>
    <button type="submit">Simpan</button>
</form>
