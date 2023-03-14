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
                    'video_duration', IF(v.video_duration >= 3600, SEC_TO_TIME(v.video_duration), RIGHT(SEC_TO_TIME(v.video_duration), 5)))
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
    JSON_ARRAYAGG(JSON_OBJECT('title', lesson_title, 'description', lesson_description))
FROM lessons;










DELIMITER //

DROP FUNCTION IF EXISTS JSON_ARRAYAGG //

CREATE AGGREGATE FUNCTION IF NOT EXISTS JSON_ARRAYAGG(next_value TEXT) RETURNS TEXT
BEGIN  

 DECLARE json TEXT DEFAULT '[]';
 DECLARE CONTINUE HANDLER FOR NOT FOUND RETURN json_remove(json, '$[0]');
      LOOP  
          FETCH GROUP NEXT ROW;
          SET json = json_array_append(json, '$', next_value);
      END LOOP;  

END //
DELIMITER ;