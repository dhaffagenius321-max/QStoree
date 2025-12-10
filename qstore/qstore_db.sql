-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 10 Des 2025 pada 14.10
-- Versi server: 5.7.24
-- Versi PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qstore_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','shipped') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`) VALUES
(1, 2, '65.95', 'confirmed', '2025-12-09 05:34:00'),
(2, 2, '134.96', 'confirmed', '2025-12-09 05:41:15'),
(3, 2, '28.35', 'confirmed', '2025-12-09 05:53:37'),
(4, 3, '29.99', 'confirmed', '2025-12-09 14:43:31'),
(5, 3, '29.99', 'confirmed', '2025-12-09 15:58:25'),
(6, 3, '29.99', 'confirmed', '2025-12-10 10:10:07'),
(7, 2, '29.99', 'confirmed', '2025-12-10 10:11:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `qty`, `price`) VALUES
(1, 1, 1, 'Ransel', 1, '29.99'),
(2, 1, 2, 'Wig', 1, '19.99'),
(3, 1, 3, 'Kaos lengan pendek', 2, '5.99'),
(4, 1, 4, 'Sarung', 1, '3.99'),
(5, 2, 7, 'Sepatu', 2, '55.99'),
(6, 2, 8, 'Handuk', 1, '12.99'),
(7, 2, 10, 'Dasi', 1, '9.99'),
(8, 3, 11, 'LED', 2, '1.18'),
(9, 3, 9, 'Kemeja', 1, '25.99'),
(10, 4, 1, 'Ransel', 1, '29.99'),
(11, 5, 1, 'Ransel', 1, '29.99'),
(12, 6, 1, 'Ransel', 1, '29.99'),
(13, 7, 1, 'Ransel', 1, '29.99');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `img`) VALUES
(1, 'Ransel', 'Ransel adalah solusi mobilitas tinggi yang dirancang khusus untuk penjualan langsung.', '29.99', 'https://vernyx.com/cdn/shop/products/TSJ635_3_1024x1024.jpg?v=1658122937'),
(2, 'Wig', 'Wig rambut sintetis berkualitas tinggi untuk tampilan yang menawan', '19.99', 'https://cossky.com/cdn/shop/products/32f6526966f96399ac53bafe2732e225_800x.jpg?v=1618982240'),
(3, 'Kaos lengan pendek', 'Kaos dengan bahan katun lembut dan nyaman.', '5.99', 'https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/e442a6f9726d4f6c99b2ae6701332f32_9366/T-shirt_Graphics_Collab_Blanc_HK9775_01_laydown.jpg'),
(4, 'Sarung', 'Sarung tenun tradisional dengan motif khas daerah.', '3.99', 'https://ds393qgzrxwzn.cloudfront.net/resize/m500x500/cat1/img/images/0/NupgCV1BdO.jpg'),
(5, 'Topi', 'Topi dengan desain modern dan bahan berkualitas.', '15.99', 'https://down-id.img.susercontent.com/file/id-11134207-81ztn-me8hhllecxs1bc'),
(6, 'Jaket', 'Jaket tahan air dengan desain stylish untuk aktivitas outdoor.', '49.99', 'https://images.footballfanatics.com/red-bull-racing/red-bull-racing-2025-team-water-resistant-jacket-unisex_ss5_p-201493641+u-tprxobjztbpvnx9pj5z2+v-15er9ravkxf5ymwxf55x.jpg?_hv=2&w=532'),
(7, 'Sepatu', 'Sepatu lari dengan teknologi bantalan terbaru untuk kenyamanan maksimal.', '55.99', 'https://contents.mediadecathlon.com/p2694599/k$3a45aa9c5d26b4898d14ea393802ca01/sepatu-lari-anak-kiprun-k500-grip-trail-cross-hitam-hijau-kiprun-8800255.jpg'),
(8, 'Handuk', 'Handuk microfiber cepat kering, anti bakteri, dan awet.', '12.99', 'https://media.monotaro.id/mid01/big/Alat%20%26%20Kebutuhan%20Kebersihan/Spons%2C%20Penggosok%20Lantai%2C%20Pel%2C%20Handuk/Non%20Brand%20Handuk%20Kecil/P101544007-1.jpg'),
(9, 'Kemeja', 'Kemeja formal dengan potongan slim fit untuk penampilan profesional.', '25.99', 'https://d29c1z66frfv6c.cloudfront.net/pub/media/catalog/product/zoom/eb0beb93a43c9f3e8049a962da292fad1ab2cc02_xxl-1.jpg'),
(10, 'Dasi', 'Dasi sutra dengan motif elegan untuk acara resmi.', '13.99', 'https://down-id.img.susercontent.com/file/sg-11134201-7rdve-m01aicqpad9ff3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('user','seller') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `dob`, `created_at`, `role`) VALUES
(1, 'seller', '$2y$10$XzC2gGF5czyR5txdUYCJR.CSNQQmeg5P1Hx2Of/293mvxe9dXtPyW', '1990-01-01', '2025-12-09 05:06:42', 'seller'),
(2, 'buyer', '$2y$10$b4phdiUpEdEycwAD6FscM.Axhh2J0//eBhPJc7WR6qCOreluHAXE2', '2025-06-10', '2025-12-09 05:26:07', 'user'),
(3, 'dhaffa', '$2y$10$06Y6X4EKNW8toSXFMspbh.qM.TADEbAQzvLjFoyP9HWtEy7t5.8WS', '2021-03-04', '2025-12-09 14:38:19', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
