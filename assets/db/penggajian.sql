-- Adminer 4.8.1 MySQL 8.0.30 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `data_jabatan`;
CREATE TABLE `data_jabatan` (
  `id_jabatan` int NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(120) NOT NULL,
  `gaji_pokok` varchar(50) NOT NULL,
  `tj_transport` varchar(50) NOT NULL,
  `uang_makan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `data_jabatan` (`id_jabatan`, `nama_jabatan`, `gaji_pokok`, `tj_transport`, `uang_makan`) VALUES
(1,	'HRD',	'4000000',	'600000',	'400000'),
(2,	'Staff Marketing',	'2500000',	'300000',	'200000'),
(3,	'Admin',	'2200000',	'300000',	'200000'),
(4,	'Sales',	'2500000',	'300000',	'200000');

DROP TABLE IF EXISTS `data_kehadiran`;
CREATE TABLE `data_kehadiran` (
  `id_kehadiran` int NOT NULL AUTO_INCREMENT,
  `bulan` varchar(15) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_pegawai` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL,
  `hadir` int NOT NULL,
  `sakit` int NOT NULL,
  `alpha` int NOT NULL,
  `lembur` int NOT NULL,
  PRIMARY KEY (`id_kehadiran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `data_kehadiran` (`id_kehadiran`, `bulan`, `nik`, `nama_pegawai`, `jenis_kelamin`, `nama_jabatan`, `hadir`, `sakit`, `alpha`, `lembur`) VALUES
(11,	'012024',	'0987654321',	'Dodi',	'Laki-Laki',	'Staff Marketing',	2,	3,	0,	3),
(12,	'012024',	'123456789',	'Fauzi',	'Laki-Laki',	'Admin',	2,	3,	4,	0);

DROP TABLE IF EXISTS `data_pegawai`;
CREATE TABLE `data_pegawai` (
  `id_pegawai` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) NOT NULL,
  `nama_pegawai` varchar(100) NOT NULL,
  `username` varchar(120) NOT NULL,
  `password` varchar(32) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `hak_akses` int NOT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `data_pegawai` (`id_pegawai`, `nik`, `nama_pegawai`, `username`, `password`, `jenis_kelamin`, `jabatan`, `tanggal_masuk`, `status`, `photo`, `hak_akses`) VALUES
(1,	'123456789',	'Fauzi',	'fauzi',	'0bd9897bf12294ce35fdc0e21065c8a7',	'Laki-Laki',	'Admin',	'2020-12-26',	'Karyawan Tetap',	'pegawai-210101-a7ca89f5fc.png',	1),
(2,	'0987654321',	'Dodi',	'dodi',	'dc82a0e0107a31ba5d137a47ab09a26b',	'Laki-Laki',	'Staff Marketing',	'2021-01-02',	'Karyawan Tidak Tetap',	'pegawai-210101-9847084dc8.png',	2);

DROP TABLE IF EXISTS `hak_akses`;
CREATE TABLE `hak_akses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(50) NOT NULL,
  `hak_akses` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `hak_akses` (`id`, `keterangan`, `hak_akses`) VALUES
(1,	'admin',	1),
(2,	'pegawai',	2);

DROP TABLE IF EXISTS `lembur`;
CREATE TABLE `lembur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT (curdate()),
  `tanggal_pulang` date DEFAULT NULL,
  `waktu` time DEFAULT (curtime()),
  `waktu_pulang` time DEFAULT NULL,
  `status_lembur` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_pulang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `lembur` (`id`, `id_pegawai`, `nik`, `tanggal`, `tanggal_pulang`, `waktu`, `waktu_pulang`, `status_lembur`, `image`, `image_pulang`) VALUES
(7,	4,	'09876543211',	'2024-01-14',	NULL,	'21:18:57',	NULL,	'1',	'image_1705267137.jpg',	NULL),
(8,	2,	'0987654321',	'2024-01-14',	'2024-01-14',	'21:31:06',	'21:31:13',	'2',	'image_1705267866.jpg',	'image_1705267873.jpg');

DROP TABLE IF EXISTS `parameter_gaji`;
CREATE TABLE `parameter_gaji` (
  `id` int NOT NULL AUTO_INCREMENT,
  `potongan` varchar(120) NOT NULL,
  `jml_potongan` int NOT NULL,
  `jenis` varchar(255) NOT NULL DEFAULT 'Potongan',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `parameter_gaji` (`id`, `potongan`, `jml_potongan`, `jenis`) VALUES
(1,	'Alpha',	50000,	'1'),
(2,	'Lembur perJam',	20000,	'2');

DROP TABLE IF EXISTS `presensi`;
CREATE TABLE `presensi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT (curdate()),
  `tanggal_pulang` date DEFAULT NULL,
  `waktu` time DEFAULT (curtime()),
  `waktu_pulang` time DEFAULT NULL,
  `status_absen` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_pulang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `presensi` (`id`, `id_pegawai`, `nik`, `tanggal`, `tanggal_pulang`, `waktu`, `waktu_pulang`, `status_absen`, `image`, `image_pulang`) VALUES
(73,	2,	'0987654321',	'2024-01-14',	'2024-01-14',	'01:53:26',	'20:56:28',	'2',	'image_1705258406.jpg',	'image_1705265788.jpg');

DROP TABLE IF EXISTS `rekap_absen`;
CREATE TABLE `rekap_absen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pegawai` int DEFAULT NULL,
  `nik` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `total_absen` int DEFAULT NULL,
  `total_terlambat` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `rekap_absen` (`id`, `id_pegawai`, `nik`, `bulan`, `total_absen`, `total_terlambat`) VALUES
(5,	NULL,	'0987654321',	'0124',	0,	NULL);

-- 2024-01-16 09:36:05
