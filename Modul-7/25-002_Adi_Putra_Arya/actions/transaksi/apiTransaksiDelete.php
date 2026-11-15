<?php 
$id = (int)($_GET['id'] ?? 0);
$sql = "DELETE FROM transaksi WHERE id=?;";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: ?url=/transaksi');
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>