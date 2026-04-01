-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2026 at 07:38 PM
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
  `id_aspirasi` int(11) NOT NULL,
  `status` enum('Menunggu','Proses','Selesai') NOT NULL DEFAULT 'Menunggu',
  `id_pelaporan` int(11) NOT NULL,
  `feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `status`, `id_pelaporan`, `feedback`) VALUES
(6, 'Proses', 6, 'baik pihak sekoalh akan menambahkan wifi sebesar 500mbps'),
(17, 'Proses', 13, 'pihak sekolah akan memperluas lapangan depan '),
(19, 'Menunggu', 14, 'trimakasih atas pujian anada '),
(20, 'Proses', 15, 'baik saya akan menambah kan cctv sebagai pantauan '),
(21, 'Menunggu', 16, 'akan ditambah kan wifi sebanyak 2 lan '),
(22, 'Selesai', 17, 'baik sudah saya konfirmasi untuk masalah harga dengan kantin'),
(23, 'Selesai', 18, 'baik terima kasih atas laporan kamu \r\n'),
(53, 'Selesai', 48, 'trimakasih atas pujiannya '),
(57, 'Selesai', 52, 'sippp perbanyak beribadah ya broo'),
(58, 'Selesai', 53, 'maaf sekolah nya masih dalam pembangunan ya ');

-- --------------------------------------------------------

--
-- Table structure for table `input_aspirasi`
--

CREATE TABLE `input_aspirasi` (
  `id_pelaporan` int(11) NOT NULL,
  `nis` int(10) NOT NULL,
  `id_kategori` int(5) NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `ket` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `input_aspirasi`
--

INSERT INTO `input_aspirasi` (`id_pelaporan`, `nis`, `id_kategori`, `lokasi`, `ket`, `created_at`) VALUES
(6, 90909090, 404, 'lab belakang', 'lab tidak ada wifi', '2026-03-03 04:44:08'),
(13, 12121212, 707, 'lapangan depan ', 'sanggat kecil tidak luas', '2026-03-04 02:29:44'),
(14, 20202020, 202, 'RUANG TENGAH', 'RUANG YANG BERSIH', '2026-03-04 03:10:35'),
(15, 30303030, 808, 'wc belakang', 'tolong wc nya jangan di pakai untuk ngerokok pak', '2026-03-04 03:11:56'),
(16, 40404040, 404, 'lab 1', 'kurang wifi', '2026-03-04 03:12:27'),
(17, 50505050, 909, 'kantin depan', 'tolong di permurah harga nya buk pak', '2026-03-04 03:13:09'),
(18, 60606060, 505, 'kelas 11 rpl 1', 'kelas nya sering menyalakan musik tolong ditindak ', '2026-03-04 03:40:06'),
(48, 8080808, 202, 'ruangan', 'ruangan kesiswaan sanggat baguss', '2026-03-29 16:31:07'),
(52, 10101010, 90928, 'mushala belakang', 'mushala yang adem dan nyaman', '2026-03-29 16:48:58'),
(53, 70707070, 606, 'lapangan bola', 'sekolah kekeurangan lapangan bola gesss', '2026-03-29 16:49:55');

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
(202, 'KESISWAAN'),
(404, 'LAB '),
(505, 'KELAS'),
(606, 'LAPANGAN'),
(707, 'WC CEWEK'),
(808, 'WC COWOK'),
(909, 'KANTIN'),
(90920, 'MEJA HIJAU'),
(90928, 'MUSHALA'),
(90931, 'JURUSAN');

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
(8080808, 'XII RPL 2'),
(10101010, 'XII RPL 9'),
(12121212, 'XII RPL 10'),
(20202020, 'XII RPL 8'),
(30303030, 'XII RPL 7'),
(40404040, 'XII RPL 6'),
(50505050, 'XII RPL 5'),
(60606060, 'XII RPL 4'),
(70707070, 'XII RPL 3'),
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
  MODIFY `id_aspirasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `input_aspirasi`
--
ALTER TABLE `input_aspirasi`
  MODIFY `id_pelaporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90932;

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
