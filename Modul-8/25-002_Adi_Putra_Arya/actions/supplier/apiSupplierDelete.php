<?php
$id = (int)($_GET['id'] ?? 0);
$sql = "DELETE FROM supplier WHERE id = ?;";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    setFlash('Supplier berhasil dihapus.');
    header('Location: ?url=/supplier');
    exit;
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
