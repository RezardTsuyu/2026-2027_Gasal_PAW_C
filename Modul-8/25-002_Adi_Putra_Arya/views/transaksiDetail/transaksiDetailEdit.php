<?php
$id = $_GET['id'] ?? 0;
$sql = "SELECT id, transaksi_id, barang_id, qty FROM transaksi_detail WHERE id = ?";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}

$barang = $conn->query("SELECT id, nama_barang FROM barang")->fetch_all(MYSQLI_ASSOC);
?>
<h2>Edit Detail Transaksi</h2>
<form method="post" action="?url=/api/transaksiDetail/edit">
    <input type="hidden" name="id" value="<?= $result['id'] ?? ''; ?>">
    <input type="hidden" name="transaksi_id" value="<?= $result['transaksi_id'] ?? ''; ?>">
    <label>Barang :
        <select name="barang_id" required>
            <?php foreach ($barang as $b): ?>
                <option value="<?= $b['id']; ?>" <?= ($b['id'] == ($result['barang_id'] ?? '')) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($b['nama_barang']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>    
    <label>Qty :
        <input type="number" name="qty" value="<?= $result['qty'] ?? 1; ?>" min="1" required>
    </label>
    <button type="submit">Simpan</button>
</form>
