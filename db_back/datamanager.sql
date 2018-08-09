-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin',	20,	1530873625),
('manager',	21,	1531467936),
('manager',	25,	1531827022),
('manager',	30,	NULL),
('supervisor',	24,	1530884247);

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin',	1,	'Администратор',	NULL,	NULL,	1530694956,	1530694956),
('createUser',	2,	'Право на создание юзера',	NULL,	NULL,	1530696113,	1530696113),
('manager',	1,	'Менеджер',	NULL,	NULL,	1530694956,	1530694956),
('supervisor',	1,	'Супервайзер',	NULL,	NULL,	1530694956,	1530694956);

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  CONSTRAINT `group_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`),
  CONSTRAINT `group_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `group` (`id`, `name`, `owner_id`, `created_at`, `updated_at`) VALUES
(1,	'Admin группа 1',	24,	'0000-00-00 00:00:00',	'2018-07-18 16:14:03'),
(8,	'Test11',	20,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(9,	'Manager group',	21,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(10,	'Manager test',	21,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(11,	'Sveta group 1',	25,	'0000-00-00 00:00:00',	'2018-07-18 14:17:14'),
(12,	'test',	21,	'0000-00-00 00:00:00',	'2018-07-18 14:17:02'),
(13,	'Test123',	21,	'2018-07-18 12:01:37',	'2018-07-18 12:01:37'),
(15,	'G1',	21,	'2018-07-18 16:16:11',	'2018-07-18 16:16:56');

DROP TABLE IF EXISTS `group_account`;
CREATE TABLE `group_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `group_account_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `group_account` (`id`, `group_id`, `account_id`) VALUES
(20,	11,	4),
(21,	11,	13),
(22,	11,	5),
(23,	11,	6),
(24,	10,	8),
(50,	1,	5),
(51,	1,	13),
(52,	1,	6),
(53,	15,	3),
(54,	15,	11),
(55,	15,	12),
(56,	15,	4),
(57,	15,	13),
(58,	15,	5),
(59,	15,	6);

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base',	1530626561),
('m130524_201442_init',	1530626573),
('m140506_102106_rbac_init',	1530693609),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id',	1530693609);

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `data_post_id` text,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION,
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `post_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(20,	'admin',	'7yM5RwTUUld-_b7Vppcc78zJvpaq4mdw',	'$2y$13$nvFIoKipfeCJqa6WotTpzOAC4FsXjX1UvIvtHOsjV8R1qXY3LItNK',	'FIHB8dl_Uc3Aw1d901SdXU0ynFHSHNto_1530873625',	'kievwarlock@gmail.com',	10,	1530873625,	1530873625),
(21,	'Manager',	'ZoyizYSt-2De8OAuOCJ9Zl2KQwfrP1H-',	'$2y$13$JXt7OzdPq7NHbT9hIY6QNuFrCHhvfHcN0Upi/rQlIn0faIPq5krUy',	'YY0jw9DRUtgP7Xc4QWcLh6aVIVmauITY_1530873648',	'manager@gmail.com',	10,	1530873648,	1531467936),
(24,	'Superviser',	'dGNkAphac4hNu1DXMzksFW4l44fEf01h',	'$2y$13$VJzCs41AeRPqHlQIq6LkaOXaTYIXmUG0UroetlALy3.LnUHLcdasa',	'Kaay8ohDVN8RtgURpBY6gcXRM2HjKdaX_1530883752',	'superviser@gmail.com',	10,	1530883752,	1530883752),
(25,	'Sveta',	'4YY9edZNTTp1f-eO0Mm1wxhJxUqevDo6',	'$2y$13$cYsa2imvT5jy4f9JNxFQi.NdhexK85B6Vxcd9KCh.QIA8JZbSO6rG',	'g0_9VxutmsRGFg-5KAW79-57Mtpixp_M_1530884270',	'kiev@gmail.com',	10,	1530884270,	1531827889),
(30,	'Test11',	'Z2w3jAYEBg8hb_kxPwIRRl4m9dlCvjor',	'$2y$13$aZzmAzOgM9Qg5PgK9.vy5OnExE.7J7B1gdYWVV5gAYCIkaGvyKHRG',	'qGL8yfhh9dpqeU3npfhQz-XuNjiElQKe_1531833129',	'kiev11@gmail.com',	10,	1531833129,	1531833129);

DROP TABLE IF EXISTS `user_account`;
CREATE TABLE `user_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `account_id` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_account` (`id`, `user_id`, `account_id`) VALUES
(3,	25,	'5c03835c-3457-4807-b79e-8571f0a10bbe'),
(66,	21,	'9121aff3-4d34-4f59-878e-86dd0ba0b33c'),
(67,	21,	'87739f2e-182c-422e-8dd7-765796c7616a'),
(68,	25,	'918cf5a3-71fa-459f-9d2d-c520e2937093'),
(69,	25,	'36f4b956-e421-4f5a-80b6-2eaa4f429213'),
(70,	25,	'299931af-22d7-4c5a-9f05-36aab0fe3ec8'),
(71,	25,	'67da8855-55dd-41eb-b538-6d45a4b4adbd'),
(72,	25,	'1223bfc0-666b-40f7-9075-871f2a4401b0'),
(73,	25,	'f4369d37-2798-497f-9876-8c32912432bc'),
(74,	25,	'c97039ee-86a4-4360-b2e4-92858b0b42f7'),
(75,	25,	'8a27de59-3d08-4bb7-8a72-a66891d047f0'),
(76,	25,	'358124b9-d3c0-441d-a6ab-92d5d46c1896'),
(77,	25,	'54b0661f-136a-47f2-97b9-7601a440ba2b'),
(78,	25,	'f8e9bb0d-a226-40a4-b108-0fa577fa9538'),
(79,	25,	'b519fd4d-54de-4491-b8f5-259aa157c1f4'),
(80,	25,	'aaf2b31c-4f2b-4a9a-a16b-b63a28d64212'),
(81,	25,	'7aa5daf4-4423-47c7-b4ba-81994b57bfb3'),
(82,	25,	'6b50926c-3ad9-46a5-bb89-e3b6e8bc4eb7');

-- 2018-08-09 15:19:03
