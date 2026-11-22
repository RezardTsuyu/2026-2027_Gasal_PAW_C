<?php
$barang = $conn->query("SELECT id, nama_barang FROM barang")->fetch_all(MYSQLI_ASSOC);
$transaksi_id = $_GET['transaksi_id'] ?? '';
?>
<h2>Tambah Detail Transaksi</h2>
<form method="post" action="?url=/api/transaksiDetail/add">
    <label>ID Transaksi :
        <input type="number" name="transaksi_id" value="<?= $transaksi_id; ?>" required>
    </label>    
    <label>Barang :
        <select name="barang_id" required>
            <option value="">Pilih barang...</option>
            <?php foreach ($barang as $b): ?>
                <option value="<?= $b['id']; ?>"><?= htmlspecialchars($b['nama_barang']); ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Qty :
        <input type="number" name="qty" min="1" value="1" required>
    </label>
    <button type="submit">Tambahkan</button>
</form>
