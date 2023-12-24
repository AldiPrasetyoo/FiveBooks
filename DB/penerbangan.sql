-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Des 2023 pada 10.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penerbangan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kursi`
--

CREATE TABLE `kursi` (
  `ID` int(11) NOT NULL,
  `ID_Jadwal` int(11) NOT NULL,
  `Kelas` enum('Ekonomi','Bisnis','First') NOT NULL,
  `Harga` int(11) NOT NULL,
  `No_Kursi` int(11) NOT NULL,
  `Status` enum('Tersedia','Tidak Tersedia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kursi`
--

INSERT INTO `kursi` (`ID`, `ID_Jadwal`, `Kelas`, `Harga`, `No_Kursi`, `Status`) VALUES
(5, 1, 'Ekonomi', 0, 1, 'Tidak Tersedia'),
(6, 1, 'Ekonomi', 0, 2, 'Tersedia'),
(7, 1, 'Ekonomi', 0, 3, 'Tersedia'),
(8, 1, 'Bisnis', 450000, 1, 'Tersedia'),
(9, 1, 'Bisnis', 450000, 2, 'Tersedia'),
(10, 1, 'Bisnis', 450000, 3, 'Tersedia'),
(11, 1, 'First', 800000, 1, 'Tidak Tersedia'),
(12, 1, 'First', 800000, 2, 'Tersedia'),
(13, 1, 'First', 800000, 3, 'Tersedia'),
(14, 2, 'Ekonomi', 0, 1, 'Tidak Tersedia'),
(15, 2, 'Ekonomi', 0, 2, 'Tersedia'),
(16, 2, 'Ekonomi', 0, 3, 'Tersedia'),
(17, 2, 'Bisnis', 450000, 1, 'Tersedia'),
(18, 2, 'Bisnis', 450000, 2, 'Tersedia'),
(19, 2, 'Bisnis', 450000, 3, 'Tersedia'),
(20, 2, 'First', 800000, 1, 'Tersedia'),
(21, 2, 'First', 800000, 2, 'Tersedia'),
(22, 2, 'First', 800000, 3, 'Tersedia'),
(23, 3, 'Ekonomi', 0, 1, 'Tidak Tersedia'),
(24, 3, 'Ekonomi', 0, 2, 'Tersedia'),
(25, 3, 'Ekonomi', 0, 3, 'Tersedia'),
(26, 3, 'Bisnis', 450000, 1, 'Tersedia'),
(27, 3, 'Bisnis', 450000, 2, 'Tersedia'),
(28, 3, 'Bisnis', 450000, 3, 'Tersedia'),
(29, 3, 'First', 800000, 1, 'Tersedia'),
(30, 3, 'First', 800000, 2, 'Tersedia'),
(31, 3, 'First', 800000, 3, 'Tersedia'),
(32, 4, 'Ekonomi', 0, 1, 'Tidak Tersedia'),
(33, 4, 'Ekonomi', 0, 2, 'Tersedia'),
(34, 4, 'Ekonomi', 0, 3, 'Tersedia'),
(35, 4, 'Bisnis', 450000, 1, 'Tersedia'),
(36, 4, 'Bisnis', 450000, 2, 'Tersedia'),
(37, 4, 'Bisnis', 450000, 3, 'Tersedia'),
(38, 4, 'First', 800000, 1, 'Tersedia'),
(39, 4, 'First', 800000, 2, 'Tersedia'),
(40, 4, 'First', 800000, 3, 'Tersedia');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kursi`
--
ALTER TABLE `kursi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `kursi_to_jadwal` (`ID_Jadwal`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kursi`
--
ALTER TABLE `kursi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kursi`
--
ALTER TABLE `kursi`
  ADD CONSTRAINT `kursi_to_jadwal` FOREIGN KEY (`ID_Jadwal`) REFERENCES `jadwal` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
