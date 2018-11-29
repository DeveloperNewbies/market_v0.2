-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 29 Kas 2018, 09:50:50
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
-- Tablo için tablo yapısı `m_log`
--

CREATE TABLE `m_log` (
  `id` int(11) NOT NULL,
  `k_adi` varchar(32) NOT NULL,
  `log` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_market`
--

CREATE TABLE `m_market` (
  `urun_id` int(11) NOT NULL,
  `urun_ad` text NOT NULL,
  `urun_aciklama` text NOT NULL,
  `urun_fiyat` float NOT NULL,
  `urun_adet` int(11) NOT NULL,
  `urun_resim` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_marketimg`
--

CREATE TABLE `m_marketimg` (
  `urun_id` int(11) NOT NULL,
  `urun_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_sell`
--

CREATE TABLE `m_sell` (
  `id` int(11) NOT NULL,
  `k_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `u_miktar` int(11) NOT NULL,
  `k_session` text NOT NULL,
  `k_ip` varchar(15) NOT NULL,
  `s_tarih` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_uinfo`
--

CREATE TABLE `m_uinfo` (
  `k_id` int(11) NOT NULL,
  `k_ad` varchar(32) NOT NULL,
  `k_soyad` varchar(32) NOT NULL,
  `k_tel` int(11) NOT NULL,
  `k_adresi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `m_uinfo`
--

INSERT INTO `m_uinfo` (`k_id`, `k_ad`, `k_soyad`, `k_tel`, `k_adresi`) VALUES
(4, '', '', 0, ''),
(5, 'Mehmet', 'Sincap', 0, '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_users`
--

CREATE TABLE `m_users` (
  `id` int(11) NOT NULL,
  `k_adi` varchar(32) NOT NULL,
  `k_sifre` varchar(32) NOT NULL,
  `session_hash` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `tarih` date NOT NULL,
  `online` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `m_users`
--

INSERT INTO `m_users` (`id`, `k_adi`, `k_sifre`, `session_hash`, `ip`, `tarih`, `online`) VALUES
(1, 'doruk', '4297f44b13955235245b2497399d7a93', 'ff3c86fb55eadd733846e83bfb17d30170bdb8c857071e4457cb79e1da88bad8', '10.21.199.198', '2018-11-28', 0),
(2, 'mehmet_tuna_anadolu@hotmail.com', '4297f44b13955235245b2497399d7a93', '729aaaf93c3e17bf60a9186c3e00fb1ace828b42661beec5b100d788326bccdc', '10.21.199.198', '2018-11-28', 1),
(3, 'sincap_mehmet_anadolu@hotmail.co', '4297f44b13955235245b2497399d7a93', '61a8a1224cd6cdd64ac4cfd85879c859238e01ea64909a6b85669327fe06d1bb', '10.21.199.198', '2018-11-28', 1),
(4, 'sincap@hotmail.com', '4297f44b13955235245b2497399d7a93', '3f9afd31745da229d7b3602d2efdfab0e7d54f4800cf49f4f90cdb05ff360485', '10.21.199.198', '2018-11-28', 1),
(5, 'mehmet_sincap@hotmail.com', '4297f44b13955235245b2497399d7a93', 'e5112f95a23ea713e163d949773822a20a76fd53299b6f7802b148d127a9436d', '10.21.199.198', '2018-11-28', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

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
  ADD PRIMARY KEY (`urun_id`);

--
-- Tablo için indeksler `m_sell`
--
ALTER TABLE `m_sell`
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `m_users`
--
ALTER TABLE `m_users`
  ADD UNIQUE KEY `id` (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `m_log`
--
ALTER TABLE `m_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `m_market`
--
ALTER TABLE `m_market`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `m_sell`
--
ALTER TABLE `m_sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `m_users`
--
ALTER TABLE `m_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
