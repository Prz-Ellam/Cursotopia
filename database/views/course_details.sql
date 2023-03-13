DROP VIEW IF EXISTS `course_details`;
CREATE VIEW IF NOT EXISTS `course_details`
AS
    SELECT
        c.course_id AS `id`,
        c.course_title AS `title`,
        c.course_description AS `description`,
        CONCAT('$', FORMAT(c.course_price, 2)) AS `price`,
        c.image_id AS `imageId`,
        c.course_created_at AS `createdAt`,
        c.course_modified_at AS `modifiedAt`,
        CONCAT(u.user_name, ' ', u.user_last_name) AS `instructorName`,
        AVG(r.review_rate) AS `rates`,
        COUNT(DISTINCT r.review_id) AS `reviews`,
        COUNT(DISTINCT e.enrollment_id) `students`,
        COUNT(DISTINCT l.level_id) `levels`,
        d.duration / 3600.0 AS `duration`
    FROM
        courses AS c
    INNER JOIN
        users AS u
    ON
        c.instructor_id = u.user_id
    INNER JOIN
        levels AS l
    ON
        c.course_id = l.course_id
    LEFT JOIN
        enrollments AS e
    ON
        c.course_id = e.course_id
    LEFT JOIN
        reviews AS r
    ON
        c.course_id = r.course_id
    INNER JOIN
        (SELECT
            l.course_id AS `course_id`,
            SUM(v.video_duration) AS `duration`
        FROM
            lessons AS le
        LEFT JOIN
            videos AS v
        ON
            le.video_id = v.video_id
        INNER JOIN
            levels AS l
        ON
            le.level_id = l.level_id
    ) AS d
    ON
        c.course_id = d.course_id
    GROUP BY
        c.course_id;


-- title
-- instructor_name          users
-- instructor_id
-- price
-- reviews                  reviews
-- duration
-- levels                   levels
-- students                 enrollments
-- created at
-- modified at
-- description
-- image


SELECT * FROM course_details;