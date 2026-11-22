<h2>Tambah User</h2>
<form method="post" action="?url=/api/user/add" autocomplete="off">
    <label>Username :
        <input type="text" name="username" placeholder="masukkan username..." required>
    </label>
    <label>Password :
        <input type="password" name="password" minlength="6" placeholder="minimal 6 karakter..." required>
    </label>
    <label>Nama User :
        <input type="text" name="nama_user" placeholder="masukkan nama lengkap..." required>
    </label>
    <label>Level :
        <select name="level" required>
            <option value="1">1 - Owner</option>
            <option value="2" selected>2 - Kasir</option>
        </select>
    </label>
    <button type="submit">Tambahkan</button>
</form>
