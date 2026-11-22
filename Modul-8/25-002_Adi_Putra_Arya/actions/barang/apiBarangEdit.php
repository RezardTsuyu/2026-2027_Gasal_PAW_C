<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $nama_barang = $_POST['nama_barang'] ?? '';
    $harga = (int)($_POST['harga'] ?? 0);

    $sql = "UPDATE barang SET nama_barang = ?, harga = ? WHERE id = ?";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $nama_barang, $harga, $id);
        $stmt->execute();
        header('Location: ?url=/barang');
        exit;
    } catch (Exception $e) {
        echo "ERROR : " . $e->getMessage();
    }
}
?>
