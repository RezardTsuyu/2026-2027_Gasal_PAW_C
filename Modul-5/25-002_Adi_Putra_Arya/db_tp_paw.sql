CREATE DATABASE `db_tp_paw` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_tp_paw`;

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(12) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `telp` varchar(12) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user` (
  `id_user` tinyint(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `level` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_barang_supplier` (`supplier_id`),
  CONSTRAINT `fk_barang_supplier` FOREIGN KEY (`supplier_id`)
    REFERENCES `supplier` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text,
  `total` int(11) NOT NULL DEFAULT 0,
  `pelanggan_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_transaksi_pelanggan` (`pelanggan_id`),
  CONSTRAINT `fk_transaksi_pelanggan` FOREIGN KEY (`pelanggan_id`)
    REFERENCES `pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`transaksi_id`, `barang_id`),
  KEY `idx_detail_barang` (`barang_id`),
  CONSTRAINT `fk_detail_transaksi` FOREIGN KEY (`transaksi_id`)
    REFERENCES `transaksi` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_detail_barang` FOREIGN KEY (`barang_id`)
    REFERENCES `barang` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waktu_bayar` datetime NOT NULL,
  `total` int(11) NOT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pembayaran_transaksi` (`transaksi_id`),
  CONSTRAINT `fk_pembayaran_transaksi` FOREIGN KEY (`transaksi_id`)
    REFERENCES `transaksi` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT. Maju Bersama', '08123456', 'Surabaya'),
(2, 'PT. Senang Sekali', '081515563', 'Bangkalan'),
(3, 'PT. Segar Segar', '0845454663', 'Surabaya'),
(4, 'CV. Sumber Rejeki', '0315551234', 'Sidoarjo'),
(5, 'PT. Indo Pangan Jaya', '081330012345', 'Gresik'),
(6, 'UD. Berkah Makmur', '085755500123', 'Malang'),
(7, 'PT. Cahaya Abadi', '082233344455', 'Surabaya'),
(8, 'CV. Mitra Sejahtera', '081234500987', 'Mojokerto'),
(9, 'PT. Nusantara Grosir', '0318889900', 'Jombang'),
(10, 'UD. Sinar Jaya', '087855566677', 'Pasuruan');

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
(1, 'Budi Santoso', 'L', '081211110001', 'Jl. Darmo Permai No. 12, Surabaya'),
(2, 'Siti Aminah', 'P', '081211110002', 'Jl. Manyar Kertoarjo No. 7, Surabaya'),
(3, 'Agus Prasetyo', 'L', '081211110003', 'Jl. Dinoyo No. 31, Surabaya'),
(4, 'Dewi Lestari', 'P', '081211110004', 'Jl. Raya Gubeng No. 18, Surabaya'),
(5, 'Rizky Ramadhan', 'L', '081211110005', 'Jl. Menur Pumpungan No. 2, Surabaya'),
(6, 'Putri Maharani', 'P', '081211110006', 'Jl. Ngagel Jaya No. 15, Surabaya'),
(7, 'Hendra Wijaya', 'L', '081211110007', 'Jl. Pakuwon Indah No. 9, Surabaya'),
(8, 'Nur Aisyah', 'P', '081211110008', 'Jl. Kertajaya Indah No. 40, Surabaya'),
(9, 'Fajar Nugroho', 'L', '081211110009', 'Jl. Rungkut Madya No. 22, Surabaya'),
(10, 'Lina Marlina', 'P', '081211110010', 'Jl. Jemursari No. 11, Surabaya');

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin', MD5('admin123'), 'Rina Kartika', 'Jl. Ketintang No. 10, Surabaya', '081230010001', 1),
(2, 'kasir01', MD5('kasir123'), 'Dimas Pratama', 'Jl. Wonokromo No. 25, Surabaya', '081230010002', 2),
(3, 'kasir02', MD5('kasir123'), 'Ayu Wulandari', 'Jl. Rungkut Asri No. 8, Surabaya', '081230010003', 2),
(4, 'kasir03', MD5('kasir123'), 'Bagas Saputra', 'Jl. Gubeng Kertajaya No. 5, Surabaya', '081230010004', 2),
(5, 'gudang01', MD5('gudang123'), 'Eko Susilo', 'Jl. Margomulyo No. 17, Surabaya', '081230010005', 3),
(6, 'gudang02', MD5('gudang123'), 'Yuni Astuti', 'Jl. Tandes Indah No. 3, Surabaya', '081230010006', 3),
(7, 'admin02', MD5('admin123'), 'Galih Permana', 'Jl. Mulyosari No. 21, Surabaya', '081230010007', 1),
(8, 'kasir04', MD5('kasir123'), 'Intan Permata', 'Jl. Kenjeran No. 44, Surabaya', '081230010008', 2),
(9, 'kasir05', MD5('kasir123'), 'Rendra Kusuma', 'Jl. Dukuh Kupang No. 9, Surabaya', '081230010009', 2),
(10, 'gudang03', MD5('gudang123'), 'Sekar Ayu', 'Jl. Pucang Anom No. 6, Surabaya', '081230010010', 3);

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Beras Premium 5 Kg', 68000, 50, 1),
(2, 'BRG002', 'Minyak Goreng 2 Liter', 36000, 80, 2),
(3, 'BRG003', 'Gula Pasir 1 Kg', 17000, 120, 3),
(4, 'BRG004', 'Telur Ayam 1 Kg', 29000, 60, 4),
(5, 'BRG005', 'Tepung Terigu 1 Kg', 13000, 90, 5),
(6, 'BRG006', 'Kopi Bubuk 200 gr', 18000, 70, 6),
(7, 'BRG007', 'Teh Celup isi 25', 9000, 150, 7),
(8, 'BRG008', 'Susu UHT 1 Liter', 19000, 100, 8),
(9, 'BRG009', 'Mi Instan Goreng', 3500, 300, 7),
(10, 'BRG010', 'Sabun Mandi Batang', 4500, 200, 6),
(11, 'BRG011', 'Air Mineral 600 ml', 3500, 240, 1),
(12, 'BRG012', 'Kecap Manis 600 ml', 22000, 65, 3);

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-05', 'Belanja kebutuhan dapur', 102000, 1),
(2, '2026-10-06', 'Pembelian minyak goreng', 36000, 2),
(3, '2026-10-07', 'Belanja telur dan mi instan', 93000, 3),
(4, '2026-10-08', 'Stok kopi dan teh warung', 36000, 4),
(5, '2026-10-09', 'Pembelian susu untuk acara', 57000, 5),
(6, '2026-10-12', 'Bahan membuat kue', 43000, 6),
(7, '2026-10-13', 'Air mineral untuk kantor', 42000, 7),
(8, '2026-10-14', 'Belanja bulanan', 40000, 8),
(9, '2026-10-15', 'Pembelian beras 2 karung', 136000, 9),
(10, '2026-10-16', 'Belanja stok warung', 142000, 10);

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 68000, 1),
(1, 3, 17000, 2),
(2, 2, 36000, 1),
(3, 4, 29000, 2),
(3, 9, 3500, 10),
(4, 6, 18000, 1),
(4, 7, 9000, 2),
(5, 8, 19000, 3),
(6, 5, 13000, 2),
(6, 3, 17000, 1),
(7, 11, 3500, 12),
(8, 12, 22000, 1),
(8, 10, 4500, 4),
(9, 1, 68000, 2),
(10, 9, 3500, 20),
(10, 2, 36000, 2);

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-05 10:15:00', 102000, 'TUNAI', 1),
(2, '2026-10-06 09:40:00', 36000, 'TRANSFER', 2),
(3, '2026-10-07 13:05:00', 93000, 'EDC', 3),
(4, '2026-10-08 11:20:00', 36000, 'TUNAI', 4),
(5, '2026-10-09 15:30:00', 57000, 'TRANSFER', 5),
(6, '2026-10-12 08:55:00', 43000, 'EDC', 6),
(7, '2026-10-13 14:10:00', 42000, 'TUNAI', 7),
(8, '2026-10-14 16:45:00', 40000, 'TRANSFER', 8),
(9, '2026-10-15 10:05:00', 136000, 'EDC', 9),
(10, '2026-10-16 12:30:00', 142000, 'TUNAI', 10);