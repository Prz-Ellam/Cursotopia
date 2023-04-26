DROP VIEW IF EXISTS `instructor_courses`;
CREATE VIEW `instructor_courses`
AS
SELECT
    c.`course_id`,
    c.`course_title`,
    c.`course_image_id`,
    COUNT(e.`enrollment_id`) AS `enrollments`,
    IFNULL(SUM(e.`enrollment_amount`), 0) AS `amount`,
    IFNULL(get_course_completion_percentage(c.`course_id`), 0) AS `average_level`,
    c.`instructor_id`,
    c.`course_is_complete`,
    c.`course_approved`,
    c.`course_approved_by`,
    c.`course_approved_at`,
    c.`course_created_at`,
    c.`course_modified_at`,
    c.`course_active`
FROM
    `courses` AS c
LEFT JOIN
    `enrollments` AS e
ON
    c.`course_id` = e.`course_id`
GROUP BY
    c.`course_id`;

