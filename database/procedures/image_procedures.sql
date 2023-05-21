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
    IN `_image_id`                      INT,
    IN `_image_name`                    VARCHAR(255),
    IN `_image_size`                    INT,
    IN `_image_content_type`            VARCHAR(30),
    IN `_image_data`                    MEDIUMBLOB,
    IN `_image_created_at`              TIMESTAMP,
    IN `_image_modified_at`             TIMESTAMP,
    IN `_image_active`                  BOOLEAN
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
        `image_modified_at`             = NOW(),
        `image_active`                  = IFNULL(`_image_active`, `image_active`)
    WHERE
        `image_id` = `_image_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `image_find_by_id` $$
CREATE PROCEDURE `image_find_by_id`(
    IN `_image_id`                      INT
)
BEGIN
    SELECT
        `image_id`                      AS `id`,
        `image_name`                    AS `name`,
        `image_size`                    AS `size`,
        `image_content_type`            AS `contentType`,
        `image_data`                    AS `data`,
        `image_created_at`              AS `createdAt`,
        `image_modified_at`             AS `modifiedAt`,
        `image_active`                  AS `active`
    FROM
        `images`
    WHERE
        `image_id` = `_image_id`
        AND `image_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `image_find_one_profile_picture` $$
CREATE PROCEDURE `image_find_one_profile_picture`(
    IN `_image_id`                      INT
)
BEGIN
    SELECT
        i.`image_id`                    AS `id`,
        i.`image_name`                  AS `name`,
        i.`image_size`                  AS `size`,
        i.`image_content_type`          AS `contentType`,
        i.`image_data`                  AS `data`,
        i.`image_created_at`            AS `createdAt`,
        i.`image_modified_at`           AS `modifiedAt`,
        i.`image_active`                AS `active`
    FROM
        `images` AS i
    INNER JOIN
        `users` AS u
    ON
        i.`image_id` = u.`profile_picture`
    WHERE
        i.`image_id` = `_image_id`
        AND i.`image_active` = TRUE;
END $$
DELIMITER ;
