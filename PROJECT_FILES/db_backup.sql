-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 31 Gru 2021, 11:00
-- Wersja serwera: 10.4.19-MariaDB
-- Wersja PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `uslugi_transportowe`
--
CREATE DATABASE IF NOT EXISTS `uslugi_transportowe` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `uslugi_transportowe`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logged_in_users`
--

DROP TABLE IF EXISTS `logged_in_users`;
CREATE TABLE IF NOT EXISTS `logged_in_users` (
  `sessionId` varchar(100) NOT NULL,
  `userId` int(11) NOT NULL,
  `lastUpdateDate` datetime NOT NULL,
  PRIMARY KEY (`sessionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `logged_in_users`
--

INSERT INTO `logged_in_users` (`sessionId`, `userId`, `lastUpdateDate`) VALUES
('abc123', 1, '2021-12-29 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `clientName` varchar(100) NOT NULL,
  `clientEmail` varchar(100) NOT NULL,
  `departureDate` datetime NOT NULL,
  `destination` varchar(100) NOT NULL,
  `journeyForm` varchar(50) NOT NULL,
  `vehicle` varchar(100) NOT NULL,
  `additionalServices` varchar(150) DEFAULT NULL,
  `status` int(2) NOT NULL,
  `creationDate` datetime NOT NULL,
  `lastUpdateDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId_fk` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `orders`
--

INSERT INTO `orders` (`id`, `userId`, `clientName`, `clientEmail`, `departureDate`, `destination`, `journeyForm`, `vehicle`, `additionalServices`, `status`, `creationDate`, `lastUpdateDate`) VALUES
(1, 2, 'grzegorz', 'brzeczyszczykiewicz@gmail.com', '2021-12-29 00:00:00', 'Lublin', 'wycieczka', 'Mercedes', 'bar;kierowcy', 1, '2021-12-29 00:00:00', '2999-12-31 23:59:59'),
(2, 2, 'jan', 'kowalski@gmail.com', '2021-12-29 00:00:00', 'Częstochowa', 'pielgrzymka', 'Renault', 'kierowcy', 1, '2021-12-29 00:00:00', '2999-12-31 23:59:59'),
(3, 2, 'adrian', 'nowak@wp.pl', '2021-12-29 00:00:00', 'Mińsk', 'pogrzeb', 'VW', 'bar', 1, '2021-12-29 00:00:00', '2999-12-31 23:59:59'),
(4, 2, 'januszes', 'januszex@gmail.com', '2021-12-29 00:00:00', 'Lodz Bałuty', 'inne', 'Renault', 'kierowcy;bar', 1, '2021-12-29 00:00:00', '2021-12-29 00:00:00'),
(5, 2, 'JANUSZEX', 'jan.kowalski@gmail.com', '2022-01-12 17:05:00', 'Częstochowa', 'pielgrzymka', 'Mercedes', NULL, 1, '2021-12-29 15:44:27', '2021-12-31 10:50:32'),
(6, 2, 'Jan Kowalski Sp. z o.o.', 'jan.kowalski@gmail.com', '2022-01-12 17:05:00', 'Częstochowa', 'pielgrzymka', 'Mercedes', 'naglosnienie;dwoch kierowcow', 1, '2021-12-29 15:45:26', '2021-12-29 15:45:26');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `creationDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login_uq` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `isAdmin`, `creationDate`) VALUES
(1, 'admin', '$2y$10$DILK/Xv1qK0LF//Nmio/PeolCz2HhtDDabrHNh8bWmQ.Z7DmtSenW', 'admin@admin.pl', 1, '2021-12-29 00:00:00'),
(2, 'j.kowalsky', '$2y$10$yIKWz6i/AtaRNewXJiheZ.UEGAIDiOnahYWqMfhnLXatPxS7QuDh6', 'kowalsky@onet.pl', 0, '2021-12-29 00:00:00');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `userId_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
