<?php
$id = (int)($_GET['id'] ?? 0);
$sql = "DELETE FROM pelanggan WHERE id = ?;";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    setFlash('Pelanggan berhasil dihapus.');
    header('Location: ?url=/pelanggan');
    exit;
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
