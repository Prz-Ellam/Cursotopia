DELIMITER $$
DROP PROCEDURE IF EXISTS `update_image`;
CREATE PROCEDURE IF NOT EXISTS `update_image`(
    `_image_id`                     INT,
    `_image_name`                   VARCHAR(255),
    `_image_size`                   BIGINT,
    `_image_content_type`           VARCHAR(30),
    `_image_data`                   MEDIUMBLOB,
    `_image_created_at`             TIMESTAMP,
    `_image_modified_at`            TIMESTAMP,
    `_image_active`                 BOOLEAN,
)
BEGIN
    UPDATE
        `users`
    SET
        `image_id`                      = IFNULL(`_image_id`, `image_id`),
        `image_name`                    = IFNULL(`_image_name`, `image_name`),
        `image_size`                    = IFNULL(`_image_size`, `image_size`),
        `image_content_type`            = IFNULL(`_image_content_type`, `image_content_type`),
        `image_data`                    = IFNULL(`_image_data`, `image_data`),
        `image_created_at`              = IFNULL(`_image_created_at`, `image_created_at`),
        `image_modified_at`             = IFNULL(`_image_modified_at`, `image_modified_at`),
        `image_active`                  = IFNULL(`_image_active`, `image_active`),
    WHERE
        `image_id` = `_image_id`;
END $$
DELIMITER ;