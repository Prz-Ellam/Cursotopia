DELIMITER $$
DROP PROCEDURE IF EXISTS `video_create` $$
CREATE PROCEDURE `video_create`(
    IN  `_video_name`                   VARCHAR(255),
    IN  `_video_duration`               TIME,
    IN  `_video_content_type`           VARCHAR(30),
    IN  `_video_address`                VARCHAR(255),
    OUT `_video_id`                     INT
)
BEGIN
    INSERT INTO `videos`(
        `video_name`,
        `video_duration`,
        `video_content_type`,
        `video_address`
    )
    VALUES(
        `_video_name`,
        `_video_duration`,
        `_video_content_type`,
        `_video_address`
    );
    SET `_video_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `video_update` $$
CREATE PROCEDURE `video_update`(
    IN `_video_id`                     INT,
    IN `_video_name`                   VARCHAR(255),
    IN `_video_duration`               TIME,
    IN `_video_content_type`           VARCHAR(30),
    IN `_video_address`                VARCHAR(255),
    IN `_video_created_at`             TIMESTAMP,
    IN `_video_modified_at`            TIMESTAMP,
    IN `_video_active`                 BOOLEAN
)
BEGIN
    UPDATE
        `videos`
    SET
        `video_name`                    = IFNULL(`_video_name`, `video_name`),
        `video_duration`                = IFNULL(`_video_duration`, `video_duration`),
        `video_content_type`            = IFNULL(`_video_content_type`, `video_content_type`),
        `video_address`                 = IFNULL(`_video_address`, `video_address`),
        `video_created_at`              = IFNULL(`_video_created_at`, `video_created_at`),
        `video_modified_at`             = IFNULL(`_video_modified_at`, NOW()),
        `video_active`                  = IFNULL(`_video_active`, `video_active`)
    WHERE
        `video_id` = `_video_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `video_find_by_id` $$
CREATE PROCEDURE `video_find_by_id`(
    IN _video_id                INT
)
BEGIN
    SELECT
        `video_id` AS `id`,
        `video_name` AS `name`,
        `video_duration` AS `duration`,
        `video_content_type` AS `contentType`,
        `video_address` AS `address`,
        `video_created_at` AS `createdAt`,
        `video_modified_at` AS `modifiedAt`,
        `video_active` AS `active`
    FROM
        `videos`
    WHERE
        `video_id` = _video_id
    LIMIT
        1;
END $$
DELIMITER ;
