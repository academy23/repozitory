-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 01 2014 г., 18:49
-- Версия сервера: 5.5.25
-- Версия PHP: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `univer`
--

-- --------------------------------------------------------

--
-- Структура таблицы `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `city` text NOT NULL,
  `street` text NOT NULL,
  `house` text NOT NULL,
  `zip_code` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `addresses`
--

INSERT INTO `addresses` (`id`, `country_id`, `city`, `street`, `house`, `zip_code`) VALUES
(1, 1, 'Чернівці', 'Головна', '21', '58552'),
(2, 1, 'Чернівці', 'Головна', '21', '58552'),
(4, 1, 'Київ', 'Богомольца', '12', '1'),
(5, 1, 'Москва', 'Сімовича', '12', '58552'),
(6, 1, 'Відень', 'Казанови', '34', '009944'),
(7, 1, 'Чернівці', 'Богомольца', '12', '009944'),
(8, 3, 'Чернівці', 'Богомольца', '34', '60200'),
(9, 0, 'Чернівці', 'Казанови', '12', '60200');

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `country`) VALUES
(1, 'Україна'),
(3, 'Франція');

-- --------------------------------------------------------

--
-- Структура таблицы `faculties`
--

CREATE TABLE IF NOT EXISTS `faculties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_faculty` text NOT NULL,
  `id_address` int(11) NOT NULL,
  `year_foundation` int(11) NOT NULL,
  `id_decan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `faculties`
--

INSERT INTO `faculties` (`id`, `title_faculty`, `id_address`, `year_foundation`, `id_decan`) VALUES
(1, 'Факультет математики та інформатики', 1, 1852, 7),
(2, 'Факультет історії та політології', 2, 1234, 1),
(4, 'факультет космосу', 4, 2344, 8),
(5, 'Біології', 5, 1234, 1),
(6, 'Факультет кераміки', 6, 1952, 0),
(8, '111112', 8, 1234, 0),
(9, 'Факльтет історії', 9, 1234, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `lectors`
--

CREATE TABLE IF NOT EXISTS `lectors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` text NOT NULL,
  `firstname` text NOT NULL,
  `date_of_birth` int(20) NOT NULL,
  `degree` text NOT NULL,
  `post` text NOT NULL,
  `id_faculty_work` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `lectors`
--

INSERT INTO `lectors` (`id`, `surname`, `firstname`, `date_of_birth`, `degree`, `post`, `id_faculty_work`) VALUES
(7, 'Ткач', 'Андрій', 701301600, 'Доктор наук', 'Асистент', 1),
(8, 'Ткач', 'Євген', 1058043600, 'Кандидат наук', 'Асистент', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_subject` text NOT NULL,
  `id_faculty` int(11) NOT NULL,
  `number_of_semestr` int(11) NOT NULL,
  `form_control` int(11) NOT NULL,
  `id_lector` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`id`, `title_subject`, `id_faculty`, `number_of_semestr`, `form_control`, `id_lector`) VALUES
(5, 'Географія', 6, 5, 1, 7),
(10, 'Фізика', 6, 1, 2, 8),
(11, 'Англійська', 6, 11, 1, 8);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
