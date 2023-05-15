DROP VIEW IF EXISTS `course_enrollments`;
CREATE VIEW `course_enrollments`
AS
SELECT
    c.`course_id`,
    u.`user_id`,
    u.`user_name`,
    u.`user_last_name`,
    u.`profile_picture` AS `profile_picture`,
    e.`enrollment_enroll_date`,
    e.`enrollment_amount`,
    IFNULL(pm.`payment_method_name`, 'Version de prueba') AS `payment_method_name`,
    get_user_course_completion(u.`user_id`, c.`course_id`) AS `percentage_complete`,
    e.`enrollment_created_at`,
    e.`enrollment_modified_at`,
    e.`enrollment_active`
FROM 
    `courses` AS c
LEFT JOIN 
    `enrollments` AS e
ON 
    c.`course_id` = e.`course_id`
INNER JOIN 
    `users` AS u
ON 
    e.`student_id` = u.`user_id`
LEFT JOIN 
    `payment_methods` AS pm
ON 
    e.`payment_method_id` = pm.`payment_method_id`
WHERE
    c.`course_is_complete` = TRUE
    AND c.`course_approved` = TRUE
GROUP BY
    c.`course_id`,
    u.`user_id`;
