<?php
// Hapus (unset) semua data session login
unset($_SESSION['login']);
unset($_SESSION['id_user']);
unset($_SESSION['username']);
unset($_SESSION['nama_user']);
unset($_SESSION['level']);

session_destroy();   // hancurkan session di server

header('Location: ?url=/login');
exit;
?>
