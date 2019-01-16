-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2019 at 07:53 PM
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biztalk`
--
CREATE DATABASE IF NOT EXISTS `biztalk` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `biztalk`;

-- --------------------------------------------------------

--
-- Table structure for table `orcEndNode`
--

CREATE TABLE `orcEndNode` (
  `id` int(11) NOT NULL,
  `orchestrations_id` int(11) NOT NULL,
  `endNode` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orcEndNode`
--

INSERT INTO `orcEndNode` (`id`, `orchestrations_id`, `endNode`) VALUES
(1, 1, 0),
(2, 1, 0),
(3, 1, 0),
(4, 4, 0),
(5, 5, 0),
(6, 11, 0),
(7, 12, 0),
(8, 12, 0),
(9, 13, 0),
(10, 14, 0),
(11, 16, 0),
(12, 17, 0),
(13, 17, 0),
(14, 17, 0),
(15, 17, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orcFollowsEdge`
--

CREATE TABLE `orcFollowsEdge` (
  `id` int(11) NOT NULL,
  `startingNode` int(11) DEFAULT NULL,
  `orchestrations_id` int(11) NOT NULL,
  `reachingNode` int(11) DEFAULT NULL,
  `startingNodeType` varchar(255) DEFAULT NULL,
  `reachingNodeType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orcFollowsEdge`
--

INSERT INTO `orcFollowsEdge` (`id`, `startingNode`, `orchestrations_id`, `reachingNode`, `startingNodeType`, `reachingNodeType`) VALUES
(1, 1, 1, 1, 'J', 'R'),
(2, 2, 1, 2, 'J', 'R'),
(3, 4, 4, 4, 'J', 'J'),
(4, 5, 5, 5, 'J', 'R'),
(5, 6, 11, 10, 'J', 'R'),
(6, 7, 12, 11, 'J', 'R'),
(7, 8, 12, 12, 'J', 'R'),
(8, 10, 14, 14, 'J', 'R'),
(9, 13, 16, 15, 'J', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `orcJobs`
--

CREATE TABLE `orcJobs` (
  `id` int(11) NOT NULL,
  `owner` int(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `orchestrations_id` int(11) NOT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `fileUrl` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orcJobs`
--

INSERT INTO `orcJobs` (`id`, `owner`, `description`, `orchestrations_id`, `destination`, `fileUrl`) VALUES
(1, 29, 'Deneme', 1, '10.0.0.1,10.0.0.2', 'Biz2.docx'),
(2, 29, 'Blabla', 1, '10.0.0.3,10.0.0.5', 'Biz3.docx'),
(3, 29, 'adsdasasd', 4, '', ''),
(4, 29, '', 4, '', ''),
(5, 29, 'serdar', 5, '127.1.1.1', ''),
(6, 29, 'XMLstartJObtest', 11, '10.10.10', 'Biz2.docx'),
(7, 29, 'job1', 12, '10.10.10', 'Biz2.docx'),
(8, 29, 'job2', 12, '10.0.0.1', 'Biz4.docx'),
(9, 29, 'startJob', 13, '1', ''),
(10, 29, 'startJob', 14, '1', ''),
(11, 29, 'firstJob', 14, '1', ''),
(12, 29, 'asd', 15, 'asd', 'Biz4.docx'),
(13, 29, 'test with yusuf', 16, '10.10.10', 'Biz3.docx');

-- --------------------------------------------------------

--
-- Table structure for table `orcLeadsToEdge`
--

CREATE TABLE `orcLeadsToEdge` (
  `id` int(11) NOT NULL,
  `startingNode` int(11) DEFAULT NULL,
  `startingNodeType` varchar(1) NOT NULL,
  `orchestrations_id` int(11) NOT NULL,
  `reachingNode` int(11) DEFAULT NULL,
  `reachingNodeType` varchar(1) NOT NULL,
  `yesNoType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orcLeadsToEdge`
--

INSERT INTO `orcLeadsToEdge` (`id`, `startingNode`, `startingNodeType`, `orchestrations_id`, `reachingNode`, `reachingNodeType`, `yesNoType`) VALUES
(1, 1, 'R', 1, 2, 'J', 'yes'),
(2, 1, 'R', 1, 0, 'E', 'no'),
(3, 2, 'R', 1, 0, 'E', ''),
(4, 2, 'R', 1, 0, 'E', ''),
(5, 5, 'R', 5, 0, 'E', ''),
(6, 10, 'R', 11, 0, 'E', ''),
(7, 10, 'R', 11, 0, 'E', ''),
(8, 11, 'R', 12, 8, 'J', ''),
(9, 11, 'R', 12, 0, 'E', ''),
(10, 12, 'R', 12, 0, 'E', ''),
(11, 12, 'R', 12, 0, 'E', ''),
(12, 13, 'R', 13, 9, 'J', 'yes'),
(13, 13, 'R', 13, 0, 'E', 'no'),
(14, 14, 'R', 14, 11, 'J', 'yes'),
(16, 14, 'R', 14, 0, 'E', 'no'),
(17, 15, 'R', 16, 0, 'E', 'yes'),
(18, 15, 'R', 16, 0, 'E', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `orcRules`
--

CREATE TABLE `orcRules` (
  `id` int(11) NOT NULL,
  `owner` int(255) DEFAULT NULL,
  `ruleName` varchar(255) DEFAULT NULL,
  `orchestrations_id` int(11) NOT NULL,
  `query` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orcRules`
--

INSERT INTO `orcRules` (`id`, `owner`, `ruleName`, `orchestrations_id`, `query`) VALUES
(1, 29, 'Rule1', 1, '15.16,17'),
(2, 29, 'Rule2', 1, '20,21,23,24'),
(3, 29, '', 4, ''),
(4, 29, '', 4, ''),
(5, 29, 'deneme', 5, ''),
(6, 45, 'ruledeneme', 6, '1,2,3,4'),
(7, 45, 'deneme', 8, '1,2,3,4'),
(8, 45, 'deneme2', 9, '1,2,3,4'),
(9, 45, 'deneme2', 10, '123'),
(10, 29, 'Rule1', 11, '15.16,17'),
(11, 29, 'RuleUno', 12, '15.16,17'),
(12, 29, 'RuleDos', 12, '696969'),
(13, 29, 'firstRule', 13, '1,2,3'),
(14, 29, 'firstRule', 14, '1,2,3'),
(15, 29, 'Rule with yusuf', 16, '20,45+6');

-- --------------------------------------------------------

--
-- Table structure for table `orchestrations`
--

CREATE TABLE `orchestrations` (
  `id` int(11) NOT NULL,
  `owner` int(255) DEFAULT NULL,
  `startJobId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orchestrations`
--

INSERT INTO `orchestrations` (`id`, `owner`, `startJobId`) VALUES
(1, 29, 1),
(2, 29, NULL),
(3, 29, NULL),
(4, 29, 4),
(5, 29, 5),
(6, 45, NULL),
(7, 45, NULL),
(8, 45, NULL),
(9, 45, NULL),
(10, 45, NULL),
(11, 29, 6),
(12, 29, 8),
(13, 29, 9),
(14, 29, 11),
(15, 29, 12),
(16, 29, 13),
(17, 29, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jobs`
--

CREATE TABLE `tbl_jobs` (
  `id` int(255) NOT NULL,
  `owner` int(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `fileUrl` varchar(255) DEFAULT NULL,
  `ruleID` int(11) DEFAULT NULL,
  `query` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_jobs`
--

INSERT INTO `tbl_jobs` (`id`, `owner`, `description`, `destination`, `fileUrl`, `ruleID`, `query`) VALUES
(1, 2, 'DDDD', '10.10.10', 'Biz6.docx', NULL, '20,45+6'),
(2, 2, 'My second User job', '10.0.0.1', 'Biz6.docx', 123, '20,+/*967686'),
(3, 2, 'requeset test', '20.20.20', 'Biz6.docx', 124, '15.16,17'),
(4, 2, 'des', '214213', '', 123, '1,2,3,4'),
(5, 2, 'hhhh', '10.10.10.10', '', 123, '10.10'),
(6, 2, 'firatla birlikte oludturdugumuz job', '10.10.10', '', 123, '20,45+6'),
(7, 53, 'test2', '33.33.33', '', 11, '21321311'),
(8, 53, 'test3', '44.44,55.55', '', 121231, '12211'),
(9, 53, 'testtttttt123', '88.88.88.88', '', 11, '12312311'),
(10, 2, 'User: alaa deneme 1 ', '1.1.1.1', '', 100, ''),
(11, 2, 'User: alaa deneme 1 ', '1.1.1.1', 'uploads/CSE 321 Homework 1.pdf', 100, ''),
(12, 2, 'User: alaa deneme 1 ', '1.1.1.1', 'uploads/CSE 321 Homework 1.pdf', 100, ''),
(13, 55, 'test', '55', '', 123, ''),
(14, 55, 'test', '55', '', 1, ''),
(15, 55, 'test', '55', '', 1, ''),
(16, 55, 'deneme job for fer', '55', '', 1, ''),
(17, 55, 'Ferthanicinjob1', '11.11.11.11', '', 14, 'AAAAA'),
(18, 2, 'User: alaa deneme 1 ', '1.1.1.1', '', 123, '11'),
(19, 2, 'User: alaa deneme 1 ', '1.1.1.1', '', 123, '11'),
(20, 2, 'User: alaa deneme 1 ', '1.1.1.1', '', 123, '11'),
(21, 2, 'asd', '123', '', 123, '10.10'),
(22, 2, 'qweqwe', 'qwe', '', 123, '696969'),
(23, 2, 'asdasdasdasd', 'asd', '', 123, '10.10'),
(24, 2, 'Firat', '53', '', 1, '696969'),
(25, 2, 'test', '10.10.10', '', 123, ''),
(26, 55, 'denemedeneme', '53', '', 1, ''),
(27, 55, 'ferhat__ferhat', '53', '', 1, ''),
(28, 53, 'oalylylyl', '1212', '', 1, '2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usr`
--

CREATE TABLE `tbl_usr` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_usr`
--

INSERT INTO `tbl_usr` (`id`, `username`, `password`, `type`) VALUES
(2, 'alaa', '123', 'user'),
(10, 'Busra', '123456789', 'user'),
(13, 'ismail', '1234', 'admin'),
(18, 'mert', 'ali', 'admin'),
(22, 'utku', 'utku', 'admin'),
(26, 'Murat', '789', 'user'),
(27, 'haticenurokur', '123', 'admin'),
(28, 'semakose', 'ayheytyu', 'admin'),
(29, 'newManager', '123', 'manager'),
(30, 'utku', '123', 'user'),
(31, 'utku2', '000', 'manager'),
(32, 'mcomert', '123', 'user'),
(33, 'akin', 'cam', 'manager'),
(36, 'man', '123', 'manager'),
(40, 'root', '123', 'admin'),
(41, 'rooter', 'serdar', 'admin'),
(43, 'gtu', '123', 'user'),
(44, 'burhan', '123', 'admin'),
(45, 'horde', '123', 'manager'),
(46, 'boss', '123', 'manager'),
(48, 'akin', '123', 'user'),
(49, 'fthorde', '123', 'manager'),
(50, 'ucanadam', 'sifre', 'admin'),
(51, 'zeliha', '123', 'user'),
(52, 'vefikfÄ±ratakmanA', '123', 'admin'),
(53, 'vefikfÄ±ratakmanU', '123', 'user'),
(54, 'vefikfÄ±ratakmanM', '123', 'manager'),
(55, 'ferhat', '123', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orcEndNode`
--
ALTER TABLE `orcEndNode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orchestrations_id` (`orchestrations_id`);

--
-- Indexes for table `orcFollowsEdge`
--
ALTER TABLE `orcFollowsEdge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orchestrations_id` (`orchestrations_id`);

--
-- Indexes for table `orcJobs`
--
ALTER TABLE `orcJobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orchestrations_id` (`orchestrations_id`);

--
-- Indexes for table `orcLeadsToEdge`
--
ALTER TABLE `orcLeadsToEdge`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orchestrations_id` (`orchestrations_id`);

--
-- Indexes for table `orcRules`
--
ALTER TABLE `orcRules`
  ADD PRIMARY KEY (`id`,`orchestrations_id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_rules_orchestriations1_idx` (`orchestrations_id`);

--
-- Indexes for table `orchestrations`
--
ALTER TABLE `orchestrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tbl_jobs`
--
ALTER TABLE `tbl_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_2` (`id`);

--
-- Indexes for table `tbl_usr`
--
ALTER TABLE `tbl_usr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orcEndNode`
--
ALTER TABLE `orcEndNode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `orcFollowsEdge`
--
ALTER TABLE `orcFollowsEdge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `orcJobs`
--
ALTER TABLE `orcJobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `orcLeadsToEdge`
--
ALTER TABLE `orcLeadsToEdge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `orcRules`
--
ALTER TABLE `orcRules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `orchestrations`
--
ALTER TABLE `orchestrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tbl_jobs`
--
ALTER TABLE `tbl_jobs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tbl_usr`
--
ALTER TABLE `tbl_usr`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orcEndNode`
--
ALTER TABLE `orcEndNode`
  ADD CONSTRAINT `orcEndNode_ibfk_1` FOREIGN KEY (`orchestrations_id`) REFERENCES `orchestrations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orcFollowsEdge`
--
ALTER TABLE `orcFollowsEdge`
  ADD CONSTRAINT `orcFollowsEdge_ibfk_1` FOREIGN KEY (`orchestrations_id`) REFERENCES `orchestrations` (`id`);

--
-- Constraints for table `orcJobs`
--
ALTER TABLE `orcJobs`
  ADD CONSTRAINT `orcJobs_ibfk_1` FOREIGN KEY (`orchestrations_id`) REFERENCES `orchestrations` (`id`);

--
-- Constraints for table `orcLeadsToEdge`
--
ALTER TABLE `orcLeadsToEdge`
  ADD CONSTRAINT `orcLeadsToEdge_ibfk_1` FOREIGN KEY (`orchestrations_id`) REFERENCES `orchestrations` (`id`);

--
-- Constraints for table `orcRules`
--
ALTER TABLE `orcRules`
  ADD CONSTRAINT `fk_orcRules_orchestrations` FOREIGN KEY (`orchestrations_id`) REFERENCES `orchestrations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
-- Database: `biztalk_server`
--
CREATE DATABASE IF NOT EXISTS `biztalk_server` DEFAULT CHARACTER SET utf8 COLLATE utf8_turkish_ci;
USE `biztalk_server`;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `JobId` int(11) NOT NULL,
  `JobOwner` int(11) NOT NULL DEFAULT '0',
  `Destination` text COLLATE utf8_turkish_ci NOT NULL,
  `FileUrl` text COLLATE utf8_turkish_ci NOT NULL,
  `Relatives` text COLLATE utf8_turkish_ci NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  `RuleId` int(11) NOT NULL DEFAULT '0',
  `InsertDateTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `UpdateDateTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Description` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`JobId`, `JobOwner`, `Destination`, `FileUrl`, `Relatives`, `Status`, `RuleId`, `InsertDateTime`, `UpdateDateTime`, `Description`) VALUES
(1, 151044083, '10.0.0.1,10.0.0.2,10.0.0.3', 'http://www.cevkos.gtu.edu.tr/wp-content/uploads/2018/03/GTU_sponsor-1.png', '1510,1511,1512', 0, 123, '2018-12-26 14:29:43', '2018-12-26 14:29:43', 'Aç?klama yaz?s?d?r.'),
(2, 151044083, '10.0.0.1,10.0.0.2,10.0.0.3', 'http://www.cevkos.gtu.edu.tr/wp-content/uploads/2018/03/GTU_sponsor-1.png', '1510,1511,1512', 0, 123, '2018-12-26 14:29:43', '2018-12-26 14:29:43', 'Aç?klama yaz?s?d?r.'),
(3, 151044083, '10.0.0.1,10.0.0.2,10.0.0.3', 'http://www.cevkos.gtu.edu.tr/wp-content/uploads/2018/03/GTU_sponsor-1.png', '1510,1511,1512', 0, 123, '2018-12-26 14:31:40', '2018-12-26 14:31:40', 'Açıklama yazısıdır.');

-- --------------------------------------------------------

--
-- Table structure for table `orchestrations`
--

CREATE TABLE `orchestrations` (
  `OrchestrationId` int(11) NOT NULL,
  `OrchestrationOwner` int(11) NOT NULL DEFAULT '0',
  `Status` int(11) NOT NULL DEFAULT '0',
  `StartingJobId` int(11) NOT NULL DEFAULT '0',
  `InsertDateTime` datetime DEFAULT NULL,
  `UpdateDateTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `RuleId` int(11) NOT NULL,
  `RuleOwner` int(11) NOT NULL DEFAULT '0',
  `RuleQuery` text NOT NULL,
  `YesEdge` int(11) NOT NULL DEFAULT '0',
  `NoEdge` int(11) NOT NULL DEFAULT '0',
  `RelativeResult` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`JobId`);

--
-- Indexes for table `orchestrations`
--
ALTER TABLE `orchestrations`
  ADD PRIMARY KEY (`OrchestrationId`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`RuleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `JobId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `orchestrations`
--
ALTER TABLE `orchestrations`
  MODIFY `OrchestrationId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `RuleId` int(11) NOT NULL AUTO_INCREMENT;--
-- Database: `biztalkdb`
--
CREATE DATABASE IF NOT EXISTS `biztalkdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `biztalkdb`;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `JobId` int(11) NOT NULL,
  `JobOwner` int(11) NOT NULL DEFAULT '0',
  `Destination` text COLLATE utf8_turkish_ci NOT NULL,
  `FileUrl` text COLLATE utf8_turkish_ci NOT NULL,
  `Relatives` text COLLATE utf8_turkish_ci NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  `RuleId` int(11) NOT NULL DEFAULT '0',
  `Description` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orchestrations`
--

CREATE TABLE `orchestrations` (
  `OrchestrationId` int(11) NOT NULL,
  `OrchestrationOwner` int(11) NOT NULL DEFAULT '0',
  `Status` int(11) NOT NULL DEFAULT '0',
  `StartingJobId` int(11) NOT NULL DEFAULT '0',
  `InsertDateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `RuleId` int(11) NOT NULL,
  `RuleOwner` int(11) NOT NULL DEFAULT '0',
  `RuleQuery` text NOT NULL,
  `YesEdge` int(11) NOT NULL DEFAULT '0',
  `NoEdge` int(11) NOT NULL DEFAULT '0',
  `RelativeResult` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`JobId`);

--
-- Indexes for table `orchestrations`
--
ALTER TABLE `orchestrations`
  ADD PRIMARY KEY (`OrchestrationId`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`RuleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `JobId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orchestrations`
--
ALTER TABLE `orchestrations`
  MODIFY `OrchestrationId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `RuleId` int(11) NOT NULL AUTO_INCREMENT;--
-- Database: `mydb`
--
CREATE DATABASE IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mydb`;

-- --------------------------------------------------------

--
-- Table structure for table `followsEdge`
--

CREATE TABLE `followsEdge` (
  `id` int(11) NOT NULL,
  `startingNode` int(11) DEFAULT NULL,
  `orchestriations_id` int(11) NOT NULL,
  `reachingNode` int(11) DEFAULT NULL,
  `startingNodeType` varchar(255) DEFAULT NULL,
  `reachingNodeType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `followsEdge`
--

INSERT INTO `followsEdge` (`id`, `startingNode`, `orchestriations_id`, `reachingNode`, `startingNodeType`, `reachingNodeType`) VALUES
(1, 1, 1, 1, 'J', 'R'),
(2, 2, 1, 2, 'J', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `orchestriations_id` int(11) NOT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `fileUrl` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `owner`, `description`, `orchestriations_id`, `destination`, `fileUrl`) VALUES
(1, 'sema', 'first job', 1, '46.101.176.37', 'http://46.101.176.37/phpmyadmin/tbl_change.php?db=mydb&table=jobs&token=e9e9a5afec017df95d3a5a41dfe4cde4'),
(2, 'alaa', 'second job', 1, '46.101.176.37', 'http://46.101.176.37/phpmyadmin/tbl_change.php?db=mydb&table=jobs&token=e9e9a5afec017df95d3a5a41dfe4cde4'),
(3, 'Alaa', 'Mydes', 1, '10.10.10', 'opps.txt');

-- --------------------------------------------------------

--
-- Table structure for table `leadsToEdge`
--

CREATE TABLE `leadsToEdge` (
  `id` int(11) NOT NULL,
  `startingNode` int(11) DEFAULT NULL,
  `orchestriations_id` int(11) NOT NULL,
  `reachingNode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `leadsToEdge`
--

INSERT INTO `leadsToEdge` (`id`, `startingNode`, `orchestriations_id`, `reachingNode`) VALUES
(1, 1, 1, 2),
(2, 1, 1, 0),
(3, 2, 1, 0),
(4, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orchestriations`
--

CREATE TABLE `orchestriations` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `startJobId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orchestriations`
--

INSERT INTO `orchestriations` (`id`, `owner`, `startJobId`) VALUES
(1, 'sema', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `orchestriations_id` int(11) NOT NULL,
  `query` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `owner`, `orchestriations_id`, `query`) VALUES
(1, 'sema', 1, '20,30,40'),
(2, 'sema', 1, '30,40,50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `followsEdge`
--
ALTER TABLE `followsEdge`
  ADD PRIMARY KEY (`id`,`orchestriations_id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_followsEdge_orchestriations1_idx` (`orchestriations_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`,`orchestriations_id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_jobs_orchestriations_idx` (`orchestriations_id`);

--
-- Indexes for table `leadsToEdge`
--
ALTER TABLE `leadsToEdge`
  ADD PRIMARY KEY (`id`,`orchestriations_id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_followsEdge_orchestriations1_idx` (`orchestriations_id`);

--
-- Indexes for table `orchestriations`
--
ALTER TABLE `orchestriations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`,`orchestriations_id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_rules_orchestriations1_idx` (`orchestriations_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `followsEdge`
--
ALTER TABLE `followsEdge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `leadsToEdge`
--
ALTER TABLE `leadsToEdge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orchestriations`
--
ALTER TABLE `orchestriations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `followsEdge`
--
ALTER TABLE `followsEdge`
  ADD CONSTRAINT `fk_followsEdge_orchestriations1` FOREIGN KEY (`orchestriations_id`) REFERENCES `orchestriations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `fk_jobs_orchestriations` FOREIGN KEY (`orchestriations_id`) REFERENCES `orchestriations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `leadsToEdge`
--
ALTER TABLE `leadsToEdge`
  ADD CONSTRAINT `fk_followsEdge_orchestriations10` FOREIGN KEY (`orchestriations_id`) REFERENCES `orchestriations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rules`
--
ALTER TABLE `rules`
  ADD CONSTRAINT `fk_rules_orchestriations1` FOREIGN KEY (`orchestriations_id`) REFERENCES `orchestriations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
-- Database: `okul`
--
CREATE DATABASE IF NOT EXISTS `okul` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `okul`;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('pmauser', '[{\"db\":\"mysql\",\"table\":\"db\"}]'),
('root', '[{\"db\":\"biztalk\",\"table\":\"orchestrations\"},{\"db\":\"biztalk\",\"table\":\"orcRules\"},{\"db\":\"biztalk\",\"table\":\"orcLeadsToEdge\"},{\"db\":\"biztalk\",\"table\":\"orcFollowsEdge\"},{\"db\":\"biztalk\",\"table\":\"orcJobs\"},{\"db\":\"biztalk\",\"table\":\"tbl_jobs\"},{\"db\":\"biztalk\",\"table\":\"orcEndNode\"},{\"db\":\"biztalk_server\",\"table\":\"jobs\"},{\"db\":\"biztalk_server\",\"table\":\"rules\"},{\"db\":\"biztalk\",\"table\":\"tbl_usr\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float UNSIGNED NOT NULL DEFAULT '0',
  `y` float UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'biztalk', 'orcRules', '[]', '2019-01-04 14:39:50'),
('root', 'biztalk', 'tbl_usr', '{\"sorted_col\":\"`tbl_usr`.`username` ASC\"}', '2018-12-26 15:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('phpmyadmin', '2018-12-01 19:06:39', '{\"collation_connection\":\"utf8mb4_unicode_ci\"}'),
('pmauser', '2018-12-01 18:42:54', '{\"collation_connection\":\"utf8mb4_unicode_ci\",\"lang\":\"tr\"}'),
('root', '2019-01-08 09:59:24', '{\"collation_connection\":\"utf8mb4_unicode_ci\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;--
-- Database: `test_orc`
--
CREATE DATABASE IF NOT EXISTS `test_orc` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test_orc`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
