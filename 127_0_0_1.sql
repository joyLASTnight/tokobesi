-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2020 at 10:50 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tob`
--
CREATE DATABASE IF NOT EXISTS `tob` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tob`;

-- --------------------------------------------------------

--
-- Table structure for table `master_barang`
--

CREATE TABLE `master_barang` (
  `kode_barang` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga_satuan` double NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_barang`
--

INSERT INTO `master_barang` (`kode_barang`, `nama_barang`, `harga_satuan`, `satuan`, `gambar`, `tanggal_input`) VALUES
('B002', 'BATU KAPUR', 5000, 'POTONG', '0', '2019-12-31 11:13:16'),
('B003', 'BATU AKIK', 10000, 'pieces', 'default.jpg', '2019-12-31 00:00:00'),
('B004', 'Batu Awan', 1000, 'pieces', 'default.jpg', '2019-12-31 00:00:00'),
('B005', 'BATU BATUAN', 10000, 'pieces', 'default.jpg', '2019-12-31 00:00:00'),
('B006', 'BATU BATU BATU', 1000, 'pieces', 'default.jpg', '2019-12-31 00:00:00'),
('B007', 'BATU LAUT', 100000, 'kilogram', 'default.jpg', '2019-12-31 00:00:00'),
('B008', 'BB', 11, 'meter', 'B008.jpg', '2019-12-31 00:00:00'),
('B009', 'BATU TUMPENG', 123123123, 'pieces', 'B009.png', '2019-12-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `master_persediaan`
--

CREATE TABLE `master_persediaan` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(128) NOT NULL,
  `jumlah_persediaan` int(15) NOT NULL,
  `jumlah_keranjang` double NOT NULL,
  `jumlah_persediaan_sementara` int(15) NOT NULL COMMENT 'temporary jumlah persediaan setelah di pesan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_persediaan`
--

INSERT INTO `master_persediaan` (`id`, `kode_barang`, `jumlah_persediaan`, `jumlah_keranjang`, `jumlah_persediaan_sementara`) VALUES
(3, 'B002', 100, 0, 0),
(4, 'B004', 0, 0, 0),
(5, 'B003', 100, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_daftar_belanja`
--

CREATE TABLE `tabel_daftar_belanja` (
  `no_keranjang` int(20) NOT NULL,
  `id_pelanggan` varchar(255) NOT NULL,
  `total_belanja` double NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_keranjang`
--

CREATE TABLE `tabel_keranjang` (
  `id` int(11) NOT NULL,
  `no_order` varchar(255) NOT NULL,
  `id_pelanggan` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_pembelian` double NOT NULL,
  `harga_total` double NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_keranjang_temp`
--

CREATE TABLE `tabel_keranjang_temp` (
  `id` int(11) NOT NULL,
  `no_order` varchar(255) NOT NULL,
  `no_keranjang` int(20) NOT NULL,
  `id_pelanggan` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_pembelian` double NOT NULL,
  `harga_total` double NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pelanggan`
--

CREATE TABLE `tabel_pelanggan` (
  `id_pelanggan` varchar(255) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_pelanggan`
--

INSERT INTO `tabel_pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `nomor_telepon`) VALUES
('4545', 'Lucky Anggara', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '082116562811');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_satuan`
--

CREATE TABLE `tabel_satuan` (
  `id` int(11) NOT NULL,
  `satuan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indexes for table `master_persediaan`
--
ALTER TABLE `master_persediaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `tabel_daftar_belanja`
--
ALTER TABLE `tabel_daftar_belanja`
  ADD PRIMARY KEY (`no_keranjang`);

--
-- Indexes for table `tabel_keranjang`
--
ALTER TABLE `tabel_keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabel_keranjang_temp`
--
ALTER TABLE `tabel_keranjang_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabel_pelanggan`
--
ALTER TABLE `tabel_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `tabel_satuan`
--
ALTER TABLE `tabel_satuan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_persediaan`
--
ALTER TABLE `master_persediaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tabel_keranjang`
--
ALTER TABLE `tabel_keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_keranjang_temp`
--
ALTER TABLE `tabel_keranjang_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tabel_satuan`
--
ALTER TABLE `tabel_satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `master_persediaan`
--
ALTER TABLE `master_persediaan`
  ADD CONSTRAINT `master_persediaan_ibfk_1` FOREIGN KEY (`kode_barang`) REFERENCES `master_barang` (`kode_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;