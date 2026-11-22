<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $nama_user = trim($_POST['nama_user'] ?? '');
    $level = (int)($_POST['level'] ?? 0);
    $akunSendiri = ($id === $_SESSION['id_user']);

    if ($username === '' || $nama_user === '' || !in_array($level, [1, 2], true)) {
        setFlash('Username, nama, dan level wajib diisi dengan benar.', 'error');
        header('Location: ?url=/user/edit&id=' . $id);
        exit;
    }
    if ($password !== '' && strlen($password) < 6) {
        setFlash('Password minimal 6 karakter.', 'error');
        header('Location: ?url=/user/edit&id=' . $id);
        exit;
    }
    if ($akunSendiri && $level !== $_SESSION['level']) {
        setFlash('Level akun yang sedang dipakai tidak boleh diubah.', 'error');
        header('Location: ?url=/user/edit&id=' . $id);
        exit;
    }

    try {
        if ($password === '') {   // password kosong = tidak diganti
            $sql = "UPDATE user SET username = ?, nama_user = ?, level = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $username, $nama_user, $level, $id);
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE user SET username = ?, nama_user = ?, level = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisi", $username, $nama_user, $level, $hash, $id);
        }
        $stmt->execute();

        if ($akunSendiri) {   // nama di navbar ikut diperbarui
            $_SESSION['nama_user'] = $nama_user;
            $_SESSION['username'] = $username;
        }
        setFlash('User berhasil diubah.');
        header('Location: ?url=/user');
        exit;
    } catch (Exception $e) {
        if ($e->getCode() === 1062) {
            setFlash('Username sudah dipakai user lain.', 'error');
            header('Location: ?url=/user/edit&id=' . $id);
            exit;
        }
        echo "ERROR : " . $e->getMessage();
    }
}
?>
