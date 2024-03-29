DELIMITER $$
DROP PROCEDURE IF EXISTS `course_create` $$
CREATE PROCEDURE `course_create`(
    IN  `_title`                        VARCHAR(50),
    IN  `_description`                  VARCHAR(255),
    IN  `_price`                        DECIMAL(10, 2),
    IN  `_image_id`                     INT,
    IN  `_instructor_id`                INT,
    OUT `_course_id`                    INT
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



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_update` $$
CREATE PROCEDURE `course_update`(
    IN `_course_id`                     INT,
    IN `_course_title`                  VARCHAR(50),
    IN `_course_description`            VARCHAR(255),
    IN `_course_price`                  DECIMAL(10, 2),
    IN `_course_image_id`               INT,
    IN `_instructor_id`                 INT,
    IN `_course_is_complete`            BOOLEAN,
    IN `_course_approved`               BOOLEAN,
    IN `_course_approved_by`            INT,
    IN `_course_approved_at`            TIMESTAMP,
    IN `_course_created_at`             TIMESTAMP,
    IN `_course_modified_at`            TIMESTAMP,
    IN `_course_active`                 BOOLEAN
)
BEGIN
    UPDATE `courses`
    SET
        `course_id`                     = IFNULL(`_course_id`, `course_id`),
        `course_title`                  = IFNULL(`_course_title`, `course_title`),
        `course_description`            = IFNULL(`_course_description`, `course_description`),
        `course_price`                  = IFNULL(`_course_price`, `course_price`),
        `course_image_id`               = IFNULL(`_course_image_id`, `course_image_id`),
        `instructor_id`                 = IFNULL(`_instructor_id`, `instructor_id`),
        `course_is_complete`            = IFNULL(`_course_is_complete`, `course_is_complete`),
        `course_approved`               = IFNULL(`_course_approved`, `course_approved`),
        `course_approved_by`            = IFNULL(`_course_approved_by`, `course_approved_by`),
        `course_approved_at`            = IFNULL(`_course_approved_at`, `course_approved_at`),
        `course_created_at`             = IFNULL(`_course_created_at`, `course_created_at`),
        `course_modified_at`            = IFNULL(`_course_modified_at`, NOW()),
        `course_active`                 = IFNULL(`_course_active`, `course_active`)
    WHERE `course_id` = `_course_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_find_by_id` $$
CREATE PROCEDURE `course_find_by_id`(
    IN `_course_id`                     INT
)
BEGIN
    SELECT
        c.`course_id`                   AS `id`,
        c.`course_title`                AS `title`,
        c.`course_description`          AS `description`,
        c.`course_price`                AS `price`,
        c.`course_image_id`             AS `imageId`,
        c.`instructor_id`               AS `instructorId`,
        c.`course_is_complete`          AS `isComplete`,
        c.`course_approved`             AS `approved`,
        c.`course_approved_by`          AS `approvedBy`,
        c.`course_approved_at`          AS `approvedAt`,
        c.`course_created_at`           AS `createdAt`,
        c.`course_modified_at`          AS `modifiedAt`,
        c.`course_active`               AS `active`,
        GROUP_CONCAT(cc.`category_id`)  AS `categories`
    FROM
        `courses` AS c
    INNER JOIN
        `course_category` AS cc
    ON
        c.`course_id` = cc.`course_id` 
        AND cc.`course_category_active`= TRUE
    WHERE
        c.`course_id` = `_course_id`
    GROUP BY
        c.`course_id`
    LIMIT
        1;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_find_by_not_approved` $$
CREATE PROCEDURE `course_find_by_not_approved`()
BEGIN
    SELECT
        c.`course_id`                   AS `id`,
        c.`course_title`                AS `title`,
        c.`course_description`          AS `description`,
        c.`course_price`                AS `price`,
        c.`course_image_id`             AS `imageId`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `instructor`,
        c.`course_approved`             AS `approved`,
        c.`course_approved_by`          AS `approvedBy`,
        c.`course_created_at`           AS `createdAt`,
        c.`course_modified_at`          AS `modifiedAt`,
        c.`course_active`               AS `active`
    FROM
        `courses` AS c
    INNER JOIN  
        `users` AS u
    ON
        c.`instructor_id` = u.`user_id`
    WHERE
        `course_approved` = FALSE
        AND `course_approved_by` IS NULL
        AND `course_is_complete` = TRUE
        AND `course_active` = TRUE
        AND (
            SELECT COUNT(c.`category_is_approved`) 
            FROM `course_category` AS cc
            INNER JOIN `categories` AS c ON cc.`category_id` = c.`category_id`
            WHERE cc.`course_id` = c.`course_id` 
            AND c.`category_is_approved` = FALSE
        ) <= 0;
END $$
DELIMITER ;








DELIMITER $$
DROP PROCEDURE IF EXISTS `course_search` $$
CREATE PROCEDURE `course_search`(
    IN `_title`                         VARCHAR(255),
    IN `_instructor_id`                 INT,
    IN `_category_id`                   INT,
    IN `_from`                          DATE,
    IN `_to`                            DATE,
    IN `_limit`                         INT,
    IN `_offset`                        INT
)
BEGIN
    SELECT 
        `course_id`                     AS `id`,
        `course_title`                  AS `title`,
        `course_price`                  AS `price`,
        `course_image_id`               AS `imageId`,
        `instructor_id`                 AS `instructorId`,
        `instructor_name`               AS `instructorName`,
        `rate`,
        `levels`,
        `video_duration`                AS `videoDuration`
    FROM 
        `course_card` AS vcc
    WHERE
        `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND `course_active` = TRUE
        -- Filtro por titulo del curso
        AND (`course_title` LIKE CONCAT('%', `_title` ,'%') OR `_title` IS NULL)
        -- Filtro por fecha
        AND (`course_created_at` BETWEEN IFNULL(`_from`, '1000-01-01') AND 
                IFNULL(`_to`, '9999-12-31'))
        -- Por categoria
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = vcc.`course_id` 
            AND cc.`category_id` = `_category_id` AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL)
        -- Por instructor
        AND (`instructor_id` = `_instructor_id` OR `_instructor_id` IS NULL)
    LIMIT
        `_limit`
    OFFSET
        `_offset`;
END $$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `course_search_total` $$
CREATE PROCEDURE `course_search_total`(
    IN `_title`                         VARCHAR(255),
    IN `_instructor_id`                 INT,
    IN `_category_id`                   INT,
    IN `_from`                          DATE,
    IN `_to`                            DATE
)
BEGIN
    SELECT 
        IFNULL(COUNT(`course_id`), 0) AS `total`
    FROM 
        `course_card` AS vcc
    WHERE
        `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND `course_active` = TRUE
        -- Filtro por titulo del curso
        AND (`course_title` LIKE CONCAT('%', `_title` ,'%') OR `_title` IS NULL)
        -- Filtro por fecha
        AND (`course_created_at` BETWEEN IFNULL(`_from`, '1000-01-01') 
            AND IFNULL(`_to`, '9999-12-31')
        )
        -- Por categoria
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = vcc.`course_id` 
            AND cc.`category_id` = `_category_id` AND cc.`course_category_active` = TRUE) 
            OR `_category_id` IS NULL)
        -- Por instructor
        AND (`instructor_id` = `_instructor_id` OR `_instructor_id` IS NULL);
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `instructor_total_revenue_report` $$
CREATE PROCEDURE `instructor_total_revenue_report`(
    IN `_instructor_id`                 INT
)
BEGIN
    SELECT
        `payment_method_name`           AS `paymentMethodName`,
        `amount`
    FROM
        `instructor_total_revenue`
    WHERE
        `user_id` = `_instructor_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_find_all_order_by_created_by` $$
CREATE PROCEDURE `course_find_all_order_by_created_by`()
BEGIN
    SELECT
        `course_id`                     AS `id`,
        `course_title`                  AS `title`,
        `course_price`                  AS `price`,
        `course_image_id`               AS `imageId`,
        `instructor_name`               AS `instructorName`,
        `levels`,
        `rate`,
        `video_duration`                AS `videoDuration`
    FROM
        `course_card`
    WHERE
        `course_active` = TRUE
        AND `course_approved` = TRUE
        AND `course_is_complete` = TRUE
    ORDER BY
        `course_created_at` DESC
    LIMIT
        15;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_find_all_order_by_rates` $$
CREATE PROCEDURE `course_find_all_order_by_rates`()
BEGIN
    SELECT
        `course_id`                     AS `id`,
        `course_title`                  AS `title`,
        `course_price`                  AS `price`,
        `course_image_id`               AS `imageId`,
        `instructor_name`               AS `instructorName`,
        `levels`,
        `rate`,
        `video_duration`                AS `videoDuration`
    FROM
        `course_card`
    WHERE
        `course_active` = TRUE
        AND `course_approved` = TRUE
        AND `course_is_complete` = TRUE
    ORDER BY
            `rate` DESC
    LIMIT
        15;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_find_all_order_by_enrollments` $$
CREATE PROCEDURE `course_find_all_order_by_enrollments`()
BEGIN
    SELECT
        cc.`course_id` AS `id`,
        cc.`course_title` AS `title`,
        cc.`course_price` AS `price`,
        cc.`course_image_id` AS `imageId`,
        cc.`instructor_name` AS `instructorName`,
        cc.`levels`,
        cc.`rate`,
        cc.`video_duration` AS `videoDuration`
    FROM
        `course_card` AS cc
    LEFT JOIN
        `enrollments` AS e
    ON
        cc.`course_id` = e.`course_id`
    WHERE
        cc.`course_active` = TRUE
        AND cc.`course_approved` = TRUE
        AND cc.`course_is_complete` = TRUE
    GROUP BY
        cc.`course_id`
    ORDER BY
        COUNT(e.`enrollment_amount`) DESC
    LIMIT
        15;
END $$
DELIMITER ;
