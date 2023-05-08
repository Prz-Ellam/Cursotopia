DELIMITER $$
DROP PROCEDURE IF EXISTS `course_category_delete_by_course` $$
CREATE PROCEDURE `course_category_delete_by_course`(
    IN `_course_id`                 INT
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