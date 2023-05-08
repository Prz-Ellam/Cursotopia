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



DELIMITER $$
DROP PROCEDURE IF EXISTS `get_course_reviews` $$
CREATE PROCEDURE `get_course_reviews`(
    IN   `course_id`            INT, 
    IN   `page_num`             INT, 
    IN   `page_size`            INT
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
    LIMIT 
        page_size 
    OFFSET
        offset_val;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `review_find_total_by_course` $$
CREATE PROCEDURE `review_find_total_by_course`(
    IN _course_id               INT
)
BEGIN
    SELECT
        IFNULL(COUNT(r.`review_id`), 0) AS `total`
    FROM
        `reviews` AS r
    INNER JOIN
        `users` AS u
    ON
        r.`user_id` = u.`user_id`
    WHERE
        r.`course_id` = _course_id 
        AND r.`review_active` = TRUE
    ORDER BY
        r.`review_created_at` DESC;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `find_user_review_in_course` $$
CREATE PROCEDURE `find_user_review_in_course`(
    IN _course_id           INT, 
    IN _user_id             INT
)
BEGIN
    SELECT
        r.`review_id` AS `id`,
        r.`review_message` AS `message`,
        r.`review_rate` AS `rate`,
        r.`course_id` AS `courseId`,
        r.`user_id` AS `userId`,
        r.`review_created_at` AS `createdAt`,
        r.`review_modified_at` AS `modifiedAt`,
        r.`review_active` AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `userName`,
        u.`profile_picture` AS `profilePicture`
    FROM
        `reviews` AS r
    INNER JOIN
        `users` AS u
    ON
        r.`user_id` = u.`user_id` 
    WHERE
        r.`course_id` = _course_id 
        AND r.`user_id` = _user_id 
        AND r.`review_active` = TRUE;
END;
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_update_review` $$
CREATE PROCEDURE `sp_update_review`(
    IN _review_id               INT, 
    IN _message                 VARCHAR(255), 
    IN _rate                    INT, 
    IN _active                  BOOLEAN
)
BEGIN
    UPDATE 
        `reviews`
    SET
        `review_message`        = IFNULL(_message, `review_message`),
        `review_rate`           = IFNULL(_rate, `review_rate`),
        `review_modified_at`    = NOW(),
        `review_active`         = IFNULL(_active, `review_active`)
    WHERE
        `review_id` = _review_id;
END$$
DELIMITER ;



DELIMITER $$
CREATE PROCEDURE sp_get_course_reviews(IN course_id INT)
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
        r.course_id = course_id
    ORDER BY
        review_created_at DESC;
END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS sp_get_review_by_course_and_user $$
CREATE PROCEDURE sp_get_review_by_course_and_user(IN course_id INT, IN user_id INT)
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
        r.course_id = course_id 
        AND r.review_active = TRUE
        AND r.user_id = user_id;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_get_review_by_id(IN id INT)
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
        r.review_id = id;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_deactivate_review(IN id INT)
BEGIN
    UPDATE
        `reviews`
    SET
        `review_active` = FALSE
    WHERE
        `review_id` = id;
END$$
DELIMITER ;