DROP VIEW IF EXISTS `course_details`;
CREATE VIEW IF NOT EXISTS `course_details`
AS
    SELECT
        c.course_id AS `id`,
        c.course_title AS `title`,
        c.course_description AS `description`,
        c.course_price AS `price`,
        c.image_id AS `imageId`,
        c.instructor_id AS `instructorId`,
        c.course_approved AS `approved`,
        c.course_approved_by AS `approvedBy`,
        c.course_created_at AS `createdAt`,
        c.course_modified_at AS `modifiedAt`,
        c.course_active AS `active`,
        COUNT(DISTINCT l.level_id) AS `levels`,
        COUNT(DISTINCT r.review_id) AS `reviews`,
        IF(AVG(r.review_rate) IS NULL, 'No reviews', AVG(r.review_rate)) `rates`,
        CONCAT(u.user_name, ' ', u.user_last_name) `instructor`,
        SUM(v.video_duration) / 3600.0 AS `duration`,
        COUNT(DISTINCT e.enrollment_id) AS `enrollments`
    FROM
        courses AS c
    INNER JOIN
        levels AS l
    ON
        c.course_id = l.course_id
    INNER JOIN
        lessons AS le
    ON
        l.level_id = le.level_id
    LEFT JOIN
        videos AS v
    ON
        le.video_id = v.video_id
    LEFT JOIN
        reviews AS r
    ON
        c.course_id = r.course_id
    INNER JOIN
        users AS u
    ON
        c.instructor_id = u.user_id
    LEFT JOIN
        enrollments AS e
    ON
        c.course_id = e.course_id
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


        SELECT
            l.level_id AS `id`,
            l.level_title AS `title`,
            l.level_description AS `description`,
            l.level_price AS `price`,
            l.course_id AS `courseId`,
            l.level_created_at AS `createdAt`,
            l.level_modified_at AS `modifiedAt`,
            l.level_active AS `active`,
            (
            SELECT 
                
                GROUP_CONCAT(
                JSON_OBJECT(
                    'title', le.lesson_title, 
                    'description', le.lesson_description,
                    'video_duration', IF(v.video_duration >= 3600, SEC_TO_TIME(v.video_duration), 
                    RIGHT(SEC_TO_TIME(v.video_duration), 5)))
                )
            FROM 
                lessons AS le
            INNER JOIN
                videos AS v
            ON
                le.video_id = v.video_id
            WHERE 
                le.level_id = l.level_id
            GROUP BY
                le.level_id
            ) AS `lessons`
        FROM
            levels AS l
        INNER JOIN
            lessons AS le
        ON
            l.level_id = le.level_id
        WHERE
            course_id = 1
        GROUP BY
            l.level_id;




SELECT       
    GROUP_CONCAT(
    JSON_OBJECT(
        'title', le.lesson_title, 
        'description', le.lesson_description,
        'video_duration', IF(v.video_duration >= 3600, SEC_TO_TIME(v.video_duration), 
            RIGHT(SEC_TO_TIME(v.video_duration), 5)))
    )
FROM 
    lessons AS le
INNER JOIN
    videos AS v
ON
    le.video_id = v.video_id
WHERE 
    le.level_id = 1
GROUP BY
    le.level_id;



SELECT
    l.level_id,
    l.level_title,
    l.level_description,
    l.level_price,
    le.lesson_id,
    CONCAT('[', GROUP_CONCAT(
        JSON_OBJECT(
            'title', le.lesson_title,
            'description', le.lesson_description,
            'duration', v.video_duration
        )
    ), ']'),
    1
FROM
    levels AS l
LEFT JOIN
    lessons AS le
ON
    l.level_id = le.level_id
INNER JOIN
    videos AS v
ON
    le.video_id = v.video_id
GROUP BY
    l.level_id;


SELECT * FROM course_details;