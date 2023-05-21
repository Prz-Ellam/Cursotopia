DROP VIEW IF EXISTS `instructor_courses_seen_by_others`;
CREATE VIEW `instructor_courses_seen_by_others`
AS
SELECT
    c.`course_id`,
    c.`course_title`,
    c.`course_image_id`,
    c.`course_price`,
    COUNT(e.`enrollment_id`) AS `enrollments`,
    IFNULL(SUM(e.`enrollment_amount`), 0) AS `amount`,
    IF(AVG(r.`review_rate`) IS NULL, 0, AVG(r.`review_rate`)) `rates`,
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
LEFT JOIN
    `reviews` AS r
ON
    c.`course_id` = r.`course_id`
    AND r.`review_active` = TRUE
GROUP BY
    c.`course_id`;
