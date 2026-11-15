<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $tanggal = $_POST['tanggal'] ?? '';
    $pelanggan = $_POST['pelanggan'] ?? '';

    $sql = "UPDATE transaksi SET tanggal = ?, pelanggan = ? WHERE id = ?";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $tanggal, $pelanggan, $id);
        $stmt->execute();
        header('Location: ?url=/transaksi');
        exit;
    } catch (Exception $e) {
        echo "ERROR : " . $e->getMessage();
    }
}
?>
