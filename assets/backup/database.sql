#
# TABLE STRUCTURE FOR: detail_detail_stok_opname
#

DROP TABLE IF EXISTS `detail_detail_stok_opname`;

CREATE TABLE `detail_detail_stok_opname` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_detail_stok_opname` int(10) NOT NULL,
  `qty` double NOT NULL,
  `keterangan` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: detail_pembelian
#

DROP TABLE IF EXISTS `detail_pembelian`;

CREATE TABLE `detail_pembelian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_order_pembelian` varchar(255) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_pembelian` double NOT NULL,
  `harga_beli` double NOT NULL,
  `diskon` double NOT NULL,
  `total_harga` double NOT NULL,
  `tanggal_input` date NOT NULL,
  `saldo` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_pembelian` (`nomor_transaksi`),
  CONSTRAINT `pembelian` FOREIGN KEY (`nomor_transaksi`) REFERENCES `master_pembelian` (`nomor_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: detail_penjualan
#

DROP TABLE IF EXISTS `detail_penjualan`;

CREATE TABLE `detail_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_order_penjualan` varchar(255) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `nomor_faktur` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_penjualan` double NOT NULL,
  `harga_jual` double NOT NULL,
  `diskon` double NOT NULL,
  `total_harga` double NOT NULL,
  `tanggal_input` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `penjualan` (`nomor_faktur`),
  KEY `nomor_faktur` (`nomor_faktur`),
  CONSTRAINT `penjualan` FOREIGN KEY (`nomor_faktur`) REFERENCES `master_penjualan` (`no_faktur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: detail_persediaan
#

DROP TABLE IF EXISTS `detail_persediaan`;

CREATE TABLE `detail_persediaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_transaksi` date NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah` double NOT NULL,
  `harga_beli` double NOT NULL,
  `saldo` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: detail_piutang
#

DROP TABLE IF EXISTS `detail_piutang`;

CREATE TABLE `detail_piutang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_faktur` varchar(255) NOT NULL,
  `nominal_pembayaran` double NOT NULL,
  `sisa_piutang` double NOT NULL,
  `tanggal` datetime NOT NULL,
  `user` varchar(255) NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `master_piutang` (`nomor_faktur`),
  CONSTRAINT `master_piutang` FOREIGN KEY (`nomor_faktur`) REFERENCES `master_piutang` (`no_faktur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: detail_retur_pembelian
#

DROP TABLE IF EXISTS `detail_retur_pembelian`;

CREATE TABLE `detail_retur_pembelian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_detail_pembelian` int(11) NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `keterangan` varchar(512) NOT NULL,
  `jumlah_retur` double NOT NULL,
  `harga_retur` double NOT NULL,
  `diskon` double NOT NULL,
  `total_retur` double NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `retur_master` (`nomor_transaksi`),
  CONSTRAINT `master` FOREIGN KEY (`nomor_transaksi`) REFERENCES `master_retur_pembelian` (`nomor_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: detail_retur_penjualan
#

DROP TABLE IF EXISTS `detail_retur_penjualan`;

CREATE TABLE `detail_retur_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_detail_penjualan` int(11) NOT NULL,
  `nomor_faktur` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `keterangan` varchar(512) NOT NULL,
  `jumlah_retur` double NOT NULL,
  `harga_retur` double NOT NULL,
  `diskon` double NOT NULL,
  `total_retur` double NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `retur_master` (`nomor_faktur`),
  CONSTRAINT `retur_master` FOREIGN KEY (`nomor_faktur`) REFERENCES `master_retur_penjualan` (`nomor_faktur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: detail_stok_opname
#

DROP TABLE IF EXISTS `detail_stok_opname`;

CREATE TABLE `detail_stok_opname` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_referensi` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `saldo_buku` double NOT NULL,
  `saldo_fisik` double NOT NULL,
  `selisih` double NOT NULL,
  `koreksi` double NOT NULL,
  `nomor_referensi_detail` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stokopname` (`nomor_referensi`),
  CONSTRAINT `stokopname` FOREIGN KEY (`nomor_referensi`) REFERENCES `master_stok_opname` (`nomor_referensi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: detail_utang
#

DROP TABLE IF EXISTS `detail_utang`;

CREATE TABLE `detail_utang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_transaksi` varchar(255) NOT NULL,
  `nominal_pembayaran` double NOT NULL,
  `sisa_utang` double NOT NULL,
  `tanggal` datetime NOT NULL,
  `user` varchar(255) NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `master_piutang` (`nomor_transaksi`),
  CONSTRAINT `master_utang` FOREIGN KEY (`nomor_transaksi`) REFERENCES `master_utang` (`nomor_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

INSERT INTO `detail_utang` (`id`, `nomor_transaksi`, `nominal_pembayaran`, `sisa_utang`, `tanggal`, `user`, `bukti`, `keterangan`, `timestamp`) VALUES (13, 'PROD.ITJ.12020', '2000000', '10650000', '2020-02-29 11:45:52', 'admin', '1', 'Down Payment', '2020-02-29 21:25:26');
INSERT INTO `detail_utang` (`id`, `nomor_transaksi`, `nominal_pembayaran`, `sisa_utang`, `tanggal`, `user`, `bukti`, `keterangan`, `timestamp`) VALUES (14, 'prod.0001', '440000', '3960000', '2020-02-29 11:50:08', 'admin', '1', 'Down Payment', '2020-02-29 21:25:29');
INSERT INTO `detail_utang` (`id`, `nomor_transaksi`, `nominal_pembayaran`, `sisa_utang`, `tanggal`, `user`, `bukti`, `keterangan`, `timestamp`) VALUES (15, 'PROD.ITJ.12020', '5000000', '5650000', '2020-03-28 00:00:00', 'admin', 'e65e169a360c54e27cd8f00549ab535b.pdf', 'pelunasan ke 2', '2020-02-29 21:41:08');
INSERT INTO `detail_utang` (`id`, `nomor_transaksi`, `nominal_pembayaran`, `sisa_utang`, `tanggal`, `user`, `bukti`, `keterangan`, `timestamp`) VALUES (16, 'PROD.ITJ.12020', '5000000', '650000', '2020-03-28 00:00:00', 'admin', '720fd93454b538a6df8730209ac807f8.pdf', 'pelunasan ke 2', '2020-02-29 21:41:32');
INSERT INTO `detail_utang` (`id`, `nomor_transaksi`, `nominal_pembayaran`, `sisa_utang`, `tanggal`, `user`, `bukti`, `keterangan`, `timestamp`) VALUES (17, 'PROD.ITJ.12020', '500000', '150000', '2020-03-31 00:00:00', 'admin', '', 'asdas', '2020-02-29 21:45:07');
INSERT INTO `detail_utang` (`id`, `nomor_transaksi`, `nominal_pembayaran`, `sisa_utang`, `tanggal`, `user`, `bukti`, `keterangan`, `timestamp`) VALUES (18, 'PROD.ITJ.12020', '50000', '100000', '2020-04-11 00:00:00', 'admin', '', 'lagi', '2020-02-29 21:45:46');
INSERT INTO `detail_utang` (`id`, `nomor_transaksi`, `nominal_pembayaran`, `sisa_utang`, `tanggal`, `user`, `bukti`, `keterangan`, `timestamp`) VALUES (19, 'PROD.ITJ.12020', '30000', '70000', '2020-04-04 00:00:00', 'admin', '1e9704ff153d35b34ffef6a722796655.pdf', 'gjghj', '2020-02-29 21:48:28');
INSERT INTO `detail_utang` (`id`, `nomor_transaksi`, `nominal_pembayaran`, `sisa_utang`, `tanggal`, `user`, `bukti`, `keterangan`, `timestamp`) VALUES (20, '4', '650000', '1000000', '2020-03-01 04:45:19', 'admin', '1', 'Down Payment', '2020-03-01 10:45:19');


#
# TABLE STRUCTURE FOR: harga_detail_pembelian
#

DROP TABLE IF EXISTS `harga_detail_pembelian`;

CREATE TABLE `harga_detail_pembelian` (
  `id` int(11) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `qty` double NOT NULL,
  `harga` double NOT NULL,
  `sisa` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_barang
#

DROP TABLE IF EXISTS `master_barang`;

CREATE TABLE `master_barang` (
  `kode_barang` varchar(255) NOT NULL,
  `tipe_barang` int(11) DEFAULT 0,
  `jenis_barang` int(11) DEFAULT 0,
  `merek_barang` int(11) DEFAULT 0,
  `kode_supplier` varchar(128) DEFAULT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga_pokok` double NOT NULL,
  `harga_satuan` double NOT NULL,
  `harga_kedua` double NOT NULL,
  `harga_ketiga` double NOT NULL,
  `kode_satuan` int(11) DEFAULT 0,
  `persediaan_minimum` int(11) NOT NULL DEFAULT 0,
  `metode_hpp` varchar(255) NOT NULL,
  `komisi_sales` double NOT NULL DEFAULT 0,
  `gambar` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `keterangan` text NOT NULL,
  `status_jual` tinyint(4) NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL,
  `is_delete` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`kode_barang`),
  KEY `tipe_barang` (`tipe_barang`,`jenis_barang`,`merek_barang`),
  KEY `satuan` (`kode_satuan`),
  KEY `merek_barang_join` (`merek_barang`),
  KEY `jenis_barang_join` (`jenis_barang`),
  KEY `kode_supplier` (`kode_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BES0001', 1, 3, 4, 'FCL359', 'BESI BETON POLOS 6 KBM', '17404', '24000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-03-01 04:15:57', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BES0002', 1, 3, 5, 'FCL359', 'BESI BETON POLOS 8 BEH', '28568', '33000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BES0003', 1, 3, 6, 'FCL359', 'BESI BETON POLOS 8 KZBM', '26568', '30000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BES0004', 1, 3, 4, 'OCZ285', 'BESI BETON POLOS 8 KBM', '27188', '33000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BES0005', 1, 3, 4, 'OCZ285', 'BESI BETON POLOS 10 KBM', '39262', '55000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BES0006', 1, 3, 7, 'HWI209', 'BESI BETON POLOS 12 DAS', '56175', '72000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BES0007', 1, 3, 8, 'HWI209', 'BESI BETON ULIR 13 YES', '74375', '89250', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BES0008', 1, 3, 7, 'HWI209', 'BESI BETON ULIR 16 DAS', '101650', '122000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BON0009', 1, 5, 9, 'BIR674', 'BONDECK 0.65 tl@ MTR', '66040', '81000', '0', '0', 7, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 1);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BON0010', 1, 5, 9, 'BIR674', 'BONDECK 0.65 tl@ 4 MTR', '264160', '324000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BON0011', 1, 5, 9, 'BIR674', 'BONDECK 0.65 tl@ 5MTR', '330200', '405000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BON0012', 1, 5, 9, 'BIR674', 'BONDECK 0.65 tl@ 6MTR', '396240', '486000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BON0013', 1, 5, 9, 'BIR674', 'BONDECK 0.70 tl@ 4MTR', '275880', '340000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BON0014', 1, 5, 9, 'BIR674', 'BONDECK 0.70 tl@ 5 MTR', '344850', '425000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BON0015', 1, 5, 9, 'BIR674', 'BONDECK 0.70 tl@ 6 MTR', '413820', '510000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('BON0016', 1, 5, 9, 'BIR674', 'BONDECK 0.70 tl@ MTR', '68970', '85000', '0', '0', 7, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('CNP0017', 1, 6, 10, 'BIR674', 'CNP 75/35 TL 0.55 mm', '41820', '49500', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('CNP0018', 1, 6, 10, 'BIR674', 'CNP 75/35 TL 0.60 mm', '45750', '51500', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('CNP0019', 1, 6, 10, 'BIR674', 'CNP 75/35 TL 0.65 mm', '44240', '55500', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('CNP0020', 1, 6, 10, 'BIR674', 'CNP 75/35 TL 0.70 mm', '47730', '61500', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('CNP0021', 1, 6, 10, 'BIR674', 'CNP 75/35 TL 0.75 mm', '54625', '64000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('CNP0022', 1, 6, 10, 'BIR674', 'CNP 75/35 TL  1.0 mm', '76101', '98000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('DEM0023', 1, 7, 11, 'SMV257', 'DEMPUL ISAMU 1 KG', '53500', '64000', '0', '0', 9, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('DEM0024', 1, 7, 11, 'SMV257', 'DEMPUL ISAMU 1/4 KG', '20500', '25000', '0', '0', 9, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('DEM0025', 1, 7, 12, 'SMV257', 'DEMPUL SANPOLAC 1 KG', '36500', '43800', '0', '0', 9, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('DEM0026', 1, 7, 12, 'SMV257', 'DEMPUL SANPOLAC 1/4 KG', '15500', '19000', '0', '0', 9, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('DEM0027', 1, 7, 12, 'SMV257', 'DEMPUL SANPOLAC GALON', '122500', '147000', '0', '0', 9, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('DIN0028', 1, 8, 13, 'SMV257', 'DINABOLT 10X50', '700', '850', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('DIN0029', 1, 8, 13, 'SMV257', 'DINABOLT 10X65', '806', '1000', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('DIN0030', 1, 8, 13, 'SMV257', 'DINABOLT 10X77', '962', '1500', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('DIN0031', 1, 8, 13, 'SMV257', 'DINABOLT 8X40', '1087', '2000', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('DIN0032', 1, 8, 13, 'SMV257', 'DINABOLT 8X65', '1279', '2000', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('GEN0033', 1, 9, 9, 'BIR674', 'GENTENG METAL PASIR COKLAT', '15625', '24000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('GEN0034', 1, 9, 9, 'BIR674', 'GENTENG METAL PASIR HIJAU', '15625', '24000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('GEN0035', 1, 9, 9, 'BIR674', 'GENTENG METAL PASIR HITAM', '15625', '24000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('GEN0036', 1, 9, 9, 'BIR674', 'GENTENG METAL PASIR MERAH', '15625', '24000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('HOL0037', 1, 10, 9, 'BIR674', 'HOLLO PLAFON 2X4', '9576', '15000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('HOL0038', 1, 10, 9, 'BIR674', 'HOLLO PLAFON 4X4', '12768', '18000', '0', '0', 6, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('KAW0040', 1, 12, 15, 'BMX310', 'KAWAT LAS RD 260 @ 2.6 mm', '42000', '0', '0', '0', 10, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('KAW0041', 1, 12, 15, 'BMX310', 'KAWAT LAS RD 260 @ 2.0 mm', '115000', '132000', '0', '0', 10, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('KAW0042', 1, 17, 16, 'HWI209', 'KAWAT TALI BETON ', '60000', '69000', '0', '0', 12, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('KIN0043', 1, 13, 17, 'BMX310', 'KINIK 14\"', '11787', '14000', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('KIN0044', 1, 13, 17, 'BMX310', 'KINIK 4X8', '35000', '40250', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('PAP0039', 1, 11, 14, 'XQO406', 'PAPAN GPYSUM 9mm x 1200mm x 2400 mm', '7000', '8500', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SKR0045', 1, 14, 18, 'ESF053', 'SKRUP RENG 10 X 16', '107', '150', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SKR0046', 1, 14, 18, 'ESF053', 'SKRUP BAJA 10 X 19', '117', '200', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SKR0047', 1, 14, 18, 'ESF053', 'SKRUP GYPSUM 1\"', '46', '75', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SKR0048', 1, 14, 18, 'ESF053', 'SKRUP GYPSUM 1. 1/4\"', '76', '85', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SPA0049', 1, 15, 9, 'BIR674', 'SPANDECK 0.25 x 1000 tl@ mtr', '27010', '34000', '0', '0', 7, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SPA0050', 1, 15, 9, 'BIR674', 'SPANDECK 0.25 x 1000 tl@ 4 MTR', '108040', '136000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SPA0051', 1, 15, 9, 'BIR674', 'SPANDECK 0.25 x 1000 tl@ 5 MTR', '135050', '170000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SPA0052', 1, 15, 9, 'BIR674', 'SPANDECK 0.25 x 1000 tl@ 6 MTR', '162060', '204000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SPA0053', 1, 15, 9, 'BIR674', 'SPANDECK 0.30 x 1000 tl@ 4 MTR', '135240', '172000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SPA0054', 1, 15, 9, 'BIR674', 'SPANDECK 0.30 x 1000 tl@ 5 MTR', '169050', '215000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SPA0055', 1, 15, 9, 'BIR674', 'SPANDECK 0.30 x 1000 tl@ 6 MTR', '202860', '258000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('SPA0056', 1, 15, 9, 'BIR674', 'SPANDECK 0.30 x 1000 tl@mtr', '33810', '43000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('WD0057', 1, 13, 19, 'BIR674', 'WD 4\"', '2300', '4000', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('WD0058', 1, 13, 19, 'BIR674', 'WD 14\"', '26000', '30000', '0', '0', 11, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('WIR0059', 1, 16, 1, 'DDW516', 'Wire Mesh M6 ', '176457', '240000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('WIR0060', 1, 16, 1, 'DDW516', 'Wire Mesh M8 K', '278080', '400000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('WIR0061', 1, 16, 1, 'DDW516', 'Wire Mesh M8 B ', '328182', '440000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);
INSERT INTO `master_barang` (`kode_barang`, `tipe_barang`, `jenis_barang`, `merek_barang`, `kode_supplier`, `nama_barang`, `harga_pokok`, `harga_satuan`, `harga_kedua`, `harga_ketiga`, `kode_satuan`, `persediaan_minimum`, `metode_hpp`, `komisi_sales`, `gambar`, `keterangan`, `status_jual`, `user`, `tanggal_input`, `is_delete`) VALUES ('WIR0062', 1, 16, 1, 'DDW516', 'Wire Mesh M10', '485894', '730000', '0', '0', 8, 0, 'FIFO', '0', 'default.jpg', '', 0, 'supervisor', '2020-02-29 00:00:00', 0);


#
# TABLE STRUCTURE FOR: master_harga_pokok_penjualan
#

DROP TABLE IF EXISTS `master_harga_pokok_penjualan`;

CREATE TABLE `master_harga_pokok_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_transaksi` datetime NOT NULL,
  `nomor_faktur` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `qty` double NOT NULL,
  `harga_pokok` double NOT NULL,
  `harga_jual` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nomor_faktur` (`nomor_faktur`),
  CONSTRAINT `hpp` FOREIGN KEY (`nomor_faktur`) REFERENCES `master_penjualan` (`no_faktur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_insentif
#

DROP TABLE IF EXISTS `master_insentif`;

CREATE TABLE `master_insentif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_faktur` varchar(255) NOT NULL,
  `sales` varchar(255) NOT NULL,
  `gross_penjualan` double NOT NULL,
  `insentif` double NOT NULL,
  `total_insentif` double NOT NULL,
  `tanggal` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nomor_faktur` (`nomor_faktur`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `master_insentif` (`id`, `nomor_faktur`, `sales`, `gross_penjualan`, `insentif`, `total_insentif`, `tanggal`, `status`) VALUES (1, '6305281', 'sales', '870200', '0', '0', '2020-02-29 00:00:00', 1);
INSERT INTO `master_insentif` (`id`, `nomor_faktur`, `sales`, `gross_penjualan`, `insentif`, `total_insentif`, `tanggal`, `status`) VALUES (2, '8061254', 'sales', '1986830', '0', '0', '2020-02-29 00:00:00', 1);
INSERT INTO `master_insentif` (`id`, `nomor_faktur`, `sales`, `gross_penjualan`, `insentif`, `total_insentif`, `tanggal`, `status`) VALUES (3, '1459703', 'sales', '522120', '0.1', '522.12', '2020-02-29 00:00:00', 1);


#
# TABLE STRUCTURE FOR: master_jenis_barang
#

DROP TABLE IF EXISTS `master_jenis_barang`;

CREATE TABLE `master_jenis_barang` (
  `id_jenis_barang` int(11) NOT NULL AUTO_INCREMENT,
  `kode_jenis_barang` varchar(128) NOT NULL,
  `nama_jenis_barang` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL,
  PRIMARY KEY (`id_jenis_barang`),
  UNIQUE KEY `kode_jenis` (`kode_jenis_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (3, 'BB', 'BESI BETON', 'jenis barang besi beton', 'supervisor', '2020-02-29 08:36:26');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (5, 'FD', 'FLOORDECK', 'untuk jenis barang floordeck', 'supervisor', '2020-02-29 08:36:31');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (6, 'BR', 'BAJA RINGAN', 'Jenis Barang baja ringan', 'supervisor', '2020-02-29 08:36:36');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (7, 'DEMP', 'DEMPUL', 'jenis barang dempul', 'supervisor', '2020-02-29 08:35:12');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (8, 'BAUD', 'BAUD', 'jenis barang baud', 'supervisor', '2020-02-29 08:35:26');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (9, 'GTG', 'GENTENG', 'jenis barang genteng', 'supervisor', '2020-02-29 08:36:42');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (10, 'HL', 'HOLLO', 'jenis barang hollo', 'supervisor', '2020-02-29 08:36:46');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (11, 'GYP', 'GYPSUM', 'jenis barang gypsum', 'supervisor', '2020-02-29 08:36:22');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (12, 'KL', 'KAWAT LAS', 'jenis barang kawat las', 'supervisor', '2020-02-29 08:37:06');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (13, 'BP', 'BATU POTONG', 'jenis barang batu potong', 'supervisor', '2020-02-29 08:37:21');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (14, 'SKR', 'SKRUP', 'jenis barang skrup', 'supervisor', '2020-02-29 08:37:37');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (15, 'AR', 'ATAP RINGAN', 'jenis barang atap ringan', 'supervisor', '2020-02-29 08:38:00');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (16, 'WM', 'WIREMESH', 'jenis barang wiremesh', 'supervisor', '2020-02-29 08:38:11');
INSERT INTO `master_jenis_barang` (`id_jenis_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (17, 'KB', 'KAWAT BETON', 'untuk jenis kawat beton', 'supervisor', '2020-02-29 10:02:56');


#
# TABLE STRUCTURE FOR: master_kartu_persediaan
#

DROP TABLE IF EXISTS `master_kartu_persediaan`;

CREATE TABLE `master_kartu_persediaan` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `jumlah` double NOT NULL,
  `harga` double NOT NULL,
  `total` double NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_merek_barang
#

DROP TABLE IF EXISTS `master_merek_barang`;

CREATE TABLE `master_merek_barang` (
  `id_merek_barang` int(11) NOT NULL AUTO_INCREMENT,
  `kode_merek_barang` varchar(128) NOT NULL,
  `nama_merek_barang` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL,
  PRIMARY KEY (`id_merek_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (1, 'NONE', 'TANPA MEREK', '', 'supervisor', '2020-02-29 00:00:00');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (4, 'KBM', 'KBM', '', 'supervisor', '2020-02-29 08:38:31');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (5, 'BEH', 'BEH', '', 'supervisor', '2020-02-29 08:38:41');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (6, 'KZBM', 'KZBM', '', 'supervisor', '2020-02-29 08:38:49');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (7, 'DAS', 'DAS', '', 'supervisor', '2020-02-29 08:38:57');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (8, 'YES', 'YES', '', 'supervisor', '2020-02-29 08:39:02');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (9, 'BBM', 'BBM', '', 'supervisor', '2020-02-29 08:39:08');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (10, 'BBMT', 'BBM TRUSS', '', 'supervisor', '2020-02-29 08:39:26');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (11, 'ISAMU', 'ISAMU', '', 'supervisor', '2020-02-29 08:39:36');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (12, 'SANPOLAC', 'SANPOLAC', '', 'supervisor', '2020-02-29 08:39:48');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (13, 'WOWO', 'WOWO', '', 'supervisor', '2020-02-29 08:39:58');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (14, 'APLUS', 'APLUS', '', 'supervisor', '2020-02-29 08:40:17');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (15, 'NS', 'NIKO STEEL', '', 'supervisor', '2020-02-29 08:40:29');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (16, 'BWG21', 'BWG 21', '', 'supervisor', '2020-02-29 08:41:37');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (17, 'KINIK', 'KINIK', '', 'supervisor', '2020-02-29 08:41:50');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (18, 'PROFIT', 'PROFIT', '', 'supervisor', '2020-02-29 08:41:59');
INSERT INTO `master_merek_barang` (`id_merek_barang`, `kode_merek_barang`, `nama_merek_barang`, `keterangan`, `user`, `tanggal_input`) VALUES (19, 'WD', 'WD', '', 'supervisor', '2020-02-29 08:42:12');


#
# TABLE STRUCTURE FOR: master_pegawai
#

DROP TABLE IF EXISTS `master_pegawai`;

CREATE TABLE `master_pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(255) NOT NULL,
  `ktp` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` int(1) NOT NULL,
  `alamat` text NOT NULL,
  `kelurahan` varchar(255) NOT NULL,
  `kecamatan` varchar(255) NOT NULL,
  `kota` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `pendidikan_terakhir` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `nomor_rekening` varchar(255) NOT NULL,
  `npwp` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `has_user` int(1) NOT NULL DEFAULT 0,
  `user` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO `master_pegawai` (`id`, `nip`, `ktp`, `nama_lengkap`, `jenis_kelamin`, `alamat`, `kelurahan`, `kecamatan`, `kota`, `tanggal_lahir`, `tanggal_masuk`, `pendidikan_terakhir`, `jabatan`, `nomor_telepon`, `nomor_rekening`, `npwp`, `status`, `gambar`, `has_user`, `user`, `timestamp`) VALUES (1, '1', '0', 'Neng Yuliantin', 1, 'Jl Raya Limbangan', '', '', 'Garut', '2020-02-29', '2020-02-29', '', 'Direktur', '0', '0-0', '0', 1, 'SpDT0P752ut6lZHE.jpeg', 1, '', '2020-02-29 13:26:00');


#
# TABLE STRUCTURE FOR: master_pelanggan
#

DROP TABLE IF EXISTS `master_pelanggan`;

CREATE TABLE `master_pelanggan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_pelanggan` (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_pembelian
#

DROP TABLE IF EXISTS `master_pembelian`;

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
  `lampiran` varchar(255) NOT NULL,
  `status_bayar` int(1) NOT NULL,
  `tanggal_input` date NOT NULL,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`no_order_pembelian`),
  UNIQUE KEY `nomor_transaksi` (`nomor_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_penjualan
#

DROP TABLE IF EXISTS `master_penjualan`;

CREATE TABLE `master_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_faktur` (`no_faktur`),
  UNIQUE KEY `no_order_penjualan` (`no_order_penjualan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_persediaan
#

DROP TABLE IF EXISTS `master_persediaan`;

CREATE TABLE `master_persediaan` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(128) NOT NULL,
  `jumlah_persediaan` double NOT NULL,
  `jumlah_keranjang` double NOT NULL,
  `jumlah_persediaan_sementara` double NOT NULL COMMENT 'temporary jumlah persediaan setelah di pesan',
  `tanggal_input` datetime NOT NULL,
  `no_order_terakhir` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kode_barang` (`kode_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_piutang
#

DROP TABLE IF EXISTS `master_piutang`;

CREATE TABLE `master_piutang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_faktur` varchar(255) NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `total_tagihan` double NOT NULL,
  `total_pembayaran` double NOT NULL,
  `down_payment` double NOT NULL DEFAULT 0,
  `sisa_piutang` double NOT NULL DEFAULT 0,
  `tanggal_input` date NOT NULL,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_faktur` (`no_faktur`),
  KEY `no_faktur_2` (`no_faktur`),
  CONSTRAINT `master_penjualan` FOREIGN KEY (`no_faktur`) REFERENCES `master_penjualan` (`no_faktur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_purchase_order
#

DROP TABLE IF EXISTS `master_purchase_order`;

CREATE TABLE `master_purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `status_po` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_po` (`no_order`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_retur_pembelian
#

DROP TABLE IF EXISTS `master_retur_pembelian`;

CREATE TABLE `master_retur_pembelian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_transaksi_asli` varchar(255) NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `kode_supplier` varchar(255) NOT NULL,
  `retur_total` double NOT NULL,
  `retur_diskon` double NOT NULL,
  `retur_pajak` double NOT NULL,
  `retur_grand_total` double NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomor_faktur` (`nomor_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_retur_penjualan
#

DROP TABLE IF EXISTS `master_retur_penjualan`;

CREATE TABLE `master_retur_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_faktur_asli` varchar(255) NOT NULL,
  `nomor_faktur` varchar(255) NOT NULL,
  `id_pelanggan` varchar(255) NOT NULL,
  `retur_total` double NOT NULL,
  `retur_diskon` double NOT NULL,
  `retur_pajak` double NOT NULL,
  `retur_grand_total` double NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomor_faktur` (`nomor_faktur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_saldo_awal
#

DROP TABLE IF EXISTS `master_saldo_awal`;

CREATE TABLE `master_saldo_awal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(255) NOT NULL,
  `nomor_faktur` varchar(255) NOT NULL,
  `qty_awal` double NOT NULL,
  `saldo_awal` double NOT NULL,
  `harga_awal` double NOT NULL,
  `tanggal_input` datetime NOT NULL,
  `tanggal_saldo` datetime NOT NULL,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `saldo_awal` (`kode_barang`),
  CONSTRAINT `saldo_awal` FOREIGN KEY (`kode_barang`) REFERENCES `master_barang` (`kode_barang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_sales
#

DROP TABLE IF EXISTS `master_sales`;

CREATE TABLE `master_sales` (
  `kode_sales` varchar(255) NOT NULL,
  `kode_pegawai` varchar(255) NOT NULL,
  `nama_sales` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `insentif` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`kode_sales`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_satuan_barang
#

DROP TABLE IF EXISTS `master_satuan_barang`;

CREATE TABLE `master_satuan_barang` (
  `id_satuan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_satuan` varchar(255) NOT NULL,
  `nama_satuan` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL,
  PRIMARY KEY (`id_satuan`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO `master_satuan_barang` (`id_satuan`, `kode_satuan`, `nama_satuan`, `keterangan`, `user`, `tanggal_input`) VALUES (6, 'BTG', 'BATANG', 'untuk produk batangan', 'supervisor', '2020-02-29 08:20:49');
INSERT INTO `master_satuan_barang` (`id_satuan`, `kode_satuan`, `nama_satuan`, `keterangan`, `user`, `tanggal_input`) VALUES (7, 'MTR', 'METER', 'Untuk satuan meter', 'supervisor', '2020-02-29 08:21:02');
INSERT INTO `master_satuan_barang` (`id_satuan`, `kode_satuan`, `nama_satuan`, `keterangan`, `user`, `tanggal_input`) VALUES (8, 'LBR', 'LEMBAR', 'Untuk satuan lembar', 'supervisor', '2020-02-29 08:21:17');
INSERT INTO `master_satuan_barang` (`id_satuan`, `kode_satuan`, `nama_satuan`, `keterangan`, `user`, `tanggal_input`) VALUES (9, 'KLG', 'KALENG', 'untuk satuan kaleng', 'supervisor', '2020-02-29 08:23:05');
INSERT INTO `master_satuan_barang` (`id_satuan`, `kode_satuan`, `nama_satuan`, `keterangan`, `user`, `tanggal_input`) VALUES (10, 'DUS', 'DUS', 'untuk satuan dus', 'supervisor', '2020-02-29 08:23:19');
INSERT INTO `master_satuan_barang` (`id_satuan`, `kode_satuan`, `nama_satuan`, `keterangan`, `user`, `tanggal_input`) VALUES (11, 'PCS', 'PIECES', 'untuk satuan pieces', 'supervisor', '2020-02-29 08:23:31');
INSERT INTO `master_satuan_barang` (`id_satuan`, `kode_satuan`, `nama_satuan`, `keterangan`, `user`, `tanggal_input`) VALUES (12, 'KG', 'KILOGRAM', 'untuk satuan kilogram', 'supervisor', '2020-02-29 08:23:48');


#
# TABLE STRUCTURE FOR: master_setting
#

DROP TABLE IF EXISTS `master_setting`;

CREATE TABLE `master_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_setting` varchar(255) NOT NULL,
  `value` varchar(1024) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (1, 'nama_perusahaan', 'Besi Baja Makmur Kadungora', '2020-02-29 13:44:39');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (2, 'alamat_perusahaan', 'ADUH ', '2020-02-21 20:02:23');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (3, 'nomor_telepon', '082116562811', '2020-02-21 20:02:37');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (4, 'nomor_fax', '129895925', '2020-02-21 13:11:01');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (5, 'alamat_email', 'aaskjjaskf@gmail.com', '2020-02-21 13:11:25');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (6, 'logo_perusahaan', '1JITEv6aepWYlocH.png', '2020-02-21 20:10:14');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (7, 'prefix_faktur', 'BBM', '2020-02-21 13:11:51');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (8, 'nomor_faktur', '1', '2020-02-25 21:16:01');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (9, 'catatan_faktur_cash', 'nlknlkn', '2020-02-21 20:16:00');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (10, 'catatan_faktur_kredit', 'asss', '2020-02-25 13:34:05');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (11, 'catatan_retur_jual', 'asdasda', '2020-02-24 18:58:09');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (12, 'catatan_retur_beli', 'asdasda', '2020-02-24 18:58:09');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (13, 'password_harga', '5', '2020-02-29 20:57:52');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (14, 'komisi_sales', '0.10', '2020-02-29 22:49:19');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (15, 'notifikasi', '2,3', '2020-02-25 21:18:42');
INSERT INTO `master_setting` (`id`, `nama_setting`, `value`, `tanggal`) VALUES (16, 'frekuensi_notifikasi', '20', '2020-02-25 21:24:49');


#
# TABLE STRUCTURE FOR: master_stok_opname
#

DROP TABLE IF EXISTS `master_stok_opname`;

CREATE TABLE `master_stok_opname` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_referensi` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `user` varchar(255) NOT NULL,
  `spv` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomor_referensi` (`nomor_referensi`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_supplier
#

DROP TABLE IF EXISTS `master_supplier`;

CREATE TABLE `master_supplier` (
  `kode_supplier` varchar(128) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `nomor_telepon` varchar(128) NOT NULL,
  `npwp` varchar(255) NOT NULL,
  `nomor_rekening` text NOT NULL,
  `keterangan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `tanggal_input` datetime NOT NULL,
  PRIMARY KEY (`kode_supplier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_tipe_barang
#

DROP TABLE IF EXISTS `master_tipe_barang`;

CREATE TABLE `master_tipe_barang` (
  `id_tipe` int(11) NOT NULL,
  `nama_tipe` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_tipe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `master_tipe_barang` (`id_tipe`, `nama_tipe`, `keterangan`, `user`, `timestamp`) VALUES (1, 'INVENTORY', 'TIPE UNTUK BARANG YANG DIJUAL', '', '2020-01-25 10:59:03');
INSERT INTO `master_tipe_barang` (`id_tipe`, `nama_tipe`, `keterangan`, `user`, `timestamp`) VALUES (2, 'NON-INVENTORY', 'TIPE UNTUK BARANG YANG TIDAK DIJUAL, CONTOH PERALATAN KANTOR', '', '2020-01-25 10:59:03');
INSERT INTO `master_tipe_barang` (`id_tipe`, `nama_tipe`, `keterangan`, `user`, `timestamp`) VALUES (3, 'JASA', 'TIPE BARANG YANG TIDAK BERUPA, SEPERTI JASA PENGANTAR BARANG, JASA RAKITAN', '', '2020-01-25 10:59:03');
INSERT INTO `master_tipe_barang` (`id_tipe`, `nama_tipe`, `keterangan`, `user`, `timestamp`) VALUES (4, 'RAKITAN', 'TIPE BARANG BUNDLING, SEPERTI PAKET SEMABAKO', '', '2020-01-25 10:59:03');


#
# TABLE STRUCTURE FOR: master_user
#

DROP TABLE IF EXISTS `master_user`;

CREATE TABLE `master_user` (
  `username` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `status` int(1) NOT NULL,
  `last_activity` datetime NOT NULL,
  `tanggal_create` datetime NOT NULL,
  `isactive` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`username`),
  KEY `nip` (`nip`),
  CONSTRAINT `nip` FOREIGN KEY (`nip`) REFERENCES `master_pegawai` (`nip`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: master_utang
#

DROP TABLE IF EXISTS `master_utang`;

CREATE TABLE `master_utang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_transaksi` varchar(255) NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `total_tagihan` double NOT NULL,
  `total_pembayaran` double NOT NULL,
  `down_payment` double NOT NULL DEFAULT 0,
  `sisa_utang` double NOT NULL DEFAULT 0,
  `tanggal_input` date NOT NULL,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_faktur` (`nomor_transaksi`),
  KEY `no_faktur_2` (`nomor_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: notif
#

DROP TABLE IF EXISTS `notif`;

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tabel_akses
#

DROP TABLE IF EXISTS `tabel_akses`;

CREATE TABLE `tabel_akses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(255) NOT NULL,
  `akses` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tabel_diskon
#

DROP TABLE IF EXISTS `tabel_diskon`;

CREATE TABLE `tabel_diskon` (
  `id` int(11) NOT NULL,
  `kode_diskon` varchar(15) NOT NULL,
  `potongan` int(11) NOT NULL,
  `jumlah_diskon` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tabel_keranjang_belanja
#

DROP TABLE IF EXISTS `tabel_keranjang_belanja`;

CREATE TABLE `tabel_keranjang_belanja` (
  `id` int(11) NOT NULL,
  `no_order` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_pembelian` double NOT NULL,
  `harga_total` double NOT NULL,
  `status` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `no_order` (`no_order`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tabel_menu
#

DROP TABLE IF EXISTS `tabel_menu`;

CREATE TABLE `tabel_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(255) NOT NULL,
  `link` varchar(512) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (1, 'Penjualan', '#', 'fa fa-cart-arrow-down', 'Kasir');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (2, 'Pembelian', '#', 'fa fa-cart-plus', 'Admin');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (3, 'Dashboard', 'dashboard/sales', 'mdi mdi-view-dashboard', 'Sales');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (4, 'Dashboard', 'dashboard/kasir', 'mdi mdi-view-dashboard', 'Kasir');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (5, 'Dashboard', 'dashboard/admin', 'mdi mdi-view-dashboard', 'Dashboard Admin');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (6, 'Dashboard', 'dashboard/supervisor', 'mdi mdi-view-dashboard', 'Dashboard Supervisor');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (7, 'Dashboard', '#', 'mdi mdi-view-dashboard', 'Dashboard Manager');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (8, 'Sales', '#', 'fa fa-user-o', 'Sales');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (9, 'Persediaan', '#', 'fa fa-window-restore', 'Supervisor');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (10, 'Data', '#', 'fa fa-database', 'Admin');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (11, 'Pegawai', '#', 'fa fa-users', 'Manajer');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (12, 'Keuangan', '#', 'fa fa-money', 'Manajer');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (13, 'Laporan', '#', 'fa fa-file-text', '');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (14, 'Data', '#', 'fa fa-database', 'Kasir');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (15, 'Keuangan', '#', 'fa fa-money', 'Admin');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (16, 'Penjualan', '#', 'fa fa-cart-arrow-down', 'Admin');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (17, 'Persediaan', '#', 'fa fa-window-restore', 'Admin');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (18, 'Sales', '#', 'fa fa-users', 'Admin');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (19, 'Pegawai', '#', 'fa fa-users', 'Supervisor');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (20, 'Settings', 'setting/setting', 'fa fa-gear', 'Manajer');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (21, 'Transaksi', '#', 'fa fa-money', 'Supervisor');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (22, 'Data', '#', 'fa fa-database', 'Supervisor');
INSERT INTO `tabel_menu` (`id`, `nama_menu`, `link`, `icon`, `keterangan`) VALUES (23, 'Transaksi', '#', 'fa fa-cart-arrow-down', 'Manajer');


#
# TABLE STRUCTURE FOR: tabel_perhitungan_order
#

DROP TABLE IF EXISTS `tabel_perhitungan_order`;

CREATE TABLE `tabel_perhitungan_order` (
  `no_order` varchar(255) NOT NULL,
  `total_keranjang` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `ongkir` double NOT NULL,
  `grand_total` double NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`no_order`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tabel_role
#

DROP TABLE IF EXISTS `tabel_role`;

CREATE TABLE `tabel_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(255) NOT NULL,
  `menu` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `tabel_role` (`id`, `nama_role`, `menu`) VALUES (1, 'Kasir', '4,1,14');
INSERT INTO `tabel_role` (`id`, `nama_role`, `menu`) VALUES (2, 'Admin', '5,16,2,17,15');
INSERT INTO `tabel_role` (`id`, `nama_role`, `menu`) VALUES (3, 'Sales', '3,8');
INSERT INTO `tabel_role` (`id`, `nama_role`, `menu`) VALUES (4, 'Supervisor', '6,21,9,10');
INSERT INTO `tabel_role` (`id`, `nama_role`, `menu`) VALUES (5, 'Manager', '7,23,9,12,11,20');
INSERT INTO `tabel_role` (`id`, `nama_role`, `menu`) VALUES (6, 'Superuser', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20');


#
# TABLE STRUCTURE FOR: tabel_submenu
#

DROP TABLE IF EXISTS `tabel_submenu`;

CREATE TABLE `tabel_submenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main_menu` varchar(255) NOT NULL,
  `nama_submenu` varchar(255) NOT NULL,
  `link` varchar(512) NOT NULL,
  `ket` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (1, '1', 'Transaksi Penjualan', 'manajemen_penjualan/penjualanbarang', 'Kasir Penjualan Barang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (2, '1', 'Daftar Transaksi', 'manajemen_penjualan/daftartransaksipenjualan', 'Kasir Daftar Penjualan');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (5, '16', 'Purchase Order', 'manajemen_penjualan/purchaseorderadmin', 'Admin P.O');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (6, '16', 'Retur Penjualan', 'manajemen_penjualan/returpenjualan', 'Admin Retur Penjualan');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (7, '16', 'Daftar Retur Penjualan', 'manajemen_penjualan/returpenjualan/daftar_retur', 'Admin Retur Penjualan Daftar');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (8, '2', 'Transaksi Pembelian', 'manajemen_pembelian/pembelianbarang', 'Admin Pembelian Barang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (9, '2', 'Daftar Transaksi', 'manajemen_pembelian/daftartransaksipembelian', 'Admin Daftar Pembelian Barang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (10, '2', 'Retur Pembelian', 'manajemen_pembelian/returpembelian', 'Admin Retur Pembelian');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (11, '2', 'Daftar Retur Pembelian', 'manajemen_pembelian/returpembelian/daftar_retur', 'Admin Daftar Retur Pembelian');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (12, '9', 'Master Persediaan', 'manajemen_persediaan/masterpersediaan', 'Supervisor Master Persediaan');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (13, '9', 'Kartu Persediaan', 'manajemen_persediaan/kartupersediaan', 'Supervisor Kartu Persediaan');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (14, '17', 'Saldo Awal Persediaan', 'manajemen_persediaan/saldoawalpersediaan', 'Admin Saldo Awal Persediaan');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (15, '17', 'Stok Opname', 'manajemen_persediaan/stokopname', 'Admin Stok Opname');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (16, '9', 'Stok Opname', 'manajemen_persediaan/reviewstokopname', 'Supervisor Review Stok Opname');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (17, '10', 'Master Barang', 'manajemen_barang/masterbarang', 'Admin Master Barang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (18, '10', 'Master Satuan Barang', 'manajemen_data/mastersatuan ', 'Admin Satuan Barang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (19, '10', 'Master Jenis Barang', 'manajemen_data/masterjenisbarang', 'Admin Jenis Barang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (20, '10', 'Master Merek Barang', 'manajemen_data/mastermerekbarang', 'Admin Merek Barang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (21, '14', 'Master Pelanggan', 'manajemen_data/masterpelanggan', 'Kasir Master Pelanggan');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (22, '10', 'Master Supplier', 'manajemen_data/mastersupplier', 'Admin Master Supplier');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (23, '11', 'Master User', 'manajemen_pegawai/masteruser', 'Manager Master User');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (24, '11', 'Master Pegawai', 'manajemen_pegawai/masterpegawai', 'Manager Master Pegawai');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (25, '22', 'Master Barang', 'manajemen_barang/masterbarang', 'Supervisor Data Barang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (26, '8', 'Purchase Order', 'manajemen_penjualan/purchaseordersales', 'Sales P.O');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (27, '8', 'Daftar Purchase Order', 'manajemen_penjualan/purchaseordersales/daftar', 'Sales Daftar P.O');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (28, '8', 'Insentif', 'manajemen_sales/insentif', 'Sales Insentif Monitor');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (29, '15', 'Master Piutang', 'manajemen_keuangan/masterpiutang/daftar_piutang', 'Admin Master Piutang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (30, '15', 'Master Utang', 'manajemen_keuangan/masterutang/daftar_utang', 'Admin Master Utang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (31, '12', 'Insentif Sales', 'manajemen_pegawai/insentifsales', 'Manajer Insentif Sales');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (32, '21', 'Daftar Transaksi Penjualan', 'manajemen_penjualan/daftartransaksipenjualan', '');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (33, '21', 'Daftar Transaksi Pembelian', 'manajemen_pembelian/daftartransaksipembelian', '');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (34, '23', 'Daftar Penjualan', 'manajemen_penjualan/daftartransaksipenjualan', 'Manajer Daftar Transaksi Penjualan');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (35, '23', 'Daftar Pembelian', 'manajemen_pembelian/daftartransaksipembelian', 'Manajer Daftar Transaksi Pembelian');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (36, '12', 'Master Utang', '	\r\nmanajemen_keuangan/masterutang/daftar_utang', 'Manajer Master Utang');
INSERT INTO `tabel_submenu` (`id`, `main_menu`, `nama_submenu`, `link`, `ket`) VALUES (37, '12', 'Master Piutang', '	\r\nmanajemen_keuangan/masterpiutang/daftar_piutang', 'Manajer Master Piutang');


#
# TABLE STRUCTURE FOR: temp_purchase_order
#

DROP TABLE IF EXISTS `temp_purchase_order`;

CREATE TABLE `temp_purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_order` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_penjualan` double NOT NULL,
  `harga_jual` double NOT NULL,
  `diskon` double NOT NULL,
  `total_harga` double NOT NULL,
  `tanggal_input` datetime NOT NULL,
  `user` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `no_order` (`no_order`),
  CONSTRAINT `master_po` FOREIGN KEY (`no_order`) REFERENCES `master_purchase_order` (`no_order`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: temp_tabel_keranjang_pembelian
#

DROP TABLE IF EXISTS `temp_tabel_keranjang_pembelian`;

CREATE TABLE `temp_tabel_keranjang_pembelian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_transaksi` datetime NOT NULL,
  `no_order_pembelian` varchar(255) NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `jumlah_pembelian` double NOT NULL,
  `harga_beli` double NOT NULL,
  `diskon` double NOT NULL,
  `total_harga` double NOT NULL,
  `tanggal_input` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: temp_tabel_keranjang_penjualan
#

DROP TABLE IF EXISTS `temp_tabel_keranjang_penjualan`;

CREATE TABLE `temp_tabel_keranjang_penjualan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: timeline_po
#

DROP TABLE IF EXISTS `timeline_po`;

CREATE TABLE `timeline_po` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_order` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `pesan` text NOT NULL,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

