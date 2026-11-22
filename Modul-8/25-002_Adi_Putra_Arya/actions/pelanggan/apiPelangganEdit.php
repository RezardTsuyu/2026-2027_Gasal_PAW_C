<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $nama_pelanggan = trim($_POST['nama_pelanggan'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');

    if ($nama_pelanggan === '') {
        setFlash('Nama pelanggan wajib diisi.', 'error');
        header('Location: ?url=/pelanggan/edit&id=' . $id);
        exit;
    }

    $sql = "UPDATE pelanggan SET nama_pelanggan = ?, alamat = ?, telepon = ? WHERE id = ?";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nama_pelanggan, $alamat, $telepon, $id);
        $stmt->execute();
        setFlash('Pelanggan berhasil diubah.');
        header('Location: ?url=/pelanggan');
        exit;
    } catch (Exception $e) {
        echo "ERROR : " . $e->getMessage();
    }
}
?>
