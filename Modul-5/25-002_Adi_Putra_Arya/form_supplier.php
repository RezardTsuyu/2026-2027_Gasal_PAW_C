<?php
// form_supplier.php - form yang dipakai bersama oleh halaman tambah dan edit
// variabel yang dibutuhkan: $aksi, $tombol, $nama, $telp, $alamat, $error
?>
<form method="post" action="<?= e($aksi) ?>">
    <div class="form-row">
        <label for="nama">Nama</label>
        <div class="kolom">
            <input type="text" id="nama" name="nama" class="i-lebar"
                   placeholder="Nama" maxlength="100" value="<?= e($nama) ?>">
            <?php if (isset($error["nama"])) { ?>
            <div class="salah"><?= e($error["nama"]) ?></div>
            <?php } ?>
        </div>
    </div>
    <div class="form-row">
        <label for="telp">Telp</label>
        <div class="kolom">
            <input type="text" id="telp" name="telp" class="i-sedang"
                   placeholder="telp" maxlength="12" value="<?= e($telp) ?>">
            <?php if (isset($error["telp"])) { ?>
            <div class="salah"><?= e($error["telp"]) ?></div>
            <?php } ?>
        </div>
    </div>
    <div class="form-row">
        <label for="alamat">Alamat</label>
        <div class="kolom">
            <input type="text" id="alamat" name="alamat" class="i-sedang"
                   placeholder="alamat" value="<?= e($alamat) ?>">
            <?php if (isset($error["alamat"])) { ?>
            <div class="salah"><?= e($error["alamat"]) ?></div>
            <?php } ?>
        </div>
    </div>
    <div class="form-aksi">
        <button type="submit" class="btn btn-hijau"><?= e($tombol) ?></button>
        <a href="index.php" class="btn btn-merah">Batal</a>
    </div>
</form>
