-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2026 at 04:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_aspirasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `status` enum('Menunggu','Proses','Selesai') NOT NULL DEFAULT 'Menunggu',
  `id_pelaporan` int(11) NOT NULL,
  `feedback` text NOT NULL,
  KEY `id_pelaporan` (`id_pelaporan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `status`, `id_pelaporan`, `feedback`) VALUES
(1, 'Menunggu', 101010, 'assalamualaikum'),
(2, 'Proses', 202020, 'assalamualaikum'),
(3, 'Proses', 404040, 'assalamualaikum'),
(4, 'Selesai', 303030, 'assalamualaikum'),
(5, 'Menunggu', 505050, 'assalamualaikum'),
(6, 'Menunggu', 606060, 'assalamualaikum'),
(7, 'Proses', 707070, 'assalamualaikum'),
(8, 'Selesai', 808080, 'assalamualaikum'),
(9, 'Selesai', 909090, 'assalamualaikum'),
(10, 'Proses', 121212, 'assalamualaikum'),
(12, 'Selesai', 2147483647, 'wwwwwwwwwwwww'),
(23, 'Selesai', 23232323, 'w'),
(26, 'Proses', 101010, 't'),
(1000, 'Selesai', 121212, 'w'),
(9999, 'Proses', 90, 'baik akan dilaksanakan'),
(30333, 'Menunggu', 121212, '22');

-- --------------------------------------------------------

--
-- Table structure for table `input_aspirasi`
--

CREATE TABLE `input_aspirasi` (
  `id_pelaporan` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nis` int(10) NOT NULL,
  `id_kategori` int(5) NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `ket` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  KEY `nis` (`nis`,`id_kategori`),
  KEY `id_kategori` (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `input_aspirasi`
--

INSERT INTO `input_aspirasi` (`id_pelaporan`, `nis`, `id_kategori`, `lokasi`, `ket`, `created_at`) VALUES
(90, 60606060, 303, 'meja bundar', ' sanggat jelek mohon di ganti ', '2026-03-03 03:12:35'),
(101010, 90909090, 101, 'BNA', 'SELESAI', '2026-03-02 04:23:17'),
(121212, 12121212, 111, 'AFK', 'SELESAI', '2026-03-02 04:23:17'),
(202020, 80808080, 202, 'JKT', 'SELESAI', '2026-03-02 04:23:17'),
(303030, 70707070, 303, 'PAPUA', 'SELESAI', '2026-03-02 04:23:17'),
(404040, 60606060, 404, 'MKSR', 'SELESAI', '2026-03-02 04:23:17'),
(505050, 50505050, 505, 'USA', 'SELESAI', '2026-03-02 04:23:17'),
(606060, 40404040, 606, 'SGPR', 'SELESAI', '2026-03-02 04:23:17'),
(707070, 30303030, 707, 'MDN', 'SELESAI', '2026-03-02 04:23:17'),
(808080, 20202020, 808, 'BNDNG', 'SELESAI', '2026-03-02 04:23:17'),
(909090, 10101010, 909, 'JPNw', 'SELESAI', '2026-03-02 04:23:17'),
(23232323, 10101010, 505, 'bai', 'SELESAI', '2026-03-02 04:23:17'),
(2147483647, 10101010, 505, 'w', 'SELESAI', '2026-03-02 04:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(5) NOT NULL,
  `ket_kategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `ket_kategori`) VALUES
(101, 'PARKIRAN'),
(111, 'SPP'),
(202, 'KESISWAAN'),
(303, 'RUANG GURU'),
(404, 'LAB '),
(505, 'KELAS'),
(606, 'LAPANGAN'),
(707, 'WC CEWEK'),
(808, 'WC COWOK'),
(909, 'KANTIN');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` int(10) NOT NULL,
  `kelas` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `kelas`) VALUES
(10101010, 'XII RPL 9'),
(12121212, 'XII RPL 10'),
(20202020, 'XII RPL 8'),
(30303030, 'XII RPL 7'),
(40404040, 'XII RPL 6'),
(50505050, 'XII RPL 5'),
(60606060, 'XII RPL 4'),
(70707070, 'XII RPL 3'),
(80808080, 'XII RPL 2'),
(90909090, 'XII RPL 1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `id_pelaporan` (`id_pelaporan`);

--
-- Indexes for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD PRIMARY KEY (`id_pelaporan`),
  ADD KEY `nis` (`nis`,`id_kategori`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30334;

--
-- AUTO_INCREMENT for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  MODIFY `id_pelaporan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90910;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `aspirasi_ibfk_1` FOREIGN KEY (`id_pelaporan`) REFERENCES `input_aspirasi` (`id_pelaporan`);

--
-- Constraints for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  ADD CONSTRAINT `input_aspirasi_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `input_aspirasi_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
