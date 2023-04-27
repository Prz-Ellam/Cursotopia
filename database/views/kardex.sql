DROP VIEW IF EXISTS `kardex`;
CREATE VIEW `kardex`
AS
SELECT
    c.`course_id`,
    c.`course_title`,
    c.`course_image_id`,
    e.`student_id`,
    IFNULL(e.enrollment_enroll_date, 'N/A') AS `enrollment_enroll_date`,
    IFNULL(e.enrollment_last_time_checked, 'N/A') AS `enrollment_last_time_checked`,
    IFNULL(e.enrollment_finish_date, 'N/A') AS `enrollment_finish_date`,
    e.`enrollment_is_finished`,
    IF(e.enrollment_is_finished, 'Acabado', 'En curso') AS `enrollment_status`,
    e.enrollment_certificate_uid AS `enrollment_certificate_uid`,
    e.`enrollment_created_at`,
    get_user_course_completion(e.student_id, c.course_id) AS `enrollment_progress`,
    c.`course_is_complete`,
    c.`course_approved`,
    c.`course_approved_by`,
    c.`course_approved_at`,
    c.`course_created_at`,
    c.`course_modified_at`,
    c.`course_active`
FROM
    `courses` AS c
INNER JOIN
    `enrollments` AS e
ON
    c.`course_id` = e.`course_id`;
