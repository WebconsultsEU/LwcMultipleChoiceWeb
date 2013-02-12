-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2013 at 04:46 PM
-- Server version: 5.1.50
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lwcmultiplechoice`
--

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `answer`, `points`) VALUES
(1, 1, 'Rotterdam', 0),
(2, 1, 'Frankfurt', 1),
(3, 1, 'Berlin', 0),
(4, 1, 'Amsterdam', 0),
(5, 2, 'Boing 707', 0),
(6, 2, 'TB-303', 1),
(7, 2, 'IT-101', 0),
(8, 2, 'xt-8086', 0),
(9, 3, 'DJ Paul - Brohymn', 0),
(10, 3, 'Bodylution - Always Hardcore', 0),
(11, 3, 'Euromasters - Amsterdam waar lecht dat dan ?', 1),
(12, 3, 'Korsakoff - My Empty Bottle', 0),
(13, 4, '1982', 0),
(14, 4, '1999', 0),
(15, 4, '2002', 0),
(16, 4, '1995', 1),
(17, 5, 'Amsterdam Arena', 0),
(18, 5, 'Turbinenhalle', 0),
(19, 5, 'Energiehal', 1),
(20, 5, 'Jabeurs', 0),
(21, 6, 'Rotterdam', 0),
(22, 6, 'London', 0),
(23, 6, 'New York', 0),
(24, 6, 'Berlin', 0),
(25, 6, 'Amsterdam', 1),
(26, 7, 'Bunker - Berlin', 1),
(27, 7, 'Funama - Rotterdam', 0),
(28, 7, 'Tunnel Hamburg', 0),
(29, 7, 'Catsuit - London', 0),
(30, 8, '1996', 0),
(31, 8, '1999', 0),
(32, 8, '2000', 0),
(33, 8, '2002', 1),
(34, 8, '2004', 0),
(35, 9, 'Riot Teenage Core', 0),
(36, 9, 'Rotterdam Teenage Core', 0),
(37, 9, 'Rotterdam Titten Core', 0),
(38, 9, 'Rotterdam Terror Corps', 1),
(39, 9, 'Rotterdam Titten Corps', 0);

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `test_id`, `question`, `created`) VALUES
(1, 1, 'In welcher bekannten Stadt wurde der erste Hardcore Track Produziert', '2013-02-05 16:05:47'),
(2, 1, 'Was erzeugte viele Hardcore Sounds', '2013-02-05 16:10:43'),
(3, 1, 'Was war das erste Release auf Rotterdam Records', '2013-02-05 16:14:30'),
(4, 1, 'In welchem Jahr fand die erste Masters of Hardcore statt ?', '2013-02-05 16:16:47'),
(5, 1, 'Welche legÃ¤ndÃ¤re Halle stand einst in Rotterdam und war Ort fÃ¼r Partys wie Megarave, A Nightmare in Rotterdam uvm...', '2013-02-12 11:36:24'),
(6, 1, 'In welcher Stadt ist das Label Mokkum Records AnsÃ¤ssig', '2013-02-12 12:32:07'),
(7, 1, 'Welcher Club war einst als "Hardest Club on Earth" bekannt.', '2013-02-12 12:33:51'),
(8, 1, 'Wann erschien das erste Release von Angerfist', '2013-02-12 12:37:03'),
(9, 1, 'WofÃ¼r steht die abkÃ¼rzung RTC', '2013-02-12 12:38:40');

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `name`, `user_id`, `created`) VALUES
(1, 'Gabber oder Zwabber', 1, '2013-02-05 16:05:07');
