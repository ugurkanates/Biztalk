CREATE SCHEMA IF NOT EXISTS biztalk_server collate utf8_turkish_ci;
CREATE SCHEMA IF NOT EXISTS biztalk_bre collate utf8_turkish_ci;
CREATE SCHEMA IF NOT EXISTS biztalk_gui collate utf8_turkish_ci;
CREATE SCHEMA IF NOT EXISTS biztalk_log collate utf8_turkish_ci;

####################################################
## SERVER
####################################################

USE biztalk_server;

CREATE TABLE IF NOT EXISTS jobs
(
	JobId int auto_increment primary key,
	JobOwner int default 0 not null,
	Destination text not null,
	FileUrl text not null,
	Relatives text not null,
	Status int default 0 not null,
	RuleId int default 0 not null,
	InsertDateTime datetime default CURRENT_TIMESTAMP not null,
	UpdateDateTime datetime default CURRENT_TIMESTAMP not null,
	Description text not null
);

CREATE TABLE IF NOT EXISTS orchestrations
(
	OrchestrationId int auto_increment primary key,
	OrchestrationOwner int default 0 not null,
	Status int default 0 not null,
	StartingJobId int default 0 not null,
	InsertDateTime datetime null,
	UpdateDateTime datetime default CURRENT_TIMESTAMP not null
);

CREATE TABLE IF NOT EXISTS rules
(
	RuleId int auto_increment primary key,
	RuleOwner int default 0 not null,
	RuleQuery text not null,
	YesEdge int default 0 not null,
	NoEdge int default 0 not null,
	RelativeResult text null
);

####################################################
## BRE
####################################################

USE biztalk_bre;

CREATE TABLE IF NOT EXISTS responses
(
	Id int auto_increment primary key,
	rule_id varchar(255) default '' not null,
	user_id varchar(255) default '' not null,
	answer varchar(1) default '' not null
);

CREATE TABLE IF NOT EXISTS rules
(
	Id int auto_increment primary key,
	rule_id varchar(255) default '' not null,
	clause text not null,
	relatives text not null
);

####################################################
## GUI
####################################################

USE biztalk_gui;

DROP TABLE IF EXISTS `orchestrations`;
CREATE TABLE `orchestrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(255) DEFAULT NULL,
  `startJobId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

#
# Structure for table "orcfollowsedge"
#

DROP TABLE IF EXISTS `orcfollowsedge`;
CREATE TABLE `orcfollowsedge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startingNode` int(11) DEFAULT NULL,
  `orchestrations_id` int(11) NOT NULL,
  `reachingNode` int(11) DEFAULT NULL,
  `startingNodeType` varchar(255) DEFAULT NULL,
  `reachingNodeType` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orchestrations_id` (`orchestrations_id`),
  CONSTRAINT `orcFollowsEdge_ibfk_1` FOREIGN KEY (`orchestrations_id`) REFERENCES `orchestrations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

#
# Structure for table "orcendnode"
#

DROP TABLE IF EXISTS `orcendnode`;
CREATE TABLE `orcendnode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orchestrations_id` int(11) NOT NULL,
  `endNode` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `orchestrations_id` (`orchestrations_id`),
  CONSTRAINT `orcEndNode_ibfk_1` FOREIGN KEY (`orchestrations_id`) REFERENCES `orchestrations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

#
# Structure for table "orcjobs"
#

DROP TABLE IF EXISTS `orcjobs`;
CREATE TABLE `orcjobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobId` int(11) NOT NULL,
  `owner` int(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `orchestrations_id` int(11) NOT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `fileUrl` varchar(255) DEFAULT NULL,
  `relatives` varchar(255) NOT NULL,
  `messages` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orchestrations_id` (`orchestrations_id`),
  CONSTRAINT `orcJobs_ibfk_1` FOREIGN KEY (`orchestrations_id`) REFERENCES `orchestrations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

#
# Structure for table "orcleadstoedge"
#

DROP TABLE IF EXISTS `orcleadstoedge`;
CREATE TABLE `orcleadstoedge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startingNode` int(11) DEFAULT NULL,
  `startingNodeType` varchar(1) NOT NULL,
  `orchestrations_id` int(11) NOT NULL,
  `reachingNode` int(11) DEFAULT NULL,
  `reachingNodeType` varchar(1) NOT NULL,
  `yesNoType` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orchestrations_id` (`orchestrations_id`),
  CONSTRAINT `orcLeadsToEdge_ibfk_1` FOREIGN KEY (`orchestrations_id`) REFERENCES `orchestrations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

#
# Structure for table "orcrules"
#

DROP TABLE IF EXISTS `orcrules`;
CREATE TABLE `orcrules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruleId` int(11) NOT NULL,
  `owner` int(255) DEFAULT NULL,
  `ruleName` varchar(255) DEFAULT NULL,
  `orchestrations_id` int(11) NOT NULL,
  `query` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`orchestrations_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_rules_orchestriations1_idx` (`orchestrations_id`),
  CONSTRAINT `fk_orcRules_orchestrations` FOREIGN KEY (`orchestrations_id`) REFERENCES `orchestrations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

#
# Structure for table "tbl_jobs"
#

DROP TABLE IF EXISTS `tbl_jobs`;
CREATE TABLE `tbl_jobs` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `owner` int(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `fileUrl` varchar(255) DEFAULT NULL,
  `ruleID` int(11) DEFAULT NULL,
  `query` varchar(255) DEFAULT NULL,
  `relatives` varchar(255) NOT NULL,
  `messages` varchar(225) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

#
# Structure for table "tbl_usr"
#

DROP TABLE IF EXISTS `tbl_usr`;
CREATE TABLE `tbl_usr` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

####################################################
## LOG
####################################################
USE biztalk_log;
