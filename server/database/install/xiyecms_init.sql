/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : xiyecms

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 11/10/2019 17:47:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for consultation
-- ----------------------------
DROP TABLE IF EXISTS `consultation`;
CREATE TABLE `consultation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `consultation_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of consultation
-- ----------------------------
BEGIN;
INSERT INTO `consultation` VALUES (1, '测试', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` int(11) NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IDcard` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2016_06_01_000001_create_oauth_auth_codes_table', 1);
INSERT INTO `migrations` VALUES (4, '2016_06_01_000002_create_oauth_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1);
INSERT INTO `migrations` VALUES (6, '2016_06_01_000004_create_oauth_clients_table', 1);
INSERT INTO `migrations` VALUES (7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1);
INSERT INTO `migrations` VALUES (8, '2019_09_26_072942_create_members_table', 1);
INSERT INTO `migrations` VALUES (9, '2019_09_26_092259_create_service_charge_table', 1);
INSERT INTO `migrations` VALUES (10, '2019_09_27_051929_create_consultation_table', 1);
COMMIT;

-- ----------------------------
-- Table structure for oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of oauth_access_tokens
-- ----------------------------
BEGIN;
INSERT INTO `oauth_access_tokens` VALUES ('059a8bea75d7663b5fadb3565579d71b1ef02380e6537777320cb5c1ab449ec99d981ad38b841301', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:18:17', '2019-10-11 03:18:17', '2020-10-11 03:18:17');
INSERT INTO `oauth_access_tokens` VALUES ('0a2e90718f666a22d14dda634f248f6490a13addb3c7493c98a66f7899c6846028d0ae09ec604bbf', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:20:46', '2019-10-11 03:20:46', '2020-10-11 03:20:46');
INSERT INTO `oauth_access_tokens` VALUES ('0b426687cb27ef4ea9a3c182db08b1f07f02f984879848c64efe00c279e12033f905ec695b034bc8', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:19:18', '2019-10-11 03:19:18', '2020-10-11 03:19:18');
INSERT INTO `oauth_access_tokens` VALUES ('14e6cf9722b53312a58a36d786e6e09f2c4e9b3ac8dda8d1c660cf4fbcc6d3e7454abe65f2d71847', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:59:04', '2019-10-11 03:59:04', '2020-10-11 03:59:04');
INSERT INTO `oauth_access_tokens` VALUES ('18ddf112dd7cda8cd8f73832ab384b1f271a4eefa3c40570d7a5e644d5f8fe8139f6c82074c1bb7f', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:44:36', '2019-10-11 03:44:36', '2020-10-11 03:44:36');
INSERT INTO `oauth_access_tokens` VALUES ('1c75657a6ab9eb051799a3affc4b51a65812ea28a785a84cfa1d453b61e13f5ae436f26f7ba680c9', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:27:03', '2019-10-11 03:27:03', '2020-10-11 03:27:03');
INSERT INTO `oauth_access_tokens` VALUES ('1c77645403c9b185af3e6051b20b208bba15da6854f406b76cce08ec4f5ef5f341a6d7472056c491', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 02:56:16', '2019-10-11 02:56:16', '2020-10-11 02:56:16');
INSERT INTO `oauth_access_tokens` VALUES ('3f980581e9d3dfaf27c181d8bd18fcdfd6e6ff390bfbe1b8df0a1aa7cd57ba72943dea4201ec046f', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:19:30', '2019-10-11 03:19:30', '2020-10-11 03:19:30');
INSERT INTO `oauth_access_tokens` VALUES ('417b3d5584dc04b20a4468654fb35e13906de608a613cb17973274d87c3eb131bd34c5b865467c16', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:57:01', '2019-10-11 03:57:01', '2020-10-11 03:57:01');
INSERT INTO `oauth_access_tokens` VALUES ('482b7c74460e6e09d586605db0ef71f4b0e35e76077f5379921810e8e80d3bb7829653ab093aa52b', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:00:50', '2019-10-11 03:00:50', '2020-10-11 03:00:50');
INSERT INTO `oauth_access_tokens` VALUES ('4f0ba05cf37604cadf6d83fcc8fee4adc9224cc9ad4e49e61458451dcbc22bc1323c2c22ea01964f', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:45:33', '2019-10-11 03:45:33', '2020-10-11 03:45:33');
INSERT INTO `oauth_access_tokens` VALUES ('680af85a3538889a6d6fb06e5d8c1c665702521e5a12bad090b1f6ded21dcf4f4cc5100d7b976e0c', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 02:57:32', '2019-10-11 02:57:32', '2020-10-11 02:57:32');
INSERT INTO `oauth_access_tokens` VALUES ('7917ab55b6c1f0d31e4fb1e1fcf315f75d335f5445eb27d14b4e8b24b719da9af97fed8e3677e443', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:22:27', '2019-10-11 03:22:27', '2020-10-11 03:22:27');
INSERT INTO `oauth_access_tokens` VALUES ('8918740c0dc5fc1a2fd8ab85552b190e799cc378953e5522ec18aeaab8c416b9ca76680914d18131', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:46:16', '2019-10-11 03:46:16', '2020-10-11 03:46:16');
INSERT INTO `oauth_access_tokens` VALUES ('920e20c6e0edefb05d257d3c52243e2afb871a9f34d4e75fbda4fc525a8075a0468aa7e8aba8dc02', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:01:22', '2019-10-11 03:01:22', '2020-10-11 03:01:22');
INSERT INTO `oauth_access_tokens` VALUES ('977289c8ec229f2a142dc7c24dbb030c82e25fc911fdc1914cd5ca50ee0bc7d6b7300e0365d47121', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 02:53:28', '2019-10-11 02:53:28', '2020-10-11 02:53:28');
INSERT INTO `oauth_access_tokens` VALUES ('9c803bc481a7b08f3cf838913a1a052c8b482982bee524c6bfd09ef1d8f544b83f44e4a90022c54f', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:18:36', '2019-10-11 03:18:36', '2020-10-11 03:18:36');
INSERT INTO `oauth_access_tokens` VALUES ('9d3ea0615a0c68b5734401948e5bc41e39ce9ff7b4644f136efc5e8318853be12aaf547906592015', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 02:50:25', '2019-10-11 02:50:25', '2020-10-11 02:50:25');
INSERT INTO `oauth_access_tokens` VALUES ('9fd641db66a76b9a2907f0c965ead14ef8236139232b7c49406d92af34df7006bc08970193ac3171', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 09:17:05', '2019-10-11 09:17:05', '2020-10-11 09:17:05');
INSERT INTO `oauth_access_tokens` VALUES ('ad9ee5c0ea61f5b71096d43f39087b0648a76102d2411a9a622a2d877c42d5e81df43979803ac606', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 04:05:34', '2019-10-11 04:05:34', '2020-10-11 04:05:34');
INSERT INTO `oauth_access_tokens` VALUES ('b0248aac6875bb3bc153b1d614ddacd0c07c6eb1e924cf88e3d7cb51fcec4675efb6e88e28c76b6a', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:15:27', '2019-10-11 03:15:27', '2020-10-11 03:15:27');
INSERT INTO `oauth_access_tokens` VALUES ('bd0c09f1d08db1491e37c8134322318c41d832fb604755aca5eaab2f7271bae74bfab5931cda256f', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:23:40', '2019-10-11 03:23:40', '2020-10-11 03:23:40');
INSERT INTO `oauth_access_tokens` VALUES ('bdb84e9e145212af83ad34fd04d17f37ca07e8f05893774178027320a1294680f552c40f5745c6a1', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:58:40', '2019-10-11 03:58:40', '2020-10-11 03:58:40');
INSERT INTO `oauth_access_tokens` VALUES ('beaf6ce734198b590d760dbc943d5234b8c858e9d7060ce4b47bfd2aa20493a0d61599d62b2ae4b5', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 02:46:44', '2019-10-11 02:46:44', '2020-10-11 02:46:44');
INSERT INTO `oauth_access_tokens` VALUES ('cb569210e8379be9dc0734d5538ffdee7d527e0db672fccd98a7db78396fcb984b44ecb977abf383', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:45:20', '2019-10-11 03:45:20', '2020-10-11 03:45:20');
INSERT INTO `oauth_access_tokens` VALUES ('cf966f90fa878b5e39dd31abccba800ae173a6917f1c03e2cbc756c99d630f17eaea2dc75daafd49', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:26:50', '2019-10-11 03:26:50', '2020-10-11 03:26:50');
INSERT INTO `oauth_access_tokens` VALUES ('d973b2476fbdbf94f193610761a2a0508f2da29b8e732c3367d290426edf367b9ad39a2cf695a50b', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:51:31', '2019-10-11 03:51:31', '2020-10-11 03:51:31');
INSERT INTO `oauth_access_tokens` VALUES ('e2827744a07650d4d02a463b98dba317e0e6fb306481a9730ec2f9c8743bb7c33df1e828b89ef766', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 02:50:57', '2019-10-11 02:50:57', '2020-10-11 02:50:57');
INSERT INTO `oauth_access_tokens` VALUES ('e594b81d28802bacc056a9e4074ac33d4e8a65999695052ff18abe2c374aa8daa9fc5e1642da7765', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:58:19', '2019-10-11 03:58:19', '2020-10-11 03:58:19');
INSERT INTO `oauth_access_tokens` VALUES ('e83d93a05839ccedaaa3b090c58e0f80bae1feebafd2a6bf04c073ed533cca6485b62a1a206ff63e', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 02:59:47', '2019-10-11 02:59:47', '2020-10-11 02:59:47');
INSERT INTO `oauth_access_tokens` VALUES ('fa968452d8e46c96d36b1753914711f16aa61688029a4265f6e570eb2f003c09305b17d550cfa395', 1, 1, 'Login Success:email-password', '[]', 0, '2019-10-11 03:57:27', '2019-10-11 03:57:27', '2020-10-11 03:57:27');
COMMIT;

-- ----------------------------
-- Table structure for oauth_auth_codes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of oauth_clients
-- ----------------------------
BEGIN;
INSERT INTO `oauth_clients` VALUES (1, NULL, 'Laravel Personal Access Client', '70mWSxJzIVzDxYsBWVyyjvfa9WqUDfKoBOBoJovx', 'http://localhost', 1, 0, 0, '2019-07-15 10:16:16', '2019-07-15 10:16:16');
INSERT INTO `oauth_clients` VALUES (2, NULL, 'Laravel Password Grant Client', 'lpaoZIVrJz2NskFI8tVzRSNTlBkso9VTnTVtmvmH', 'http://localhost', 0, 1, 0, '2019-07-15 10:16:16', '2019-07-15 10:16:16');
COMMIT;

-- ----------------------------
-- Table structure for oauth_personal_access_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of oauth_personal_access_clients
-- ----------------------------
BEGIN;
INSERT INTO `oauth_personal_access_clients` VALUES (1, 1, '2019-07-15 10:16:16', '2019-07-15 10:16:16');
COMMIT;

-- ----------------------------
-- Table structure for oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for service_charge
-- ----------------------------
DROP TABLE IF EXISTS `service_charge`;
CREATE TABLE `service_charge` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `consulation_id` int(11) NOT NULL,
  `accout_id` int(11) NOT NULL,
  `bank_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opening_bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 'admin', 'vicky@xoncology.com', '$2a$10$WzJ7sAUF0R91Wb0dp8x9eeI8wfh6ssu4E5ZjgUtTMsn8Nwbd9YYQO', NULL, '2019-10-08 16:18:14', '2019-10-08 16:18:14');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
