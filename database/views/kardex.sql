-- CREATE VIEW IF NOT EXISTS `kardex`;
DROP VIEW IF EXISTS `kardex`;
CREATE VIEW IF NOT EXISTS `kardex`
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
        (SUM(IF(ule.user_lesson_is_complete, 1, 0)) / 
        COUNT(ule.user_lesson_is_complete)) AS `enrollment_progress`
    FROM
        courses AS c
    LEFT JOIN
        enrollments AS e
    ON
        c.course_id = e.course_id
    INNER JOIN
        levels AS l
    ON
        e.course_id = l.course_id
    LEFT JOIN
        user_level AS ul
    ON
        l.level_id = ul.level_id
    INNER JOIN
        lessons AS le
    ON
        l.level_id = le.level_id
    LEFT JOIN
        user_lesson AS ule 
    ON
        le.lesson_id = ule.lesson_id AND e.student_id = ule.user_id
    GROUP BY
        e.student_id;






