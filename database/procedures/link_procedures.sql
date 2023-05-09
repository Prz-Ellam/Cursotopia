DELIMITER $$
DROP PROCEDURE IF EXISTS `link_create` $$
CREATE PROCEDURE `link_create`(
    IN  `_link_name`                    VARCHAR(255),
    IN  `_link_address`                 VARCHAR(255),
    OUT `_link_id`                      INT
)
BEGIN
    INSERT INTO `links`(
        `link_name`,
        `link_address`
    )
    VALUES(
        `_link_name`,
        `_link_address`
    );
    SET `_link_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `link_update` $$
CREATE PROCEDURE `link_update`(
    IN `_link_id`                       INT,
    IN `_link_name`                     VARCHAR(255),
    IN `_link_address`                  VARCHAR(255),
    IN `_link_created_at`               TIMESTAMP,
    IN `_link_modified_at`              TIMESTAMP,
    IN `_link_active`                   BOOLEAN
)
BEGIN
    UPDATE
        `links`
    SET
        `link_name`                     = IFNULL(`_link_name`, `link_name`),
        `link_address`                  = IFNULL(`_link_address`, `link_address`),
        `link_created_at`               = IFNULL(`_link_created_at`, `link_created_at`),
        `link_modified_at`              = IFNULL(`_link_modified_at`, NOW()),
        `link_active`                   = IFNULL(`_link_active`, `link_active`)
    WHERE
        `link_id` = `_link_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `link_find_by_id` $$
CREATE PROCEDURE `link_find_by_id`(
    IN `_link_id`                       INT
)
BEGIN
    SELECT
        `link_id`                       AS `id`,
        `link_name`                     AS `name`,
        `link_address`                  AS `address`,
        `link_created_at`               AS `createdAt`,
        `link_modified_at`              AS `modifiedAt`,
        `link_active`                   AS `active`
    FROM
        `links`
    WHERE
        `link_id` = `_link_id`
        AND `link_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;
