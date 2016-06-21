-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 21, 2016 at 01:09 
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
(191, '->', 19, NULL),
(192, '::', 19, 1),
(193, '.', 19, NULL),
(194, '=', 19, NULL),
(199, 'inherit', 20, NULL),
(200, 'instanceof', 20, NULL),
(201, 'extends', 20, 2),
(202, 'new', 20, NULL),
(223, '1\r\nответ на все\r\n   оп', 27, 0),
(224, '2', 27, NULL),
(225, '4', 27, NULL),
(226, '3', 27, NULL),
(227, '5', 27, NULL),
(228, 'fatal error', 18, 0),
(229, 'warning', 18, NULL),
(230, 'notice', 18, NULL),
(231, 'ничего', 18, NULL);

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
(18, '<p>Что произойдет, если добавить в класс приватный коснтруктор и создать экземпляр класса?</p>', 87),
(19, '<p>Какой оператор позволяет обращатсья к статическому свойству класса?</p>', 87),
(20, '<p>Наследование классов в PHP реализовано при помощи оператора</p>', 87),
(22, 'Вопросы.\r\nЧто за вопрос ?\r\nВ чем проблема? \r\nЕсть такой код:\r\n<?php\r\necho "hello world!" . ''.'' . "+6.";', 89),
(23, 'Вот такой вот вопрос?', 90),
(24, 'Еще один вопрос?', 90),
(25, 'Ну и еще один давайте вопросец', 90),
(26, 'Еще еще... нужно больше вопросов', 90),
(27, '<p>Вот такой вот<strong> вопрос. </strong>Нужно дать ответ какой результат выведет данный метод. Если будут заданы все параметры:&nbsp;</p>\r\n\r\n<pre>\r\npublic static function getTestData($test_id)\r\n{\r\n    $data[&#39;correct&#39;] = [];\r\n    $data[&#39;dataTest&#39;] = [];\r\n\r\n    $questions = Questions::find_all_by_test_id($test_id);\r\n    foreach ($questions as $question) {\r\n        $answers = Answers::find(&#39;all&#39;, ["conditions" => ["question_id = ?", $question->id]]);\r\n\r\n        $data[&#39;dataTest&#39;][&#39;test_id&#39;] = $test_id;\r\n        $data[&#39;dataTest&#39;][$question->id][&#39;question&#39;] = nl2br(htmlentities($question->question));\r\n        foreach ($answers as $answer) {\r\n            if (is_numeric($answer->is_true)) {\r\n                $data[&#39;correct&#39;][$test_id][$question->id][$answer->id] = true;\r\n            }\r\n            $data[&#39;dataTest&#39;][$question->id][$answer->id] = nl2br(htmlentities($answer->answer));\r\n\r\n        }\r\n    }\r\n    return (isset($data)) ? $<strong>data</strong> : false;\r\n}</pre>', 87);

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
  `mark` double DEFAULT NULL,
  `attempts` smallint(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='history table';

--
-- Dumping data for table `statistics`
--

INSERT INTO `statistics` (`id`, `user_id`, `language_id`, `test_id`, `question_count`, `archive_answers`, `pass_date`, `test_time`, `max_mark`, `is_passed`, `is_enabled`, `mark`, `attempts`) VALUES
(79, 15, 26, 87, NULL, NULL, '2016-06-17 12:35:19', NULL, 0, 0, 1, 0, 1),
(80, 15, 26, 87, 4, 'a:1:{i:19;a:1:{i:192;s:1:"1";}}', '2016-06-17 12:36:36', '00:00:06', 4, 0, 1, 1, 0),
(81, 15, 27, 90, 4, 'a:1:{i:26;a:3:{i:160;s:1:"1";i:161;s:1:"1";i:162;s:1:"1";}}', '2016-06-17 12:36:56', '00:00:10', 4, 0, 1, 0, 1),
(82, 15, 27, 90, NULL, NULL, '2016-06-17 12:37:17', NULL, 0, 0, 1, 0, 0),
(83, 1, 26, 87, NULL, NULL, '2016-06-17 19:56:52', NULL, 0, 0, 1, 0, 1),
(84, 1, 27, 90, 4, 'a:1:{i:26;a:1:{i:161;s:1:"1";}}', '2016-06-17 19:57:03', '00:00:03', 4, 0, 1, 0, 1);

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
  `photo_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT '/images/avatars/avatar.png',
  `role` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login_mail`, `full_name`, `pass`, `phone`, `photo_path`, `role`, `reg_date`, `active`) VALUES
(1, 'admin', 'Administrator', 'myWSCxSk12PxI', '0508005958', '/images/avatars/c4ca4238a0b923820dcc509a6f75849b.jpg', 'admin', '2016-05-22 00:57:32', 1),
(15, 'Vyacheslav', 'Vyacheslav Lynnyk', 'myWSCxSk12PxI', '0508005958', '/images/avatars/9bf31c7ff062936a96d3c8bd1f8f2ff3.jpg', 'user', '2016-05-22 22:17:51', 1),
(16, 'guest', 'Гость', 'my78IKkmW1ix6', '', '/images/avatars/c74d97b01eae257e44aa9d5bade97baf.jpg', 'user', '2016-06-11 10:16:55', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
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
