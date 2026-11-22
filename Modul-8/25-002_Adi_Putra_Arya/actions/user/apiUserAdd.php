<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $nama_user = trim($_POST['nama_user'] ?? '');
    $level = (int)($_POST['level'] ?? 0);

    if ($username === '' || $nama_user === '' || !in_array($level, [1, 2], true)) {
        setFlash('Username, nama, dan level wajib diisi dengan benar.', 'error');
        header('Location: ?url=/user/add');
        exit;
    }
    if (strlen($password) < 6) {
        setFlash('Password minimal 6 karakter.', 'error');
        header('Location: ?url=/user/add');
        exit;
    }

    // Password tidak disimpan apa adanya, tetapi dalam bentuk hash
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username, password, nama_user, level) VALUES (?, ?, ?, ?);";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $hash, $nama_user, $level);
        $stmt->execute();
        setFlash('User berhasil ditambahkan.');
        header('Location: ?url=/user');
        exit;
    } catch (Exception $e) {
        if ($e->getCode() === 1062) {   // kode error duplicate entry
            setFlash('Username sudah dipakai user lain.', 'error');
            header('Location: ?url=/user/add');
            exit;
        }
        echo "ERROR : " . $e->getMessage();
    }
}
?>
