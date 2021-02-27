-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.16-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for vuondacuanam
CREATE DATABASE IF NOT EXISTS `vuondacuanam` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `vuondacuanam`;

-- Dumping structure for table vuondacuanam.chudegopy
CREATE TABLE IF NOT EXISTS `chudegopy` (
  `cd_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cd_ten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cd_ma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table vuondacuanam.donhang
CREATE TABLE IF NOT EXISTS `donhang` (
  `dh_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dh_ngaylap` date NOT NULL,
  `dh_trangthaithanhtoan` bit(1) NOT NULL DEFAULT b'0',
  `dh_noigiao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dh_ngaygiao` date NOT NULL,
  `kh_ma` int(10) unsigned NOT NULL,
  `httt_ma` int(10) unsigned NOT NULL,
  PRIMARY KEY (`dh_ma`),
  KEY `FK_donhang_khachhang` (`kh_ma`),
  KEY `FK_donhang_hinhthucthanhtoan` (`httt_ma`),
  CONSTRAINT `FK_donhang_hinhthucthanhtoan` FOREIGN KEY (`httt_ma`) REFERENCES `hinhthucthanhtoan` (`httt_ma`),
  CONSTRAINT `FK_donhang_khachhang` FOREIGN KEY (`kh_ma`) REFERENCES `khachhang` (`kh_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table vuondacuanam.gopy
CREATE TABLE IF NOT EXISTS `gopy` (
  `gy_ma` int(10) unsigned NOT NULL,
  `gy_ten` char(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `gy_diachi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gy_dienthoai` int(11) DEFAULT NULL,
  `gy_email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gy_bietqua` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gy_cogiaodich` bit(1) NOT NULL DEFAULT b'0',
  `gy_noidung` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gy_ngaygopy` date NOT NULL,
  `cd_ma` int(10) unsigned NOT NULL,
  PRIMARY KEY (`gy_ma`),
  KEY `FK_gopy_chudegopy` (`cd_ma`),
  CONSTRAINT `FK_gopy_chudegopy` FOREIGN KEY (`cd_ma`) REFERENCES `chudegopy` (`cd_ma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table vuondacuanam.hinhsanpham
CREATE TABLE IF NOT EXISTS `hinhsanpham` (
  `hsp_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hsp_ten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hsp_mota` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp_ma` int(10) unsigned NOT NULL,
  PRIMARY KEY (`hsp_ma`),
  KEY `FK_hinhsanpham_sanpham` (`sp_ma`),
  CONSTRAINT `FK_hinhsanpham_sanpham` FOREIGN KEY (`sp_ma`) REFERENCES `sanpham` (`sp_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table vuondacuanam.hinhthucthanhtoan
CREATE TABLE IF NOT EXISTS `hinhthucthanhtoan` (
  `httt_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `httt_ten` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`httt_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table vuondacuanam.khachhang
CREATE TABLE IF NOT EXISTS `khachhang` (
  `kh_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kh_ten` char(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `kh_gioitinh` enum('Female','Male','Unidentified') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kh_diachi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kh_dienthoai` char(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `kh_email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kh_ngaysinh` date DEFAULT NULL,
  `tk_ma` int(10) unsigned NOT NULL,
  PRIMARY KEY (`kh_ma`),
  KEY `FK_khachhang_taikhoan` (`tk_ma`),
  CONSTRAINT `FK_khachhang_taikhoan` FOREIGN KEY (`tk_ma`) REFERENCES `taikhoan` (`tk_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table vuondacuanam.khuyenmai
CREATE TABLE IF NOT EXISTS `khuyenmai` (
  `km_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `km_ten` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `km_chitiet` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `km_tungay` datetime NOT NULL,
  `km_denngay` datetime NOT NULL,
  PRIMARY KEY (`km_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table vuondacuanam.loaisanpham
CREATE TABLE IF NOT EXISTS `loaisanpham` (
  `lsp_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lsp_ten` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lsp_mota` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lsp_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table vuondacuanam.sanpham
CREATE TABLE IF NOT EXISTS `sanpham` (
  `sp_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sp_ten` char(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sp_gia` float DEFAULT 0,
  `sp_giacu` float DEFAULT NULL,
  `sp_mota_ngan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp_mota_chitiet` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp_soluong` int(10) unsigned NOT NULL,
  `sp_ngaycapnhat` date DEFAULT NULL,
  `lsp_ma` int(10) unsigned NOT NULL,
  `km_ma` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`sp_ma`),
  KEY `FK_sanpham_loaisanpham` (`lsp_ma`),
  KEY `FK_sanpham_khuyenmai` (`km_ma`),
  CONSTRAINT `FK_sanpham_khuyenmai` FOREIGN KEY (`km_ma`) REFERENCES `khuyenmai` (`km_ma`),
  CONSTRAINT `FK_sanpham_loaisanpham` FOREIGN KEY (`lsp_ma`) REFERENCES `loaisanpham` (`lsp_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table vuondacuanam.sanpham_donhang
CREATE TABLE IF NOT EXISTS `sanpham_donhang` (
  `sp_ma` int(10) unsigned NOT NULL,
  `dh_ma` int(10) unsigned NOT NULL,
  `sp_dh_soluong` int(10) unsigned NOT NULL,
  `sp_dh_dongia` float unsigned NOT NULL DEFAULT 0,
  KEY `FK__sanpham` (`sp_ma`),
  KEY `FK__donhang` (`dh_ma`),
  CONSTRAINT `FK__donhang` FOREIGN KEY (`dh_ma`) REFERENCES `donhang` (`dh_ma`),
  CONSTRAINT `FK__sanpham` FOREIGN KEY (`sp_ma`) REFERENCES `sanpham` (`sp_ma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table vuondacuanam.taikhoan
CREATE TABLE IF NOT EXISTS `taikhoan` (
  `tk_ma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tk_username` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tk_password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tk_anhdaidien` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`tk_ma`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
