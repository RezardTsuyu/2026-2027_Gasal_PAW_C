<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="halaman-login">
    <div class="kotak-login">
        <h2>Sistem Penjualan</h2>
        <p class="sub">Silakan login untuk melanjutkan</p>
        <?php tampilFlash(); ?>
        <form method="post" action="?url=/api/login">
            <label>Username :
                <input type="text" name="username" placeholder="masukkan username..." required autofocus>
            </label>
            <label>Password :
                <input type="password" name="password" placeholder="masukkan password..." required>
            </label>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
