-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 21, 2023 at 09:34 AM
-- Server version: 8.0.34-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `n1566504_gbu_reseller`
--

-- --------------------------------------------------------

--
-- Table structure for table `mutasi`
--

CREATE TABLE `mutasi` (
  `muta_id` int NOT NULL,
  `peng_id` int NOT NULL,
  `muta_kode_transaksi` enum('C','D') NOT NULL,
  `muta_nominal` bigint NOT NULL,
  `muta_waktu` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mutasi`
--

INSERT INTO `mutasi` (`muta_id`, `peng_id`, `muta_kode_transaksi`, `muta_nominal`, `muta_waktu`) VALUES
(1, 3, 'C', 250000, '2023-09-21 08:25:20'),
(2, 3, 'D', 100000, '2023-09-21 08:25:42'),
(3, 3, 'C', 150000, '2023-09-21 09:00:14'),
(4, 3, 'C', 50000, '2023-09-21 09:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `peng_id` int NOT NULL,
  `peng_name` varchar(100) NOT NULL,
  `peng_nik` varchar(50) NOT NULL,
  `peng_hp` varchar(20) NOT NULL,
  `peng_rekening` varchar(40) NOT NULL,
  `peng_tabungan` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`peng_id`, `peng_name`, `peng_nik`, `peng_hp`, `peng_rekening`, `peng_tabungan`, `created_at`, `updated_at`) VALUES
(3, 'dada', '2134234', '083445654', '816645', '1600000', '2023-09-21 07:08:25', '2023-09-21 07:08:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mutasi`
--
ALTER TABLE `mutasi`
  ADD PRIMARY KEY (`muta_id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`peng_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mutasi`
--
ALTER TABLE `mutasi`
  MODIFY `muta_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `peng_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
