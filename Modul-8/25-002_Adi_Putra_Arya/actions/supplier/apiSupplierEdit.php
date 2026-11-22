<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $nama_supplier = trim($_POST['nama_supplier'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');

    if ($nama_supplier === '') {
        setFlash('Nama supplier wajib diisi.', 'error');
        header('Location: ?url=/supplier/edit&id=' . $id);
        exit;
    }

    $sql = "UPDATE supplier SET nama_supplier = ?, alamat = ?, telepon = ? WHERE id = ?";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nama_supplier, $alamat, $telepon, $id);
        $stmt->execute();
        setFlash('Supplier berhasil diubah.');
        header('Location: ?url=/supplier');
        exit;
    } catch (Exception $e) {
        echo "ERROR : " . $e->getMessage();
    }
}
?>
