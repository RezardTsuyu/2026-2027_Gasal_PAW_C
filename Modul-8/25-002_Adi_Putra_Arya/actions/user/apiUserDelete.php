<?php
$id = (int)($_GET['id'] ?? 0);

// Akun yang sedang login tidak boleh menghapus dirinya sendiri
if ($id === $_SESSION['id_user']) {
    setFlash('Akun yang sedang dipakai tidak boleh dihapus.', 'error');
    header('Location: ?url=/user');
    exit;
}

$sql = "DELETE FROM user WHERE id = ?;";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    setFlash('User berhasil dihapus.');
    header('Location: ?url=/user');
    exit;
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}
?>
