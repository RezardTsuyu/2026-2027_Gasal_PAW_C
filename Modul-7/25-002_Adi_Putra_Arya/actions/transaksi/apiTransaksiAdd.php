<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO transaksi (tanggal, pelanggan) VALUES (?, ?);";
    $tanggal = $_POST['tanggal'] ?? '';
    $pelanggan = $_POST['pelanggan'] ?? '';

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $tanggal, $pelanggan);
        $stmt->execute();
        header('Location: ?url=/transaksi');
        exit;
    } catch (Exception $e) {
        echo "ERROR : " . $e->getMessage();
    }
}
?>