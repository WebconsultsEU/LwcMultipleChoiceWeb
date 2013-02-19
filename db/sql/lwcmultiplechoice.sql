-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 14, 2013 at 12:57 PM
-- Server version: 5.1.50
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `lwcmultiplechoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned NOT NULL,
  `answer` varchar(255) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(10) unsigned NOT NULL,
  `question` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `test_id` (`test_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `description` varchar(2048) NOT NULL,
  `teaser` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`);
