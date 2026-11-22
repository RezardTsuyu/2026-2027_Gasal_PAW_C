<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = trim($_POST['nama_pelanggan'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');

    if ($nama_pelanggan === '') {
        setFlash('Nama pelanggan wajib diisi.', 'error');
        header('Location: ?url=/pelanggan/add');
        exit;
    }

    $sql = "INSERT INTO pelanggan (nama_pelanggan, alamat, telepon) VALUES (?, ?, ?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nama_pelanggan, $alamat, $telepon);
        $stmt->execute();
        setFlash('Pelanggan berhasil ditambahkan.');
        header('Location: ?url=/pelanggan');
        exit;
    } catch (Exception $e) {
        echo "ERROR : " . $e->getMessage();
    }
}
?>
