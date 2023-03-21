DROP VIEW IF EXISTS `instructor_courses`;
CREATE VIEW IF NOT EXISTS `instructor_courses`
AS
SELECT
    c.course_id AS `id`,
    c.course_title AS `title`,
    c.image_id AS `imageId`,
    COUNT(e.enrollment_id) AS `enrollments`,
    IFNULL(SUM(e.enrollment_amount), 0) AS `amount`,
    1 AS `averageLevel`,
    c.instructor_id AS `instructorId`
FROM
    courses AS c
LEFT JOIN
    enrollments AS e
ON
    c.course_id = e.course_id
WHERE
    c.course_active = TRUE
    AND c.course_approved = TRUE
GROUP BY
    c.course_id;

