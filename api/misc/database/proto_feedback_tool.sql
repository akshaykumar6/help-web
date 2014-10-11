-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2014 at 08:14 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `proto_feedback_tool`
--

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `ques_id` int(16) NOT NULL AUTO_INCREMENT COMMENT 'PRIMARY KEY',
  `ques_qtype_id` int(16) DEFAULT NULL COMMENT 'FOREIGN KEY to Question Type',
  `ques_sur_id` int(16) DEFAULT NULL COMMENT 'FOREIGN KEY to the Survey ID it is associated to',
  `ques_description` text COMMENT 'The Question',
  PRIMARY KEY (`ques_id`),
  KEY `FK__question_types` (`ques_qtype_id`),
  KEY `FK_question_survey` (`ques_sur_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Defining new questions' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `question_options`
--

CREATE TABLE IF NOT EXISTS `question_options` (
  `qopt_id` int(16) NOT NULL AUTO_INCREMENT COMMENT 'PRIMARY KEY',
  `qopt_ques_id` int(16) DEFAULT NULL COMMENT 'FOREIGN KEY to the question it belongs to',
  `qopt_description` text COMMENT 'The Option',
  PRIMARY KEY (`qopt_id`),
  KEY `FK_question_options_question` (`qopt_ques_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question_types`
--

CREATE TABLE IF NOT EXISTS `question_types` (
  `qtype_id` int(16) NOT NULL AUTO_INCREMENT COMMENT 'PRIMARY KEY',
  `qtype_description` text COMMENT 'Question Type Description',
  PRIMARY KEY (`qtype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Defining the types of question, such as MCQ with Single, Multiple, Rating, and Comment Answers' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `question_types`
--

INSERT INTO `question_types` (`qtype_id`, `qtype_description`) VALUES
(1, 'Single Answer Multiple Choice Question'),
(2, 'Multiple Answer Multiple Choice Question'),
(3, 'Rating Based Question'),
(4, 'Comment Based Question');

-- --------------------------------------------------------

--
-- Table structure for table `simulation`
--

CREATE TABLE IF NOT EXISTS `simulation` (
  `sim_id` int(16) NOT NULL AUTO_INCREMENT COMMENT 'PRIMARY KEY',
  `sim_name` text COMMENT 'Simulation Name',
  PRIMARY KEY (`sim_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Gives a key value mapping to all the simulations' AUTO_INCREMENT=14 ;

--
-- Dumping data for table `simulation`
--

INSERT INTO `simulation` (`sim_id`, `sim_name`) VALUES
(12, 'F1'),
(13, 'Hello');

-- --------------------------------------------------------

--
-- Table structure for table `simulation_user`
--

CREATE TABLE IF NOT EXISTS `simulation_user` (
  `suser_id` int(16) NOT NULL AUTO_INCREMENT COMMENT 'PRIMARY KEY',
  `suser_sim_user_id` int(16) DEFAULT NULL COMMENT 'The user ID used in the simulation',
  `suser_sim_id` int(16) DEFAULT NULL COMMENT 'FOREIGN KEY to the sim ID which the user is a part of',
  `suser_sur_id` int(16) DEFAULT NULL COMMENT 'FOREIGN KEY to the survey ID which the user is answering',
  `suser_feedback_complete` int(16) DEFAULT '-1' COMMENT 'If the user has completed the feedback: -1=>Incomplete, 0=>in Progress, 1=>Completed',
  `suser_start_timestamp` timestamp NULL DEFAULT NULL COMMENT 'When the user started, ie, when this entry was made',
  `suser_update_timestamp` timestamp NULL DEFAULT NULL COMMENT 'When the user last updated the survey',
  PRIMARY KEY (`suser_id`),
  KEY `FK_simulation_user_survey` (`suser_sur_id`),
  KEY `FK_simulation_user_simulation` (`suser_sim_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='A user list based on the simID and sim user ID' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE IF NOT EXISTS `survey` (
  `sur_id` int(16) NOT NULL AUTO_INCREMENT COMMENT 'PRIMARY KEY',
  `sur_name` text COMMENT 'Survey Name',
  `sur_description` text COMMENT 'Survey Description',
  `sur_is_sample` int(1) DEFAULT NULL COMMENT 'Flag to check if the collection can be reued to create new collection',
  `sur_sim_id` int(16) DEFAULT NULL COMMENT 'FOREIGN KEY to the sim ID',
  PRIMARY KEY (`sur_id`),
  KEY `FK_sur_simulation` (`sur_sim_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='A new survey targeting a simulation' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_question_answer`
--

CREATE TABLE IF NOT EXISTS `user_question_answer` (
  `uqa_id` int(16) NOT NULL AUTO_INCREMENT COMMENT 'PRIMARY KEY',
  `uqa_suser_id` int(16) DEFAULT NULL COMMENT 'FOREIGN KEY to the user ID - simulation ID primary key',
  `uqa_ques_id` int(16) DEFAULT NULL COMMENT 'FOREIGN KEY to the question ID',
  `uqa_comment` text COMMENT 'Comment Based Answer',
  `uqa_rating` int(2) DEFAULT NULL COMMENT 'Rating Based Answer',
  PRIMARY KEY (`uqa_id`),
  KEY `FK__simulation_user` (`uqa_suser_id`),
  KEY `FK__question` (`uqa_ques_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All the questions which the user has to answer will have an entry here' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_question_options_answers`
--

CREATE TABLE IF NOT EXISTS `user_question_options_answers` (
  `uqoa_id` int(16) NOT NULL AUTO_INCREMENT COMMENT 'PRIMARY KEY',
  `uqoa_uqa_id` int(16) DEFAULT NULL COMMENT 'FOREIGN KEY to the user ID - simulation ID primary key',
  `uqoa_qopt_id` int(16) DEFAULT NULL COMMENT 'FOREIGN KEY to the option ID',
  PRIMARY KEY (`uqoa_id`),
  KEY `FK__user_question_answer` (`uqoa_uqa_id`),
  KEY `FK__question_options` (`uqoa_qopt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All user MCQ answers' AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_question_survey` FOREIGN KEY (`ques_sur_id`) REFERENCES `survey` (`sur_id`),
  ADD CONSTRAINT `FK__question_types` FOREIGN KEY (`ques_qtype_id`) REFERENCES `question_types` (`qtype_id`);

--
-- Constraints for table `question_options`
--
ALTER TABLE `question_options`
  ADD CONSTRAINT `FK_question_options_question` FOREIGN KEY (`qopt_ques_id`) REFERENCES `question` (`ques_id`);

--
-- Constraints for table `simulation_user`
--
ALTER TABLE `simulation_user`
  ADD CONSTRAINT `FK_simulation_user_simulation` FOREIGN KEY (`suser_sim_id`) REFERENCES `simulation` (`sim_id`),
  ADD CONSTRAINT `FK_simulation_user_survey` FOREIGN KEY (`suser_sur_id`) REFERENCES `survey` (`sur_id`);

--
-- Constraints for table `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `FK_sur_simulation` FOREIGN KEY (`sur_sim_id`) REFERENCES `simulation` (`sim_id`);

--
-- Constraints for table `user_question_answer`
--
ALTER TABLE `user_question_answer`
  ADD CONSTRAINT `FK__question` FOREIGN KEY (`uqa_ques_id`) REFERENCES `question` (`ques_id`),
  ADD CONSTRAINT `FK__simulation_user` FOREIGN KEY (`uqa_suser_id`) REFERENCES `simulation_user` (`suser_id`);

--
-- Constraints for table `user_question_options_answers`
--
ALTER TABLE `user_question_options_answers`
  ADD CONSTRAINT `FK__question_options` FOREIGN KEY (`uqoa_qopt_id`) REFERENCES `question_options` (`qopt_id`),
  ADD CONSTRAINT `FK__user_question_answer` FOREIGN KEY (`uqoa_uqa_id`) REFERENCES `user_question_answer` (`uqa_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
