DELIMITER $$
DROP TRIGGER IF EXISTS `after_insert_on_enrollment` $$
CREATE TRIGGER `after_insert_on_enrollment`
AFTER INSERT
ON `enrollments` FOR EACH ROW
BEGIN
    INSERT INTO `user_level`(
        `user_id`,
        `level_id`
    )
    SELECT
        new.`student_id`,
        `level_id`
    FROM
        `levels`
    WHERE
        `course_id` = new.`course_id`
        AND `level_active` = TRUE;
END $$
DELIMITER ;
