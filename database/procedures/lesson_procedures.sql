DELIMITER $$
DROP PROCEDURE IF EXISTS `lesson_create` $$
CREATE PROCEDURE `lesson_create`(
    IN  `_lesson_title`                 VARCHAR(50),
    IN  `_lesson_description`           VARCHAR(255),
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
        `_lesson_title`,
        `_lesson_description`,
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
    IN `_lesson_id`                     INT,
    IN `_lesson_title`                  VARCHAR(50),
    IN `_lesson_description`            VARCHAR(255),
    IN `_level_id`                      INT,
    IN `_video_id`                      INT,
    IN `_image_id`                      INT,
    IN `_document_id`                   INT,
    IN `_link_id`                       INT,
    IN `_lesson_created_at`             TIMESTAMP,
    IN `_lesson_modified_at`            TIMESTAMP,
    IN `_lesson_active`                 BOOLEAN
)
BEGIN
    UPDATE
        `lessons`
    SET
        `lesson_id`                     = IFNULL(`_lesson_id`, `lesson_id`),
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



DELIMITER $$
DROP PROCEDURE IF EXISTS `lesson_find_by_id` $$
CREATE PROCEDURE `lesson_find_by_id`(
    IN `_lesson_id`                     INT
)
BEGIN
    SELECT
        le.`lesson_id`                  AS `id`,
        le.`lesson_title`               AS `title`,
        le.`lesson_description`         AS `description`,
        le.`level_id`                   AS `levelId`,
        le.`video_id`                   AS `videoId`,
        le.`image_id`                   AS `imageId`,
        le.`document_id`                AS `documentId`,
        le.`link_id`                    AS `linkId`,
        le.`lesson_created_at`          AS `createdAt`,
        le.`lesson_modified_at`         AS `modifiedAt`,
        le.`lesson_active`              AS `active`,
        c.`instructor_id`               AS `instructorId`,
        c.`course_is_complete`          AS `courseIsComplete`
    FROM
        `lessons` AS le
    INNER JOIN
        `levels` AS l ON le.`level_id` = l.`level_id`
    INNER JOIN
        `courses` AS c ON l.`course_id` = c.`course_id`
    WHERE
        `lesson_id` = `_lesson_id`
        AND `lesson_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `lesson_find_by_level` $$
CREATE PROCEDURE `lesson_find_by_level`(
    IN `_level_id`                      INT
)
BEGIN
    SELECT
        `lesson_id`                     AS `id`,
        `lesson_title`                  AS `title`,
        `lesson_description`            AS `description`,
        `level_id`                      AS `levelId`,
        `video_id`                      AS `videoId`,
        `image_id`                      AS `imageId`,
        `document_id`                   AS `documentId`,
        `link_id`                       AS `linkId`,
        `lesson_created_at`             AS `createdAt`,
        `lesson_modified_at`            AS `modifiedAt`,
        `lesson_active`                 AS `active`
    FROM
        `lessons`
    WHERE
        `level_id` = `_level_id`
        AND `lesson_active` = TRUE;
END $$
DELIMITER ;