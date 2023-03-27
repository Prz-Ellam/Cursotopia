DELIMITER $$
DROP PROCEDURE IF EXISTS `insert_user`;
CREATE PROCEDURE IF NOT EXISTS `insert_user`(
    IN  `_user_name`                VARCHAR(50),
    IN  `_user_last_name`           VARCHAR(50),
    IN  `_user_birth_date`          DATE,
    IN  `_user_gender`              ENUM('Masculino', 'Femenino', 'Otro'),
    IN  `_user_email`               VARCHAR(255),
    IN  `_user_password`            VARCHAR(255),
    IN  `_user_role`                INT,
    IN  `_profile_picture`          INT,
    OUT `_user_id`                  INT
)
BEGIN
    INSERT INTO users(
        `user_name`, 
        `user_last_name`, 
        `user_birth_date`,
        `user_gender`,
        `user_email`,
        `user_password`,
        `user_role`,
        `profile_picture`
    ) 
    VALUES(
        `_user_name`,
        `_user_last_name`,
        `_user_birth_date`,
        `_user_gender`,
        `_user_email`,
        `_user_password`,
        `_user_role`,
        `_profile_picture`
    );
    SET `_user_id` = LAST_INSERT_ID();
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `update_user`;
CREATE PROCEDURE IF NOT EXISTS `update_user`(
    `_user_id`                      INT,
    `_user_name`                    VARCHAR(50),
    `_user_last_name`               VARCHAR(50),
    `_user_birth_date`              DATE,
    `_user_gender`                  ENUM('Masculino', 'Femenino', 'Otro'),
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
        `user_name`                     = IFNULL(`_user_name`, `user_name`),
        `user_last_name`                = IFNULL(`_user_last_name`, `user_last_name`),
        `user_birth_date`               = IFNULL(`_user_birth_date`, `user_birth_date`),
        `user_gender`                   = IFNULL(`_user_gender`, `user_gender`),
        `user_email`                    = IFNULL(`_user_email`, `user_email`),
        `user_password`                 = IFNULL(`_user_password`, `user_password`),
        `user_role`                     = IFNULL(`_user_role`, `user_role`),
        `profile_picture`               = IFNULL(`_profile_picture`, `profile_picture`),
        `user_enabled`                  = IFNULL(`_user_enabled`, `user_enabled`),
        `user_created_at`               = IFNULL(`_user_created_at`, `user_created_at`),
        `user_modified_at`              = IFNULL(`_user_modified_at`, NOW()),
        `user_active`                   = IFNULL(`_user_active`, `user_active`)
    WHERE
        `user_id` = `_user_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `find_users`;
CREATE PROCEDURE IF NOT EXISTS `find_users`(
    IN `_user_id`                       INT,
    IN `_user_id_op`                    ENUM('=', '<>'),
    IN `_user_email`                    VARCHAR(255),
    IN `_user_email_op`                 ENUM('=', '<>')
)
BEGIN
    SELECT 
        `user_id`,
        `user_name`,
        `user_last_name`,
        `user_birth_date`,
        `user_gender`,
        `user_email`,
        `user_password`,
        `user_role`,
        `profile_picture`,
        `user_enabled`,
        `user_created_at`,
        `user_modified_at`,
        `user_active`
    FROM 
        `users`
    WHERE
        (
            `_user_id_op` IS NULL 
            OR (`_user_id_op` = '=' AND `user_id` = `_user_id`) 
            OR (`_user_id_op` = '<>' AND `user_id` <> `_user_id`)
        )
        AND 
        (
            `_user_email_op` IS NULL 
            OR (`_user_email_op` = '=' AND `user_email` = `_user_email`) 
            OR (`_user_email_op` = '<>' AND `user_email` <> `_user_email`)
        );
END $$
DELIMITER ;





