
SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+01:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `Author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `Author` (`id`, `name`) VALUES
(1,	'Jos'),
(2,	'Piet');

CREATE TABLE `BlogPost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `authorId` int(11) NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `authorId` (`authorId`),
  CONSTRAINT `BlogPost_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `Author` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `BlogPost` (`id`, `authorId`, `content`) VALUES
(1,	1,	'Goe bezig'),
(2,	2,	'Iel goe bezig');

CREATE TABLE `Comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `authorId` int(11) NOT NULL,
  `blogPostId` int(11) NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `authorId` (`authorId`),
  KEY `blogPostId` (`blogPostId`),
  CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`blogPostId`) REFERENCES `BlogPost` (`id`),
  CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`authorId`) REFERENCES `Author` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `Comment` (`id`, `authorId`, `blogPostId`, `content`) VALUES
(1,	2,	1,	'Dank je'),
(2,	1,	1,	'Graag gedaan'),
(3,	1,	2,	'Heel erg bedankt'),
(4,	2,	2,	'Heel erg graag gedaan');

