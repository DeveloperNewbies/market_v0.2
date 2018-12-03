-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 Ara 2018, 21:34:04
-- Sunucu sürümü: 10.1.37-MariaDB
-- PHP Sürümü: 7.2.12

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

CREATE TABLE `m_itemcat` (
  `item_cat_id` int(11) NOT NULL,
  `item_cat_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `m_itemcat`
--

INSERT INTO `m_itemcat` (`item_cat_id`, `item_cat_name`) VALUES
(1, 'İçecek');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_kategori`
--

CREATE TABLE `m_kategori` (
  `id` int(11) NOT NULL,
  `kat_id` int(11) NOT NULL,
  `kat_op` text NOT NULL,
  `kat_cont` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `m_kategori`
--

INSERT INTO `m_kategori` (`id`, `kat_id`, `kat_op`, `kat_cont`) VALUES
(1, 1, 'Boyut', '1 LT'),
(2, 1, 'Boyut', '2 LT');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_log`
--

CREATE TABLE `m_log` (
  `id` int(11) NOT NULL,
  `k_adi` varchar(32) NOT NULL,
  `log` text NOT NULL,
  `log_cat` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_market`
--

CREATE TABLE `m_market` (
  `urun_id` int(11) NOT NULL,
  `urun_ad` text NOT NULL,
  `urun_aciklama` text NOT NULL,
  `urun_details` text NOT NULL,
  `urun_fiyat` float NOT NULL,
  `urun_adet` int(11) NOT NULL,
  `urun_tarih` datetime NOT NULL,
  `urun_grup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `m_market`
--

INSERT INTO `m_market` (`urun_id`, `urun_ad`, `urun_aciklama`, `urun_details`, `urun_fiyat`, `urun_adet`, `urun_tarih`, `urun_grup`) VALUES
(1, 'Harnup Özü', 'Harnup Özü Faydalıdır. ', 'Harnup Özü Faydalıdır. ', 10.99, 20, '0000-00-00 00:00:00', 1),
(2, 'Tahinli Harnup Özü', 'Tahinli Harnup Özü', 'Tahinli Harnup Özü', 13, 0, '0000-00-00 00:00:00', 0),
(3, 'Nar Ekşisi', 'Katıksız Nar Ekşisi', 'Katıksız Nar Ekşisi', 5.99, 10, '0000-00-00 00:00:00', 0),
(4, 'Tahinli Harnup Özü 700 GR', 'Tahinli Harnup Özü 700 GR', 'Tahinli Harnup Özü 700 GR', 17.5, 12, '2018-12-03 00:00:00', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_marketimg`
--

CREATE TABLE `m_marketimg` (
  `id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `m_marketimg`
--

INSERT INTO `m_marketimg` (`id`, `urun_id`, `urun_img`) VALUES
(1, 1, 'images/harnup/harnupozu250ml.png'),
(2, 2, 'images/harnup/tahinli330gr.jpg'),
(3, 3, 'images/nar_eksisi/narozu350gr.png'),
(4, 4, 'images/nar_eksisi/narozu700-gr.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_marketinfo`
--

CREATE TABLE `m_marketinfo` (
  `id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_info` text NOT NULL,
  `urun_infocont` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `m_marketinfo`
--

INSERT INTO `m_marketinfo` (`id`, `urun_id`, `urun_info`, `urun_infocont`) VALUES
(1, 1, 'Ağırlık', '5 KG'),
(2, 1, 'Tat', 'Enfes'),
(3, 3, 'Tat', 'Enfes');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `m_order`
--

CREATE TABLE `m_order` (
  `id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `k_id` int(11) NOT NULL,
  `urun_fiyat` float NOT NULL,
  `urun_adet` int(11) NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `k_ip` varchar(15) NOT NULL,
  `kargo_takip_no` int(11) NOT NULL DEFAULT '0',
  `satis_sonuc` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `m_order`
--

INSERT INTO `m_order` (`id`, `urun_id`, `k_id`, `urun_fiyat`, `urun_adet`, `tarih`, `k_ip`, `kargo_takip_no`, `satis_sonuc`) VALUES
(1, 1, 2, 5, 2, '2018-12-01 00:00:00', '::81', 0, 3);

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
(5, 'Mehmet', 'Sincap', 0, ''),
(6, 'Alp', 'Deny', 0, ''),
(1, 'Doruk', 'Han', 0, '-');

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
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `online` int(2) NOT NULL DEFAULT '0',
  `user_group` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin5;

--
-- Tablo döküm verisi `m_users`
--

INSERT INTO `m_users` (`id`, `k_adi`, `k_sifre`, `session_hash`, `ip`, `tarih`, `online`, `user_group`) VALUES
(1, 'doruk@hotmail.com', '4297f44b13955235245b2497399d7a93', '993df8b103b7ec8a7b05fe41d3e706fbe366267937ae167070d38ed124c88962', '::1', '2018-11-28 00:00:00', 1, 2),
(2, 'mehmet_tuna_anadolu@hotmail.com', '4297f44b13955235245b2497399d7a93', '729aaaf93c3e17bf60a9186c3e00fb1ace828b42661beec5b100d788326bccdc', '10.21.199.198', '2018-11-28 00:00:00', 1, 1),
(3, 'sincap_mehmet_anadolu@hotmail.co', '4297f44b13955235245b2497399d7a93', '61a8a1224cd6cdd64ac4cfd85879c859238e01ea64909a6b85669327fe06d1bb', '10.21.199.198', '2018-11-28 00:00:00', 1, 1),
(4, 'sincap@hotmail.com', '4297f44b13955235245b2497399d7a93', '3f9afd31745da229d7b3602d2efdfab0e7d54f4800cf49f4f90cdb05ff360485', '10.21.199.198', '2018-11-28 00:00:00', 1, 1),
(5, 'mehmet_sincap@hotmail.com', '4297f44b13955235245b2497399d7a93', 'e5112f95a23ea713e163d949773822a20a76fd53299b6f7802b148d127a9436d', '10.21.199.198', '2018-11-28 00:00:00', 1, 1),
(6, 'adeny@hotmail.com', '4297f44b13955235245b2497399d7a93', 'cce49dcaeb2e51f13c124d1ab13c52be8b61a5799f594fef8aa1e9b42abdcc91', '192.168.43.209', '2018-12-01 00:00:00', 0, 1);

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
  MODIFY `item_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `m_kategori`
--
ALTER TABLE `m_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `m_log`
--
ALTER TABLE `m_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `m_market`
--
ALTER TABLE `m_market`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `m_marketimg`
--
ALTER TABLE `m_marketimg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `m_marketinfo`
--
ALTER TABLE `m_marketinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `m_order`
--
ALTER TABLE `m_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `m_users`
--
ALTER TABLE `m_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
