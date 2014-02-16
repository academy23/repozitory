-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Фев 14 2014 г., 12:20
-- Версия сервера: 5.5.25
-- Версия PHP: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `university`
--

-- --------------------------------------------------------

--
-- Структура таблицы `address`
--

CREATE TABLE IF NOT EXISTS `address` ( --addresses - тут же буде не одна адреса :), і для всіх таблиць так же
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` text NOT NULL, -- варто country_id і країни в окрему таблицю
  `city` text NOT NULL,
  `street` text NOT NULL,
  `house` text NOT NULL,
  `zip_code` int(11) NOT NULL, -- int не добре, якщо zip 00394, то можуть бути проблеми
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `degree`
--

CREATE TABLE IF NOT EXISTS `degree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_degree` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_faculty` text NOT NULL,
  `id_address` int(11) NOT NULL, --краще address_id, але і так може бути
  `year_of_foundation` int(11) NOT NULL,
  `id_decan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `form_control`
--

CREATE TABLE IF NOT EXISTS `form_control` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_form_control` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `lector`
--

CREATE TABLE IF NOT EXISTS `lector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` text NOT NULL,
  `name` text NOT NULL,
  `date_of_birth` int(11) NOT NULL,
  `id_degree` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_faculty_work` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_post` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_subject` text NOT NULL,
  `id_faculty` int(11) NOT NULL,
  `number_of_semestr` int(11) NOT NULL,
  `id_form_of_control` int(11) NOT NULL,
  `id_lector` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
