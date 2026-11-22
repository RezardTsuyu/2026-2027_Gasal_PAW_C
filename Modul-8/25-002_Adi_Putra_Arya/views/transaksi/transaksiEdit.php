<?php
$id = $_GET['id'] ?? 0;
$sql = "SELECT id, tanggal, pelanggan, total FROM transaksi WHERE id = ?";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
<h2>Edit Transaksi</h2>
<form method="post" action="?url=/api/transaksi/edit">
    <input type="hidden" name="id" value="<?= $result['id'] ?? ''; ?>">
    <label>tanggal :
        <input type="date" value="<?= $result['tanggal'] ?? ''; ?>" name="tanggal" required>
    </label>    
    <label>pelanggan :
        <input type="text" name="pelanggan" value="<?= htmlspecialchars($result['pelanggan'] ?? ''); ?>" placeholder="masukkan nama pelanggan..." required>
    </label>
    <button type="submit">Simpan</button>
</form>