DELIMITER $$
DROP PROCEDURE IF EXISTS `review_create` $$
CREATE PROCEDURE `review_create`(
    IN  `_review_message`           VARCHAR(255),
    IN  `_review_rate`              TINYINT,
    IN  `_course_id`                INT,
    IN  `_user_id`                  INT
)
BEGIN
    INSERT INTO `reviews`(
        `review_message`,
        `review_rate`,
        `course_id`,
        `user_id`
    )
    VALUES(
        `_review_message`,
        `_review_rate`,
        `_course_id`,
        `_user_id`
    );
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS `get_course_reviews`;
DELIMITER $$
CREATE PROCEDURE `get_course_reviews`(
    IN   `course_id`    INT, 
    IN   `page_num`     INT, 
    IN   `page_size`    INT
)
BEGIN
    DECLARE offset_val INT;
    SET offset_val = (page_num - 1) * page_size;
    
    SELECT
        r.review_id AS `id`,
        r.review_message AS `message`,
        r.review_rate AS `rate`,
        r.course_id AS `courseId`,
        r.user_id AS `userId`,
        r.review_created_at AS `createdAt`,
        r.review_modified_at AS `modifiedAt`,
        r.review_active AS `active`,
        CONCAT(u.user_name, ' ', u.user_last_name) AS `userName`,
        u.profile_picture AS `profilePicture`
    FROM
        reviews AS r
    INNER JOIN
        users AS u
    ON
        r.user_id = u.user_id
    WHERE
        r.course_id = course_id AND r.review_active=1
    ORDER BY
        r.review_created_at DESC
    LIMIT page_size OFFSET offset_val;
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `find_user_review_in_course` $$
CREATE PROCEDURE `find_user_review_in_course`(
    IN `courseId` INT, 
    IN `userId` INT
)
BEGIN
    SELECT
        r.review_id AS `id`,
        r.review_message AS `message`,
        r.review_rate AS `rate`,
        r.course_id AS `courseId`,
        r.user_id AS `userId`,
        r.review_created_at AS `createdAt`,
        r.review_modified_at AS `modifiedAt`,
        r.review_active AS `active`,
        CONCAT(u.user_name, ' ', u.user_last_name) AS `userName`,
        u.profile_picture AS `profilePicture`
    FROM
        reviews AS r
    INNER JOIN
        users AS u
    ON
        r.user_id = u.user_id 
    WHERE
        course_id = courseId AND r.user_id = userId AND r.review_active=1;
END;
DELIMITER ;