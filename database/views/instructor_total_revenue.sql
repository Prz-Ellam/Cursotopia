DROP VIEW IF EXISTS `instructor_total_revenue`;
CREATE VIEW `instructor_total_revenue`
AS
SELECT
    u.`user_id`,
    pm.`payment_method_id`,
    pm.`payment_method_name`,
    IFNULL(p.`amount`, 0) AS `amount`
FROM
    `users` AS u
JOIN
    `payment_methods` AS pm
ON
    u.`user_role` = 2
LEFT JOIN (
    SELECT
        u.`user_id`,
        e.`payment_method_id`,
        SUM(e.`enrollment_amount`) AS `amount`
    FROM
        `users` AS u
    INNER JOIN
        `courses` AS c
    ON
        u.`user_id` = c.`instructor_id` AND u.`user_role` = 2
    INNER JOIN
        `enrollments` AS e
    ON
        c.`course_id` = e.`course_id`
    GROUP BY
        u.`user_id`,
        e.`payment_method_id`) AS p
ON
    u.`user_id` = p.`user_id` 
    AND pm.`payment_method_id` = p.`payment_method_id`
