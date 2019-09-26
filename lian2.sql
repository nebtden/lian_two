/*
 Navicat MySQL Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MariaDB
 Source Server Version : 100207
 Source Host           : localhost:3306
 Source Schema         : lian2

 Target Server Type    : MariaDB
 Target Server Version : 100207
 File Encoding         : 65001

 Date: 27/09/2019 00:00:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `permission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES (1, 0, 1, 'Dashboard', 'fa-bar-chart', '/', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (2, 0, 2, 'Admin', 'fa-tasks', '', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (3, 2, 3, 'Users', 'fa-users', 'auth/users', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (8, 0, 8, '客户管理', 'fa-user', 'clients', NULL, '2019-07-24 03:44:46', '2019-07-24 03:44:46');
INSERT INTO `admin_menu` VALUES (10, 0, 10, '销售管理', 'fa-blind', 'users', NULL, '2019-07-24 03:44:46', '2019-07-24 03:44:46');
INSERT INTO `admin_menu` VALUES (11, 0, 11, '设置', 'fa-server', 'setting', NULL, '2019-07-24 03:44:46', '2019-07-24 03:44:46');

-- ----------------------------
-- Table structure for admin_menu_copy1
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu_copy1`;
CREATE TABLE `admin_menu_copy1`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `permission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_menu_copy1
-- ----------------------------
INSERT INTO `admin_menu_copy1` VALUES (1, 0, 1, 'Dashboard', 'fa-bar-chart', '/', NULL, NULL, NULL);
INSERT INTO `admin_menu_copy1` VALUES (2, 0, 2, 'Admin', 'fa-tasks', '', NULL, NULL, NULL);
INSERT INTO `admin_menu_copy1` VALUES (3, 2, 3, 'Users', 'fa-users', 'auth/users', NULL, NULL, NULL);
INSERT INTO `admin_menu_copy1` VALUES (4, 2, 4, 'Roles', 'fa-user', 'auth/roles', NULL, NULL, NULL);
INSERT INTO `admin_menu_copy1` VALUES (5, 2, 5, 'Permission', 'fa-ban', 'auth/permissions', NULL, NULL, NULL);
INSERT INTO `admin_menu_copy1` VALUES (6, 2, 6, 'Menu', 'fa-bars', 'auth/menu', NULL, NULL, NULL);
INSERT INTO `admin_menu_copy1` VALUES (7, 2, 7, 'Operation log', 'fa-history', 'auth/logs', NULL, NULL, NULL);
INSERT INTO `admin_menu_copy1` VALUES (8, 0, 8, '客户管理', 'fa-user', 'clients', NULL, '2019-07-24 03:44:46', '2019-07-24 03:44:46');
INSERT INTO `admin_menu_copy1` VALUES (10, 0, 10, '销售管理', 'fa-blind', 'users', NULL, '2019-07-24 03:44:46', '2019-07-24 03:44:46');
INSERT INTO `admin_menu_copy1` VALUES (11, 0, 11, '设置', 'fa-server', 'setting', NULL, '2019-07-24 03:44:46', '2019-07-24 03:44:46');

-- ----------------------------
-- Table structure for admin_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_operation_log`;
CREATE TABLE `admin_operation_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_operation_log_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 111 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_operation_log
-- ----------------------------
INSERT INTO `admin_operation_log` VALUES (1, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-20 14:13:11', '2019-09-20 14:13:11');
INSERT INTO `admin_operation_log` VALUES (2, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-20 15:10:13', '2019-09-20 15:10:13');
INSERT INTO `admin_operation_log` VALUES (3, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-20 15:10:20', '2019-09-20 15:10:20');
INSERT INTO `admin_operation_log` VALUES (4, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-22 15:16:13', '2019-09-22 15:16:13');
INSERT INTO `admin_operation_log` VALUES (5, 1, 'admin', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-22 15:16:31', '2019-09-22 15:16:31');
INSERT INTO `admin_operation_log` VALUES (6, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-22 15:18:10', '2019-09-22 15:18:10');
INSERT INTO `admin_operation_log` VALUES (7, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-22 15:18:14', '2019-09-22 15:18:14');
INSERT INTO `admin_operation_log` VALUES (8, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-22 15:19:30', '2019-09-22 15:19:30');
INSERT INTO `admin_operation_log` VALUES (9, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-22 15:24:50', '2019-09-22 15:24:50');
INSERT INTO `admin_operation_log` VALUES (10, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-22 15:25:01', '2019-09-22 15:25:01');
INSERT INTO `admin_operation_log` VALUES (11, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-22 15:25:17', '2019-09-22 15:25:17');
INSERT INTO `admin_operation_log` VALUES (12, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-22 15:25:27', '2019-09-22 15:25:27');
INSERT INTO `admin_operation_log` VALUES (13, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-22 15:36:18', '2019-09-22 15:36:18');
INSERT INTO `admin_operation_log` VALUES (14, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-22 15:36:56', '2019-09-22 15:36:56');
INSERT INTO `admin_operation_log` VALUES (15, 1, 'admin/rules', 'GET', '127.0.0.1', '[]', '2019-09-22 15:54:37', '2019-09-22 15:54:37');
INSERT INTO `admin_operation_log` VALUES (16, 1, 'admin/rules', 'GET', '127.0.0.1', '[]', '2019-09-22 15:55:22', '2019-09-22 15:55:22');
INSERT INTO `admin_operation_log` VALUES (17, 1, 'admin/rules', 'GET', '127.0.0.1', '[]', '2019-09-23 01:04:57', '2019-09-23 01:04:57');
INSERT INTO `admin_operation_log` VALUES (18, 1, 'admin/rules/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-23 01:05:00', '2019-09-23 01:05:00');
INSERT INTO `admin_operation_log` VALUES (19, 1, 'admin/rules/create', 'GET', '127.0.0.1', '[]', '2019-09-23 01:05:59', '2019-09-23 01:05:59');
INSERT INTO `admin_operation_log` VALUES (20, 1, 'admin/rules/create', 'GET', '127.0.0.1', '[]', '2019-09-23 01:06:21', '2019-09-23 01:06:21');
INSERT INTO `admin_operation_log` VALUES (21, 1, 'admin/rules/create', 'GET', '127.0.0.1', '[]', '2019-09-23 01:06:57', '2019-09-23 01:06:57');
INSERT INTO `admin_operation_log` VALUES (22, 1, 'admin/rules/create', 'GET', '127.0.0.1', '[]', '2019-09-23 01:07:32', '2019-09-23 01:07:32');
INSERT INTO `admin_operation_log` VALUES (23, 1, 'admin/rules', 'POST', '127.0.0.1', '{\"name\":\"test\",\"_token\":\"TDEukD74qIwfsymggDDj61hLfLzdOtFkf1MQp30s\"}', '2019-09-23 01:07:37', '2019-09-23 01:07:37');
INSERT INTO `admin_operation_log` VALUES (24, 1, 'admin/rules', 'GET', '127.0.0.1', '[]', '2019-09-23 01:07:38', '2019-09-23 01:07:38');
INSERT INTO `admin_operation_log` VALUES (25, 1, 'admin/rules/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-23 01:07:46', '2019-09-23 01:07:46');
INSERT INTO `admin_operation_log` VALUES (26, 1, 'admin/rules/1/edit', 'GET', '127.0.0.1', '[]', '2019-09-23 06:22:17', '2019-09-23 06:22:17');
INSERT INTO `admin_operation_log` VALUES (27, 1, 'admin/rules/1/edit', 'GET', '127.0.0.1', '[]', '2019-09-23 06:22:53', '2019-09-23 06:22:53');
INSERT INTO `admin_operation_log` VALUES (28, 1, 'admin/rules/1', 'PUT', '127.0.0.1', '{\"name\":\"test\",\"detail\":{\"new_1\":{\"title\":\"1\",\"time_last\":\"1\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"x4gclSd9nRvIe1RcMRAYR0nNlJYPJlHZlSEzAr9G\",\"_method\":\"PUT\"}', '2019-09-23 06:23:04', '2019-09-23 06:23:04');
INSERT INTO `admin_operation_log` VALUES (29, 1, 'admin/rules/1/edit', 'GET', '127.0.0.1', '[]', '2019-09-23 06:23:06', '2019-09-23 06:23:06');
INSERT INTO `admin_operation_log` VALUES (30, 1, 'admin/rules/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-23 06:23:18', '2019-09-23 06:23:18');
INSERT INTO `admin_operation_log` VALUES (31, 1, 'admin/rules/1/edit', 'GET', '127.0.0.1', '[]', '2019-09-23 06:23:21', '2019-09-23 06:23:21');
INSERT INTO `admin_operation_log` VALUES (32, 1, 'admin/rules/1', 'PUT', '127.0.0.1', '{\"name\":\"test\",\"detail\":{\"new_1\":{\"time_last\":\"1\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"x4gclSd9nRvIe1RcMRAYR0nNlJYPJlHZlSEzAr9G\",\"_method\":\"PUT\"}', '2019-09-23 06:23:27', '2019-09-23 06:23:27');
INSERT INTO `admin_operation_log` VALUES (33, 1, 'admin/rules/1/edit', 'GET', '127.0.0.1', '[]', '2019-09-23 06:23:30', '2019-09-23 06:23:30');
INSERT INTO `admin_operation_log` VALUES (34, 1, 'admin/rules/1/edit', 'GET', '127.0.0.1', '[]', '2019-09-23 06:26:59', '2019-09-23 06:26:59');
INSERT INTO `admin_operation_log` VALUES (35, 1, 'admin/rules/1', 'PUT', '127.0.0.1', '{\"name\":\"test\",\"detail\":{\"new_1\":{\"time_last\":\"1\",\"index\":\"1\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"x4gclSd9nRvIe1RcMRAYR0nNlJYPJlHZlSEzAr9G\",\"_method\":\"PUT\"}', '2019-09-23 06:27:04', '2019-09-23 06:27:04');
INSERT INTO `admin_operation_log` VALUES (36, 1, 'admin/rules', 'GET', '127.0.0.1', '[]', '2019-09-23 06:27:05', '2019-09-23 06:27:05');
INSERT INTO `admin_operation_log` VALUES (37, 1, 'admin/rules/1', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-23 06:27:09', '2019-09-23 06:27:09');
INSERT INTO `admin_operation_log` VALUES (38, 1, 'admin/rules', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-23 06:27:16', '2019-09-23 06:27:16');
INSERT INTO `admin_operation_log` VALUES (39, 1, 'admin/rules/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-23 06:27:20', '2019-09-23 06:27:20');
INSERT INTO `admin_operation_log` VALUES (40, 1, 'admin/rules/1/edit', 'GET', '127.0.0.1', '[]', '2019-09-23 06:32:19', '2019-09-23 06:32:19');
INSERT INTO `admin_operation_log` VALUES (41, 1, 'admin/rules', 'GET', '127.0.0.1', '[]', '2019-09-23 06:32:57', '2019-09-23 06:32:57');
INSERT INTO `admin_operation_log` VALUES (42, 1, 'admin/rules/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-23 06:33:00', '2019-09-23 06:33:00');
INSERT INTO `admin_operation_log` VALUES (43, 1, 'admin/rules', 'POST', '127.0.0.1', '{\"name\":\"test2\",\"detail\":{\"new_1\":{\"time_last\":\"2\",\"index\":\"1\",\"user_id\":\"86\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"x4gclSd9nRvIe1RcMRAYR0nNlJYPJlHZlSEzAr9G\",\"_previous_\":\"http:\\/\\/test.lian2.com\\/admin\\/rules\\/\"}', '2019-09-23 06:33:10', '2019-09-23 06:33:10');
INSERT INTO `admin_operation_log` VALUES (44, 1, 'admin/rules', 'GET', '127.0.0.1', '[]', '2019-09-23 06:33:12', '2019-09-23 06:33:12');
INSERT INTO `admin_operation_log` VALUES (45, 1, 'admin/rules/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-23 06:33:57', '2019-09-23 06:33:57');
INSERT INTO `admin_operation_log` VALUES (46, 1, 'admin/rules/2', 'PUT', '127.0.0.1', '{\"name\":\"test2\",\"detail\":{\"new_1\":{\"time_last\":\"1\",\"index\":\"1\",\"user_id\":\"86\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"x4gclSd9nRvIe1RcMRAYR0nNlJYPJlHZlSEzAr9G\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/test.lian2.com\\/admin\\/rules\\/\"}', '2019-09-23 06:34:04', '2019-09-23 06:34:04');
INSERT INTO `admin_operation_log` VALUES (47, 1, 'admin/rules', 'GET', '127.0.0.1', '[]', '2019-09-23 06:34:05', '2019-09-23 06:34:05');
INSERT INTO `admin_operation_log` VALUES (48, 1, 'admin/rules', 'GET', '127.0.0.1', '[]', '2019-09-23 06:36:25', '2019-09-23 06:36:25');
INSERT INTO `admin_operation_log` VALUES (49, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-23 14:42:12', '2019-09-23 14:42:12');
INSERT INTO `admin_operation_log` VALUES (50, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 14:42:23', '2019-09-23 14:42:23');
INSERT INTO `admin_operation_log` VALUES (51, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 14:44:15', '2019-09-23 14:44:15');
INSERT INTO `admin_operation_log` VALUES (52, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 15:22:17', '2019-09-23 15:22:17');
INSERT INTO `admin_operation_log` VALUES (53, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 15:24:17', '2019-09-23 15:24:17');
INSERT INTO `admin_operation_log` VALUES (54, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 15:24:35', '2019-09-23 15:24:35');
INSERT INTO `admin_operation_log` VALUES (55, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 15:25:16', '2019-09-23 15:25:16');
INSERT INTO `admin_operation_log` VALUES (56, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 15:26:48', '2019-09-23 15:26:48');
INSERT INTO `admin_operation_log` VALUES (57, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 15:30:41', '2019-09-23 15:30:41');
INSERT INTO `admin_operation_log` VALUES (58, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 15:31:51', '2019-09-23 15:31:51');
INSERT INTO `admin_operation_log` VALUES (59, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 15:33:08', '2019-09-23 15:33:08');
INSERT INTO `admin_operation_log` VALUES (60, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-23 15:33:33', '2019-09-23 15:33:33');
INSERT INTO `admin_operation_log` VALUES (61, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-24 14:17:07', '2019-09-24 14:17:07');
INSERT INTO `admin_operation_log` VALUES (62, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-24 14:17:35', '2019-09-24 14:17:35');
INSERT INTO `admin_operation_log` VALUES (63, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-24 14:17:38', '2019-09-24 14:17:38');
INSERT INTO `admin_operation_log` VALUES (64, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-24 14:20:41', '2019-09-24 14:20:41');
INSERT INTO `admin_operation_log` VALUES (65, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-24 14:21:01', '2019-09-24 14:21:01');
INSERT INTO `admin_operation_log` VALUES (66, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-24 14:21:23', '2019-09-24 14:21:23');
INSERT INTO `admin_operation_log` VALUES (67, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-24 14:21:36', '2019-09-24 14:21:36');
INSERT INTO `admin_operation_log` VALUES (68, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"1\",\"_pjax\":\"#pjax-container\"}', '2019-09-24 14:21:41', '2019-09-24 14:21:41');
INSERT INTO `admin_operation_log` VALUES (69, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"1\"}', '2019-09-24 14:21:42', '2019-09-24 14:21:42');
INSERT INTO `admin_operation_log` VALUES (70, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-24 14:22:03', '2019-09-24 14:22:03');
INSERT INTO `admin_operation_log` VALUES (71, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-24 14:26:05', '2019-09-24 14:26:05');
INSERT INTO `admin_operation_log` VALUES (72, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"1\"}', '2019-09-24 14:26:10', '2019-09-24 14:26:10');
INSERT INTO `admin_operation_log` VALUES (73, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"1\"}', '2019-09-24 14:26:23', '2019-09-24 14:26:23');
INSERT INTO `admin_operation_log` VALUES (74, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-24 14:26:27', '2019-09-24 14:26:27');
INSERT INTO `admin_operation_log` VALUES (75, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-24 14:26:48', '2019-09-24 14:26:48');
INSERT INTO `admin_operation_log` VALUES (76, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-24 14:26:57', '2019-09-24 14:26:57');
INSERT INTO `admin_operation_log` VALUES (77, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-24 14:27:05', '2019-09-24 14:27:05');
INSERT INTO `admin_operation_log` VALUES (78, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-24 14:29:19', '2019-09-24 14:29:19');
INSERT INTO `admin_operation_log` VALUES (79, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-24 14:29:26', '2019-09-24 14:29:26');
INSERT INTO `admin_operation_log` VALUES (80, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"1\",\"_pjax\":\"#pjax-container\"}', '2019-09-24 14:32:57', '2019-09-24 14:32:57');
INSERT INTO `admin_operation_log` VALUES (81, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"1\"}', '2019-09-24 14:32:58', '2019-09-24 14:32:58');
INSERT INTO `admin_operation_log` VALUES (82, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\",\"_pjax\":\"#pjax-container\"}', '2019-09-24 14:33:04', '2019-09-24 14:33:04');
INSERT INTO `admin_operation_log` VALUES (83, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-24 14:33:05', '2019-09-24 14:33:05');
INSERT INTO `admin_operation_log` VALUES (84, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-24 14:33:13', '2019-09-24 14:33:13');
INSERT INTO `admin_operation_log` VALUES (85, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-24 14:33:15', '2019-09-24 14:33:15');
INSERT INTO `admin_operation_log` VALUES (86, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-24 14:35:38', '2019-09-24 14:35:38');
INSERT INTO `admin_operation_log` VALUES (87, 1, 'admin/clients-import/index', 'GET', '127.0.0.1', '[]', '2019-09-24 14:36:30', '2019-09-24 14:36:30');
INSERT INTO `admin_operation_log` VALUES (88, 1, 'admin/clients-import/index', 'GET', '127.0.0.1', '[]', '2019-09-24 14:37:09', '2019-09-24 14:37:09');
INSERT INTO `admin_operation_log` VALUES (89, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-24 14:37:57', '2019-09-24 14:37:57');
INSERT INTO `admin_operation_log` VALUES (90, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-24 14:38:02', '2019-09-24 14:38:02');
INSERT INTO `admin_operation_log` VALUES (91, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-24 14:38:03', '2019-09-24 14:38:03');
INSERT INTO `admin_operation_log` VALUES (92, 1, 'admin/clients-import/index', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2019-09-24 14:38:06', '2019-09-24 14:38:06');
INSERT INTO `admin_operation_log` VALUES (93, 1, 'admin', 'GET', '127.0.0.1', '[]', '2019-09-26 14:49:55', '2019-09-26 14:49:55');
INSERT INTO `admin_operation_log` VALUES (94, 1, 'admin/clients', 'GET', '127.0.0.1', '[]', '2019-09-26 15:09:59', '2019-09-26 15:09:59');
INSERT INTO `admin_operation_log` VALUES (95, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:10:36', '2019-09-26 15:10:36');
INSERT INTO `admin_operation_log` VALUES (96, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:10:49', '2019-09-26 15:10:49');
INSERT INTO `admin_operation_log` VALUES (97, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:12:06', '2019-09-26 15:12:06');
INSERT INTO `admin_operation_log` VALUES (98, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:28:33', '2019-09-26 15:28:33');
INSERT INTO `admin_operation_log` VALUES (99, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:29:16', '2019-09-26 15:29:16');
INSERT INTO `admin_operation_log` VALUES (100, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:29:31', '2019-09-26 15:29:31');
INSERT INTO `admin_operation_log` VALUES (101, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:31:39', '2019-09-26 15:31:39');
INSERT INTO `admin_operation_log` VALUES (102, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:32:08', '2019-09-26 15:32:08');
INSERT INTO `admin_operation_log` VALUES (103, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:32:22', '2019-09-26 15:32:22');
INSERT INTO `admin_operation_log` VALUES (104, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:33:40', '2019-09-26 15:33:40');
INSERT INTO `admin_operation_log` VALUES (105, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:34:42', '2019-09-26 15:34:42');
INSERT INTO `admin_operation_log` VALUES (106, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:35:35', '2019-09-26 15:35:35');
INSERT INTO `admin_operation_log` VALUES (107, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:36:24', '2019-09-26 15:36:24');
INSERT INTO `admin_operation_log` VALUES (108, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:36:34', '2019-09-26 15:36:34');
INSERT INTO `admin_operation_log` VALUES (109, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:36:47', '2019-09-26 15:36:47');
INSERT INTO `admin_operation_log` VALUES (110, 1, 'admin/clients', 'GET', '127.0.0.1', '{\"admin_user_id\":\"2\"}', '2019-09-26 15:36:59', '2019-09-26 15:36:59');

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `http_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_permissions_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `admin_permissions_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES (1, 'All permission', '*', '', '*', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu`  (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_menu_role_id_menu_id_index`(`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
INSERT INTO `admin_role_menu` VALUES (1, 2, NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions`  (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_permissions_role_id_permission_id_index`(`role_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
INSERT INTO `admin_role_permissions` VALUES (1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users`  (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_users_role_id_user_id_index`(`role_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
INSERT INTO `admin_role_users` VALUES (1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_roles_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `admin_roles_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES (1, 'Administrator', 'administrator', '2019-09-20 08:15:51', '2019-09-20 08:15:51');

-- ----------------------------
-- Table structure for admin_user_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE `admin_user_permissions`  (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_user_permissions_user_id_permission_id_index`(`user_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$4IHSUxbNgpdWCqvGHQVJmOOi/680vduoSBA.n9sU0F6W8SW6rVU2S', 'Administrator', NULL, 'xAHUPiY8VF831sYk3Yu7h3KvbworkxORgqkD9vyFBWSyCGp7JVyevIzUbh6S', '2019-09-20 08:15:51', '2019-09-20 08:15:51');
INSERT INTO `admin_users` VALUES (2, 'simon', '$2y$10$4IHSUxbNgpdWCqvGHQVJmOOi/680vduoSBA.n9sU0F6W8SW6rVU2S', 'Administrator', NULL, 'xAHUPiY8VF831sYk3Yu7h3KvbworkxORgqkD9vyFBWSyCGp7JVyevIzUbh6S', '2019-09-20 08:15:51', '2019-09-20 08:15:51');

-- ----------------------------
-- Table structure for clients
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态，最终确定的状态',
  `sales_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0  未打电话  1 ',
  `admin_remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '管理员备注',
  `sales_remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '销售备注',
  `transfer_remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '财务备注',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注信息',
  `rule_id` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `is_rule_stoped` tinyint(1) NOT NULL DEFAULT 0,
  `admin_user_id` int(11) NOT NULL DEFAULT 0 COMMENT '指定的销售人员id',
  `upload_admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '提交的admin_user_id 无法更改',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `phone`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '客户，即需要买手机的' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of clients
-- ----------------------------
INSERT INTO `clients` VALUES (1, 'simon', '13365802535', 1, 0, NULL, NULL, NULL, NULL, 1, NULL, 0, 2, 0, NULL, NULL);

-- ----------------------------
-- Table structure for clients_users
-- ----------------------------
DROP TABLE IF EXISTS `clients_users`;
CREATE TABLE `clients_users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `accept_at` timestamp(0) NULL DEFAULT NULL COMMENT '点击接收时间',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间，也即派发时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of clients_users
-- ----------------------------
INSERT INTO `clients_users` VALUES (1, 1, 86, '2112', '2019-09-23 15:21:35', '1', '2019-09-23 15:21:35', '2019-09-26 14:56:17');
INSERT INTO `clients_users` VALUES (2, 1, 87, '2112', '2019-09-23 15:21:35', '1', '2019-09-23 15:21:35', '2019-09-26 14:56:17');

-- ----------------------------
-- Table structure for clients_users_logs
-- ----------------------------
DROP TABLE IF EXISTS `clients_users_logs`;
CREATE TABLE `clients_users_logs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `old_status` tinyint(1) NOT NULL DEFAULT 0,
  `new_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT '创建时间，也即派发时间',
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of clients_users_logs
-- ----------------------------
INSERT INTO `clients_users_logs` VALUES (1, 1, 86, 1, 1, '2019-09-23 15:21:35', '2019-09-26 14:56:17');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2016_01_04_173148_create_admin_tables', 1);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rules
-- ----------------------------
DROP TABLE IF EXISTS `rules`;
CREATE TABLE `rules`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rules
-- ----------------------------
INSERT INTO `rules` VALUES (1, 'test', '2019-09-23 01:07:37', '2019-09-23 01:07:37');
INSERT INTO `rules` VALUES (2, 'test2', '2019-09-23 06:33:10', '2019-09-23 06:33:10');

-- ----------------------------
-- Table structure for rules_detail
-- ----------------------------
DROP TABLE IF EXISTS `rules_detail`;
CREATE TABLE `rules_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_id` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `time_last` int(11) NULL DEFAULT NULL COMMENT '时间间隔，小时计算',
  `index` tinyint(1) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rules_detail
-- ----------------------------
INSERT INTO `rules_detail` VALUES (1, 1, 86, 1, 1, '2019-09-23 06:27:04', '2019-09-23 06:27:04');
INSERT INTO `rules_detail` VALUES (3, 2, 86, 1, 1, '2019-09-23 06:34:04', '2019-09-23 06:34:04');

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'home_text', '首页信息  你好！欢迎您的到来！', '首页配置', '2019-07-25 06:28:00');
INSERT INTO `settings` VALUES (2, 'send_email', '198700333@qq.com', '发件箱', '2019-07-26 09:19:52');
INSERT INTO `settings` VALUES (3, 'receiver_email', '198700333@qq.com', '收件箱', '2019-07-26 09:20:03');
INSERT INTO `settings` VALUES (5, 'email_host', 'smtp.qq.com', '1', NULL);
INSERT INTO `settings` VALUES (6, 'email_password', 'cahbwvgaewxbbhii', 'xqcibgvtxkvcbigb', NULL);
INSERT INTO `settings` VALUES (7, 'notice', '【】【跑滴滴，请来湖南租行天下网约车】【】湖南租行天下网约车，针对渠道商特给与介绍成功返还X元一台的佣金。\r\n湖南租行天下是整个行业龙头企业，规模，品牌成交率稳居行业首位，选择与我们合作，您佣金更快捷、公平公正、透明！\r\n感谢您的选择与信任！\r\n\r\n\r\n【】您好，您提交信息后，可再去注册登录后台，及可看到您所提交的客户信息状态！【】', '当渠道商没有注册的时候，使用这个', '2019-07-31 03:04:08');
INSERT INTO `settings` VALUES (8, 'notice_1', '尊敬的普通渠道商：您好!\r\n【直推：通过后台提交客户信息或分享客户二维码供客户自行提交信息。】\r\n直推成交=返佣金XXX元到您银行卡；', '普通经销商公告', '2019-07-25 07:19:07');
INSERT INTO `settings` VALUES (9, 'notice_2', '待客户如家人，感恩您的信任，如您有朋友需要加入公司，请在本后台提交数据，或将二维码发送给对方自行提交数据。\r\n成交后赠送X次保养给您！', '老客户', '2019-07-25 07:26:16');
INSERT INTO `settings` VALUES (10, 'notice_3', '尊敬的高级渠道商：您好!\r\n（仅高级渠道商具有分享二维码，邀请注册为普通渠道商的权限！）\r\n【直推：通过后台提交客户信息或分享客户二维码供客户自行提交信息。】\r\n【间推：您邀请的普通渠道商通过后台提交客户信息或分享客户二维码供客户自行提交信息。】\r\n直推成交=返佣金XXX元到您银行卡；\r\n间推成交=返佣金xx元到您银行卡', '高级经销商公告信息，可以发展下级', '2019-07-25 07:14:07');
INSERT INTO `settings` VALUES (11, 'notice_4', '各位外拓经理，持之以恒，坚持不懈，源源不断！\r\n【本月新增任务：10单，天道酬勤，加油！】', '外拓经理公告信息', '2019-08-17 12:11:14');
INSERT INTO `settings` VALUES (12, 'login_notice', '湖南租行天下网约车，是长沙网约车业务最大的网约车公司！本公司业务人员从业经验资深，成交率远高于行业平均水准，公司规模、品牌口碑、服务专业性稳居行业前茅！诚邀合作伙伴注册，推荐意向客户，合作共赢！【单月佣金政策仅针对公司已认证合作商有效，登录后台可见】', '登录公告信息', '2019-08-15 15:15:57');
INSERT INTO `settings` VALUES (13, 'register_notice', '欢迎注册为湖南租行天下合作商，推荐意向客户来本公司跑网约车，丰厚佣金等你来拿!【公司采取特邀认证形式，获得认证资格，方可认证通过】', '注册公告信息', '2019-08-15 15:14:34');
INSERT INTO `settings` VALUES (14, 'top_is_open', '1', '是否开启显示外拓经理，1开启，0不显示', '2019-08-14 15:07:32');
INSERT INTO `settings` VALUES (15, 'self_notice', '湖南租行天下，滴滴网约车龙头企业，加入我们公司，快速合法合规赚钱！【赶快提交您的信息吧，工作人员将会在最短时间内，给您详细解答】', '用于用户自助填写信息的时候，显示', '2019-08-15 15:54:16');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 88 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (86, '13365802535', '13365802535', '', '2019-09-21 22:19:18', '$2y$10$X6GX3CAVYtTlfFw5mi2Za..uJPGChJ6/gR/o10Ofqp1o9Hle4TNSG', 'fG7WiWn7diNGmQT3X19IiZsZ9PAWiqNRdbKCnQWZapDmXAQTZcmBqHHaiu6u', 1, NULL, '2019-09-21 22:19:24', '2019-09-21 22:19:28');
INSERT INTO `users` VALUES (87, '11', '11', '23', '2019-09-26 23:34:09', '1', '1', 1, NULL, '2019-09-26 23:34:21', '2019-09-26 23:34:23');

SET FOREIGN_KEY_CHECKS = 1;
