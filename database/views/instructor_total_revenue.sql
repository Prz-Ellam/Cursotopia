DROP VIEW IF EXISTS `instructor_total_revenue`;
CREATE VIEW `instructor_total_revenue`
AS

    SELECT
        *
    FROM
        `users` AS u
    INNER JOIN
        `courses` AS c
    ON
        u.user_id = c.instructor_id
    LEFT JOIN
        `enrollments` AS e
    ON
        c.course_id = e.course_id
    WHERE
        c.course_is_complete = TRUE
        AND c.course_approved = TRUE
        AND c.course_active = TRUE
    GROUP BY 
        c.instructor_id, e.payment_method_id;

    SELECT 
        c.instructor_id AS `instructor_id`,
        pm.payment_method_name AS `payment_method_name`, 
        SUM(e.enrollment_amount) AS `total_amount`
    FROM 
        `enrollments` AS e
    INNER JOIN 
        `courses` AS c
    ON 
        e.course_id = c.course_id
    INNER JOIN 
        `payment_methods`AS pm
    ON 
        e.payment_method_id = pm.payment_method_id
    GROUP BY 
        c.instructor_id, e.payment_method_id;