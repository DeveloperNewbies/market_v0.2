-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 30 Oca 2019, 22:24:38
-- Sunucu sürümü: 5.6.33
-- PHP Sürümü: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE `m_itemcat` (
  `item_cat_id` int(11) NOT NULL,
  `item_cat_name` mediumtext COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_kategori`
--

CREATE TABLE `m_kategori` (
  `id` int(11) NOT NULL,
  `kat_id` int(11) NOT NULL,
  `kat_op` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `kat_cont` mediumtext COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_log`
--

CREATE TABLE `m_log` (
  `id` int(11) NOT NULL,
  `k_adi` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `log` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `log_cat` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `m_log`
--

INSERT INTO `m_log` (`id`, `k_adi`, `log`, `log_cat`, `ip`, `tarih`) VALUES
(1, 'root', 'Systems Created For Client!', 0, '-', '2019-01-30 22:21:39');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_market`
--

CREATE TABLE `m_market` (
  `urun_id` int(11) NOT NULL,
  `urun_ad` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `urun_aciklama` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `urun_details` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `urun_fiyat` float NOT NULL,
  `kdv` int(11) NOT NULL DEFAULT '18',
  `urun_adet` int(11) NOT NULL,
  `urun_tarih` datetime NOT NULL,
  `urun_grup` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_marketimg`
--

CREATE TABLE `m_marketimg` (
  `id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_img` mediumtext COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_marketinfo`
--

CREATE TABLE `m_marketinfo` (
  `id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_info` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `urun_infocont` mediumtext COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_order`
--

CREATE TABLE `m_order` (
  `id` int(11) NOT NULL,
  `k_id` int(11) NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_op_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `k_ip` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `kargo_takip_no` int(11) NOT NULL DEFAULT '0',
  `kargo_firma` text COLLATE utf8_turkish_ci NOT NULL,
  `satis_sonuc` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_orderbill`
--

CREATE TABLE `m_orderbill` (
  `id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_ad` text COLLATE utf8_turkish_ci NOT NULL,
  `urun_fiyat` float NOT NULL,
  `urun_adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_orderbill_info`
--

CREATE TABLE `m_orderbill_info` (
  `id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `u_name` text COLLATE utf8_turkish_ci NOT NULL,
  `u_surname` text COLLATE utf8_turkish_ci NOT NULL,
  `u_adress` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_uinfo`
--

CREATE TABLE `m_uinfo` (
  `k_id` int(11) NOT NULL,
  `k_ad` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `k_soyad` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `k_tel` bigint(11) NOT NULL,
  `k_adresi` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `k_adresi2` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_users`
--

CREATE TABLE `m_users` (
  `id` int(11) NOT NULL,
  `k_adi` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `k_sifre` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `session_hash` mediumtext COLLATE utf8_turkish_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `online` int(2) NOT NULL DEFAULT '0',
  `user_group` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `m_itemcat`
--
ALTER TABLE `m_itemcat`
  ADD UNIQUE KEY `item_cat_id` (`item_cat_id`);

--
-- Tablo için indeksler `m_kategori`
--
ALTER TABLE `m_kategori`
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `m_log`
--
ALTER TABLE `m_log`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `m_market`
--
ALTER TABLE `m_market`
  ADD UNIQUE KEY `urun_id` (`urun_id`);

--
-- Tablo için indeksler `m_marketimg`
--
ALTER TABLE `m_marketimg`
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `m_marketinfo`
--
ALTER TABLE `m_marketinfo`
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `m_order`
--
ALTER TABLE `m_order`
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `m_orderbill`
--
ALTER TABLE `m_orderbill`
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `m_orderbill_info`
--
ALTER TABLE `m_orderbill_info`
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `m_uinfo`
--
ALTER TABLE `m_uinfo`
  ADD UNIQUE KEY `k_id` (`k_id`);

--
-- Tablo için indeksler `m_users`
--
ALTER TABLE `m_users`
  ADD UNIQUE KEY `id` (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `m_itemcat`
--
ALTER TABLE `m_itemcat`
  MODIFY `item_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Tablo için AUTO_INCREMENT değeri `m_kategori`
--
ALTER TABLE `m_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Tablo için AUTO_INCREMENT değeri `m_log`
--
ALTER TABLE `m_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=634;
--
-- Tablo için AUTO_INCREMENT değeri `m_market`
--
ALTER TABLE `m_market`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- Tablo için AUTO_INCREMENT değeri `m_marketimg`
--
ALTER TABLE `m_marketimg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
--
-- Tablo için AUTO_INCREMENT değeri `m_marketinfo`
--
ALTER TABLE `m_marketinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `m_order`
--
ALTER TABLE `m_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- Tablo için AUTO_INCREMENT değeri `m_orderbill`
--
ALTER TABLE `m_orderbill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;
--
-- Tablo için AUTO_INCREMENT değeri `m_orderbill_info`
--
ALTER TABLE `m_orderbill_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- Tablo için AUTO_INCREMENT değeri `m_users`
--
ALTER TABLE `m_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
