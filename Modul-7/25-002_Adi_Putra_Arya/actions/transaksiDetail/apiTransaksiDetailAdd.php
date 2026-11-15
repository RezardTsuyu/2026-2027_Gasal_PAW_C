<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaksi_id = (int)($_POST['transaksi_id'] ?? 0);
    $barang_id = (int)($_POST['barang_id'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 1);

    $conn->begin_transaction();

    try {
        $sql = "INSERT INTO transaksi_detail (transaksi_id, barang_id, qty) VALUES (?, ?, ?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $transaksi_id, $barang_id, $qty);
        $stmt->execute();

        $sqlTotal = "UPDATE transaksi SET total = (
            SELECT COALESCE(SUM(b.harga * td.qty), 0)
            FROM transaksi_detail td
            JOIN barang b ON td.barang_id = b.id
            WHERE td.transaksi_id = ?
        ) WHERE id = ?;";
        $stmtTotal = $conn->prepare($sqlTotal);
        $stmtTotal->bind_param("ii", $transaksi_id, $transaksi_id);
        $stmtTotal->execute();

        $conn->commit();

        header('Location: ?url=/transaksiDetail&id=' . $transaksi_id);
    } catch (Exception $e) {
        $conn->rollback();
        echo "ERROR : " . $e->getMessage();
    }
}
?>
