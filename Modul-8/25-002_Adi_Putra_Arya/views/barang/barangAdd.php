<h2>Tambah Barang</h2>
<form method="post" action="?url=/api/barang/add">
    <label>Nama Barang :
        <input type="text" name="nama_barang" placeholder="masukkan nama barang..." required>
    </label>    
    <label>Harga :
        <input type="number" name="harga" min="0" placeholder="masukkan harga..." required>
    </label>
    <button type="submit">Tambahkan</button>
</form>
