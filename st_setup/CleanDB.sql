-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 13 Şub 2019, 23:20:03
-- Sunucu sürümü: 10.1.36-MariaDB
-- PHP Sürümü: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `marketing`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_itemcat`
--

CREATE TABLE IF NOT EXISTS `m_itemcat` (
  `item_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_cat_name` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  UNIQUE KEY `item_cat_id` (`item_cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_kategori`
--

CREATE TABLE IF NOT EXISTS `m_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kat_id` int(11) NOT NULL,
  `kat_op` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `kat_cont` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_log`
--

CREATE TABLE IF NOT EXISTS `m_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `k_adi` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `log` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `log_cat` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `m_log`
--

INSERT INTO `m_log` (`id`, `k_adi`, `log`, `log_cat`, `ip`, `tarih`) VALUES
(1, 'root', 'Systems Created For Client!', 0, '-', '2018-12-07 11:51:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_logcat`
--

CREATE TABLE IF NOT EXISTS `m_logcat` (
  `logcat_id` int(11) NOT NULL AUTO_INCREMENT,
  `logcat_name` text COLLATE utf8_turkish_ci NOT NULL,
  UNIQUE KEY `logcat_id` (`logcat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_market`
--

CREATE TABLE IF NOT EXISTS `m_market` (
  `urun_id` int(11) NOT NULL AUTO_INCREMENT,
  `urun_ad` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `urun_aciklama` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `urun_details` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `urun_fiyat` float NOT NULL,
  `kdv` int(11) NOT NULL DEFAULT '18',
  `urun_adet` int(11) NOT NULL,
  `urun_tarih` datetime NOT NULL,
  `urun_grup` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  UNIQUE KEY `urun_id` (`urun_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_marketimg`
--

CREATE TABLE IF NOT EXISTS `m_marketimg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urun_id` int(11) NOT NULL,
  `urun_img` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_marketinfo`
--

CREATE TABLE IF NOT EXISTS `m_marketinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urun_id` int(11) NOT NULL,
  `urun_info` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `urun_infocont` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_order`
--

CREATE TABLE IF NOT EXISTS `m_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `k_id` int(11) NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_op_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `k_ip` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `kargo_takip_no` int(11) NOT NULL DEFAULT '0',
  `kargo_firma` text COLLATE utf8_turkish_ci NOT NULL,
  `satis_sonuc` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_orderbill`
--

CREATE TABLE IF NOT EXISTS `m_orderbill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_ad` text COLLATE utf8_turkish_ci NOT NULL,
  `urun_fiyat` float NOT NULL,
  `urun_adet` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_orderbill_info`
--

CREATE TABLE IF NOT EXISTS `m_orderbill_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `s_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `u_name` text COLLATE utf8_turkish_ci NOT NULL,
  `u_surname` text COLLATE utf8_turkish_ci NOT NULL,
  `u_adress` text COLLATE utf8_turkish_ci NOT NULL,
  `u_tel` bigint(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_uactive`
--

CREATE TABLE IF NOT EXISTS `m_uactive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_mail` text COLLATE utf8_turkish_ci NOT NULL,
  `u_pass` text COLLATE utf8_turkish_ci NOT NULL,
  `u_ad` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `u_soyad` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `u_hash` text COLLATE utf8_turkish_ci NOT NULL,
  `u_ip` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `u_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `u_active` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_uinfo`
--

CREATE TABLE IF NOT EXISTS `m_uinfo` (
  `k_id` int(11) NOT NULL,
  `k_ad` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `k_soyad` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `k_tel` bigint(11) NOT NULL,
  `k_adresi` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `k_adresi2` text COLLATE utf8_turkish_ci NOT NULL,
  UNIQUE KEY `k_id` (`k_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_users`
--

CREATE TABLE IF NOT EXISTS `m_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `k_adi` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `k_sifre` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `session_hash` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `online` int(2) NOT NULL DEFAULT '0',
  `user_group` int(11) NOT NULL DEFAULT '1',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
