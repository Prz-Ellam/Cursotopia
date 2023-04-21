DELIMITER $$
DROP PROCEDURE IF EXISTS `lesson_create` $$
CREATE PROCEDURE `lesson_create`(
    IN  `_title`                        VARCHAR(50),
    IN  `_description`                  VARCHAR(255),
    IN  `_level_id`                     INT,
    IN  `_video_id`                     INT,
    IN  `_image_id`                     INT,
    IN  `_document_id`                  INT,
    IN  `_link_id`                      INT,
    OUT `_lesson_id`                    INT
)
BEGIN
    INSERT INTO `lessons`(
        `lesson_title`,
        `lesson_description`,
        `level_id`,
        `video_id`,
        `image_id`,
        `document_id`,
        `link_id`
    )
    VALUES(
        `_title`,
        `_description`,
        `_level_id`,
        `_video_id`,
        `_image_id`,
        `_document_id`,
        `_link_id`
    );
    SET `_lesson_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `lesson_update` $$
CREATE PROCEDURE `lesson_update`(
    `_lesson_id`                     INT,
    `_lesson_title`                  VARCHAR(50),
    `_lesson_description`            VARCHAR(255),
    `_level_id`                      INT,
    `_video_id`                      INT,
    `_image_id`                      INT,
    `_document_id`                   INT,
    `_link_id`                       INT,
    `_lesson_created_at`             TIMESTAMP,
    `_lesson_modified_at`            TIMESTAMP,
    `_lesson_active`                 BOOLEAN
)
BEGIN
    UPDATE
        `lessons`
    SET
        `lesson_title`                  = IFNULL(`_lesson_title`, `lesson_title`),
        `lesson_description`            = IFNULL(`_lesson_description`, `lesson_description`),
        `level_id`                      = IFNULL(`_level_id`, `level_id`), 
        `video_id`                      = IFNULL(`_video_id`, `video_id`), 
        `image_id`                      = IFNULL(`_image_id`, `image_id`), 
        `document_id`                   = IFNULL(`_document_id`, `document_id`), 
        `link_id`                       = IFNULL(`_link_id`, `link_id`), 
        `lesson_created_at`             = IFNULL(`_lesson_created_at`, `lesson_created_at`),
        `lesson_modified_at`            = IFNULL(`_lesson_modified_at`, NOW()),
        `lesson_active`                 = IFNULL(`_lesson_active`, `lesson_active`)
    WHERE
        `lesson_id` = `_lesson_id`;
END $$
DELIMITER ;