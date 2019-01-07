-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 07 Sty 2019, 15:39
-- Wersja serwera: 10.1.36-MariaDB
-- Wersja PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `chat`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(301, 0, 0, 'peterParker', '2018-12-18 19:00:32', 1),
(302, 0, 0, 'davidMoore', '2018-12-18 19:00:32', 1),
(303, 2, 1, 'Hello!', '2018-12-18 19:04:36', 0),
(304, 1, 2, 'Hi! How are you?', '2018-12-18 19:05:11', 0),
(305, 0, -1, 'peterParker', '2018-12-18 19:06:13', 1),
(306, 0, 1, ' Hello my friends!', '2018-12-18 19:07:46', 1),
(307, 2, 1, 'hello', '2018-12-19 09:14:06', 0),
(308, 2, 1, 'gg', '2018-12-19 09:14:14', 0),
(309, 0, -1, 'johnsmith', '2018-12-19 09:18:27', 1),
(310, 0, -1, 'johnsmith', '2018-12-19 09:18:29', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `groupchat`
--

CREATE TABLE `groupchat` (
  `id` int(11) NOT NULL,
  `chatName` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `login_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `groupchat`
--

INSERT INTO `groupchat` (`id`, `chatName`, `login_id`) VALUES
(212, 'chatName', 3),
(220, 'name', 3),
(222, 'Students', 2),
(223, 'Students', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login`
--

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `login`
--

INSERT INTO `login` (`user_id`, `username`, `password`) VALUES
(1, 'johnsmith', '$2y$10$4REfvTZpxLgkAR/lKG9QiOkSdahOYIR3MeoGJAyiWmRkEFfjH3396'),
(2, 'peterParker', '$2y$10$4REfvTZpxLgkAR/lKG9QiOkSdahOYIR3MeoGJAyiWmRkEFfjH3396'),
(3, 'davidMoore', '$2y$10$4REfvTZpxLgkAR/lKG9QiOkSdahOYIR3MeoGJAyiWmRkEFfjH3396');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_type` varchar(1) NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(1, 1, '2018-12-15 20:42:39', 'n'),
(2, 3, '2018-12-15 20:05:39', 'n'),
(3, 1, '2018-12-16 15:45:31', 'n'),
(4, 3, '2018-12-16 18:12:46', 'n'),
(5, 1, '2018-12-16 19:05:20', 'n'),
(6, 3, '2018-12-16 19:04:39', 'n'),
(7, 4, '2018-12-18 12:21:56', 'n'),
(8, 1, '2018-12-18 12:30:57', 'n'),
(9, 2, '2018-12-18 12:38:59', 'n'),
(10, 1, '2018-12-18 12:39:30', 'n'),
(11, 3, '2018-12-18 13:15:21', 'n'),
(12, 4, '2018-12-18 15:18:48', 'n'),
(13, 1, '2018-12-18 18:56:39', 'n'),
(14, 1, '2018-12-18 19:04:39', 'n'),
(15, 2, '2018-12-18 19:06:14', 'n'),
(16, 1, '2018-12-18 19:41:41', 'n'),
(17, 1, '2018-12-19 11:39:50', 'n'),
(18, 2, '2018-12-19 11:39:45', 'n');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indeksy dla tabeli `groupchat`
--
ALTER TABLE `groupchat`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeksy dla tabeli `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=311;

--
-- AUTO_INCREMENT dla tabeli `groupchat`
--
ALTER TABLE `groupchat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT dla tabeli `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
