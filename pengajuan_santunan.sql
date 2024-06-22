-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 22, 2024 at 04:41 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengajuan_santunan`
--

-- --------------------------------------------------------

--
-- Table structure for table `pengajuans`
--

CREATE TABLE `pengajuans` (
  `pengajuan_id` int(100) NOT NULL,
  `jenis_kecelakaan` varchar(100) NOT NULL,
  `jam_hari_tanggal` datetime NOT NULL,
  `tempat_kecelakaan` varchar(100) NOT NULL,
  `nama_orang_tua` varchar(100) NOT NULL,
  `alamat_orang_tua` varchar(100) NOT NULL,
  `no_telp_orang_tua` varchar(20) NOT NULL,
  `file_surat_keterangan_visum` varchar(100) NOT NULL,
  `file_kronologi_kejadian` varchar(100) NOT NULL,
  `file_nota` varchar(100) NOT NULL,
  `status_acc_staff` datetime DEFAULT NULL,
  `status_acc_kabag` datetime DEFAULT NULL,
  `status_acc_kabak` datetime DEFAULT NULL,
  `status` int(1) NOT NULL,
  `nomor_unik_pelapor` varchar(9) NOT NULL,
  `tanggal_pengajuan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pengajuans`
--

INSERT INTO `pengajuans` (`pengajuan_id`, `jenis_kecelakaan`, `jam_hari_tanggal`, `tempat_kecelakaan`, `nama_orang_tua`, `alamat_orang_tua`, `no_telp_orang_tua`, `file_surat_keterangan_visum`, `file_kronologi_kejadian`, `file_nota`, `status_acc_staff`, `status_acc_kabag`, `status_acc_kabak`, `status`, `nomor_unik_pelapor`, `tanggal_pengajuan`) VALUES
(3, 'Patah di hati', '2024-06-13 00:00:00', 'G Walk', 'Andi Budiman', 'Pondok Candra', '08123456789', 'Screenshot 2024-05-12 at 20.15.36.png', 'Screenshot 2024-05-12 at 20.15.36.png', 'Screenshot 2024-05-12 at 20.15.36.png', '2024-06-20 10:33:19', '2024-06-20 06:32:01', '2024-06-20 06:31:57', 1, 'c14210273', '2024-06-19 15:42:09'),
(4, 'Terjatuh dan terdiam', '2024-07-06 14:00:00', 'G Walk', 'Andi Budiman', 'Pondok Candra', '08123456789', 'Screenshot 2024-05-14 at 22.14.21.png', 'Screenshot 2024-05-14 at 22.14.21.png', 'Screenshot 2024-05-14 at 22.14.21.png', NULL, '2024-06-20 03:21:31', '2024-06-20 03:21:43', 3, 'c14210273', '2024-06-20 03:21:25'),
(5, 'Mengsedih', '2024-06-20 00:00:00', 'Toilet P2', 'Andi Budiman', 'Pondok Candra', '08123456789', 'Screenshot 2024-05-14 at 22.14.21.png', 'Screenshot 2024-05-14 at 22.14.21.png', 'Screenshot 2024-05-14 at 22.14.21.png', '2024-06-22 15:32:48', NULL, NULL, 4, 'c14210273', '2024-06-20 03:22:45'),
(6, 'dadad', '2024-05-31 00:00:00', 'Toilet P2', 'Andi Budiman', 'Pondok Candra', '08123456789', 'Screenshot 2024-05-14 at 22.14.21.png', 'Screenshot 2024-05-14 at 22.14.21.png', 'Screenshot 2024-05-14 at 22.14.21.png', '2024-06-22 15:35:11', NULL, NULL, 4, 'c14210273', '2024-06-20 04:06:03'),
(7, 'Terjatuh di hati', '2024-06-12 06:00:00', 'Toilet P2', 'Andi Budiman', 'Pondok Candra', '0812345678', 'Screenshot 2024-06-21 at 13.36.34.png', 'Screenshot 2024-06-21 at 13.36.34.png', 'Screenshot 2024-06-21 at 13.36.34.png', '2024-06-22 15:37:03', '2024-06-22 16:09:26', '2024-06-22 16:11:58', 3, 'c14210273', '2024-06-22 15:32:03'),
(8, 'Aaa', '2024-06-05 06:00:00', 'Toilet P2', 'Andi Budiman', 'Pondok Candra', '0821419243', 'Screenshot 2024-06-21 at 13.36.34.png', 'Screenshot 2024-06-21 at 13.36.34.png', 'Screenshot 2024-06-21 at 13.36.34.png', '2024-06-22 15:39:56', NULL, NULL, 1, 'c14210273', '2024-06-22 15:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `nomor_unik` varchar(9) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` int(1) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `jenis_kelamin` int(1) NOT NULL,
  `fakultas` varchar(100) NOT NULL,
  `program_studi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`nomor_unik`, `password`, `role`, `nama`, `alamat`, `no_telp`, `jenis_kelamin`, `fakultas`, `program_studi`) VALUES
('c14210273', 'password', 0, 'Sidi', 'Wonokromo', '0812345678', 0, 'Teknologi Industri', 'Informatika'),
('c14210274', 'password', 0, 'Vidi', 'Wonorejo', '0812345678', 0, 'Industri Kreatif', 'Creative Tourism'),
('c14210275', 'password', 1, 'Budi', 'Kenjeran', '0812345678', 0, '', ''),
('c14210276', 'password', 2, 'Andik', 'Ciputat', '0812345678', 0, '', ''),
('c14210277', 'password', 3, 'Putri Milano', 'Kenjeran', '0812345678', 1, '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengajuans`
--
ALTER TABLE `pengajuans`
  ADD PRIMARY KEY (`pengajuan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`nomor_unik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengajuans`
--
ALTER TABLE `pengajuans`
  MODIFY `pengajuan_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
