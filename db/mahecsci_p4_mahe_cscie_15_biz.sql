-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 26, 2013 at 09:30 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mahecsci_p4_mahe_cscie_15_biz`
--
CREATE DATABASE IF NOT EXISTS `mahecsci_p4_mahe_cscie_15_biz` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mahecsci_p4_mahe_cscie_15_biz`;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  `group_desc` varchar(255) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `per_complete` int(11) DEFAULT NULL,
  `projects_project_id` int(11) NOT NULL,
  `parent_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_id_UNIQUE` (`group_id`),
  KEY `fk_groups_projects1_idx` (`projects_project_id`),
  KEY `fk_groups_groups1_idx` (`parent_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `created`, `modified`, `group_desc`, `start_date`, `end_date`, `per_complete`, `projects_project_id`, `parent_group_id`) VALUES
(1, 1387827552, 1387827552, 'New Project', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 17, NULL),
(2, 1387827678, 1387827678, 'Another Project', '2013-12-25 00:00:00', '2013-12-31 00:00:00', 0, 18, NULL),
(3, 1387831218, 1387831218, 'My Project', '2013-12-24 00:00:00', '2013-12-26 00:00:00', 0, 19, NULL),
(4, 1388023371, 1388023371, 'Test Project', '2014-01-08 00:00:00', '2014-02-12 00:00:00', 0, 20, NULL),
(5, 1388023855, 1388023855, 'HR Website', '2013-12-26 00:00:00', '2014-02-27 00:00:00', 0, 21, NULL),
(6, 1388025366, 1388025366, 'HR Data', '2013-12-27 00:00:00', '2014-01-01 00:00:00', NULL, 21, 5),
(7, 1388071081, 1388071081, 'New Group', '2013-12-27 00:00:00', '2014-01-08 00:00:00', NULL, 18, 2);

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

CREATE TABLE IF NOT EXISTS `milestones` (
  `milestone_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  `milestone_desc` varchar(255) DEFAULT NULL,
  `milestone_date` datetime DEFAULT NULL,
  `groups_group_id` int(11) NOT NULL,
  `assigned_to_id` int(11) NOT NULL,
  PRIMARY KEY (`milestone_id`),
  UNIQUE KEY `milestone_id_UNIQUE` (`milestone_id`),
  KEY `fk_milestones_groups1_idx` (`groups_group_id`),
  KEY `fk_milestones_users_roles1_idx` (`assigned_to_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='	' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `milestones`
--

INSERT INTO `milestones` (`milestone_id`, `created`, `modified`, `milestone_desc`, `milestone_date`, `groups_group_id`, `assigned_to_id`) VALUES
(1, 1387827552, 1387827552, 'Finally', '2013-12-28 00:00:00', 1, 17),
(2, 1388090866, 1388090877, 'One more', '2014-01-04 00:00:00', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `project_desc` varchar(255) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `actual_start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `actual_end_date` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `pm_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`),
  UNIQUE KEY `project_id_UNIQUE` (`project_id`),
  KEY `fk_projects_users_roles1_idx` (`pm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `created`, `modified`, `project_name`, `project_desc`, `start_date`, `actual_start_date`, `end_date`, `actual_end_date`, `status`, `pm_id`) VALUES
(14, 1387788743, 1387788743, 'Marketing Website', 'This is a new marketing website', '2013-12-25 00:00:00', '2013-12-25 00:00:00', '2014-01-30 00:00:00', '2014-01-30 00:00:00', 'green', 6),
(17, 1387827552, 1387827552, 'New Project', 'To test trigger', '2013-12-24 00:00:00', '2013-12-24 00:00:00', '2013-12-30 00:00:00', '2013-12-30 00:00:00', 'green', 5),
(18, 1387827678, 1388007419, 'Another Project', 'One more test', '2013-12-25 00:00:00', '2013-12-25 00:00:00', '2013-12-31 00:00:00', '2013-12-31 00:00:00', 'yellow', 5),
(19, 1387831218, 1387832113, 'My Project', 'Hello', '2013-12-24 00:00:00', '2013-12-24 00:00:00', '2013-12-26 00:00:00', '2013-12-26 00:00:00', 'green', 7),
(20, 1388023371, 1388023739, 'Test Project', 'This is a testing project', '2014-01-08 00:00:00', '2014-01-08 00:00:00', '2014-02-12 00:00:00', '2014-02-12 00:00:00', 'yellow', 5),
(21, 1388023855, 1388023863, 'HR Website', 'Website for HR', '2013-12-26 00:00:00', '2013-12-26 00:00:00', '2014-02-27 00:00:00', '2014-02-27 00:00:00', 'yellow', 8);

--
-- Triggers `projects`
--
DROP TRIGGER IF EXISTS `projects_AINS`;
DELIMITER //
CREATE TRIGGER `projects_AINS` AFTER INSERT ON `projects`
 FOR EACH ROW BEGIN
	INSERT INTO `groups`
	(`created`,
	`modified`,
	`group_desc`,
	`start_date`,
	`end_date`,
	`per_complete`,
	`projects_project_id`,
	`parent_group_id`)
	VALUES
	(NEW.created,
	NEW.modified,
	NEW.project_name,
	NEW.start_date,
	NEW.end_date,
	0,
	NEW.project_id,
	NULL);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `role_types`
--

CREATE TABLE IF NOT EXISTS `role_types` (
  `role_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_type_id`),
  UNIQUE KEY `role_type_id_UNIQUE` (`role_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `role_types`
--

INSERT INTO `role_types` (`role_type_id`, `role_name`) VALUES
(1, 'Administrator'),
(2, 'Project Manager'),
(3, 'Team Member');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  `task_desc` varchar(255) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `per_complete` int(11) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `groups_group_id` int(11) NOT NULL,
  `assigned_to_id` int(11) NOT NULL,
  `depends_on` int(11) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`task_id`),
  UNIQUE KEY `task_id_UNIQUE` (`task_id`),
  KEY `fk_tasks_groups1_idx` (`groups_group_id`),
  KEY `fk_tasks_users_roles1_idx` (`assigned_to_id`),
  KEY `fk_tasks_tasks1_idx` (`depends_on`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `created`, `modified`, `task_desc`, `start_date`, `end_date`, `per_complete`, `status`, `groups_group_id`, `assigned_to_id`, `depends_on`, `color`) VALUES
(1, 1387827552, 1388000048, 'First task', '2013-12-24 00:00:00', '2013-12-27 00:00:00', 25, 'green', 1, 17, NULL, '#ffb878'),
(3, 1387948743, 1387948949, 'Another task', '2013-12-26 00:00:00', '2013-12-31 00:00:00', 44, 'green', 1, 19, NULL, '#5484ed'),
(4, 1387949058, 1388089962, 'Related Task', '2014-01-02 00:00:00', '2014-01-04 00:00:00', 45, 'green', 1, 6, 3, '#a4bdfc'),
(5, 1387989619, 1388016709, 'New Task', '2013-12-26 00:00:00', '2014-01-01 00:00:00', 25, 'green', 2, 6, NULL, '#7ae7bf'),
(6, 1388024577, 1388025325, 'My New Task', '2013-12-26 00:00:00', '2013-12-30 00:00:00', 41, 'yellow', 5, 17, NULL, '#5484ed'),
(7, 1388026322, 1388026322, 'HR data task', '2013-12-26 00:00:00', '2013-12-08 00:00:00', 30, 'green', 6, 17, 6, '#7bd148'),
(8, 1388060754, 1388060754, 'Help me', '2013-12-19 00:00:00', '2013-12-02 00:00:00', 47, 'green', 6, 19, NULL, '#a4bdfc'),
(9, 1388070439, 1388070771, 'Another task', '2014-01-02 00:00:00', '2014-01-06 00:00:00', 21, 'green', 2, 17, NULL, '#fbd75b'),
(10, 1388070728, 1388070728, 'Another new task', '2013-12-27 00:00:00', '2014-01-31 00:00:00', 35, 'green', 2, 19, NULL, '#fbd75b');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `timezon` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(25) DEFAULT 'Active',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `created`, `modified`, `token`, `password`, `last_login`, `timezon`, `first_name`, `last_name`, `email`, `avatar`, `status`) VALUES
(1, 1387693406, 1387864738, '988c5a1c84b82f84ef2dafe2819a10528c21e701', '859739d32e6165fe610bb6cd0523dd9230499c90', 1388093025, NULL, 'Mahendran', 'Nair', 'mahendran.nair@gmail.com', '\\uploads\\avatars\\default.gif', 'Active'),
(2, 1387695502, 1387695502, '5eef083dec7a559cc7d136e72839171a70ac35b8', '859739d32e6165fe610bb6cd0523dd9230499c90', NULL, NULL, 'Mike', 'Gatting', 'mike@gatting.com', '\\uploads\\avatars\\default.gif', 'Active'),
(3, 1387697236, 1387697236, '13abc5bcf57e1791c8bceda1291c4d172863100a', '859739d32e6165fe610bb6cd0523dd9230499c90', NULL, NULL, 'Don', 'Draper', 'dondraper@sharklasers.com', '\\uploads\\avatars\\default.gif', 'Active'),
(5, 1387725999, 1388086833, '62b9bd9afee483c4431fe0f5ac0ea711f948d7dc', '859739d32e6165fe610bb6cd0523dd9230499c90', NULL, NULL, 'Betty', 'White', 'bettywhite@sharklasers.com', '\\uploads\\avatars\\default.gif', 'Active'),
(6, 1387754843, 1387754843, '2e7086b50c3ddeed6086632300ab8b4ca2672043', '859739d32e6165fe610bb6cd0523dd9230499c90', 1387853978, NULL, 'Dan', 'Brown', 'danbrown@sharklasers.com', '\\uploads\\avatars\\default.gif', 'Active'),
(7, 1387845531, 1387845531, '78b3ff7bb8e64beae67dcbabb6a0106de41049b8', '859739d32e6165fe610bb6cd0523dd9230499c90', 1388023831, NULL, 'Marcy', 'Grey', 'marcygrey@sharklasers.com', '\\uploads\\avatars\\default.gif', 'Active'),
(11, 1387899659, 1387899776, '2b974be9fb37a79c062d15da7af3e65004e1d2c6', '859739d32e6165fe610bb6cd0523dd9230499c90', NULL, NULL, 'Jerry', 'Seinfeld', 'jerryseinfeld@sharklasers.com', '\\uploads\\avatars\\default.gif', 'Active'),
(12, 1387901650, 1387901766, '0e56d0070950bf202feb92fcd874787a0bb8496b', '859739d32e6165fe610bb6cd0523dd9230499c90', NULL, NULL, 'Elaine', 'Benez', 'elaine.benez@sharklasers.com', '\\uploads\\avatars\\default.gif', 'Active'),
(13, 1387903072, 1387903228, '2e88fb21f1d2e33247fc95df1536ae4b7ad1d0ec', '859739d32e6165fe610bb6cd0523dd9230499c90', 1388066400, NULL, 'Cosmo', 'Cramer', 'cosmo.cramer@sharklasers.com', '\\uploads\\avatars\\default.gif', 'Active'),
(14, 1387903297, 1387903297, 'f13d05f10e048a5c6da48dd4fac9640f4ce4f74e', '859739d32e6165fe610bb6cd0523dd9230499c90', NULL, NULL, 'George', 'Costanza', 'george.costanza@sharklasers.com', '\\uploads\\avatars\\default.gif', 'Active'),
(18, 1388076117, 1388076154, '8380b9d7bc6d9f09ca4a192b93ba5347a21da2b2', '859739d32e6165fe610bb6cd0523dd9230499c90', NULL, NULL, 'Barney', 'Stinson', 'barney.stinson@sharklasers.com', '\\uploads\\avatars\\default.gif', 'Active'),
(25, 1388089246, 1388089691, '498c79223a48aa2a81716a90001e2f31ea556dd7', '859739d32e6165fe610bb6cd0523dd9230499c90', NULL, NULL, 'Vimal', 'Nair', 'vimal.nair@sharklasers.com', '\\uploads\\avatars\\default.gif', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  `users_user_id` int(11) NOT NULL,
  `role_types_role_type_id` int(11) NOT NULL,
  PRIMARY KEY (`user_role_id`),
  UNIQUE KEY `user_project_role_id_UNIQUE` (`user_role_id`),
  KEY `fk_users_projects_roles_users_idx` (`users_user_id`),
  KEY `fk_users_projects_roles_role_types1_idx` (`role_types_role_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`user_role_id`, `created`, `modified`, `users_user_id`, `role_types_role_type_id`) VALUES
(3, 1387725999, 1387725999, 5, 2),
(4, 1387725999, 1387725999, 1, 1),
(5, 1387725999, 1387725999, 1, 2),
(6, 1387725999, 1387725999, 1, 3),
(7, 1387754843, 1387754843, 6, 2),
(8, 1387845531, 1387845531, 7, 2),
(13, 1387899659, 1387899659, 11, 2),
(14, 1387899659, 1387899659, 11, 1),
(15, 1387901650, 1387901650, 12, 2),
(16, 1387903072, 1387903072, 13, 2),
(17, 1387903072, 1387903072, 13, 3),
(18, 1387903297, 1387903297, 14, 2),
(19, 1387903297, 1387903297, 14, 3),
(26, 1388076117, 1388076117, 18, 2),
(27, 1388076117, 1388076117, 18, 1),
(38, 1388086833, 1388086833, 5, 1),
(42, 1388089246, 1388089246, 25, 2),
(43, 1388089246, 1388089246, 25, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `fk_groups_groups1` FOREIGN KEY (`parent_group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_groups_projects1` FOREIGN KEY (`projects_project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `milestones`
--
ALTER TABLE `milestones`
  ADD CONSTRAINT `fk_milestones_groups1` FOREIGN KEY (`groups_group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_milestones_users_roles1` FOREIGN KEY (`assigned_to_id`) REFERENCES `users_roles` (`user_role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_projects_users_roles1` FOREIGN KEY (`pm_id`) REFERENCES `users_roles` (`user_role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_tasks_groups1` FOREIGN KEY (`groups_group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tasks_tasks1` FOREIGN KEY (`depends_on`) REFERENCES `tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tasks_users_roles1` FOREIGN KEY (`assigned_to_id`) REFERENCES `users_roles` (`user_role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `fk_users_projects_roles_role_types1` FOREIGN KEY (`role_types_role_type_id`) REFERENCES `role_types` (`role_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_projects_roles_users` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
