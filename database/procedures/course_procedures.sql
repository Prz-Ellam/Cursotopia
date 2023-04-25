DELIMITER $$
DROP PROCEDURE IF EXISTS `course_create` $$
CREATE PROCEDURE `course_create`(
    IN  `_title`                    VARCHAR(50),
    IN  `_description`              VARCHAR(255),
    IN  `_price`                    DECIMAL(10, 2),
    IN  `_image_id`                 INT,
    IN  `_instructor_id`            INT,
    OUT `_course_id`                INT
)
BEGIN
    INSERT INTO `courses`(
        `course_title`,
        `course_description`,
        `course_price`,
        `course_image_id`,
        `instructor_id`
    )
    VALUES(
        `_title`,
        `_description`,
        `_price`,
        `_image_id`,
        `_instructor_id`
    );
    SET `_course_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



-- DELIMITER $$
-- DROP PROCEDURE IF EXISTS `update_course` $$
-- CREATE PROCEDURE `update_course`(
--     `_course_id`                        INT,
--     `_course_title`                     VARCHAR(50),
--     `_course_description`               VARCHAR(255),
--     `_course_price`                     DECIMAL(10, 2),
--     `_course_image_id`                  INT,
--     `_instructor_id`                    INT,
--     `_course_is_complete`               BOOLEAN,
--     `_course_approved`                  BOOLEAN,
--     `_course_approved_by`               INT,
--     `_course_approved_at`               TIMESTAMP,
--     `_course_created_at`                TIMESTAMP NOT NULL DEFAULT NOW(),
--     `_course_modified_at`               TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
--     `_course_active`                    BOOLEAN NOT NULL DEFAULT TRUE,
-- )
-- BEGIN
    
-- END $$
-- DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `instructor_courses_report` $$
CREATE PROCEDURE `instructor_courses_report`(
    IN _instructor_id           INT,
    IN _category_id             INT,
    IN _from                    DATE,
    IN _to                      DATE,
    IN _limit                   INT,
    IN _offset                  INT
)
BEGIN
    SELECT
        ic.`id`,
        ic.`title`,
        ic.`imageId`,
        ic.`enrollments`,
        ic.`amount`,
        ic.`averageLevel`,
        ic.`instructorId`,
        ic.`createdAt`
    FROM
        `instructor_courses` AS ic
    WHERE
        `instructorId` = _instructor_id
        AND (ic.`createdAt` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        AND (
            SELECT CASE
            WHEN _category_id IS NULL THEN 1
            ELSE EXISTS(
                SELECT 1
                FROM `course_category`
                WHERE `course_id` = ic.`id`
                AND `category_id` = _category_id
                AND `course_category_active` = TRUE
            )
            END
        )
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_enrollments_report` $$
CREATE PROCEDURE `course_enrollments_report`(
    IN _course_id               INT,
    IN _from                    DATE,
    IN _to                      DATE,
    IN _limit                   INT,
    IN _offset                  INT
)
BEGIN
    SELECT 
        ce.course_id AS `courseId`,
        ce.user_id AS `userId`,
        CONCAT(ce.user_name, ' ', ce.user_last_name) AS `username`,
        ce.user_profile_picture AS `profilePicture`,
        ce.enrollment_enroll_date AS `enrollmentDate`,
        ce.enrollment_created_at AS `createdAt`,
        ce.enrollment_amount AS `amount`,
        ce.payment_method_name AS `paymentMethodName`,
        ce.percentage_complete AS `percentageComplete`
    FROM
        `course_enrollments` AS ce
    WHERE
        ce.course_id = _course_id
        AND (ce.enrollment_created_at BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_search` $$
CREATE PROCEDURE `course_search`(
    IN _title                   VARCHAR(255),
    IN _instructor_id           INT,
    IN _category_id             INT,
    IN _from                    DATE,
    IN _to                      DATE,
    IN _limit                   INT,
    IN _offset                  INT
)
BEGIN
    SELECT 
        `course_id` AS `id`,
        `course_title` AS `title`,
        `course_price` AS `price`,
        `course_image_id` AS `imageId`,
        `instructor_id` AS `instructorId`,
        `instructor_name` AS `instructorName`,
        `rate`,
        `levels`,
        `video_duration` AS `videoDuration`
    FROM 
        `course_card`
    WHERE
        `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND `course_active` = TRUE
        -- Filtro por titulo del curso
        AND (`course_title` LIKE CONCAT('%', _title ,'%') OR _title IS NULL)
        -- Filtro por fecha
        AND (`course_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        -- Por categoria
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = `course_id` 
            AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL)
        -- Por instructor
        AND (`instructor_id` = _instructor_id OR _instructor_id IS NULL)
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `course_search_total` $$
CREATE PROCEDURE `course_search_total`(
    IN _title                   VARCHAR(255),
    IN _instructor_id           INT,
    IN _category_id             INT,
    IN _from                    DATE,
    IN _to                      DATE,
    IN _limit                   INT,
    IN _offset                  INT
)
BEGIN
    SELECT 
        IFNULL(COUNT(`course_id`), 0) AS `total`
    FROM 
        `course_card`
    WHERE
        `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND `course_active` = TRUE
        -- Filtro por titulo del curso
        AND (`course_title` LIKE CONCAT('%', _title ,'%') OR _title IS NULL)
        -- Filtro por fecha
        AND (`course_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        -- Por categoria
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = `course_id` 
            AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL)
        -- Por instructor
        AND (`instructor_id` = _instructor_id OR _instructor_id IS NULL)
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;