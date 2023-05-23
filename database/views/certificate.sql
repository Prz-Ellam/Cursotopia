DROP VIEW IF EXISTS `certificate`;
CREATE VIEW `certificate`
AS
SELECT
    e.`course_id`,
    e.`student_id`,
    e.`enrollment_finish_date`,
    e.`enrollment_certificate_uid`,
    CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `student`,
    CONCAT(i.`user_name`, ' ', i.`user_last_name`) AS `instructor`,
    c.`course_title`
FROM
    `enrollments` AS e
INNER JOIN
    `users` AS u
ON
    e.`student_id` = u.`user_id`
INNER JOIN
    `courses` AS c
ON
    e.`course_id` = c.`course_id`
INNER JOIN
    `users` AS i
ON
    c.`instructor_id` = i.`user_id`
WHERE
    `enrollment_is_finished` = TRUE;
