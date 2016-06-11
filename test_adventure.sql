-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 07, 2016 at 10:35 
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_adventure`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `answer` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `question_id` mediumint(8) UNSIGNED NOT NULL,
  `is_true` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `answer`, `question_id`, `is_true`) VALUES
(1, 'bool(0 + 1)', 1, 1),
(109, 'fatal error', 18, 0),
(110, 'warning', 18, NULL),
(111, 'notice', 18, NULL),
(112, 'ничего', 18, NULL),
(113, '->', 19, NULL),
(114, '::', 19, 1),
(115, '.', 19, NULL),
(116, '=', 19, NULL),
(140, 'Ответ 1', 22, NULL),
(141, 'будет:\r\necho "hello world!\r\nИли echo "hello world!.+6', 22, 1),
(142, 'Ответ 3', 22, NULL),
(143, 'Ответ 4', 22, NULL),
(144, 'Опа опа опапа', 23, NULL),
(145, 'раз два три', 23, NULL),
(146, 'четыре', 23, 2),
(147, 'пять', 23, NULL),
(148, 'шесть', 23, NULL),
(149, '1', 24, NULL),
(150, '2', 24, NULL),
(151, '33', 24, NULL),
(152, '44', 24, NULL),
(153, '55', 24, 4),
(154, '667', 24, NULL),
(155, 'ыфва', 25, NULL),
(156, 'фыва', 25, 1),
(157, 'фыва', 25, NULL),
(158, 'фывафыва', 25, NULL),
(159, '222', 26, 0),
(160, '333', 26, NULL),
(161, '111', 26, NULL),
(162, '555', 26, NULL),
(163, '678', 26, NULL),
(168, 'inherit', 20, NULL),
(169, 'instanceof', 20, NULL),
(170, 'extends', 20, 2),
(171, 'new', 20, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`) VALUES
(26, 'Php'),
(27, 'HTML/CSS');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `question` text COLLATE utf8_unicode_ci NOT NULL,
  `test_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `test_id`) VALUES
(1, 'What is true?', 1),
(18, 'Что произойдет, если добавить в класс приватный коснтруктор и создать экземпляр класса?', 87),
(19, 'Какой оператор позволяет обращатсья к статическому свойству класса?', 87),
(20, 'Наследование классов в PHP реализовано при помощи оператора', 87),
(22, 'Вопросы.\r\nЧто за вопрос ?\r\nВ чем проблема? \r\nЕсть такой код:\r\n<?php\r\necho "hello world!" . ''.'' . "+6.";', 89),
(23, 'Вот такой вот вопрос?', 90),
(24, 'Еще один вопрос?', 90),
(25, 'Ну и еще один давайте вопросец', 90),
(26, 'Еще еще... нужно больше вопросов', 90);

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE `statistics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language_id` smallint(6) NOT NULL,
  `test_id` smallint(6) NOT NULL,
  `question_count` tinyint(4) DEFAULT NULL,
  `archive_answers` text,
  `pass_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `test_time` time DEFAULT NULL,
  `max_mark` float NOT NULL,
  `is_passed` tinyint(4) NOT NULL,
  `is_enabled` tinyint(4) NOT NULL DEFAULT '1',
  `mark` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='history table';

--
-- Dumping data for table `statistics`
--

INSERT INTO `statistics` (`id`, `user_id`, `language_id`, `test_id`, `question_count`, `archive_answers`, `pass_date`, `test_time`, `max_mark`, `is_passed`, `is_enabled`, `mark`) VALUES
(1, 15, 26, 87, 3, 'a:3:{i:18;a:1:{i:109;s:1:"1";}i:19;a:1:{i:114;s:1:"1";}i:20;a:1:{i:119;s:1:"1";}}', '2016-06-05 21:52:30', '00:00:00', 3, 1, 1, 2.5),
(2, 15, 26, 87, 3, 'a:3:{i:18;a:1:{i:112;s:1:"1";}i:19;a:1:{i:113;s:1:"1";}i:20;a:1:{i:118;s:1:"1";}}', '2016-06-05 22:05:12', '00:00:44', 3, 0, 1, 0.5),
(3, 1, 26, 87, 3, 'a:3:{i:18;a:1:{i:109;s:1:"1";}i:19;a:1:{i:114;s:1:"1";}i:20;a:1:{i:170;s:1:"1";}}', '2016-06-05 22:18:28', '00:00:11', 3, 1, 1, 3),
(4, 1, 27, 90, 4, 'a:4:{i:23;a:1:{i:144;s:1:"1";}i:24;a:1:{i:150;s:1:"1";}i:25;a:1:{i:155;s:1:"1";}i:26;a:1:{i:160;s:1:"1";}}', '2016-06-05 22:59:13', '00:00:15', 4, 0, 1, 0),
(5, 15, 27, 90, 4, 'a:0:{}', '2016-06-06 00:53:34', '00:00:11', 4, 1, 1, 4),
(6, 15, 27, 90, 4, 'a:0:{}', '2016-06-06 19:33:40', '00:00:00', 4, 1, 1, 4),
(7, 15, 27, 90, 4, 'a:0:{}', '2016-06-06 21:37:17', '07:46:34', 4, 0, 1, 2),
(8, 1, 26, 89, 1, 'a:1:{i:22;a:1:{i:141;s:1:"1";}}', '2016-06-07 00:53:55', '00:00:27', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `test` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `test`, `language_id`) VALUES
(87, 'PHP Норм', 26),
(89, 'PHP nl2br', 26),
(90, 'Basic', 27);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login_mail` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login_mail`, `full_name`, `pass`, `phone`, `photo_path`, `role`, `reg_date`, `active`) VALUES
(1, 'admin', 'Administrator', 'myWSCxSk12PxI', '0508005958', '/images/avatars/c4ca4238a0b923820dcc509a6f75849b.jpg', 'admin', '2016-05-22 00:57:32', 1),
(15, 'Vyacheslav', 'Vyacheslav Lynnyk', 'myWSCxSk12PxI', '0508005958', '/images/avatars/9bf31c7ff062936a96d3c8bd1f8f2ff3.jpg', 'user', '2016-05-22 22:17:51', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_ibfk_1` (`question_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_ibfk_1` (`test_id`);

--
-- Indexes for table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests_ibfk_1` (`language_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`);

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
