DROP VIEW IF EXISTS `course_details`;
CREATE VIEW `course_details`
AS
    SELECT
        c.`course_id` AS `id`,
        c.`course_title` AS `title`,
        c.`course_description` AS `description`,
        c.`course_price` AS `price`,
        c.`course_image_id` AS `imageId`,
        c.`instructor_id` AS `instructorId`,
        c.`course_approved` AS `approved`,
        c.`course_approved_by` AS `approvedBy`,
        c.`course_created_at` AS `createdAt`,
        c.`course_modified_at` AS `modifiedAt`,
        c.`course_active` AS `active`,
        COUNT(DISTINCT l.`level_id`) AS `levels`,
        COUNT(DISTINCT r.`review_id`) AS `reviews`,
        IF(AVG(r.`review_rate`) IS NULL, 'No hay reseñas', AVG(r.`review_rate`)) `rates`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) `instructor`,
        SUM(TIME_TO_SEC(v.`video_duration`)) / 3600.0 AS `duration`,
        COUNT(DISTINCT e.`enrollment_id`) AS `enrollments`,
        IF(SUM(l.`level_is_free`) > 0, TRUE, FALSE) AS `levelFree`
    FROM
        `courses` AS c
    INNER JOIN
        `levels` AS l
    ON
        c.`course_id` = l.`course_id` AND l.`level_active` = TRUE
    INNER JOIN
        `lessons` AS le
    ON
        l.`level_id` = le.`level_id` AND le.`lesson_active` = TRUE
    LEFT JOIN
        `videos` AS v
    ON
        le.`video_id` = v.`video_id` AND v.`video_active` = TRUE
    LEFT JOIN
        `reviews` AS r
    ON
        c.`course_id` = r.`course_id` AND r.`review_active` = TRUE
    INNER JOIN
        `users` AS u
    ON
        c.`instructor_id` = u.`user_id`
    LEFT JOIN
        `enrollments` AS e
    ON
        c.`course_id` = e.`course_id` AND e.`enrollment_active` = TRUE
    GROUP BY
        c.`course_id`;