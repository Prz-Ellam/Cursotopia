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