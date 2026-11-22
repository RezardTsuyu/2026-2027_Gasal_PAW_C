<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // 1. Validasi input kosong
    if ($username === '' || $password === '') {
        setFlash('Username dan password wajib diisi.', 'error');
        header('Location: ?url=/login');
        exit;
    }

    // 2. Cari user (prepared statement -> aman dari SQL Injection)
    $sql = "SELECT id, username, password, nama_user, level FROM user WHERE username = ?";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
    } catch (Exception $e) {
        echo "ERROR : " . $e->getMessage();
        exit;
    }

    // 3. Cocokkan password dengan hash di database
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);   // ganti ID session (anti session fixation)

        // 4. Set session
        $_SESSION['login']     = true;
        $_SESSION['id_user']   = (int)$user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['nama_user'] = $user['nama_user'];
        $_SESSION['level']     = (int)$user['level'];

        header('Location: ?url=/');
        exit;
    }

    // Pesan sengaja umum agar tidak membocorkan username yang valid
    setFlash('Username atau password salah.', 'error');
    header('Location: ?url=/login');
    exit;
}
header('Location: ?url=/login');
exit;
?>
