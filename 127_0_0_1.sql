-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2020 at 04:12 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

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
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id` int(11) NOT NULL,
  `no_order_pembelian` varchar(255) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_pembelian` double NOT NULL,
  `harga_beli` double NOT NULL,
  `diskon` double NOT NULL,
  `total_harga` double NOT NULL,
  `tanggal_input` date NOT NULL,
  `saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id`, `no_order_pembelian`, `tanggal_transaksi`, `nomor_transaksi`, `kode_barang`, `jumlah_pembelian`, `harga_beli`, `diskon`, `total_harga`, `tanggal_input`, `saldo`) VALUES
(47, '9NCuao2sA60hJ3FH', '2020-02-09 06:39:05', 'betasdas', 'B001', 1000, 95000, 0, 95000000, '2020-02-09', 1000),
(48, 'ZrmHLlIg36NazME1', '2020-02-09 09:45:16', 'asfasf', 'B001', 500, 90000, 0, 45000000, '2020-02-09', 500),
(49, 'ZrmHLlIg36NazME1', '2020-02-07 09:45:29', 'asfasf', 'BES0002', 500, 100000, 0, 50000000, '2020-02-09', 500);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id` int(11) NOT NULL,
  `no_order_penjualan` varchar(255) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `nomor_faktur` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_penjualan` double NOT NULL,
  `harga_jual` double NOT NULL,
  `diskon` double NOT NULL,
  `total_harga` double NOT NULL,
  `tanggal_input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id`, `no_order_penjualan`, `tanggal_transaksi`, `nomor_faktur`, `kode_barang`, `jumlah_penjualan`, `harga_jual`, `diskon`, `total_harga`, `tanggal_input`) VALUES
(74, 'PO.090220001', '2020-02-09 00:00:00', 'BBM090220001', 'B001', 100, 2500000, 0, 250000000, '2020-02-09');

-- --------------------------------------------------------

--
-- Table structure for table `detail_persediaan`
--

CREATE TABLE `detail_persediaan` (
  `id` int(11) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah` double NOT NULL,
  `harga_beli` double NOT NULL,
  `saldo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_persediaan`
--

INSERT INTO `detail_persediaan` (`id`, `tanggal_transaksi`, `nomor_transaksi`, `kode_barang`, `jumlah`, `harga_beli`, `saldo`) VALUES
(11, '2020-01-23', 'ITJ.1.sad/123124', 'P001', 1000, 1000000, 1000),
(12, '2020-01-21', 'itjas/21312/5125', 'K001', 500, 900000, 500),
(13, '2020-01-21', '125125125', 'K001', 500, 1000000, 500),
(14, '2020-01-29', 'hmmm', 'B001', 1000, 500000, 1000),
(15, '2020-01-29', '1214', 'B001', 50, 2000000, 50),
(16, '2020-02-03', 'ksdfs', 'K001', 500, 20000, 500),
(17, '2020-02-03', 'ksdfs', 'BES0002', 100, 150000, 100),
(18, '2020-02-03', 'ksdfs', 'P001', 200, 100000, 200),
(19, '2020-02-09', 'betasdas', 'B001', 1000, 95000, 1000),
(20, '2020-02-09', 'asfasf', 'B001', 500, 90000, 500),
(21, '2020-02-07', 'asfasf', 'BES0002', 500, 100000, 500);

-- --------------------------------------------------------

--
-- Table structure for table `harga_detail_pembelian`
--

CREATE TABLE `harga_detail_pembelian` (
  `id` int(11) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `qty` double NOT NULL,
  `harga` double NOT NULL,
  `sisa` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_barang`
--

CREATE TABLE `master_barang` (
  `kode_barang` varchar(255) NOT NULL,
  `tipe_barang` int(11) DEFAULT 0,
  `jenis_barang` int(11) DEFAULT 0,
  `merek_barang` int(11) DEFAULT 0,
  `kode_supplier` varchar(128) DEFAULT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga_pokok` double NOT NULL,
  `harga_satuan` double NOT NULL,
  `kode_satuan` int(11) DEFAULT 0,
  `persediaan_minimum` int(11) NOT NULL DEFAULT 0,
  `metode_hpp` varchar(255) NOT NULL,
  `komisi_sales` double NOT NULL DEFAULT 0,
  `gambar` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `status_jual` tinyint(4) NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_barang`
--

INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`) VALUES
('B001', 1, 1, 1, 'EKZ372', 'BESI', 15000, 2500000, 0, 10, 'FIFO', 0, 'Za4l1NCG8EtRVcmT.png', '', 0, '', '2020-01-31 02:48:06'),
('BES0002', 1, 1, 0, 'EKZ372', 'BESI BETON', 0, 150000, 0, 10, 'FIFO', 20000, 'default.png', '', 0, '', '2020-02-08 10:58:42'),
('K001', 1, 1, 1, 'EKZ372', 'KERTAS', 1000000, 1200000, 0, 10, 'FIFO', 500, 'uj84iknmXGLWMdRK.png', '', 0, '', '2020-01-31 02:42:24'),
('P001', 1, 1, 1, 'EKZ372', 'PIPA BESI', 1000000, 1200000, 0, 10, 'FIFO', 0, '1A3ahrCWoTwyU2qm.png', '', 0, '', '2020-01-31 05:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `master_harga_pokok_penjualan`
--

CREATE TABLE `master_harga_pokok_penjualan` (
  `id` int(11) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `nomor_faktur` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `qty` double NOT NULL,
  `harga_pokok` double NOT NULL,
  `harga_jual` double NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_harga_pokok_penjualan`
--

INSERT INTO `master_harga_pokok_penjualan` (`id`, `tanggal_transaksi`, `nomor_faktur`, `kode_barang`, `qty`, `harga_pokok`, `harga_jual`, `keterangan`) VALUES
(67, '2020-02-09 10:14:09', 'BBM090220001', 'B001', 100, 100000, 2500000, 'FIFO');

-- --------------------------------------------------------

--
-- Table structure for table `master_hutang`
--

CREATE TABLE `master_hutang` (
  `id` int(11) NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `down_payment` double NOT NULL DEFAULT 0,
  `sisa_pembayaran` double NOT NULL DEFAULT 0,
  `tanggal_input` date NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_jenis_barang`
--

CREATE TABLE `master_jenis_barang` (
  `id_jenis_barang` int(11) NOT NULL,
  `kode_jenis_barang` varchar(128) NOT NULL,
  `nama_jenis_barang` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_jenis_barang`
--

INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES
(0, 'Null', 'TIDAK ADA JENIS', '', 'lucky15', '2020-01-28 14:54:57'),
(1, 'BSI', 'BESI', 'Jenis Barang ', '', '2020-01-05 05:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `master_kartu_persediaan`
--

CREATE TABLE `master_kartu_persediaan` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `jumlah` double NOT NULL,
  `harga` double NOT NULL,
  `total` double NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_kartu_persediaan`
--

INSERT INTO `master_kartu_persediaan` (`id`, `kode_barang`, `nomor_transaksi`, `tanggal_transaksi`, `jumlah`, `harga`, `total`, `status`) VALUES
(1, 'B001', 'asdasdasd', '2020-01-14', 10, 10000, 100000, 0),
(2, 'B001', 'sdasfasgasga', '2020-01-15', 5, 12000, 60000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_merek_barang`
--

CREATE TABLE `master_merek_barang` (
  `id_merek_barang` int(11) NOT NULL,
  `kode_merek_barang` varchar(128) NOT NULL,
  `nama_merek_barang` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_merek_barang`
--

INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES
(0, 'NULL', 'TIDAK ADA MEREK', 'TIDAK ADA MEREK BARANG', '', '2020-01-05 00:00:00'),
(1, 'ATM', 'ANTAM', 'MEREK BESI', '', '2020-01-05 00:00:00'),
(6, 'KTK', 'KERAKATAU STEEL', 'BESI KRAKATAU STEEL', '', '2020-01-05 08:05:10');

-- --------------------------------------------------------

--
-- Table structure for table `master_pelanggan`
--

CREATE TABLE `master_pelanggan` (
  `id` int(11) NOT NULL,
  `id_pelanggan` varchar(255) NOT NULL,
  `tipe_pelanggan` varchar(255) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `npwp` varchar(255) NOT NULL,
  `nomor_rekening` varchar(255) NOT NULL,
  `status_pelanggan` int(11) NOT NULL,
  `tanggal_input` date NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_pelanggan`
--

INSERT INTO `master_pelanggan` (`id`, `id_pelanggan`, `tipe_pelanggan`, `nama_pelanggan`, `alamat`, `email`, `nomor_telepon`, `npwp`, `nomor_rekening`, `status_pelanggan`, `tanggal_input`, `user`) VALUES
(1, 'aD98NsXPRLKdYSir', '', 'a', '', '', '', '', '', 1, '0000-00-00', ''),
(2, 'GsUZhP0R9kSE7eMf', '', 'a', '', '', '', '', '', 1, '0000-00-00', ''),
(3, 'LZQ9840', 'rekanan', 'LUCKY ANGGARA', 'Bandung', 'anggara.lucky1992@gmail.com', '082116562811', '12.132.454.3-513.213', 'BNI-012501250-Lucky Anggara', 0, '2020-01-26', 'lucky15'),
(4, 'myvZH97qQfVjnbEu', '', 'a', '', '', '', '', '', 1, '0000-00-00', ''),
(6, 'Wnli8xKPrsBOMjz1', '', 'bebe', '', '', '', '', '', 1, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `master_pembelian`
--

CREATE TABLE `master_pembelian` (
  `no_order_pembelian` varchar(255) NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `kode_supplier` varchar(255) NOT NULL,
  `total_pembelian` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak_keluaran` double NOT NULL,
  `ongkir` double NOT NULL,
  `grand_total` double NOT NULL,
  `status_bayar` int(1) NOT NULL,
  `tanggal_input` date NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_pembelian`
--

INSERT INTO `master_pembelian` (`no_order_pembelian`, `nomor_transaksi`, `tanggal_transaksi`, `kode_supplier`, `total_pembelian`, `diskon`, `pajak_keluaran`, `ongkir`, `grand_total`, `status_bayar`, `tanggal_input`, `user`) VALUES
('9NCuao2sA60hJ3FH', 'betasdas', '2020-02-09 06:39:19', 'EKZ372', 95000000, 0, 9500000, 0, 104500000, 1, '2020-02-09', 'lucky15'),
('ZrmHLlIg36NazME1', 'asfasf', '2020-02-07 09:45:40', 'EKZ372', 95000000, 0, 9500000, 0, 104500000, 1, '2020-02-09', 'lucky15');

-- --------------------------------------------------------

--
-- Table structure for table `master_penjualan`
--

CREATE TABLE `master_penjualan` (
  `id` int(11) NOT NULL,
  `no_order_penjualan` varchar(255) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `no_faktur` varchar(255) NOT NULL,
  `id_pelanggan` varchar(255) NOT NULL,
  `total_penjualan` double NOT NULL DEFAULT 0,
  `diskon` double DEFAULT 0,
  `pajak_masukan` double NOT NULL DEFAULT 0,
  `ongkir` double NOT NULL DEFAULT 0,
  `grand_total` double NOT NULL DEFAULT 0,
  `status_bayar` int(1) NOT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `tanggal_input` date NOT NULL,
  `sales` varchar(255) NOT NULL DEFAULT 'nosales',
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_penjualan`
--

INSERT INTO `master_penjualan` (`id`, `no_order_penjualan`, `tanggal_transaksi`, `no_faktur`, `id_pelanggan`, `total_penjualan`, `diskon`, `pajak_masukan`, `ongkir`, `grand_total`, `status_bayar`, `tanggal_jatuh_tempo`, `tanggal_input`, `sales`, `user`) VALUES
(38, 'PO.090220001', '2020-02-09 00:00:00', 'BBM090220001', 'LZQ9840', 250000000, 0, 0, 0, 250000000, 1, NULL, '2020-02-09', 'lucky15', 'desi10');

-- --------------------------------------------------------

--
-- Table structure for table `master_persediaan`
--

CREATE TABLE `master_persediaan` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(128) NOT NULL,
  `jumlah_persediaan` double NOT NULL,
  `jumlah_keranjang` double NOT NULL,
  `jumlah_persediaan_sementara` double NOT NULL COMMENT 'temporary jumlah persediaan setelah di pesan',
  `tanggal_input` datetime NOT NULL,
  `no_order_terakhir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_persediaan`
--

INSERT INTO `master_persediaan` (`id`, `kode_barang`, `jumlah_persediaan`, `jumlah_keranjang`, `jumlah_persediaan_sementara`, `tanggal_input`, `no_order_terakhir`) VALUES
(0, 'K001', -2323, 1, 0, '2020-01-22 15:46:02', ''),
(15, 'P001', 564.5, -1440.5, 0, '2020-01-21 16:22:28', ''),
(16, 'B001', -5011, 401, 0, '2020-01-21 04:28:53', '');

-- --------------------------------------------------------

--
-- Table structure for table `master_piutang`
--

CREATE TABLE `master_piutang` (
  `id` int(11) NOT NULL,
  `no_faktur` varchar(255) NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `down_payment` double NOT NULL DEFAULT 0,
  `sisa_pembayaran` double NOT NULL DEFAULT 0,
  `tanggal_input` date NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_piutang`
--

INSERT INTO `master_piutang` (`id`, `no_faktur`, `tanggal_jatuh_tempo`, `down_payment`, `sisa_pembayaran`, `tanggal_input`, `user`) VALUES
(1, 'EAQ4782051', '2020-03-01', 10000000, 38000000, '2020-01-27', 'lucky15'),
(2, 'BBM080220002', '2020-03-08', 1000000, 21020000, '2020-02-08', 'lucky15'),
(3, 'BBM080220003', '2020-04-11', 2000000, 144575000, '2020-02-08', 'desi10'),
(4, 'BBM080220005', '2020-03-13', 100000, 12400000, '2020-02-08', 'desi10');

-- --------------------------------------------------------

--
-- Table structure for table `master_purchase_order`
--

CREATE TABLE `master_purchase_order` (
  `id` int(11) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `no_order` varchar(255) NOT NULL,
  `sales` varchar(255) NOT NULL,
  `id_pelanggan` varchar(255) NOT NULL,
  `total_penjualan` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak_masukan` double NOT NULL,
  `ongkir` double NOT NULL,
  `grand_total` double NOT NULL,
  `tanggal_input` datetime NOT NULL,
  `user` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL,
  `status_po` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_purchase_order`
--

INSERT INTO `master_purchase_order` (`id`, `tanggal_transaksi`, `no_order`, `sales`, `id_pelanggan`, `total_penjualan`, `diskon`, `pajak_masukan`, `ongkir`, `grand_total`, `tanggal_input`, `user`, `admin`, `status_po`) VALUES
(31, '0000-00-00 00:00:00', 'PO.090220001', 'lucky15', 'LZQ9840', 250000000, 0, 0, 0, 250000000, '2020-02-09 10:14:09', 'lucky15', 'desi10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `master_saldo_awal`
--

CREATE TABLE `master_saldo_awal` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `nomor_faktur` varchar(255) NOT NULL,
  `qty_awal` double NOT NULL,
  `saldo_awal` double NOT NULL,
  `harga_awal` double NOT NULL,
  `tanggal_input` datetime NOT NULL,
  `tanggal_saldo` datetime NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_saldo_awal`
--

INSERT INTO `master_saldo_awal` (`id`, `kode_barang`, `nomor_faktur`, `qty_awal`, `saldo_awal`, `harga_awal`, `tanggal_input`, `tanggal_saldo`, `user`) VALUES
(7, 'B001', 'SALDO AWAL', 100, 0, 100000, '2020-02-09 06:32:03', '2020-01-01 00:00:01', 'lucky15'),
(8, 'BES0002', 'SALDO AWAL', 10, 10, 105000, '2020-02-09 09:46:10', '2020-01-01 00:00:01', 'lucky15');

-- --------------------------------------------------------

--
-- Table structure for table `master_sales`
--

CREATE TABLE `master_sales` (
  `kode_sales` varchar(255) NOT NULL,
  `kode_pegawai` varchar(255) NOT NULL,
  `nama_sales` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `insentif` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_sales`
--

INSERT INTO `master_sales` (`kode_sales`, `kode_pegawai`, `nama_sales`, `status`, `insentif`) VALUES
('d', '10002', 'Desi', 'Aktif', 0),
('l', '10001', 'Lucky', 'Aktif', 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_satuan_barang`
--

CREATE TABLE `master_satuan_barang` (
  `id_satuan` int(11) NOT NULL,
  `kode_satuan` varchar(255) NOT NULL,
  `nama_satuan` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_satuan_barang`
--

INSERT INTO `master_satuan_barang` (`id_satuan`, `kode_satuan`, `nama_satuan`, `keterangan`, `user`, `tanggal_input`) VALUES
(0, 'PCS', 'PIECES', 'Untuk produk satuan seperti Gulaasdasda', '', '2020-01-05 08:20:51'),
(1, 'PTG', 'POTONG', '', '', '0000-00-00 00:00:00'),
(2, 'MTR', 'METER', '', '', '0000-00-00 00:00:00'),
(3, 'CM', 'CENTIMETER', 'Untuk alsdklaskdasd', '', '2020-01-04 08:02:14'),
(4, 'PCS', 'PIECES', 'Untuk produk satuan seperti Gula', '', '2020-01-05 05:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `master_stock_opname`
--

CREATE TABLE `master_stock_opname` (
  `id` int(11) NOT NULL,
  `nomor_referensi` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_supplier`
--

CREATE TABLE `master_supplier` (
  `kode_supplier` varchar(128) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `nomor_telepon` varchar(128) NOT NULL,
  `npwp` varchar(255) NOT NULL,
  `nomor_rekening` text NOT NULL,
  `keterangan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_supplier`
--

INSERT INTO `master_supplier` (`kode_supplier`, `nama_supplier`, `alamat`, `nomor_telepon`, `npwp`, `nomor_rekening`, `keterangan`, `user`, `tanggal_input`) VALUES
('EKO076', 'PT JAYA MAKMUR', 'aksdjlkasjdlkasjdlkaj\r\nasdasdasd\r\nasdasdasdasd', '921839018239081', '12.983.910.2-839.012', 'BCA-192839128-Lucky', 'asdasdasd', '', '2020-01-16 14:43:17'),
('EKZ372', 'GENERAL VENDOR', 'General Vendor', '0', '00.000.000.0-000.000', '--0--', 'General Vendor', '', '2020-01-16 14:43:50'),
('QHQ851', 'PTP', 'TPPTPTTPPTPTPTPT', '123012301203', '11.111.111.1-111.111', 'BCA-12310230122-1231231231', 'paspdapdasdasdasda', '', '2020-01-05 06:26:04');

-- --------------------------------------------------------

--
-- Table structure for table `master_tipe_barang`
--

CREATE TABLE `master_tipe_barang` (
  `id_tipe` int(11) NOT NULL,
  `nama_tipe` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_tipe_barang`
--

INSERT INTO `master_tipe_barang` (`id_tipe`, `nama_tipe`, `keterangan`, `user`, `timestamp`) VALUES
(1, 'INVENTORY', 'TIPE UNTUK BARANG YANG DIJUAL', '', '2020-01-25 03:59:03'),
(2, 'NON-INVENTORY', 'TIPE UNTUK BARANG YANG TIDAK DIJUAL, CONTOH PERALATAN KANTOR', '', '2020-01-25 03:59:03'),
(3, 'JASA', 'TIPE BARANG YANG TIDAK BERUPA, SEPERTI JASA PENGANTAR BARANG, JASA RAKITAN', '', '2020-01-25 03:59:03'),
(4, 'RAKITAN', 'TIPE BARANG BUNDLING, SEPERTI PAKET SEMABAKO', '', '2020-01-25 03:59:03');

-- --------------------------------------------------------

--
-- Table structure for table `master_user`
--

CREATE TABLE `master_user` (
  `username` varchar(255) NOT NULL,
  `kode_pegawai` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_user`
--

INSERT INTO `master_user` (`username`, `kode_pegawai`, `password`, `role`, `nama`, `avatar`, `status`, `timestamp`) VALUES
('desi10', '10002', '123', 'Sales', 'Desi Evilia A', 'avatar-3.jpg', 'logout', '2020-02-09 10:40:25'),
('lucky15', '10001', '123', 'Sales', 'Lucky Anggara', 'avatar-2.jpg', 'logout', '2020-02-09 14:04:34');

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_perusahaan`
--

CREATE TABLE `setting_perusahaan` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `alamat_perusahaan` text NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `nomor_fax` varchar(255) NOT NULL,
  `alamat_email` varchar(255) NOT NULL,
  `logo_perusahaan` varchar(255) NOT NULL,
  `prefix_faktur` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting_perusahaan`
--

INSERT INTO `setting_perusahaan` (`id`, `nama_perusahaan`, `alamat_perusahaan`, `nomor_telepon`, `nomor_fax`, `alamat_email`, `logo_perusahaan`, `prefix_faktur`) VALUES
(1, 'PT. BERKAH BAJA MAKMUR', 'JL. RAYA BANDUNG TASIK LIMBANGAN TIMUR\r\nGARUT, JAWA BARAT', '082119349199', '-', 'berkahbajamakmur@gmail.com', 'logo-perusahaan.png', 'BBM');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_diskon`
--

CREATE TABLE `tabel_diskon` (
  `id` int(11) NOT NULL,
  `kode_diskon` varchar(15) NOT NULL,
  `potongan` int(11) NOT NULL,
  `jumlah_diskon` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_diskon`
--

INSERT INTO `tabel_diskon` (`id`, `kode_diskon`, `potongan`, `jumlah_diskon`, `keterangan`) VALUES
(1, 'HAYU10', 10, 10, 'POTONGAN DISKON 10 Persen');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_keranjang_belanja`
--

CREATE TABLE `tabel_keranjang_belanja` (
  `id` int(11) NOT NULL,
  `no_order` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_pembelian` double NOT NULL,
  `harga_total` double NOT NULL,
  `status` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_perhitungan_order`
--

CREATE TABLE `tabel_perhitungan_order` (
  `no_order` varchar(255) NOT NULL,
  `total_keranjang` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `ongkir` double NOT NULL,
  `grand_total` double NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tabel_perhitungan_order`
--

INSERT INTO `tabel_perhitungan_order` (`no_order`, `total_keranjang`, `diskon`, `pajak`, `ongkir`, `grand_total`, `timestamp`) VALUES
('9NCuao2sA60hJ3FH', 95000000, 0, 9500000, 0, 104500000, '2020-02-09 05:39:08'),
('PO.080220001', 750000, 0, 0, 0, 750000, '2020-02-08 15:37:47'),
('PO.080220003', 750000, 0, 0, 0, 750000, '2020-02-08 15:28:37'),
('PO.090220001', 250000000, 0, 0, 0, 250000000, '2020-02-09 08:52:45'),
('PO.090220002', 30000000, 0, 0, 0, 30000000, '2020-02-09 13:04:07'),
('ZrmHLlIg36NazME1', 95000000, 0, 9500000, 0, 104500000, '2020-02-09 08:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `temp_purchase_order`
--

CREATE TABLE `temp_purchase_order` (
  `id` int(11) NOT NULL,
  `no_order` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_penjualan` double NOT NULL,
  `harga_jual` double NOT NULL,
  `diskon` double NOT NULL,
  `total_harga` double NOT NULL,
  `tanggal_input` datetime NOT NULL,
  `user` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_purchase_order`
--

INSERT INTO `temp_purchase_order` (`id`, `no_order`, `kode_barang`, `jumlah_penjualan`, `harga_jual`, `diskon`, `total_harga`, `tanggal_input`, `user`, `status`) VALUES
(189, 'PO.090220001', 'B001', 100, 2500000, 0, 250000000, '2020-02-09 09:28:47', 'lucky15', 2);

-- --------------------------------------------------------

--
-- Table structure for table `temp_tabel_keranjang_pembelian`
--

CREATE TABLE `temp_tabel_keranjang_pembelian` (
  `id` int(11) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `no_order_pembelian` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_pembelian` double NOT NULL,
  `harga_beli` double NOT NULL,
  `diskon` double NOT NULL,
  `total_harga` double NOT NULL,
  `tanggal_input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_tabel_keranjang_penjualan`
--

CREATE TABLE `temp_tabel_keranjang_penjualan` (
  `id` int(11) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `no_order_penjualan` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_penjualan` double NOT NULL,
  `harga_jual` double NOT NULL,
  `diskon` double NOT NULL,
  `total_harga` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `user` varchar(255) NOT NULL,
  `is_po` int(1) NOT NULL DEFAULT 0,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timeline_po`
--

CREATE TABLE `timeline_po` (
  `id` int(11) NOT NULL,
  `no_order` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `pesan` text NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timeline_po`
--

INSERT INTO `timeline_po` (`id`, `no_order`, `urutan`, `tanggal`, `pesan`, `user`) VALUES
(36, 'PO.090220001', 1, '2020-02-09 09:59:56', 'xvsdg', 'lucky15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_pembelian` (`nomor_transaksi`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjualan` (`nomor_faktur`),
  ADD KEY `nomor_faktur` (`nomor_faktur`);

--
-- Indexes for table `detail_persediaan`
--
ALTER TABLE `detail_persediaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harga_detail_pembelian`
--
ALTER TABLE `harga_detail_pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD PRIMARY KEY (`kode_barang`),
  ADD KEY `tipe_barang` (`tipe_barang`,`jenis_barang`,`merek_barang`),
  ADD KEY `satuan` (`kode_satuan`),
  ADD KEY `merek_barang_join` (`merek_barang`),
  ADD KEY `jenis_barang_join` (`jenis_barang`),
  ADD KEY `kode_supplier` (`kode_supplier`);

--
-- Indexes for table `master_harga_pokok_penjualan`
--
ALTER TABLE `master_harga_pokok_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomor_faktur` (`nomor_faktur`);

--
-- Indexes for table `master_hutang`
--
ALTER TABLE `master_hutang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_faktur` (`nomor_transaksi`),
  ADD KEY `no_faktur_2` (`nomor_transaksi`);

--
-- Indexes for table `master_jenis_barang`
--
ALTER TABLE `master_jenis_barang`
  ADD PRIMARY KEY (`id_jenis_barang`),
  ADD UNIQUE KEY `kode_jenis` (`kode_jenis_barang`);

--
-- Indexes for table `master_kartu_persediaan`
--
ALTER TABLE `master_kartu_persediaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_merek_barang`
--
ALTER TABLE `master_merek_barang`
  ADD PRIMARY KEY (`id_merek_barang`);

--
-- Indexes for table `master_pelanggan`
--
ALTER TABLE `master_pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `master_pembelian`
--
ALTER TABLE `master_pembelian`
  ADD PRIMARY KEY (`no_order_pembelian`),
  ADD UNIQUE KEY `nomor_transaksi` (`nomor_transaksi`);

--
-- Indexes for table `master_penjualan`
--
ALTER TABLE `master_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_faktur` (`no_faktur`),
  ADD UNIQUE KEY `no_order_penjualan` (`no_order_penjualan`);

--
-- Indexes for table `master_persediaan`
--
ALTER TABLE `master_persediaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `master_piutang`
--
ALTER TABLE `master_piutang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_faktur` (`no_faktur`),
  ADD KEY `no_faktur_2` (`no_faktur`);

--
-- Indexes for table `master_purchase_order`
--
ALTER TABLE `master_purchase_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_po` (`no_order`);

--
-- Indexes for table `master_saldo_awal`
--
ALTER TABLE `master_saldo_awal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saldo_awal` (`kode_barang`);

--
-- Indexes for table `master_sales`
--
ALTER TABLE `master_sales`
  ADD PRIMARY KEY (`kode_sales`);

--
-- Indexes for table `master_satuan_barang`
--
ALTER TABLE `master_satuan_barang`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `master_stock_opname`
--
ALTER TABLE `master_stock_opname`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_referensi` (`nomor_referensi`);

--
-- Indexes for table `master_supplier`
--
ALTER TABLE `master_supplier`
  ADD PRIMARY KEY (`kode_supplier`);

--
-- Indexes for table `master_tipe_barang`
--
ALTER TABLE `master_tipe_barang`
  ADD PRIMARY KEY (`id_tipe`);

--
-- Indexes for table `master_user`
--
ALTER TABLE `master_user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `kode_pegawai` (`kode_pegawai`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_perusahaan`
--
ALTER TABLE `setting_perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabel_diskon`
--
ALTER TABLE `tabel_diskon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabel_keranjang_belanja`
--
ALTER TABLE `tabel_keranjang_belanja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_order` (`no_order`);

--
-- Indexes for table `tabel_perhitungan_order`
--
ALTER TABLE `tabel_perhitungan_order`
  ADD PRIMARY KEY (`no_order`);

--
-- Indexes for table `temp_purchase_order`
--
ALTER TABLE `temp_purchase_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_order` (`no_order`);

--
-- Indexes for table `temp_tabel_keranjang_pembelian`
--
ALTER TABLE `temp_tabel_keranjang_pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_tabel_keranjang_penjualan`
--
ALTER TABLE `temp_tabel_keranjang_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timeline_po`
--
ALTER TABLE `timeline_po`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `detail_persediaan`
--
ALTER TABLE `detail_persediaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `master_harga_pokok_penjualan`
--
ALTER TABLE `master_harga_pokok_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `master_hutang`
--
ALTER TABLE `master_hutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_pelanggan`
--
ALTER TABLE `master_pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_penjualan`
--
ALTER TABLE `master_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `master_piutang`
--
ALTER TABLE `master_piutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_purchase_order`
--
ALTER TABLE `master_purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `master_saldo_awal`
--
ALTER TABLE `master_saldo_awal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `master_stock_opname`
--
ALTER TABLE `master_stock_opname`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_purchase_order`
--
ALTER TABLE `temp_purchase_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `temp_tabel_keranjang_pembelian`
--
ALTER TABLE `temp_tabel_keranjang_pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `temp_tabel_keranjang_penjualan`
--
ALTER TABLE `temp_tabel_keranjang_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `timeline_po`
--
ALTER TABLE `timeline_po`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `pembelian` FOREIGN KEY (`nomor_transaksi`) REFERENCES `master_pembelian` (`nomor_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `penjualan` FOREIGN KEY (`nomor_faktur`) REFERENCES `master_penjualan` (`no_faktur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_harga_pokok_penjualan`
--
ALTER TABLE `master_harga_pokok_penjualan`
  ADD CONSTRAINT `hpp` FOREIGN KEY (`nomor_faktur`) REFERENCES `master_penjualan` (`no_faktur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_saldo_awal`
--
ALTER TABLE `master_saldo_awal`
  ADD CONSTRAINT `saldo_awal` FOREIGN KEY (`kode_barang`) REFERENCES `master_barang` (`kode_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `temp_purchase_order`
--
ALTER TABLE `temp_purchase_order`
  ADD CONSTRAINT `master_po` FOREIGN KEY (`no_order`) REFERENCES `master_purchase_order` (`no_order`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
