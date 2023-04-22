DROP VIEW IF EXISTS `instructor_courses`;
CREATE VIEW `instructor_courses`
AS
SELECT
    c.course_id AS `id`,
    c.course_title AS `title`,
    c.course_image_id AS `imageId`,
    COUNT(e.enrollment_id) AS `enrollments`,
    IFNULL(SUM(e.enrollment_amount), 0) AS `amount`,
    IFNULL(get_course_completion_percentage(c.course_id),0) AS `averageLevel`,
    c.instructor_id AS `instructorId`
FROM
    `courses` AS c
LEFT JOIN
    `enrollments` AS e
ON
    c.course_id = e.course_id
WHERE
    c.course_active = TRUE
    AND c.course_is_complete = TRUE
    AND c.course_approved = TRUE
GROUP BY
    c.course_id;

SELECT * FROM `instructor_courses`;

