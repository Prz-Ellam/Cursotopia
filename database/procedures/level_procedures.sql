DELIMITER $$
DROP PROCEDURE IF EXISTS `level_create` $$
CREATE PROCEDURE `level_create`(
    IN  `_title`                        VARCHAR(50),
    IN  `_description`                  VARCHAR(255),
    IN  `_is_free`                      BOOLEAN,
    IN  `_course_id`                    INT,
    OUT `_level_id`                     INT
)
BEGIN
    INSERT INTO `levels`(
        `level_title`,
        `level_description`,
        `level_is_free`,
        `course_id`
    )
    VALUES(
        `_title`,
        `_description`,
        `_is_free`,
        `_course_id`
    );
    SET `_level_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `level_update` $$
CREATE PROCEDURE `level_update`(
    `_level_id`                      INT,
    `_level_title`                   VARCHAR(50),
    `_level_description`             VARCHAR(255),
    `_level_is_free`                 BOOLEAN,
    `_course_id`                     INT,
    `_level_created_at`              TIMESTAMP,
    `_level_modified_at`             TIMESTAMP,
    `_level_active`                  BOOLEAN
)
BEGIN
    UPDATE
        `levels`
    SET
        `level_title`                   = IFNULL(`_level_title`, `level_title`),
        `level_description`             = IFNULL(`_level_description`, `level_description`),
        `level_is_free`                 = IFNULL(`_level_is_free`, `level_is_free`),
        `course_id`                     = IFNULL(`_course_id`, `course_id`),
        `level_created_at`              = IFNULL(`_level_created_at`, `level_created_at`),
        `level_modified_at`             = IFNULL(`_level_modified_at`, NOW()),
        `level_active`                  = IFNULL(`_level_active`, `level_active`)
    WHERE
        `level_id` = `_level_id`;
END $$
DELIMITER ;