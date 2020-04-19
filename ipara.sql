-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 19 Nis 2020, 14:06:10
-- Sunucu sürümü: 10.1.40-MariaDB
-- PHP Sürümü: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ipara`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `payment_orderid` int(11) NOT NULL,
  `payment_name` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL,
  `payment_surname` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL,
  `payment_email` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL,
  `payment_amount` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL,
  `payment_cardownername` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL,
  `payment_cardnumber` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL,
  `payment_cardmonth` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL,
  `payment_cardyear` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL,
  `payment_cardcvc` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL,
  `payment_installment` varchar(255) COLLATE utf8_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- Tablo döküm verisi `payments`
--

INSERT INTO `payments` (`payment_id`, `payment_orderid`, `payment_name`, `payment_surname`, `payment_email`, `payment_amount`, `payment_cardownername`, `payment_cardnumber`, `payment_cardmonth`, `payment_cardyear`, `payment_cardcvc`, `payment_installment`) VALUES
(1, 82, 'Test', 'Name', 'eposta@adresi.com', '1500', 'Cardname Surname', '4282209004348015', '12', '22', '123', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `product_amount` int(11) NOT NULL,
  `product_description` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`product_id`, `product_code`, `product_name`, `product_amount`, `product_description`) VALUES
(1, 'PR53335', 'Test Ürün', 1500, 'Bu test bir üründür.');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
