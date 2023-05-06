DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_one_by_name` $$
CREATE PROCEDURE `category_find_one_by_name`(
    IN _category_name               VARCHAR(50)
)
BEGIN
    SELECT
        `category_id`,
        `category_name`,
        `category_description`,
        `category_is_approved`,
        `category_approved_by`,
        `category_created_by`,
        `category_created_at`,
        `category_modified_at`,
        `category_active`
    FROM
        `categories`
    WHERE
        `category_name` = _category_name
    LIMIT
        1;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `update_category` $$
CREATE PROCEDURE `update_category`(
    `_category_id`                  INT,
    `_category_name`                VARCHAR(50),
    `_category_description`         VARCHAR(255),
    `_category_approved`            BOOLEAN,
    `_category_approved_by`         INT,
    `_category_created_by`          INT,
    `_category_created_at`          TIMESTAMP,
    `_category_modified_at`         TIMESTAMP,
    `_category_active`              BOOLEAN
)
BEGIN
    UPDATE
        `categories`
    SET
        `category_id`                   = IFNULL(`_category_id`, `category_id`),
        `category_name`                 = IFNULL(`_category_name`, `category_name`),
        `category_description`          = IFNULL(`_category_description`, `category_description`),
        `category_approved`             = IFNULL(`_category_approved`, `category_approved`),
        `category_approved_by`          = IFNULL(`_category_approved_by`, `category_approved_by`),
        `category_created_by`           = IFNULL(`_category_created_by`, `category_created_by`),
        `category_created_at`           = IFNULL(`_category_created_at`, `category_created_at`),
        `category_modified_at`          = IFNULL(`_category_modified_at`, `category_modified_at`),
        `category_active`               = IFNULL(`_category_active`, `category_active`)
    WHERE
        `category_id` = `_category_id`;
END $$
DELIMITER ;


-- Obtiene todas las categorías que no han sido aprobadas
DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_not_approved` $$
CREATE PROCEDURE `category_find_not_approved`()
BEGIN
    SELECT
        c.`category_id` AS `id`,
        c.`category_name` AS `name`,
        c.`category_description` AS `description`,
        c.`category_is_approved` AS `isApproved`,
        c.`category_approved_by` AS `approvedBy`,
        c.`category_created_by` AS `createdBy`,
        c.`category_created_at` AS `createdAt`,
        c.`category_modified_at` AS `modifiedAt`,
        c.`category_active` AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `user`
    FROM
        `categories` AS c
    INNER JOIN
        `users` AS u
    ON
        c.`category_created_by` = u.`user_id`
    WHERE
        `category_is_approved` = FALSE
        AND `category_active` = TRUE;
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_not_active` $$
CREATE PROCEDURE `category_find_not_active`()
BEGIN
    SELECT
        c.`category_id` AS `id`,
        c.`category_name` AS `name`,
        c.`category_description` AS `description`,
        c.`category_is_approved` AS `isApproved`,
        c.`category_approved_by` AS `approvedBy`,
        c.`category_created_by` AS `createdBy`,
        c.`category_created_at` AS `createdAt`,
        c.`category_modified_at` AS `modifiedAt`,
        c.`category_active` AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `user`
    FROM
        `categories` AS c
    INNER JOIN
        `users` AS u
    ON
        c.`category_created_by` = u.`user_id`
    WHERE
        `category_active` = FALSE;
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_not_active` $$
CREATE PROCEDURE `category_find_not_active`()
BEGIN
    SELECT
        c.`category_id` AS `id`,
        c.`category_name` AS `name`,
        c.`category_description` AS `description`,
        c.`category_is_approved` AS `isApproved`,
        c.`category_approved_by` AS `approvedBy`,
        c.`category_created_by` AS `createdBy`,
        c.`category_created_at` AS `createdAt`,
        c.`category_modified_at` AS `modifiedAt`,
        c.`category_active` AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `user`
    FROM
        `categories` AS c
    INNER JOIN
        `users` AS u
    ON
        c.`category_created_by` = u.`user_id`
    WHERE
        `category_active` = FALSE;
END $$
DELIMITER ;


-- Aprueba una categoría
DELIMITER $$
DROP PROCEDURE IF EXISTS `category_approve` $$
CREATE PROCEDURE `category_approve`(
    IN _category_id             INT,
    IN _admin_id                INT
)
BEGIN
    UPDATE
        `categories`
    SET
        `category_is_approved` = TRUE,
        `category_approved_by` = _admin_id,
        `category_modified_at` = NOW()
    WHERE
        `category_id` = _category_id;
END $$
DELIMITER ;
