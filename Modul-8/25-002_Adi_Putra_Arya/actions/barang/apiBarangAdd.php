<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO barang (nama_barang, harga) VALUES (?, ?);";
    $nama_barang = $_POST['nama_barang'] ?? '';
    $harga = (int)($_POST['harga'] ?? 0);

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nama_barang, $harga);
        $stmt->execute();
        header('Location: ?url=/barang');
        exit;
    } catch (Exception $e) {
        echo "ERROR : " . $e->getMessage();
    }
}
?>
