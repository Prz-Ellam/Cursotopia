DELIMITER $$
DROP PROCEDURE IF EXISTS `document_create` $$
CREATE PROCEDURE `document_create`(
    IN `_document_name`                  VARCHAR(255),
    IN `_document_content_type`          VARCHAR(30),
    IN `_document_address`               VARCHAR(255),
    OUT `_document_id`                   INT
)
BEGIN
    INSERT INTO `documents`(
        `document_name`,
        `document_content_type`,
        `document_address`
    )
    VALUES(
        `_document_name`,
        `_document_content_type`,
        `_document_address`
    );
    SET `_document_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `document_update` $$
CREATE PROCEDURE `document_update`(
    IN `_document_id`                    INT,
    IN `_document_name`                  VARCHAR(255),
    IN `_document_content_type`          VARCHAR(30),
    IN `_document_address`               VARCHAR(255),
    IN `_document_created_at`            TIMESTAMP,
    IN `_document_modified_at`           TIMESTAMP,
    IN `_document_active`                BOOLEAN
)
BEGIN
    UPDATE
        `documents`
    SET
        `document_name`                  = IFNULL(`_document_name`, `document_name`),
        `document_content_type`          = IFNULL(`_document_content_type`, `document_content_type`),
        `document_address`               = IFNULL(`_document_address`, `document_address`),
        `document_created_at`            = IFNULL(`_document_created_at`, `document_created_at`),
        `document_modified_at`           = IFNULL(`_document_modified_at`, NOW()),
        `document_active`                = IFNULL(`_document_active`, `document_active`)
    WHERE
        `document_id` = `_document_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `document_find_by_id` $$
CREATE PROCEDURE `document_find_by_id`(
    IN `_document_id`               INT
)
BEGIN
    SELECT
        `document_id` AS `id`,
        `document_name` AS `name`,
        `document_content_type` AS `contentType`,
        `document_address` AS `address`,
        `document_created_at` AS `createdAt`,
        `document_modified_at` AS `modifiedAt`,
        `document_active` AS `active`
    FROM
        `documents`
    WHERE
        `document_id` = `_document_id`
        AND `document_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;
