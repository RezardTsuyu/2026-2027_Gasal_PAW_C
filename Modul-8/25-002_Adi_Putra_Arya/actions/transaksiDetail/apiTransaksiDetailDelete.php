<?php 
$id = (int)($_GET['id'] ?? 0);

$conn->begin_transaction();

try {
    $stmtGet = $conn->prepare("SELECT transaksi_id FROM transaksi_detail WHERE id = ?");
    $stmtGet->bind_param("i", $id);
    $stmtGet->execute();
    $row = $stmtGet->get_result()->fetch_assoc();
    $transaksi_id = (int)($row['transaksi_id'] ?? 0);

    $sql = "DELETE FROM transaksi_detail WHERE id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($transaksi_id > 0) {
        $sqlTotal = "UPDATE transaksi SET total = (
            SELECT COALESCE(SUM(b.harga * td.qty), 0)
            FROM transaksi_detail td
            JOIN barang b ON td.barang_id = b.id
            WHERE td.transaksi_id = ?
        ) WHERE id = ?;";
        $stmtTotal = $conn->prepare($sqlTotal);
        $stmtTotal->bind_param("ii", $transaksi_id, $transaksi_id);
        $stmtTotal->execute();
    }

    $conn->commit();

    if ($transaksi_id > 0) {
        header('Location: ?url=/transaksiDetail&id=' . $transaksi_id);
    } else {
        header('Location: ?url=/transaksiDetail');
    }
} catch (Exception $e) {
    $conn->rollback();
    echo "ERROR : " . $e->getMessage();
}
?>
