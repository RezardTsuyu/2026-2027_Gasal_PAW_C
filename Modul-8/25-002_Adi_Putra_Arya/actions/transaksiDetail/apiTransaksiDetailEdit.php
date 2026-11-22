<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $transaksi_id = (int)($_POST['transaksi_id'] ?? 0);
    $barang_id = (int)($_POST['barang_id'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 1);

    // Memulai database transaction
    $conn->begin_transaction();

    try {
        // 1. Update data pada transaksi_detail
        $sql = "UPDATE transaksi_detail SET barang_id = ?, qty = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $barang_id, $qty, $id);
        $stmt->execute();

        // 2. Hitung dan update total pada transaksi
        $sqlTotal = "UPDATE transaksi SET total = (
            SELECT COALESCE(SUM(b.harga * td.qty), 0)
            FROM transaksi_detail td
            JOIN barang b ON td.barang_id = b.id
            WHERE td.transaksi_id = ?
        ) WHERE id = ?;";
        $stmtTotal = $conn->prepare($sqlTotal);
        $stmtTotal->bind_param("ii", $transaksi_id, $transaksi_id);
        $stmtTotal->execute();

        // 3. Commit jika kedua query berhasil
        $conn->commit();

        header('Location: ?url=/transaksiDetail&id=' . $transaksi_id);
        exit;
    } catch (Exception $e) {
        // Rollback jika terjadi kesalahan
        $conn->rollback();
        echo "ERROR : " . $e->getMessage();
    }
}
?>
