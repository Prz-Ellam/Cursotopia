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