<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_supplier = trim($_POST['nama_supplier'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');

    if ($nama_supplier === '') {
        setFlash('Nama supplier wajib diisi.', 'error');
        header('Location: ?url=/supplier/add');
        exit;
    }

    $sql = "INSERT INTO supplier (nama_supplier, alamat, telepon) VALUES (?, ?, ?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nama_supplier, $alamat, $telepon);
        $stmt->execute();
        setFlash('Supplier berhasil ditambahkan.');
        header('Location: ?url=/supplier');
        exit;
    } catch (Exception $e) {
        echo "ERROR : " . $e->getMessage();
    }
}
?>
