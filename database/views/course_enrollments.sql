DROP VIEW IF EXISTS `course_enrollments`;
CREATE VIEW `course_enrollments`
AS
SELECT
    c.course_id AS `course_id`,
    u.user_id AS `user_id`,
    u.user_name AS `user_name`,
    u.user_last_name AS `user_last_name`,
    u.profile_picture AS `user_profile_picture`,
    e.enrollment_enroll_date AS `enrollment_enroll_date`,
    e.enrollment_created_at AS `enrollment_created_at`,
    e.enrollment_amount AS `enrollment_amount`,
    pm.payment_method_name AS `payment_method_name`,
    get_user_course_completion(u.user_id, c.course_id) AS `percentage_complete`
FROM 
    `courses` AS c
LEFT JOIN 
    `enrollments` AS e
ON 
    c.course_id = e.course_id
INNER JOIN 
    `users` AS u
ON 
    e.student_id = u.user_id
INNER JOIN 
    `payment_methods` AS pm
ON 
    e.payment_method_id = pm.payment_method_id
WHERE
    c.course_is_complete = TRUE
    AND c.course_approved = TRUE
    AND c.course_active = TRUE
GROUP BY
    c.course_id,
    u.user_id;



