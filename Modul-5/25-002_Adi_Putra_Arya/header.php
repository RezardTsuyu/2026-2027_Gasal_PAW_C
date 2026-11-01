<?php
// header.php - bagian atas halaman: bar judul dan CSS
require_once "koneksi.php";

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>TP Modul 5 - Database</title>
<style>
* { box-sizing: border-box; }
body { margin: 0; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
       font-size: 14px; color: #333; background: #fff; }
.wrap { width: 92%; max-width: 980px; margin: 0 auto; }

.navbar { background: linear-gradient(#0a5ba8, #063a73); margin-bottom: 24px; }
.navbar .brand { display: inline-block; color: #fff; font-weight: bold; padding: 14px 0; }

.judul { display: flex; justify-content: space-between; align-items: center;
         border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 18px; }
.judul h2 { margin: 0; font-weight: normal; font-size: 26px; color: #3a7ca8; }

.btn { display: inline-block; padding: 6px 12px; font-size: 13px; line-height: 1.4;
       color: #fff; border: 1px solid transparent; border-radius: 3px; cursor: pointer;
       text-decoration: none; font-family: inherit; }
.btn:hover { opacity: .9; }
.btn-hijau  { background: linear-gradient(#6bb24a, #4f9a2f); border-color: #47892b; }
.btn-oranye { background: linear-gradient(#e8710a, #c25a00); border-color: #b05200; }
.btn-merah  { background: linear-gradient(#d9323b, #b01e27); border-color: #9c1a22; }

table.data { width: 100%; border-collapse: collapse; border: 1px solid #ddd; }
table.data th { background: #d9edf7; color: #2c4a63; text-align: left; padding: 8px;
                border-bottom: 2px solid #c5dff0; }
table.data td { padding: 8px; border-top: 1px solid #ddd; vertical-align: middle; }
table.data tbody tr:hover td { background: #f7fbfe; }
form.inline { display: inline; margin: 0; }

.alert { padding: 10px 14px; border-radius: 3px; margin-bottom: 14px; }
.alert-ok  { background: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6; }
.alert-err { background: #f2dede; color: #a94442; border: 1px solid #ebccd1; }

.form-row { display: flex; align-items: flex-start; margin-bottom: 15px; }
.form-row label { width: 22%; text-align: right; padding: 7px 15px 0 0; font-weight: bold; }
.form-row .kolom { flex: 1; }
.form-row input { width: 100%; padding: 6px 12px; font-size: 14px; font-family: inherit;
                  border: 1px solid #ccc; border-radius: 4px; }
.i-lebar { max-width: 480px; }
.i-sedang { max-width: 320px; }
.salah { color: #a94442; font-size: 12px; margin-top: 4px; }
.form-aksi { margin-left: 22%; }
</style>
</head>
<body>
<div class="navbar">
    <div class="wrap">
        <span class="brand">TP Modul 5</span>
    </div>
</div>
<div class="wrap">
