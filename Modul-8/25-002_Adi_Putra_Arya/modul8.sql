-- ============================================================
-- TP Modul 8 PAW - Session dan Security
-- Tambahan untuk database KampusDB (Modul 7). Jalankan SETELAH
-- kampusdb.sql diimpor: phpMyAdmin > pilih KampusDB > Import.
-- Tabel barang, transaksi, transaksi_detail TIDAK diubah.
--
-- Akun contoh (password disimpan sebagai hash bcrypt):
--   owner / owner123  -> level 1 (Owner), nama: Budi
--   kasir / kasir123  -> level 2 (Kasir), nama: Wati
--   (user lain juga memakai password kasir123)
-- ============================================================

USE KampusDB;

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_user VARCHAR(100) NOT NULL,
    level TINYINT NOT NULL COMMENT '1 = owner, 2 = kasir'
) ENGINE=InnoDB;

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100) NOT NULL,
    alamat VARCHAR(200),
    telepon VARCHAR(20)
) ENGINE=InnoDB;

CREATE TABLE pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(100) NOT NULL,
    alamat VARCHAR(200),
    telepon VARCHAR(20)
) ENGINE=InnoDB;

INSERT INTO user (username, password, nama_user, level) VALUES
('owner', '$2y$12$gtIus197njffHHRGXIM7FeIip7ZKEf7iNXxSd5rVQMJOXuE3y7.YW', 'Budi', 1),
('kasir', '$2y$12$vpt5xa9o8BYGPFcoSg4GtOqNNt3QhJqnEPCGgxORAjjfTK2vJ3Si.', 'Wati', 2),
('rina', '$2y$12$KmGF7HOReb0ZCd9vq1cKoOvmtZtGHOsGJkxvy5FUimBGkmik4Ozwe', 'Rina Wulandari', 2),
('dimas', '$2y$12$zuN3kbMaP0W6hMQP/s/R0e1EeHZ7ezTHx.GwnwZBeFj3gZALdi65W', 'Dimas Pratama', 2),
('eka', '$2y$12$vvUaNKTYn7u7BxPa/uUwTOmD6tBldf9XnAFb2nvIsFNuYAvD.Urhq', 'Eka Putri', 2);

INSERT INTO supplier (nama_supplier, alamat, telepon) VALUES
('PT Sinar Alat Tulis', 'Jl. Rungkut Industri No. 12, Surabaya', '031-8431122'),
('CV Bintang Kertas', 'Jl. Halim Perdanakusuma No. 5, Bangkalan', '0313-3095577'),
('UD Maju Jaya Stationery', 'Jl. Jaksa Agung Suprapto No. 18, Sampang', '0323-321456'),
('PT Nusantara Office Supply', 'Jl. Raya Waru No. 77, Sidoarjo', '031-8556677'),
('CV Cahaya Prima', 'Jl. Raya Pamekasan No. 31, Pamekasan', '0324-322118');

INSERT INTO pelanggan (nama_pelanggan, alamat, telepon) VALUES
('Andi Pratama', 'Kamal, Bangkalan', '081234560001'),
('Budi Santoso', 'Socah, Bangkalan', '081234560002'),
('Citra Dewi', 'Burneh, Bangkalan', '081234560003'),
('Deni Setiawan', 'Arosbaya, Bangkalan', '081234560004'),
('Eka Rahmawati', 'Galis, Bangkalan', '081234560005'),
('Fajar Nugraha', 'Tanah Merah, Bangkalan', '081234560006');
