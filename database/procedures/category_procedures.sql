DELIMITER $$
DROP PROCEDURE IF EXISTS `category_create` $$
CREATE PROCEDURE `category_create`(
    IN  `_name`                         VARCHAR(50),
    IN  `_description`                  VARCHAR(255),
    IN  `_created_by`                   INT,
    OUT `_category_id`                  INT
)
BEGIN
    INSERT INTO `categories`(
        `category_name`,
        `category_description`,
        `category_created_by`
    )
    VALUES(
        `_name`,
        `_description`,
        `_created_by`
    );
    SET `_category_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `category_update` $$
CREATE PROCEDURE `category_update`(
    IN `_category_id`                   INT,
    IN `_category_name`                 VARCHAR(50),
    IN `_category_description`          VARCHAR(255),
    IN `_category_is_approved`          BOOLEAN,
    IN `_category_approved_by`          INT,
    IN `_category_created_by`           INT,
    IN `_category_created_at`           TIMESTAMP,
    IN `_category_modified_at`          TIMESTAMP,
    IN `_category_active`               BOOLEAN
)
BEGIN
    UPDATE
        `categories`
    SET
        `category_name`                 = IFNULL(`_category_name`, `category_name`),
        `category_description`          = IFNULL(`_category_description`, `category_description`),
        `category_is_approved`          = IFNULL(`_category_is_approved`, `category_is_approved`),
        `category_approved_by`          = IFNULL(`_category_approved_by`, `category_approved_by`),
        `category_created_by`           = IFNULL(`_category_created_by`, `category_created_by`),
        `category_created_at`           = IFNULL(`_category_created_at`, `category_created_at`),
        `category_modified_at`          = NOW(),
        `category_active`               = IFNULL(`_category_active`, `category_active`)
    WHERE
        `category_id` = `_category_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_by_id` $$
CREATE PROCEDURE `category_find_by_id`(
    IN `_category_id`                   INT
)
BEGIN
    SELECT
        `category_id`                   AS `id`,
        `category_name`                 AS `name`,
        `category_description`          AS `description`,
        `category_is_approved`          AS `approved`,
        `category_approved_by`          AS `approvedBy`,
        `category_created_by`           AS `createdBy`,
        `category_created_at`           AS `createdAt`,
        `category_modified_at`          AS `modifiedAt`,
        `category_active`               AS `active`
    FROM
        `categories`
    WHERE
        `category_id` = `_category_id`
        AND `category_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;


-- Busca todas las categorías que han sido aprobadas
DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_all` $$
CREATE PROCEDURE `category_find_all`()
BEGIN
    SELECT
        `category_id`                   AS `id`,
        `category_name`                 AS `name`,
        `category_description`          AS `description`,
        `category_is_approved`          AS `approved`,
        `category_approved_by`          AS `approvedBy`,
        `category_created_by`           AS `createdBy`,
        `category_created_at`           AS `createdAt`,
        `category_modified_at`          AS `modifiedAt`,
        `category_active`               AS `active`
    FROM
        `categories`
    WHERE
        `category_active` = TRUE
        AND `category_is_approved` = TRUE;
END $$
DELIMITER ;


-- Busca todas las categorías aprobadas + las creadas por un usuario
DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_all_by_user` $$
CREATE PROCEDURE `category_find_all_by_user`(
    IN `_user_id`                       INT
)
BEGIN
    SELECT
        `category_id`                   AS `id`,
        `category_name`                 AS `name`,
        `category_description`          AS `description`,
        `category_is_approved`          AS `approved`,
        `category_approved_by`          AS `approvedBy`,
        `category_created_by`           AS `createdBy`,
        `category_created_at`           AS `createdAt`,
        `category_modified_at`          AS `modifiedAt`,
        `category_active`               AS `active`
    FROM
        `categories`
    WHERE
        `category_active` = TRUE
        AND (`category_is_approved` = TRUE
        OR `category_created_by` = `_user_id`);
END $$
DELIMITER ;


-- Busca todas las categorías de un curso
DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_all_by_course` $$
CREATE PROCEDURE `category_find_all_by_course`(
    IN `_course_id`                     INT
)
BEGIN
    SELECT
        c.`category_id`                 AS `id`,
        c.`category_name`               AS `name`,
        c.`category_description`        AS `description`,
        c.`category_is_approved`        AS `approved`,
        c.`category_approved_by`        AS `approvedBy`,
        c.`category_created_at`         AS `createdAt`,
        c.`category_modified_at`        AS `modifiedAt`,
        c.`category_active`             AS `active`
    FROM
        `categories` AS c
    INNER JOIN
        `course_category` AS cc
    ON
        c.`category_id` = cc.`category_id` 
        AND cc.`course_category_active` = TRUE
    WHERE
        cc.`course_id` = `_course_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_all_not_active` $$
CREATE PROCEDURE `category_find_all_not_active`()
BEGIN
    SELECT
        c.`category_id`                 AS `id`,
        c.`category_name`               AS `name`,
        c.`category_description`        AS `description`,
        c.`category_is_approved`        AS `isApproved`,
        c.`category_approved_by`        AS `approvedBy`,
        c.`category_created_by`         AS `createdBy`,
        c.`category_created_at`         AS `createdAt`,
        c.`category_modified_at`        AS `modifiedAt`,
        c.`category_active`             AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `user`
    FROM
        `categories` AS c
    INNER JOIN
        `users` AS u
    ON
        c.`category_created_by` = u.`user_id`
    WHERE
        c.`category_active` = FALSE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_all_not_approved` $$
CREATE PROCEDURE `category_find_all_not_approved`()
BEGIN
    SELECT
        c.`category_id`                 AS `id`,
        c.`category_name`               AS `name`,
        c.`category_description`        AS `description`,
        c.`category_is_approved`        AS `isApproved`,
        c.`category_approved_by`        AS `approvedBy`,
        c.`category_created_by`         AS `createdBy`,
        c.`category_created_at`         AS `createdAt`,
        c.`category_modified_at`        AS `modifiedAt`,
        c.`category_active`             AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `user`
    FROM
        `categories` AS c
    INNER JOIN
        `users` AS u
    ON
        c.`category_created_by` = u.`user_id`
    WHERE
        `category_is_approved` = FALSE
        AND `category_approved_by` IS NULL
        AND `category_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_one_by_name` $$
CREATE PROCEDURE `category_find_one_by_name`(
    IN `_category_name`                 VARCHAR(50),
    IN `_category_id`                   INT
)
BEGIN
    SELECT
        `category_id`                   AS `id`,
        `category_name`                 AS `name`,
        `category_description`          AS `description`,
        `category_is_approved`          AS `approved`,
        `category_approved_by`          AS `approvedBy`,
        `category_created_by`           AS `createdBy`,
        `category_created_at`           AS `createdAt`,
        `category_modified_at`          AS `modifiedAt`,
        `category_active`               AS `active`
    FROM
        `categories`
    WHERE
        `category_name` = `_category_name`
        AND `category_active` = TRUE
        AND `category_id` <> `_category_id`
    LIMIT
        1;
END $$
DELIMITER ;
