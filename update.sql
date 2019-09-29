ALTER TABLE `clients_users`
    ADD COLUMN `rules_id`  int(11) NOT NULL DEFAULT 0 COMMENT '选择的策略' AFTER `id`;

ALTER TABLE `clients_users`
    ADD COLUMN `effect_at`  timestamp NULL ON UPDATE CURRENT_TIMESTAMP AFTER `status`;
