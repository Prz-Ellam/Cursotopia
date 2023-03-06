DELIMITER $$
DROP PROCEDURE IF EXISTS `update_user`;
CREATE PROCEDURE IF NOT EXISTS `update_user`(
    `_user_id`                      INT,
    `_user_name`                    VARCHAR(50),
    `_user_last_name`               VARCHAR(50),
    `_user_birth_date`              DATE,
    `_user_gender`                  INT,
    `_user_email`                   VARCHAR(255),
    `_user_password`                VARCHAR(255),
    `_user_role`                    INT,
    `_profile_picture`              INT,
    `_user_enabled`                 BOOLEAN,
    `_user_created_at`              TIMESTAMP,
    `_user_modified_at`             TIMESTAMP,
    `_user_active`                  BOOLEAN
)
BEGIN
    UPDATE
        `users`
    SET
        `user_id`                       = IFNULL(`_user_id`, `user_id`),
        `user_name`                     = IFNULL(`_user_id`, `user_name`),
        `user_last_name`                = IFNULL(`_user_id`, `user_last_name`),
        `user_birth_date`               = IFNULL(`_user_id`, `user_birth_date`),
        `user_gender`                   = IFNULL(`_user_id`, `user_gender`),
        `user_email`                    = IFNULL(`_user_id`, `user_email`),
        `user_password`                 = IFNULL(`_user_id`, `user_password`),
        `user_role`                     = IFNULL(`_user_id`, `user_role`),
        `profile_picture`               = IFNULL(`_user_id`, `profile_picture`),
        `user_enabled`                  = IFNULL(`_user_id`, `user_enabled`),
        `user_created_at`               = IFNULL(`_user_id`, `user_created_at`),
        `user_modified_at`              = IFNULL(`_user_id`, `user_modified_at`),
        `user_active`                   = IFNULL(`_user_id`, `user_active`)
    WHERE
        `user_id` = `_user_id`;
END $$
DELIMITER ;

