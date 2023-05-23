DELIMITER $$
DROP PROCEDURE IF EXISTS `course_category_create` $$
CREATE PROCEDURE `course_category_create`(
    IN  `_course_id`                    INT,
    IN  `_category_id`                  INT,
    OUT `_course_category_id`           INT
)
BEGIN
    INSERT INTO `course_category`(
        `course_id`,
        `category_id`
    )
    VALUES(
        `_course_id`,
        `_category_id`
    );
    SET `_course_category_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_category_delete_by_course` $$
CREATE PROCEDURE `course_category_delete_by_course`(
    IN `_course_id`                     INT
)
BEGIN
    UPDATE
        `course_category`
    SET
        `course_category_active` = FALSE,
        `course_category_modified_at` = NOW()
    WHERE
        `course_id` = `_course_id`;
END $$
DELIMITER ;
