-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2016 at 12:10 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `testlogs`
--

CREATE TABLE `testlogs` (
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `level` text COLLATE utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `testlogs`
--

INSERT INTO `testlogs` (`time`, `level`, `message`) VALUES
('2016-08-19 09:05:23', 'warning', 'Строка'),
('2016-08-19 09:05:23', 'debug', 'Array\n(\n    [0] => Array\n        (\n            [0] => 1\n            [1] => 2\n            [2] => 3\n            [3] => 4\n            [4] => 5\n        )\n\n    [1] => Array\n        (\n            [key1] => value1\n            [key2] => value2\n        )\n\n)\n'),
('2016-08-19 09:05:23', 'debug', 'Logger Object\n(\n    [transport] => LoggerTransportFile Object\n        (\n            [logFile] => Resource id #9\n        )\n\n    [testProperty1] => 1\n    [testProperty2] => 2\n)\n'),
('2016-08-19 09:05:23', 'notice', 'Unsupported message type. Only strings, arrays, objects and exceptions are allowed'),
('2016-08-19 09:05:23', 'alert', 'exception \'Exception\' with message \'Division by zero.\' in D:\\Documents\\Drive\\Web\\PHP\\Projects\\Logger\\LoggerAllInOne.php:164\nStack trace:\n#0 {main}');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
