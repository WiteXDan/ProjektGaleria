-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 02 Lut 2019, 01:40
-- Wersja serwera: 10.1.37-MariaDB
-- Wersja PHP: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `michalski_4ta`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `albumy`
--

CREATE TABLE `albumy` (
  `id` int(11) NOT NULL,
  `tytul` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `data` datetime NOT NULL,
  `id_uzytkownika` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `albumy`
--

INSERT INTO `albumy` (`id`, `tytul`, `data`, `id_uzytkownika`) VALUES
(55, 'Kazlosas', '2018-12-14 10:49:47', 48),
(56, 'waw2', '2018-12-14 10:55:51', 48),
(57, 'ape', '2018-12-14 10:58:42', 48),
(58, 'waeaw3', '2018-12-14 10:59:17', 48),
(59, 'aw213', '2018-12-14 11:00:48', 48),
(60, '213546', '2018-12-14 11:02:06', 48),
(68, 'sadfsxc', '2019-02-01 23:09:02', 50);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `login` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `zarejestrowany` date NOT NULL,
  `uprawnienia` enum('użytkownik','moderator','administrator') COLLATE utf8_polish_ci NOT NULL,
  `aktywny` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`, `email`, `zarejestrowany`, `uprawnienia`, `aktywny`) VALUES
(46, 'Pawelek', 'd9eb05de1011527cbc752b969f4f92dd', 'pawel@vp.pl', '2018-11-27', 'użytkownik', 1),
(47, 'Pawlos', '251be584eadf7aed737d2724882a7445', 'pawel@vp.pl', '2018-11-27', 'użytkownik', 1),
(48, 'witexdan2', '251be584eadf7aed737d2724882a7445', 'michalski.wiktorprince.wiktor@gmail.com', '2018-11-30', 'użytkownik', 1),
(49, 'witexdon', '251be584eadf7aed737d2724882a7445', 'michalski.wiktorprince.wiktor@gmail.com', '2019-01-04', 'użytkownik', 1),
(50, 'WiteXDan22', '251be584eadf7aed737d2724882a7445', 'jac_mich@autograf.pl', '2019-01-27', 'administrator', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia`
--

CREATE TABLE `zdjecia` (
  `id` int(11) NOT NULL,
  `opis` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `id_albumu` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `zaakceptowane` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zdjecia`
--

INSERT INTO `zdjecia` (`id`, `opis`, `id_albumu`, `data`, `zaakceptowane`) VALUES
(1, 'moje', 6, '0000-00-00 00:00:00', 1),
(3, 'moje zdjecie', 6, '2018-11-04 19:23:42', 1),
(12, 'FAJNE', 7, '2018-11-04 19:40:18', 1),
(19, 'asdf', 11, '2018-11-06 13:51:15', 1),
(20, 'asdxz', 9, '2018-11-06 13:51:41', 1),
(21, '', 13, '2018-11-06 13:57:17', 1),
(22, 'Kazlosas', 11, '2018-11-06 14:11:13', 1),
(23, 'asdzxc', 14, '2018-11-06 14:11:50', 1),
(24, 'Moje', 50, '2018-11-30 11:09:18', 1),
(25, 'Kazlosa', 50, '2018-11-30 11:29:08', 1),
(54, '', 55, '2018-12-14 10:49:52', 1),
(55, '', 55, '2018-12-14 10:50:53', 0),
(58, '', 55, '2018-12-14 10:54:25', 1),
(59, '', 55, '2018-12-14 10:54:33', 1),
(61, '', 55, '2018-12-14 10:59:30', 1),
(64, '', 60, '2018-12-14 11:02:12', 0),
(65, '', 55, '2018-12-14 11:02:18', 1),
(75, 'ogien', 55, '2018-12-14 11:42:53', 1),
(76, 'Zdjecie', 55, '2018-12-18 13:19:14', 0),
(77, 'Opis', 55, '2018-12-18 13:27:58', 0),
(99, '1234', 68, '2019-02-01 23:09:08', 0),
(100, '124', 68, '2019-02-01 23:09:15', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia_komentarze`
--

CREATE TABLE `zdjecia_komentarze` (
  `id_zdjecia` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `komentarz` text COLLATE utf8_polish_ci NOT NULL,
  `zaakceptowany` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zdjecia_komentarze`
--

INSERT INTO `zdjecia_komentarze` (`id_zdjecia`, `id_uzytkownika`, `data`, `komentarz`, `zaakceptowany`) VALUES
(61, 50, '2019-02-02 00:05:22', 'kaomet4532', 1),
(61, 50, '2019-02-02 01:32:25', 'kaomet', 0),
(61, 50, '2019-02-02 01:32:28', 's124', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia_oceny`
--

CREATE TABLE `zdjecia_oceny` (
  `id_uzytkownika` int(11) NOT NULL,
  `ocena` tinyint(11) UNSIGNED NOT NULL,
  `id_zdjecia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zdjecia_oceny`
--

INSERT INTO `zdjecia_oceny` (`id_uzytkownika`, `ocena`, `id_zdjecia`) VALUES
(49, 6, 49);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `albumy`
--
ALTER TABLE `albumy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_albumu` (`id_albumu`);

--
-- Indeksy dla tabeli `zdjecia_komentarze`
--
ALTER TABLE `zdjecia_komentarze`
  ADD KEY `id_uzytkownika` (`id_uzytkownika`),
  ADD KEY `id_zdjecia` (`id_zdjecia`) USING BTREE;

--
-- Indeksy dla tabeli `zdjecia_oceny`
--
ALTER TABLE `zdjecia_oceny`
  ADD KEY `id_zdjecia` (`id_zdjecia`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `albumy`
--
ALTER TABLE `albumy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `albumy`
--
ALTER TABLE `albumy`
  ADD CONSTRAINT `albumy_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id`);

--
-- Ograniczenia dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD CONSTRAINT `zdjecia_ibfk_1` FOREIGN KEY (`id_albumu`) REFERENCES `albumy` (`id`);

--
-- Ograniczenia dla tabeli `zdjecia_komentarze`
--
ALTER TABLE `zdjecia_komentarze`
  ADD CONSTRAINT `zdjecia_komentarze_ibfk_1` FOREIGN KEY (`id_zdjecia`) REFERENCES `zdjecia` (`id`),
  ADD CONSTRAINT `zdjecia_komentarze_ibfk_2` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id`);

--
-- Ograniczenia dla tabeli `zdjecia_oceny`
--
ALTER TABLE `zdjecia_oceny`
  ADD CONSTRAINT `zdjecia_oceny_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id`),
  ADD CONSTRAINT `zdjecia_oceny_ibfk_2` FOREIGN KEY (`id_zdjecia`) REFERENCES `zdjecia` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
