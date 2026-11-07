<?php
// TANPA_DB memberi tahu koneksi.php agar tidak langsung memilih database,
// karena database "penjualan" mungkin belum ada saat script ini pertama kali dijalankan.
define('TANPA_DB', true);
require 'koneksi.php';

$sql = <<<'SQL'
CREATE DATABASE IF NOT EXISTS penjualan CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE penjualan;

-- Hapus tabel dari yang paling "anak" ke yang paling "induk" (urutan penting karena ada foreign key)
DROP TABLE IF EXISTS transaksi_detail;
DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS transaksi;
DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS supplier;
DROP TABLE IF EXISTS pelanggan;
DROP TABLE IF EXISTS `user`;

-- ===== Tabel induk / master =====
CREATE TABLE supplier (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  telp VARCHAR(12),
  alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE pelanggan (
  id VARCHAR(20) PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  telp VARCHAR(12),
  alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE `user` (
  id_user TINYINT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL UNIQUE,
  password VARCHAR(35) NOT NULL,
  nama VARCHAR(50) NOT NULL,
  alamat VARCHAR(150),
  hp VARCHAR(20),
  level TINYINT(1) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(10) NOT NULL UNIQUE,
  nama_barang VARCHAR(100) NOT NULL,
  harga INT NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  supplier_id INT NOT NULL,
  FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ===== Tabel transaksi (master) dan turunannya (detail, pembayaran) =====
CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_transaksi DATE NOT NULL,
  keterangan TEXT,
  total INT NOT NULL DEFAULT 0,
  pelanggan_id VARCHAR(20) NOT NULL,
  FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Sesuai diagram: tidak ada kolom id, kuncinya gabungan (transaksi_id, barang_id)
-- sehingga barang yang sama tidak mungkin tersimpan dua kali dalam satu transaksi.
CREATE TABLE transaksi_detail (
  transaksi_id INT NOT NULL,
  barang_id INT NOT NULL,
  harga INT NOT NULL,
  qty INT NOT NULL,
  PRIMARY KEY (transaksi_id, barang_id),
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,
  FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_bayar DATETIME NOT NULL,
  total INT NOT NULL,
  metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
  transaksi_id INT NOT NULL,
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===== Data awal =====

INSERT INTO supplier (id, nama, telp, alamat) VALUES
  (1, 'PT Sinar Alat Tulis', '0215550101', 'Jl. Merdeka No. 10, Jakarta'),
  (2, 'CV Kertas Jaya', '0225550202', 'Jl. Asia Afrika No. 25, Bandung'),
  (3, 'UD Maju Bersama', '0245550303', 'Jl. Pandanaran No. 7, Semarang'),
  (4, 'PT Warna Nusantara', '0274555040', 'Jl. Malioboro No. 15, Yogyakarta'),
  (5, 'CV Pena Mas', '0614555050', 'Jl. Gatot Subroto No. 3, Medan'),
  (6, 'UD Berkah Stationery', '0361555060', 'Jl. Sunset Road No. 9, Denpasar');

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
  ('P001', 'Andi Pratama', 'L', '081234560001', 'Jl. Melati No. 1, Jakarta'),
  ('P002', 'Budi Santoso', 'L', '081234560002', 'Jl. Mawar No. 2, Bandung'),
  ('P003', 'Citra Dewi', 'P', '081234560003', 'Jl. Kenanga No. 3, Semarang'),
  ('P004', 'Deni Setiawan', 'L', '081234560004', 'Jl. Anggrek No. 4, Yogyakarta'),
  ('P005', 'Eka Rahmawati', 'P', '081234560005', 'Jl. Dahlia No. 5, Malang'),
  ('P006', 'Fajar Nugraha', 'L', '081234560006', 'Jl. Cempaka No. 6, Bogor'),
  ('P007', 'Gita Permata', 'P', '081234560007', 'Jl. Teratai No. 7, Solo'),
  ('P008', 'Hadi Wijaya', 'L', '081234560008', 'Jl. Flamboyan No. 8, Medan'),
  ('P009', 'Indah Lestari', 'P', '081234560009', 'Jl. Sakura No. 9, Denpasar'),
  ('P010', 'Joko Supriadi', 'L', '081234560010', 'Jl. Kamboja No. 10, Makassar');

INSERT INTO `user` (username, password, nama, alamat, hp, level) VALUES
  ('admin', MD5('admin123'), 'Administrator', 'Jl. Pemuda No. 1, Jakarta', '081200000001', 1),
  ('kasir1', MD5('kasir123'), 'Kasir Satu', 'Jl. Veteran No. 2, Jakarta', '081200000002', 2),
  ('kasir2', MD5('kasir123'), 'Kasir Dua', 'Jl. Veteran No. 3, Jakarta', '081200000003', 2),
  ('kasir3', MD5('kasir123'), 'Kasir Tiga', 'Jl. Veteran No. 4, Jakarta', '081200000004', 2),
  ('supervisor', MD5('super123'), 'Supervisor Toko', 'Jl. Pemuda No. 5, Jakarta', '081200000005', 1);

INSERT INTO barang (id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
  (1, 'BRG-001', 'Buku Tulis A5', 5000, 120, 2),
  (2, 'BRG-002', 'Pulpen Gel Hitam', 4000, 200, 1),
  (3, 'BRG-003', 'Pensil 2B', 2500, 150, 1),
  (4, 'BRG-004', 'Penghapus Karet', 1500, 180, 1),
  (5, 'BRG-005', 'Penggaris 30cm', 3000, 90, 3),
  (6, 'BRG-006', 'Correction Tape (Tipe-X)', 6000, 60, 3),
  (7, 'BRG-007', 'Spidol Whiteboard', 8500, 75, 4),
  (8, 'BRG-008', 'Map Folio Plastik', 2000, 300, 2),
  (9, 'BRG-009', 'Sticky Notes Pastel', 7500, 80, 4),
  (10, 'BRG-010', 'Gunting Kertas', 9000, 40, 5),
  (11, 'BRG-011', 'Lakban Bening', 6500, 50, 5),
  (12, 'BRG-012', 'Stapler Mini', 12000, 30, 6);

INSERT INTO transaksi (id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
  (1, '2026-11-01', 'Pembelian alat tulis kelas', 24500, 'P001'),
  (2, '2026-11-01', 'Pembelian perlengkapan menggambar', 13000, 'P002'),
  (3, '2026-11-02', 'Pembelian perlengkapan kantor', 36500, 'P003'),
  (4, '2026-11-02', 'Pembelian map dan gunting', 19000, 'P004'),
  (5, '2026-11-03', 'Pembelian buku dan pensil', 30000, 'P005'),
  (6, '2026-11-03', 'Pembelian spidol dan penghapus', 28500, 'P006'),
  (7, '2026-11-04', 'Pembelian alat tulis bulanan', 33000, 'P007'),
  (8, '2026-11-04', 'Pembelian map arsip', 26000, 'P008'),
  (9, '2026-11-04', 'Pembelian perlengkapan tugas', 28000, 'P009'),
  (10, '2026-11-04', 'Pembelian perlengkapan lomba', 38500, 'P010');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
  (1, 1, 5000, 3),
  (1, 2, 4000, 2),
  (1, 4, 1500, 1),
  (2, 3, 2500, 4),
  (2, 5, 3000, 1),
  (3, 6, 6000, 2),
  (3, 7, 8500, 2),
  (3, 9, 7500, 1),
  (4, 10, 9000, 1),
  (4, 8, 2000, 5),
  (5, 1, 5000, 5),
  (5, 3, 2500, 2),
  (6, 7, 8500, 3),
  (6, 4, 1500, 2),
  (7, 2, 4000, 3),
  (7, 9, 7500, 2),
  (7, 5, 3000, 2),
  (8, 8, 2000, 10),
  (8, 6, 6000, 1),
  (9, 10, 9000, 2),
  (9, 1, 5000, 2),
  (10, 2, 4000, 5),
  (10, 3, 2500, 4),
  (10, 7, 8500, 1);

INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES
  ('2026-11-01 09:15:00', 24500, 'TUNAI', 1),
  ('2026-11-01 11:40:00', 13000, 'TUNAI', 2),
  ('2026-11-02 10:05:00', 36500, 'TRANSFER', 3),
  ('2026-11-02 13:20:00', 19000, 'EDC', 4),
  ('2026-11-03 08:50:00', 30000, 'TUNAI', 5),
  ('2026-11-03 14:10:00', 28500, 'TRANSFER', 6),
  ('2026-11-04 09:30:00', 33000, 'EDC', 7),
  ('2026-11-04 15:45:00', 26000, 'TUNAI', 8),
  ('2026-11-04 12:25:00', 28000, 'TRANSFER', 9),
  ('2026-11-04 16:05:00', 38500, 'EDC', 10);
SQL;

try {
	mysqli_multi_query($conn, $sql);
	// multi_query menjalankan banyak statement sekaligus. Hasil tiap statement HARUS dibaca satu per satu,
	// kalau tidak, error pada statement ke-2 dan seterusnya tidak akan pernah terdeteksi.
	do {
		if ($hasil = mysqli_store_result($conn)) {
			mysqli_free_result($hasil);
		}
	} while (mysqli_more_results($conn) && mysqli_next_result($conn));
	echo "database berhasil dibuat ulang. <a href=\"index.php\">Buka aplikasi</a>";
} catch (Exception $e) {
	echo "Error: ". $e->getMessage();
}
mysqli_close($conn);
?>