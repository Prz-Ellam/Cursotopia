DELIMITER $$
DROP PROCEDURE IF EXISTS `image_create` $$
CREATE PROCEDURE `image_create`(
    IN  `_image_name`                   VARCHAR(255),
    IN  `_image_size`                   INT,
    IN  `_image_content_type`           VARCHAR(30),
    IN  `_image_data`                   MEDIUMBLOB,
    OUT `_image_id`                     INT
)
BEGIN
    INSERT INTO `images`(
        `image_name`,
        `image_size`,
        `image_content_type`,
        `image_data`
    )
    VALUES(
        `_image_name`,
        `_image_size`,
        `_image_content_type`,
        `_image_data`
    );
    SET `_image_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `image_update` $$
CREATE PROCEDURE `image_update`(
    IN `_image_id`                     INT,
    IN `_image_name`                   VARCHAR(255),
    IN `_image_size`                   INT,
    IN `_image_content_type`           VARCHAR(30),
    IN `_image_data`                   MEDIUMBLOB,
    IN `_image_created_at`             TIMESTAMP,
    IN `_image_modified_at`            TIMESTAMP,
    IN `_image_active`                 BOOLEAN
)
BEGIN
    UPDATE
        `images`
    SET
        `image_name`                    = IFNULL(`_image_name`, `image_name`),
        `image_size`                    = IFNULL(`_image_size`, `image_size`),
        `image_content_type`            = IFNULL(`_image_content_type`, `image_content_type`),
        `image_data`                    = IFNULL(`_image_data`, `image_data`),
        `image_created_at`              = IFNULL(`_image_created_at`, `image_created_at`),
        `image_modified_at`             = IFNULL(`_image_modified_at`, NOW()),
        `image_active`                  = IFNULL(`_image_active`, `image_active`)
    WHERE
        `image_id` = `_image_id`;
END $$
DELIMITER ;



-- DELIMITER $$
-- DROP PROCEDURE IF EXISTS `image_find_one` $$
-- CREATE PROCEDURE `image_find_one`(
--     IN `_image_id`                      INT,
--     IN `_image_name`                    VARCHAR(255),
--     IN `_image_size`                    INT,
--     IN `_image_content_type`            VARCHAR(30),
--     IN `_image_data`                    MEDIUMBLOB,
--     IN `_image_created_at`              TIMESTAMP,
--     IN `_image_modified_at`             TIMESTAMP,
--     IN `_image_active`                  BOOLEAN
-- )
-- BEGIN
--     SELECT
--         `image_id` AS `id`,
--         `image_name` AS `name`,
--         `image_size` AS `size`,
--         `image_content_type` AS `contentType`,
--         `image_data` AS `data`,
--         `image_created_at` AS `createdAt`,
--         `image_modified_at` AS `modifiedAt`,
--         `image_active` AS `active`
--     FROM
--         `images`
--     WHERE
--         `image_id` = IFNULL(`_image_id`, `image_id`)
--         AND `image_name` = IFNULL(`_image_name`, `image_name`)
--         AND `image_size` = IFNULL(`_image_size`, `image_size`)
--         AND `image_content_type` = IFNULL(`_image_content_type`, `image_content_type`)
--         AND `image_data` = IFNULL(`_image_data`, `image_data`)
--         AND `image_created_at` = IFNULL(`_image_created_at`, `image_created_at`)
--         AND `image_modified_at` = IFNULL(`_image_modified_at`, `image_modified_at`)
--         AND `image_active` = IFNULL(`_image_active`, `image_active`)
--     LIMIT
--         1;
-- END $$
-- DELIMITER ;