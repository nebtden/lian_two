ALTER TABLE `lian2`.`clients` 
CHANGE COLUMN `is_rule_stoped` `is_rule_stopped` tinyint(1) NOT NULL DEFAULT 0 AFTER `user_id`


ALTER TABLE `lian2`.`users`
ADD COLUMN `admin_user_id` int(11) NOT NULL DEFAULT 0 AFTER `status`;
UPDATE `lian2`.`admin_menu` SET `icon` = 'fa-plus-square' WHERE `id` = 11;

CREATE TABLE `users_result_analyses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `old_status` tinyint(1) NOT NULL DEFAULT 0,
  `new_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间，也即派发时间',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users_time_analyses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `old_status` tinyint(1) NOT NULL DEFAULT 0,
  `new_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间，也即派发时间',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `lian2`.`clients_users`
ADD COLUMN `complain_remark` varchar(255) NULL COMMENT '销售说明' AFTER `remark`;
