DROP VIEW IF EXISTS `kardex`;
CREATE VIEW `kardex`
AS
    SELECT
        c.course_id AS `course_id`,
        e.student_id AS `student_id`,
        c.course_title AS `course_title`,
        IFNULL(e.enrollment_enroll_date, 'N/A') AS `enrollment_enroll_date`,
        IFNULL(e.enrollment_last_time_checked, 'N/A') AS `enrollment_last_time_checked`,
        IFNULL(e.enrollment_finish_date, 'N/A') AS `enrollment_finish_date`,
        IF(e.enrollment_is_finished, 'Acabado', 'En curso') AS `enrollment_is_finished`,
        e.enrollment_certificate_uid AS `enrollment_certificate_uid`,
        get_user_course_completion(e.student_id, c.course_id) AS `enrollment_progress`
    FROM
        `courses` AS c
    INNER JOIN
        `enrollments` AS e
    ON
        c.course_id = e.course_id
    WHERE
        c.course_is_complete = TRUE
        AND c.course_approved = TRUE;


