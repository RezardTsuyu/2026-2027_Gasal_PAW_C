<?php 
$id = (int)($_GET['id'] ?? 0);
$sql = "DELETE FROM barang WHERE id = ?;";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: ?url=/barang');
    exit;
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
