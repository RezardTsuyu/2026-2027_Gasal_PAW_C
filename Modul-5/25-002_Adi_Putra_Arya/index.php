<?php
// index.php - Data Master Supplier (tampil data + tombol Tambah, Edit, Hapus)
require_once "header.php";

// pesan hasil proses (dikirim lewat ?status=... setelah redirect)
$pesan = array(
    "tambah"  => array("ok",  "Data supplier berhasil ditambahkan."),
    "edit"    => array("ok",  "Data supplier berhasil diperbarui."),
    "hapus"   => array("ok",  "Data supplier berhasil dihapus."),
    "dipakai" => array("err", "Supplier tidak dapat dihapus karena masih dipakai data barang."),
    "gagal"   => array("err", "Data tidak ditemukan atau terjadi kesalahan."),
);
$status = ambil($_GET, "status");

// mengambil data supplier dari database
$hasil = mysqli_query($koneksi, "SELECT id, nama, telp, alamat FROM supplier ORDER BY id");
?>
<div class="judul">
    <h2>Data Master Supplier</h2>
    <a href="supplier_tambah.php" class="btn btn-hijau">Tambah Data</a>
</div>

<?php if (isset($pesan[$status])) { ?>
<div class="alert alert-<?= $pesan[$status][0] ?>"><?= e($pesan[$status][1]) ?></div>
<?php } ?>

<table class="data">
    <thead>
        <tr>
            <th style="width: 50px">No</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th style="width: 150px">Tindakan</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($hasil)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= e($row["nama"]) ?></td>
            <td><?= e($row["telp"]) ?></td>
            <td><?= e($row["alamat"]) ?></td>
            <td>
                <a href="supplier_edit.php?id=<?= (int) $row["id"] ?>"
                   class="btn btn-oranye">Edit</a>
                <form action="supplier_hapus.php" method="post" class="inline"
                      onsubmit="return confirm('Anda yakin akan menghapus supplier ini?');">
                    <input type="hidden" name="id" value="<?= (int) $row["id"] ?>">
                    <button type="submit" class="btn btn-merah">Hapus</button>
                </form>
            </td>
        </tr>
    <?php } ?>
    <?php if ($no == 1) { ?>
        <tr><td colspan="5" style="text-align: center">Belum ada data supplier.</td></tr>
    <?php } ?>
    </tbody>
</table>

</div>
</body>
</html>
