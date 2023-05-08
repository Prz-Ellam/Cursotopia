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



DELIMITER $$
DROP PROCEDURE IF EXISTS `level_find_by_id` $$
CREATE PROCEDURE `level_find_by_id`(
    IN `_level_id`          INT
)
BEGIN
    SELECT
        `level_id` AS `id`,
        `level_title` AS `title`,
        `level_description` AS `description`,
        `level_is_free` AS `free`,
        `course_id` AS `courseId`,
        `level_created_at` AS `createdAt`,
        `level_modified_at` AS `modifiedAt`,
        `level_active` AS `active`
    FROM
        `levels`
    WHERE
        `level_id` = `_level_id`
        AND `level_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `level_find_by_course` $$
CREATE PROCEDURE `level_find_by_course`(
    IN `_course_id`             INT
)
BEGIN
    SELECT
        `level_id` AS `id`,
        `level_title` AS `title`,
        `level_description` AS `description`,
        `level_is_free` AS `free`,
        `course_id` AS `courseId`,
        `level_created_at` AS `createdAt`,
        `level_modified_at` AS `modifiedAt`,
        `level_active` AS `active`
    FROM
        `levels`
    WHERE
        `course_id` = `_course_id`
        AND `level_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `level_find_user_complete` $$
CREATE PROCEDURE `level_find_user_complete`(
    IN _course_id           INT,
    IN _user_id             INT
)
BEGIN
    SELECT
        l.level_id AS `id`,   
        l.level_title AS `title`, 
        l.level_description AS `description`,
        l.level_is_free AS `free`,
        l.course_id AS `courseId`,
        l.level_created_at AS `createdAt`,
        l.level_modified_at AS `modifiedAt`,
        l.level_active AS `active`,
        ul.user_level_is_complete AS `isComplete`,
        ul.user_level_complete_at AS `completeAt`,
        CONCAT('[', GROUP_CONCAT(
            JSON_OBJECT(
                'id', le.lesson_id,
                'title', le.lesson_title,
                'description', le.lesson_description,
                'mainResource', find_main_resource(le.lesson_id),
                'isComplete', ule.user_lesson_is_complete,
                'completeAt', ule.user_lesson_complete_at,
                'videoDuration', IF(v.video_duration >= 3600, v.video_duration, RIGHT(v.video_duration, 5))
            )
        ), ']') AS `lessons`
    FROM `levels` AS l
    INNER JOIN `user_level` AS ul
    ON l.level_id = ul.level_id AND ul.user_id = _user_id
    INNER JOIN `lessons` AS le
    ON l.level_id = le.level_id
    INNER JOIN `user_lesson` AS ule
    ON le.lesson_id = ule.lesson_id AND ule.user_id = _user_id
    LEFT JOIN `videos` AS v
    ON le.video_id = v.video_id
    WHERE l.course_id = _course_id
    GROUP BY
        l.level_id;
END $$
DELIMITER ;