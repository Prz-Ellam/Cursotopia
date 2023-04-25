DROP VIEW IF EXISTS `course_card`;
CREATE VIEW `course_card`
AS
    SELECT
        c.`course_id`,
        c.`course_title`,
        c.`course_price`,
        c.`course_image_id`,
        u.`user_id` AS `instructor_id`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `instructor_name`,
        IF(AVG(r.`review_rate`) IS NULL, 'No hay reseñas', AVG(r.`review_rate`)) `rate`,
        COUNT(DISTINCT l.`level_id`) AS `levels`,
        SUM(TIME_TO_SEC(v.`video_duration`)) / 3600.0 AS `video_duration`,
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
        `users` AS u
    ON
        c.`instructor_id` = u.`user_id`
    LEFT JOIN
        `reviews` AS r
    ON
        c.`course_id` = r.`course_id`
    INNER JOIN
        `levels` AS l
    ON
        c.`course_id` = l.`course_id`
    INNER JOIN
        `lessons` AS le
    ON
        l.`level_id` = le.`level_id`
    LEFT JOIN
        `videos` AS v
    ON
        le.`video_id` = v.`video_id`
    GROUP BY
        c.`course_id`


-- id
-- title
-- price
-- image
-- instructor name      Users
-- reviews              Reviews

-- levels               Levels
-- total duration       Videos -> Lessons