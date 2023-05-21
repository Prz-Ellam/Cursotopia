DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images`(
    `image_id`                      INT NOT NULL AUTO_INCREMENT,
    `image_name`                    VARCHAR(255) NOT NULL,
    `image_size`                    INT NOT NULL,
    `image_content_type`            VARCHAR(30) NOT NULL,
    `image_data`                    MEDIUMBLOB NOT NULL,
    `image_created_at`              TIMESTAMP NOT NULL DEFAULT NOW(),
    `image_modified_at`             TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `image_active`                  BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `image_pk`
        PRIMARY KEY (`image_id`),
    CONSTRAINT `image_name_uniq`
        UNIQUE (`image_name`),
    CONSTRAINT `image_size_chk`
        CHECK (`image_size` > 0 AND `image_size` <= 8 * 1024 * 1024), -- 8MB
    CONSTRAINT `image_content_type_chk`
        CHECK (`image_content_type` IN ('image/jpeg', 'image/jpg', 'image/png'))
);

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos`(
    `video_id`                      INT NOT NULL AUTO_INCREMENT,
    `video_name`                    VARCHAR(255) NOT NULL,
    `video_duration`                TIME NOT NULL,
    `video_content_type`            VARCHAR(30) NOT NULL,
    `video_address`                 VARCHAR(255) NOT NULL,
    `video_created_at`              TIMESTAMP NOT NULL DEFAULT NOW(),
    `video_modified_at`             TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `video_active`                  BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `video_pk`
        PRIMARY KEY (`video_id`),
    CONSTRAINT `video_name_uniq`
        UNIQUE (`video_name`),
    CONSTRAINT `video_content_type_chk`
        CHECK (`video_content_type` IN ('video/mp4', 'video/webm', 'video/ogg'))
);

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents`(
    `document_id`                   INT NOT NULL AUTO_INCREMENT,
    `document_name`                 VARCHAR(255) NOT NULL,
    `document_content_type`         VARCHAR(30) NOT NULL,
    `document_address`              VARCHAR(255) NOT NULL,
    `document_created_at`           TIMESTAMP NOT NULL DEFAULT NOW(),
    `document_modified_at`          TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `document_active`               BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `document_pk`
        PRIMARY KEY (`document_id`),
    CONSTRAINT `document_name_uniq`
        UNIQUE (`document_name`),
    CONSTRAINT `document_content_type_chk`
        CHECK (`document_content_type` IN ('application/pdf'))
);

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links`(
    `link_id`                       INT NOT NULL AUTO_INCREMENT,
    `link_name`                     VARCHAR(255) NOT NULL,
    `link_address`                  VARCHAR(255) NOT NULL,
    `link_created_at`               TIMESTAMP NOT NULL DEFAULT NOW(),
    `link_modified_at`              TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `link_active`                   BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `link_pk`
        PRIMARY KEY (`link_id`)
);

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles`(
    `role_id`                       INT NOT NULL AUTO_INCREMENT,
    `role_name`                     VARCHAR(50) NOT NULL,
    `role_is_public`                BOOLEAN NOT NULL DEFAULT TRUE,
    `role_created_at`               TIMESTAMP NOT NULL DEFAULT NOW(),
    `role_modified_at`              TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `role_active`                   BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `role_pk`
        PRIMARY KEY (`role_id`),
    CONSTRAINT `role_name_uniq`
        UNIQUE (`role_name`)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`(
    `user_id`                       INT NOT NULL AUTO_INCREMENT,
    `user_name`                     VARCHAR(50) NOT NULL,
    `user_last_name`                VARCHAR(50) NOT NULL,
    `user_birth_date`               DATE NOT NULL,
    `user_gender`                   ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
    `user_email`                    VARCHAR(255) NOT NULL UNIQUE,
    `user_password`                 VARCHAR(255) NOT NULL,
    `user_role`                     INT NOT NULL,
    `profile_picture`               INT NOT NULL,
    `user_enabled`                  BOOLEAN NOT NULL DEFAULT TRUE,
    `user_created_at`               TIMESTAMP NOT NULL DEFAULT NOW(),
    `user_modified_at`              TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `user_active`                   BOOLEAN NOT NULL DEFAULT TRUE,
    INDEX `idx_user_email` (`user_email`),
    CONSTRAINT `users_pk`
        PRIMARY KEY (`user_id`),
    CONSTRAINT `users_images_fk`
        FOREIGN KEY (`profile_picture`) 
        REFERENCES `images`(`image_id`),
    CONSTRAINT `users_roles_fk`
        FOREIGN KEY (`user_role`) 
        REFERENCES `roles`(`role_id`),
    CONSTRAINT `user_email_uniq`
        UNIQUE (`user_email`)
);

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses`(
    `course_id`                     INT NOT NULL AUTO_INCREMENT,
    `course_title`                  VARCHAR(50) NOT NULL,
    `course_description`            VARCHAR(255) NOT NULL,
    `course_price`                  DECIMAL(10, 2) NOT NULL,
    `course_image_id`               INT NOT NULL UNIQUE,
    `instructor_id`                 INT NOT NULL,
    `course_is_complete`            BOOLEAN NOT NULL DEFAULT FALSE,
    `course_approved`               BOOLEAN NOT NULL DEFAULT FALSE,
    `course_approved_by`            INT DEFAULT NULL,
    `course_approved_at`            TIMESTAMP,
    `course_created_at`             TIMESTAMP NOT NULL DEFAULT NOW(),
    `course_modified_at`            TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `course_active`                 BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `course_pk`
        PRIMARY KEY (`course_id`),
    CONSTRAINT `course_image_fk`
        FOREIGN KEY (`course_image_id`) 
        REFERENCES `images`(`image_id`),
    CONSTRAINT `course_instructor_fk`
        FOREIGN KEY (`instructor_id`) 
        REFERENCES `users`(`user_id`),
    CONSTRAINT `course_approved_by_fk`
        FOREIGN KEY (`course_approved_by`) 
        REFERENCES `users`(`user_id`),
    CONSTRAINT `course_image_id_uniq`
        UNIQUE (`course_image_id`),
    CONSTRAINT `course_price_chk`
        CHECK (`course_price` >= 0)
);

DROP TABLE IF EXISTS `levels`;
CREATE TABLE IF NOT EXISTS `levels`(
    `level_id`                      INT NOT NULL AUTO_INCREMENT,
    `level_title`                   VARCHAR(50) NOT NULL,
    `level_description`             VARCHAR(255) NOT NULL,
    `level_is_free`                 BOOLEAN NOT NULL,
    `course_id`                     INT NOT NULL,
    `level_created_at`              TIMESTAMP NOT NULL DEFAULT NOW(),
    `level_modified_at`             TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `level_active`                  BOOLEAN NOT NULL DEFAULT TRUE,
    INDEX `level_course_idx` (`course_id`),
    CONSTRAINT `level_pk`
        PRIMARY KEY (`level_id`),
    CONSTRAINT `level_course_fk`
        FOREIGN KEY (`course_id`) 
        REFERENCES `courses`(`course_id`)
);

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons`(
    `lesson_id`                     INT NOT NULL AUTO_INCREMENT,
    `lesson_title`                  VARCHAR(50) NOT NULL,
    `lesson_description`            VARCHAR(255) NOT NULL,
    `level_id`                      INT NOT NULL,
    `video_id`                      INT DEFAULT NULL,
    `image_id`                      INT DEFAULT NULL,
    `document_id`                   INT DEFAULT NULL,
    `link_id`                       INT DEFAULT NULL,
    `lesson_created_at`             TIMESTAMP NOT NULL DEFAULT NOW(),
    `lesson_modified_at`            TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `lesson_active`                 BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `lesson_pk`
        PRIMARY KEY (`lesson_id`),
    CONSTRAINT `lesson_level_fk`
        FOREIGN KEY (`level_id`) 
        REFERENCES `levels`(`level_id`),
    CONSTRAINT `lesson_video_fk`
        FOREIGN KEY (`video_id`) 
        REFERENCES `videos`(`video_id`),
    CONSTRAINT `lesson_image_fk`
        FOREIGN KEY (`image_id`) 
        REFERENCES `images`(`image_id`),
    CONSTRAINT `lesson_document_fk`
        FOREIGN KEY (`document_id`) 
        REFERENCES `documents`(`document_id`),
    CONSTRAINT `lesson_link_fk`
        FOREIGN KEY (`link_id`) 
        REFERENCES `links`(`link_id`)
);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories`(
    `category_id`                   INT NOT NULL AUTO_INCREMENT,
    `category_name`                 VARCHAR(50) NOT NULL,
    `category_description`          VARCHAR(255),
    `category_is_approved`          BOOLEAN NOT NULL DEFAULT FALSE,
    `category_approved_by`          INT DEFAULT NULL,
    `category_created_by`           INT NOT NULL,
    `category_created_at`           TIMESTAMP NOT NULL DEFAULT NOW(),
    `category_modified_at`          TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `category_active`               BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `category_pk`
        PRIMARY KEY (`category_id`),
    CONSTRAINT `category_approved_by_fk`
        FOREIGN KEY (`category_approved_by`) 
        REFERENCES `users`(`user_id`),
    CONSTRAINT `category_created_by_fk`
        FOREIGN KEY (`category_created_by`) 
        REFERENCES `users`(`user_id`),
    CONSTRAINT `category_name_uniq`
        UNIQUE (`category_name`)
);

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews`(
    `review_id`                     INT NOT NULL AUTO_INCREMENT,
    `review_message`                VARCHAR(255) NOT NULL,
    `review_rate`                   TINYINT NOT NULL,
    `course_id`                     INT NOT NULL,
    `user_id`                       INT NOT NULL,
    `review_created_at`             TIMESTAMP NOT NULL DEFAULT NOW(),
    `review_modified_at`            TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `review_active`                 BOOLEAN NOT NULL DEFAULT TRUE,
    INDEX `idx_course_id` (`course_id`),
    CONSTRAINT `review_pk`
        PRIMARY KEY (`review_id`),
    CONSTRAINT `review_course_fk`
        FOREIGN KEY (`course_id`) 
        REFERENCES `courses`(`course_id`),
    CONSTRAINT `review_user_fk`
        FOREIGN KEY (`user_id`) 
        REFERENCES `users`(`user_id`),
    CONSTRAINT `review_rate_chk`
        CHECK (`review_rate` BETWEEN 1 AND 5)
);

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods`(
    `payment_method_id`             INT NOT NULL AUTO_INCREMENT,
    `payment_method_name`           VARCHAR(50) NOT NULL,
    `payment_method_created_at`     TIMESTAMP NOT NULL DEFAULT NOW(),
    `payment_method_mofified_at`    TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `payment_method_active`         BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `payment_method_pk`
        PRIMARY KEY (`payment_method_id`),
    CONSTRAINT `payment_method_name_uniq`
        UNIQUE (`payment_method_name`)
);

DROP TABLE IF EXISTS `enrollments`;
CREATE TABLE IF NOT EXISTS `enrollments`(
    `enrollment_id`                 INT NOT NULL AUTO_INCREMENT,
    `course_id`                     INT NOT NULL,
    `student_id`                    INT NOT NULL,
    `enrollment_is_finished`        BOOLEAN NOT NULL DEFAULT FALSE,
    `enrollment_enroll_date`        DATETIME,
    `enrollment_finish_date`        DATETIME,
    `enrollment_certificate_uid`    VARCHAR(36),
    `enrollment_amount`             DECIMAL(10, 2),
    `payment_method_id`             INT,
    `enrollment_is_paid`            BOOLEAN DEFAULT FALSE,
    `enrollment_last_time_checked`  DATETIME,
    `enrollment_created_at`         TIMESTAMP NOT NULL DEFAULT NOW(),
    `enrollment_modified_at`        TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `enrollment_active`             BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `enrollment_pk`
        PRIMARY KEY (`enrollment_id`),
    CONSTRAINT `enrollment_course_fk`
        FOREIGN KEY (`course_id`) 
        REFERENCES `courses`(`course_id`),
    CONSTRAINT `enrollment_student_fk`
        FOREIGN KEY (`student_id`) 
        REFERENCES `users`(`user_id`),
    CONSTRAINT `enrollment_payment_method_fk`
        FOREIGN KEY (`payment_method_id`) 
        REFERENCES `payment_methods`(`payment_method_id`),
    CONSTRAINT `course_student_uniq`
        UNIQUE KEY (`course_id`, `student_id`),
    CONSTRAINT `enrollment_amount_chk`
        CHECK (`enrollment_amount` >= 0)
);

DROP TABLE IF EXISTS `user_level`;
CREATE TABLE IF NOT EXISTS `user_level`(
    `user_level_id`                 INT NOT NULL AUTO_INCREMENT,
    `user_id`                       INT NOT NULL,
    `level_id`                      INT NOT NULL,
    `user_level_is_complete`        BOOLEAN NOT NULL DEFAULT FALSE,
    `user_level_complete_at`        TIMESTAMP,
    `user_level_last_access_date`   DATETIME,
    `user_level_created_at`         TIMESTAMP NOT NULL DEFAULT NOW(),
    `user_level_modified_at`        TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    CONSTRAINT `user_level_pk`
        PRIMARY KEY (`user_level_id`),
    CONSTRAINT `user_level_user_fk`
        FOREIGN KEY (`user_id`) 
        REFERENCES `users`(`user_id`),
    CONSTRAINT `user_level_level_fk`
        FOREIGN KEY (`level_id`) 
        REFERENCES `levels`(`level_id`),
    CONSTRAINT `user_level_unique`
        UNIQUE KEY (`user_id`, `level_id`)
);

DROP TABLE IF EXISTS `user_lesson`;
CREATE TABLE IF NOT EXISTS `user_lesson`(
    `user_lesson_id`                INT NOT NULL AUTO_INCREMENT,
    `user_id`                       INT NOT NULL,
    `lesson_id`                     INT NOT NULL,
    `user_lesson_is_complete`       BOOLEAN NOT NULL DEFAULT FALSE,
    `user_lesson_complete_at`       TIMESTAMP,
    `user_lesson_last_time_checked` DATETIME,
    `user_lesson_created_at`        TIMESTAMP NOT NULL DEFAULT NOW(),
    `user_lesson_modified_at`       TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    CONSTRAINT `user_lesson_pk`
        PRIMARY KEY (`user_lesson_id`),
    CONSTRAINT `user_lesson_user_fk`
        FOREIGN KEY (`user_id`) 
        REFERENCES `users`(`user_id`),
    CONSTRAINT `user_lesson_lesson_fk`
        FOREIGN KEY (`lesson_id`) 
        REFERENCES `lessons`(`lesson_id`),
    CONSTRAINT `user_lesson_unique`
        UNIQUE KEY (`user_id`, `lesson_id`)
);

DROP TABLE IF EXISTS `course_category`;
CREATE TABLE IF NOT EXISTS `course_category`(
    `course_category_id`            INT NOT NULL AUTO_INCREMENT,
    `course_id`                     INT NOT NULL,
    `category_id`                   INT NOT NULL,
    `course_category_created_at`    TIMESTAMP NOT NULL DEFAULT NOW(),
    `course_category_modified_at`   TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `course_category_active`        BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `course_category_pk`
        PRIMARY KEY (`course_category_id`),
    CONSTRAINT `course_category_course_fk`
        FOREIGN KEY (`course_id`) 
        REFERENCES `courses`(`course_id`),
    CONSTRAINT `course_category_category_fk`
        FOREIGN KEY (`category_id`) 
        REFERENCES `categories`(`category_id`)
);

DROP TABLE IF EXISTS `chats`;
CREATE TABLE IF NOT EXISTS `chats`(
    `chat_id`                       INT NOT NULL AUTO_INCREMENT,
    `chat_last_message`             VARCHAR(255) DEFAULT NULL,
    `chat_last_message_at`          DATETIME DEFAULT NULL,
    `chat_created_at`               TIMESTAMP NOT NULL DEFAULT NOW(),
    `chat_modified_at`              TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `chat_active`                   BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `chat_pk`
        PRIMARY KEY (`chat_id`)
);

DROP TABLE IF EXISTS `chat_participants`;
CREATE TABLE IF NOT EXISTS `chat_participants`(
    `chat_participant_id`           INT NOT NULL AUTO_INCREMENT,
    `user_id`                       INT NOT NULL,
    `chat_id`                       INT NOT NULL,
    `chat_participant_created_at`   TIMESTAMP NOT NULL DEFAULT NOW(),
    `chat_participant_modified_at`  TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `chat_participant_active`       BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `chat_participant_pk`
        PRIMARY KEY (`chat_participant_id`),
    CONSTRAINT `chat_participant_user_fk`
        FOREIGN KEY (`user_id`) 
        REFERENCES `users`(`user_id`),
    CONSTRAINT `chat_participant_chat_fk`
        FOREIGN KEY (`chat_id`) 
        REFERENCES `chats`(`chat_id`)
);

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages`(
    `message_id`                    INT NOT NULL AUTO_INCREMENT,
    `user_id`                       INT NOT NULL,
    `chat_id`                       INT NOT NULL,
    `message_content`               VARCHAR(255) NOT NULL,
    `message_created_at`            TIMESTAMP NOT NULL DEFAULT NOW(),
    `message_modified_at`           TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `message_active`                BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `message_pk`
        PRIMARY KEY (`message_id`),
    CONSTRAINT `message_user_fk`
        FOREIGN KEY (`user_id`) 
        REFERENCES `users`(`user_id`),
    CONSTRAINT `message_chat_fk`
        FOREIGN KEY (`chat_id`) 
        REFERENCES `chats`(`chat_id`)
);

DROP TABLE IF EXISTS `messages_views`;
CREATE TABLE IF NOT EXISTS `message_views`(
    `message_view_id`               INT NOT NULL AUTO_INCREMENT,
    `message_id`                    INT NOT NULL,
    `user_id`                       INT NOT NULL,
    `viewed_at`                     TIMESTAMP NOT NULL DEFAULT NOW(),
    CONSTRAINT `message_view_pk`
        PRIMARY KEY (`message_view_id`),
    CONSTRAINT `message_view_message_fk`
        FOREIGN KEY (`message_id`) 
        REFERENCES `messages`(`message_id`),
    CONSTRAINT `message_view_user_fk`
        FOREIGN KEY (`user_id`) 
        REFERENCES `users`(`user_id`)
);
DELIMITER $$
DROP FUNCTION IF EXISTS `get_course_completion_percentage` $$
CREATE FUNCTION `get_course_completion_percentage`(
    `_course_id`                        INT
) 
RETURNS DECIMAL(5, 2)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE completion DECIMAL(5, 2);
  
    SELECT 
        AVG(ule.`user_lesson_is_complete`) * 100 
    INTO completion
    FROM
        `courses` AS c
    LEFT JOIN 
        `enrollments` AS e ON c.`course_id` = e.`course_id`
    INNER JOIN 
        `levels` AS l ON c.`course_id` = l.`course_id`
    INNER JOIN 
        `lessons` AS le ON l.`level_id` = le.`level_id`
    INNER JOIN 
        `user_lesson` AS ule ON le.`lesson_id` = ule.`lesson_id` 
        AND e.`student_id` = ule.`user_id`
    WHERE 
        c.`course_id` = `_course_id`
        AND c.`course_active` = TRUE 
        AND c.`course_approved` = TRUE;
  
  RETURN completion;
END $$
DELIMITER ;



DELIMITER $$
DROP FUNCTION IF EXISTS `get_user_course_completion` $$
CREATE FUNCTION `get_user_course_completion`(
    `_user_id`                          INT,
    `_course_id`                        INT
) 
RETURNS FLOAT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE course_completion FLOAT;

    SELECT 
        AVG(ule.`user_lesson_is_complete`) * 100
    INTO course_completion
        FROM `user_lesson` AS ule
    INNER JOIN 
        `lessons` AS le ON ule.`lesson_id` = le.`lesson_id` AND le.lesson_active = TRUE
    INNER JOIN 
        `levels` AS l ON le.`level_id` = l.`level_id` AND l.level_active = TRUE
    WHERE 
        `user_id` = `_user_id` 
        AND l.`course_id` = `_course_id`;

  RETURN course_completion;
END $$
DELIMITER ;



DELIMITER $$
DROP FUNCTION IF EXISTS `get_course_video_duration` $$
CREATE FUNCTION `get_course_video_duration`(
    `_course_id`                        INT
) 
RETURNS DECIMAL(10, 2)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE total_duration DECIMAL(10, 2);
    
    SELECT 
        SUM(TIME_TO_SEC(v.`video_duration`)) / 3600.0
    INTO 
        total_duration
    FROM 
        `courses` AS c
    INNER JOIN 
        `levels` AS l ON c.`course_id` = l.`course_id` 
        AND l.`level_active` = TRUE
    INNER JOIN 
        `lessons` AS le ON l.`level_id` = le.`level_id` 
        AND le.`lesson_active` = TRUE
    LEFT JOIN 
        `videos` AS v ON le.`video_id` = v.`video_id` 
        AND v.`video_active` = TRUE
    WHERE 
        c.`course_id` = `_course_id`;
        
    RETURN total_duration;
END $$
DELIMITER ;
-- Busca el recurso de mayor prioridad que este existente
DELIMITER $$
DROP FUNCTION IF EXISTS `find_main_resource` $$
CREATE FUNCTION `find_main_resource`(
    `_lesson_id`                        INT
)
RETURNS VARCHAR(50)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE main_resource VARCHAR(50);
    
    SELECT CASE
        WHEN `video_id` IS NOT NULL THEN 'video'
        WHEN `image_id` IS NOT NULL THEN 'image'
        WHEN `document_id` IS NOT NULL THEN 'document'
        WHEN `link_id` IS NOT NULL THEN 'link'
        ELSE NULL
    END INTO main_resource
    FROM `lessons`
    WHERE `lesson_id` = `_lesson_id`;
    
    RETURN main_resource;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `category_create` $$
CREATE PROCEDURE `category_create`(
    IN  `_name`                         VARCHAR(50),
    IN  `_description`                  VARCHAR(255),
    IN  `_created_by`                   INT,
    OUT `_category_id`                  INT
)
BEGIN
    INSERT INTO `categories`(
        `category_name`,
        `category_description`,
        `category_created_by`
    )
    VALUES(
        `_name`,
        `_description`,
        `_created_by`
    );
    SET `_category_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `category_update` $$
CREATE PROCEDURE `category_update`(
    IN `_category_id`                   INT,
    IN `_category_name`                 VARCHAR(50),
    IN `_category_description`          VARCHAR(255),
    IN `_category_is_approved`          BOOLEAN,
    IN `_category_approved_by`          INT,
    IN `_category_created_by`           INT,
    IN `_category_created_at`           TIMESTAMP,
    IN `_category_modified_at`          TIMESTAMP,
    IN `_category_active`               BOOLEAN
)
BEGIN
    UPDATE
        `categories`
    SET
        `category_name`                 = IFNULL(`_category_name`, `category_name`),
        `category_description`          = IFNULL(`_category_description`, `category_description`),
        `category_is_approved`          = IFNULL(`_category_is_approved`, `category_is_approved`),
        `category_approved_by`          = IFNULL(`_category_approved_by`, `category_approved_by`),
        `category_created_by`           = IFNULL(`_category_created_by`, `category_created_by`),
        `category_created_at`           = IFNULL(`_category_created_at`, `category_created_at`),
        `category_modified_at`          = NOW(),
        `category_active`               = IFNULL(`_category_active`, `category_active`)
    WHERE
        `category_id` = `_category_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_by_id` $$
CREATE PROCEDURE `category_find_by_id`(
    IN `_category_id`                   INT
)
BEGIN
    SELECT
        `category_id`                   AS `id`,
        `category_name`                 AS `name`,
        `category_description`          AS `description`,
        `category_is_approved`          AS `approved`,
        `category_approved_by`          AS `approvedBy`,
        `category_created_by`           AS `createdBy`,
        `category_created_at`           AS `createdAt`,
        `category_modified_at`          AS `modifiedAt`,
        `category_active`               AS `active`
    FROM
        `categories`
    WHERE
        `category_id` = `_category_id`
        AND `category_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;


-- Busca todas las categorías que han sido aprobadas
DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_all` $$
CREATE PROCEDURE `category_find_all`()
BEGIN
    SELECT
        `category_id`                   AS `id`,
        `category_name`                 AS `name`,
        `category_description`          AS `description`,
        `category_is_approved`          AS `approved`,
        `category_approved_by`          AS `approvedBy`,
        `category_created_by`           AS `createdBy`,
        `category_created_at`           AS `createdAt`,
        `category_modified_at`          AS `modifiedAt`,
        `category_active`               AS `active`
    FROM
        `categories`
    WHERE
        `category_active` = TRUE
        AND `category_is_approved` = TRUE;
END $$
DELIMITER ;


-- Busca todas las categorías aprobadas + las creadas por un usuario
DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_all_by_user` $$
CREATE PROCEDURE `category_find_all_by_user`(
    IN `_user_id`                       INT
)
BEGIN
    SELECT
        `category_id`                   AS `id`,
        `category_name`                 AS `name`,
        `category_description`          AS `description`,
        `category_is_approved`          AS `approved`,
        `category_approved_by`          AS `approvedBy`,
        `category_created_by`           AS `createdBy`,
        `category_created_at`           AS `createdAt`,
        `category_modified_at`          AS `modifiedAt`,
        `category_active`               AS `active`
    FROM
        `categories`
    WHERE
        `category_active` = TRUE
        AND (`category_is_approved` = TRUE
        OR `category_created_by` = `_user_id`);
END $$
DELIMITER ;


-- Busca todas las categorías de un curso
DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_all_by_course` $$
CREATE PROCEDURE `category_find_all_by_course`(
    IN `_course_id`                     INT
)
BEGIN
    SELECT
        c.`category_id`                 AS `id`,
        c.`category_name`               AS `name`,
        c.`category_description`        AS `description`,
        c.`category_is_approved`        AS `approved`,
        c.`category_approved_by`        AS `approvedBy`,
        c.`category_created_at`         AS `createdAt`,
        c.`category_modified_at`        AS `modifiedAt`,
        c.`category_active`             AS `active`
    FROM
        `categories` AS c
    INNER JOIN
        `course_category` AS cc
    ON
        c.`category_id` = cc.`category_id` 
        AND cc.`course_category_active` = TRUE
    WHERE
        cc.`course_id` = `_course_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_all_not_active` $$
CREATE PROCEDURE `category_find_all_not_active`()
BEGIN
    SELECT
        c.`category_id`                 AS `id`,
        c.`category_name`               AS `name`,
        c.`category_description`        AS `description`,
        c.`category_is_approved`        AS `isApproved`,
        c.`category_approved_by`        AS `approvedBy`,
        c.`category_created_by`         AS `createdBy`,
        c.`category_created_at`         AS `createdAt`,
        c.`category_modified_at`        AS `modifiedAt`,
        c.`category_active`             AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `user`
    FROM
        `categories` AS c
    INNER JOIN
        `users` AS u
    ON
        c.`category_created_by` = u.`user_id`
    WHERE
        c.`category_active` = FALSE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_all_not_approved` $$
CREATE PROCEDURE `category_find_all_not_approved`()
BEGIN
    SELECT
        c.`category_id`                 AS `id`,
        c.`category_name`               AS `name`,
        c.`category_description`        AS `description`,
        c.`category_is_approved`        AS `isApproved`,
        c.`category_approved_by`        AS `approvedBy`,
        c.`category_created_by`         AS `createdBy`,
        c.`category_created_at`         AS `createdAt`,
        c.`category_modified_at`        AS `modifiedAt`,
        c.`category_active`             AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `user`
    FROM
        `categories` AS c
    INNER JOIN
        `users` AS u
    ON
        c.`category_created_by` = u.`user_id`
    WHERE
        `category_is_approved` = FALSE
        AND `category_approved_by` IS NULL
        AND `category_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `category_find_one_by_name` $$
CREATE PROCEDURE `category_find_one_by_name`(
    IN `_category_name`                 VARCHAR(50),
    IN `_category_id`                   INT
)
BEGIN
    SELECT
        `category_id`                   AS `id`,
        `category_name`                 AS `name`,
        `category_description`          AS `description`,
        `category_is_approved`          AS `approved`,
        `category_approved_by`          AS `approvedBy`,
        `category_created_by`           AS `createdBy`,
        `category_created_at`           AS `createdAt`,
        `category_modified_at`          AS `modifiedAt`,
        `category_active`               AS `active`
    FROM
        `categories`
    WHERE
        `category_name` = `_category_name`
        AND `category_active` = TRUE
        AND `category_id` <> `_category_id`
    LIMIT
        1;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `chat_insert` $$
CREATE PROCEDURE `chat_insert`()
BEGIN
    INSERT INTO `chats` VALUES();
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `find_chat` $$
CREATE PROCEDURE `find_chat`(
    IN `_user_one`                      INT,
    IN `_user_two`                      INT
)
BEGIN
    SET @chat_id = (
        SELECT
            c.`chat_id` AS `chatId`
        FROM
            `chats` AS c
        LEFT JOIN
            `chat_participants` AS cp
        ON
            c.`chat_id` = cp.`chat_id`
        WHERE
            cp.`user_id` = `_user_one`
            OR cp.`user_id` = `_user_two`
        GROUP BY
            c.`chat_id`
        HAVING
            COUNT(cp.`user_id`) >= 2
        LIMIT
            1
    );

    IF @chat_id IS NULL THEN
        INSERT INTO `chats` VALUES();
        SET @chat_id = LAST_INSERT_ID();

        INSERT INTO `chat_participants`(`user_id`, `chat_id`)
        VALUES (`_user_one`, @chat_id), (`_user_two`, @chat_id);
    END IF;

    SELECT @chat_id AS `chatId`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `find_all_by_user` $$
CREATE PROCEDURE `find_all_by_user`(
    IN `_user_id`                       INT
)
BEGIN
    SELECT
        c.`chat_id`                     AS `id`, 
        cp.`user_id`                    AS `userId`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `user`,
        u.`profile_picture`             AS `profilePicture`,
        (
            SELECT 
                COUNT(m.`message_id`) 
            FROM 
                `messages` m 
            WHERE 
                m.`chat_id` = c.`chat_id` 
                AND m.`user_id` != `_user_id` 
                AND NOT EXISTS (
                    SELECT 
                        1 
                    FROM 
                        `message_views` mv 
                    WHERE 
                        mv.`message_id` = m.`message_id` 
                        AND mv.`user_id` = `_user_id`
                )
        ) AS `unseenMessagesCount`,
        (
            SELECT 
                `message_content`
            FROM 
                `messages` m2
            WHERE 
                m2.`chat_id` = c.`chat_id`
            ORDER BY 
                `message_created_at` DESC
            LIMIT 
                1
        ) AS `lastMessageContent`,
        (
            SELECT 
                m.`message_created_at` 
            FROM 
                `messages` m 
            WHERE 
                m.`chat_id` = c.`chat_id` 
            ORDER BY 
                m.`message_created_at` DESC 
            LIMIT 
                1
        ) AS `lastMessageCreatedAt`
    FROM 
        `chats` AS c 
    INNER JOIN 
        `chat_participants` AS cp 
    ON 
        c.`chat_id` = cp.`chat_id`
    INNER JOIN 
        `users` AS u 
    ON
        cp.`user_id` = u.`user_id`
    WHERE
        c.`chat_id` IN (
            SELECT 
                `chat_id` 
            FROM 
                `chat_participants` 
            WHERE 
                user_id = `_user_id`
        )
        AND cp.`user_id` != `_user_id`
    ORDER BY
        ISNULL(`lastMessageCreatedAt`) DESC, 
        `lastMessageCreatedAt` DESC;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `course_category_create` $$
CREATE PROCEDURE `course_category_create`(
    IN  `_course_id`                    INT,
    IN  `_category_id`                  INT,
    OUT `_course_category_id`           INT
)
BEGIN
    INSERT INTO `course_category`(
        `course_id`,
        `category_id`
    )
    VALUES(
        `_course_id`,
        `_category_id`
    );
    SET `_course_category_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_category_delete_by_course` $$
CREATE PROCEDURE `course_category_delete_by_course`(
    IN `_course_id`                     INT
)
BEGIN
    UPDATE
        `course_category`
    SET
        `course_category_active` = FALSE,
        `course_category_modified_at` = NOW()
    WHERE
        `course_id` = `_course_id`;
END $$
DELIMITER ;
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
DELIMITER $$
DROP PROCEDURE IF EXISTS `document_create` $$
CREATE PROCEDURE `document_create`(
    IN  `_document_name`                VARCHAR(255),
    IN  `_document_content_type`        VARCHAR(30),
    IN  `_document_address`             VARCHAR(255),
    OUT `_document_id`                  INT
)
BEGIN
    INSERT INTO `documents`(
        `document_name`,
        `document_content_type`,
        `document_address`
    )
    VALUES(
        `_document_name`,
        `_document_content_type`,
        `_document_address`
    );
    SET `_document_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `document_update` $$
CREATE PROCEDURE `document_update`(
    IN `_document_id`                   INT,
    IN `_document_name`                 VARCHAR(255),
    IN `_document_content_type`         VARCHAR(30),
    IN `_document_address`              VARCHAR(255),
    IN `_document_created_at`           TIMESTAMP,
    IN `_document_modified_at`          TIMESTAMP,
    IN `_document_active`               BOOLEAN
)
BEGIN
    UPDATE
        `documents`
    SET
        `document_name`                 = IFNULL(`_document_name`, `document_name`),
        `document_content_type`         = IFNULL(`_document_content_type`, `document_content_type`),
        `document_address`              = IFNULL(`_document_address`, `document_address`),
        `document_created_at`           = IFNULL(`_document_created_at`, `document_created_at`),
        `document_modified_at`          = NOW(),
        `document_active`               = IFNULL(`_document_active`, `document_active`)
    WHERE
        `document_id` = `_document_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `document_find_by_id` $$
CREATE PROCEDURE `document_find_by_id`(
    IN `_document_id`                   INT
)
BEGIN
    SELECT
        `document_id`                   AS `id`,
        `document_name`                 AS `name`,
        `document_content_type`         AS `contentType`,
        `document_address`              AS `address`,
        `document_created_at`           AS `createdAt`,
        `document_modified_at`          AS `modifiedAt`,
        `document_active`               AS `active`
    FROM
        `documents`
    WHERE
        `document_id` = `_document_id`
        AND `document_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `enrollment_find_one_by_course_and_student` $$
CREATE PROCEDURE `enrollment_find_one_by_course_and_student`(
    IN `_course_id`                     INT,
    IN `_student_id`                    INT
)
BEGIN
    SELECT
        `enrollment_id` AS `id`,
        `course_id` AS `courseId`,
        `student_id` AS `studentId`,
        `enrollment_is_finished` AS `isFinished`,
        `enrollment_enroll_date` AS `enrollDate`,
        `enrollment_finish_date` AS `finishDate`,
        `enrollment_certificate_uid` AS `certificateUid`,
        `enrollment_amount` AS `amount`,
        `payment_method_id` AS `paymentMethod`,
        `enrollment_is_paid` AS `isPaid`,
        `enrollment_last_time_checked` AS `lastTimeChecked`,
        `enrollment_created_at` AS `createdAt`,
        `enrollment_modified_at` AS `modifiedAt`,
        `enrollment_active` AS `active`
    FROM
        `enrollments`
    WHERE
        `course_id` = `_course_id`
        AND `student_id` = `_student_id`
    LIMIT
        1;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `enrollment_pay` $$
CREATE PROCEDURE `enrollment_pay`(
    IN  `_course_id`                    INT,
    IN  `_student_id`                   INT,
    IN  `_amount`                       DECIMAL(10,2),
    IN  `_payment_method_id`            INT,
    OUT `_enrollment_id`                INT
)
BEGIN
    DECLARE num_rows INT;
    SELECT COUNT(`enrollment_id`) INTO num_rows FROM `enrollments` WHERE `course_id` = `_course_id` AND `student_id` = `_student_id`;
    IF num_rows = 0 THEN
        INSERT INTO `enrollments`(
            `course_id`,
            `student_id`,
            `enrollment_amount`,
            `payment_method_id`
        )
        VALUES(
            `_course_id`,
            `_student_id`,
            `_amount`,
            `_payment_method_id`
        );
        SET `_enrollment_id` = LAST_INSERT_ID();
    ELSE
        UPDATE
            `enrollments`
        SET
            `enrollment_amount` = IFNULL(`_amount`, `enrollment_amount`),
            `payment_method_id` = IFNULL(`_payment_method_id`, `payment_method_id`)
        WHERE
            `course_id` = `_course_id`
            AND `student_id` = `_student_id`;
        SET `_enrollment_id` = (SELECT `enrollment_id` FROM `enrollments` WHERE `course_id` = `_course_id` AND `student_id` = `_student_id` LIMIT 1);
    END IF;

    UPDATE
        `enrollments`
    SET
        `enrollment_is_paid` = CASE WHEN `enrollment_amount` IS NOT NULL AND `payment_method_id` IS NOT NULL THEN true ELSE false END
    WHERE
        `course_id` = `_course_id`
        AND `student_id` = `_student_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `complete_lesson` $$
CREATE PROCEDURE `complete_lesson`(
    IN _user_id             INT,
    IN _lesson_id           INT
)
BEGIN
    DECLARE _level_id INT;
    DECLARE _course_id INT;
    DECLARE is_level_complete BOOLEAN;
    DECLARE is_course_complete BOOLEAN;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    -- Iniciar la transacción
    START TRANSACTION;

    -- Completa la lección
    UPDATE 
        `user_lesson`
    SET 
        `user_lesson_is_complete` = TRUE,
        `user_lesson_complete_at` = COALESCE(`user_lesson_complete_at`, NOW())
    WHERE 
        `lesson_id` = _lesson_id 
        AND `user_id` = _user_id;

    -- Buscar el id del nivel al que pertenece esa lección
    SELECT 
        le.level_id INTO _level_id 
    FROM 
        `user_lesson` AS ule
    INNER JOIN 
        `lessons` AS le
    ON 
        ule.lesson_id = le.lesson_id
    WHERE 
        ule.lesson_id = _lesson_id 
        AND ule.user_id = _user_id
    LIMIT
        1;

    -- Buscar todas las lecciones de ese nivel
    -- De todas las lecciones de ese nivel checar si todas estan en complete
    SELECT SUM(ule.user_lesson_is_complete) = COUNT(ule.user_lesson_is_complete)
    INTO is_level_complete
    FROM `lessons` AS le
    INNER JOIN `user_lesson` AS ule
    ON le.lesson_id = ule.lesson_id
    WHERE le.level_id = _level_id AND ule.user_id = _user_id;

    -- Si devuelve 1 entonces actualizamos el user_level
    IF (is_level_complete = 1) THEN
        UPDATE
            `user_level`
        SET
            `user_level_is_complete` = TRUE,
            `user_level_complete_at` = COALESCE(`user_level_complete_at`, NOW())
        WHERE
            `user_id` = _user_id
            AND `level_id` = _level_id;
    END IF;

    SELECT `course_id` INTO _course_id 
    FROM `levels` AS l 
    INNER JOIN `user_level` AS ul 
    ON l.level_id = ul.level_id
    WHERE ul.level_id = _level_id AND ul.user_id = _user_id; 

    -- Buscar todos los niveles de ese curso
    SELECT SUM(ul.user_level_is_complete) = COUNT(ul.user_level_is_complete) 
    INTO is_course_complete
    FROM levels AS l
    INNER JOIN user_level AS ul
    ON l.level_id = ul.level_id
    WHERE l.course_id = _course_id AND ul.user_id = _user_id;

    -- Actualizar el enrollment
    IF (is_course_complete = 1) THEN
        UPDATE
            `enrollments`
        SET
            `enrollment_is_finished` = TRUE,
            `enrollment_finish_date` = COALESCE(`enrollment_finish_date`, NOW()),
            `enrollment_certificate_uid` = COALESCE(`enrollment_certificate_uid`, UUID())
        WHERE
            `course_id` = _course_id
            AND `student_id` = _user_id;
    END IF;

    COMMIT;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `visit_lesson` $$
CREATE PROCEDURE `visit_lesson`(
    IN _student_id                      INT,
    IN _lesson_id                       INT
)
BEGIN
    DECLARE _level_id INT;
    DECLARE _course_id INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    UPDATE
        `user_lesson`
    SET
        `user_lesson_last_time_checked` = NOW()
    WHERE
        `lesson_id` = _lesson_id
        AND `user_id` = _student_id;

    -- Buscar el nivel
    SELECT 
        le.level_id INTO _level_id 
    FROM 
        `user_lesson` AS ule
    INNER JOIN 
        `lessons` AS le
    ON 
        ule.lesson_id = le.lesson_id
    WHERE 
        ule.lesson_id = _lesson_id 
        AND ule.user_id = _student_id
    LIMIT
        1;

    UPDATE
        `user_level`
    SET
        `user_level_last_access_date` = NOW()
    WHERE
        `level_id` = _lesson_id
        AND `user_id` = _student_id;

    SELECT `course_id` INTO _course_id 
    FROM `levels` AS l 
    INNER JOIN `user_level` AS ul 
    ON l.level_id = ul.level_id
    WHERE ul.level_id = _level_id AND ul.user_id = _student_id; 

    UPDATE
        `enrollments`
    SET
        `enrollment_last_time_checked` = NOW()
    WHERE
        `course_id` = _course_id
        AND `student_id` = _student_id;

    COMMIT;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_sales_report` $$
CREATE PROCEDURE `course_sales_report`(
    IN _instructor_id                   INT,
    IN _category_id                     INT,
    IN _from                            DATE,
    IN _to                              DATE,
    IN _active                          BOOLEAN,
    IN _limit                           INT,
    IN _offset                          INT
)
BEGIN
    SELECT
        `course_id`                     AS `id`,
        `course_title`                  AS `title`,
        `course_image_id`               AS `imageId`,
        `enrollments`,
        `amount`,
        `average_level`                 AS `averageLevel`,
        `instructor_id`                 AS `instructor_id`,
        `course_created_at`             AS `createdAt`
    FROM
        `instructor_courses`            AS ic
    WHERE
        `instructor_id` = _instructor_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND (`course_active` = TRUE OR _active = FALSE)
        AND (`course_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = ic.`course_id` 
            AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL)
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `course_sales_report_total` $$
CREATE PROCEDURE `course_sales_report_total`(
    IN _instructor_id                   INT,
    IN _category_id                     INT,
    IN _from                            DATE,
    IN _to                              DATE,
    IN _active                          BOOLEAN
)
BEGIN
    SELECT
        IFNULL(COUNT(`course_id`), 0)   AS `total`
    FROM
        `instructor_courses` AS ic
    WHERE
        `instructor_id` = _instructor_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND (`course_active` = TRUE OR _active = FALSE)
        AND (`course_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = ic.`course_id` 
            AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL);
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `instructor_courses_seen_by_others_report` $$
CREATE PROCEDURE `instructor_courses_seen_by_others_report`(
    IN _instructor_id                   INT,
    IN _limit                           INT,
    IN _offset                          INT
)
BEGIN
    SELECT
        `course_id`                     AS `id`,
        `course_title`                  AS `title`,
        `course_image_id`               AS `imageId`,
        `course_price`                  AS `price`,
        `enrollments`,
        `amount`,
        `rates`                         AS `rate`,
        `instructor_id`                 AS `instructor_id`,
        `course_created_at`             AS `createdAt`
    FROM
        `instructor_courses_seen_by_others`
    WHERE
        `instructor_id` = _instructor_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND `course_active` = TRUE
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `instructor_courses_seen_by_others_report_total` $$
CREATE PROCEDURE `instructor_courses_seen_by_others_report_total`(
    IN _instructor_id                   INT
)
BEGIN
    SELECT
        IFNULL(COUNT(`course_id`), 0) AS `total`
    FROM
        `instructor_courses_seen_by_others`
    WHERE
        `instructor_id` = _instructor_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND `course_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `kardex_report` $$
CREATE PROCEDURE `kardex_report`(
    IN _student_id                      INT,
    IN _from                            DATE,
    IN _to                              DATE,
    IN _category_id                     INT,
    IN _complete                        BOOLEAN,
    IN _active                          BOOLEAN,
    IN _limit                           INT,
    IN _offset                          INT
)
BEGIN
    SELECT
        `course_id`                     AS `id`,
        `course_title`                  AS `title`,
        `course_image_id`               AS `imageId`,
        `student_id`                    AS `studentId`,
        --`enrollment_enroll_date` AS `enrollDate`,
        `enrollment_created_at`         AS `enrollDate`,
        `enrollment_last_time_checked`  AS `lastTimeChecked`,
        `enrollment_finish_date`        AS `finishDate`,
        `enrollment_is_finished`        AS `isFinished`,
        `enrollment_status`             AS `status`,
        `enrollment_certificate_uid`    AS `certificateUid`,
        `enrollment_progress`           AS `progress`
    FROM
        `kardex` AS k
    WHERE
        `student_id` = _student_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND (`enrollment_is_finished` = TRUE OR _complete = FALSE)
        AND (`course_active` = TRUE OR _active = FALSE)
        AND (`enrollment_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = k.`course_id` 
            AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL
        )
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `kardex_report_total` $$
CREATE PROCEDURE `kardex_report_total`(
    IN _student_id                      INT,
    IN _from                            DATE,
    IN _to                              DATE,
    IN _category_id                     INT,
    IN _complete                        BOOLEAN,
    IN _active                          BOOLEAN
)
BEGIN
    SELECT
        IFNULL(COUNT(`course_id`), 0) AS `total`
    FROM
        `kardex` AS k
    WHERE
        `student_id` = _student_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND (`enrollment_is_finished` = TRUE OR _complete = FALSE)
        AND (`course_active` = TRUE OR _active = FALSE)
        AND (`course_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = k.`course_id` 
            AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL
        );
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_enrollments_report` $$
CREATE PROCEDURE `course_enrollments_report`(
    IN _course_id                       INT,
    IN _from                            DATE,
    IN _to                              DATE,
    IN _limit                           INT,
    IN _offset                          INT
)
BEGIN
    SELECT 
        ce.`course_id` AS `courseId`,
        ce.`user_id` AS `userId`,
        CONCAT(ce.`user_name`, ' ', ce.`user_last_name`) AS `username`,
        ce.`profile_picture` AS `profilePicture`,
        ce.`enrollment_enroll_date` AS `enrollmentDate`,
        ce.`enrollment_created_at` AS `createdAt`,
        ce.`enrollment_amount` AS `amount`,
        ce.`payment_method_name` AS `paymentMethodName`,
        ce.`percentage_complete` AS `percentageComplete`
    FROM
        `course_enrollments` AS ce
    WHERE
        ce.`course_id` = _course_id
        AND (ce.`enrollment_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_enrollments_report_total` $$
CREATE PROCEDURE `course_enrollments_report_total`(
    IN _course_id                       INT,
    IN _from                            DATE,
    IN _to                              DATE
)
BEGIN
    SELECT 
        COUNT(ce.`course_id`) AS `total`
    FROM
        `course_enrollments` AS ce
    WHERE
        ce.`course_id` = _course_id
        AND (ce.`enrollment_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'));
END $$
DELIMITER ;


-- Bien hecho
DELIMITER $$
DROP PROCEDURE IF EXISTS `certificate_find_one` $$
CREATE PROCEDURE `certificate_find_one`(
    IN `_student_id`                    INT,
    IN `_course_id`                     INT
)
BEGIN
    SELECT
        `student`,
        `instructor`,
        `course_title` AS `course`,
        `enrollment_finish_date` AS `finishDate`,
        `enrollment_certificate_uid` AS `certificateId`
    FROM
        `certificate`
    WHERE
        `student_id` = `_student_id`
        AND `course_id` = `_course_id`
    LIMIT
        1;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `image_create` $$
CREATE PROCEDURE `image_create`(
    IN  `_image_name`                   VARCHAR(255),
    IN  `_image_size`                   INT,
    IN  `_image_content_type`           VARCHAR(30),
    IN  `_image_data`                   MEDIUMBLOB,
    OUT `_image_id`                     INT
)
BEGIN
    INSERT INTO `images`(
        `image_name`,
        `image_size`,
        `image_content_type`,
        `image_data`
    )
    VALUES(
        `_image_name`,
        `_image_size`,
        `_image_content_type`,
        `_image_data`
    );
    SET `_image_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `image_update` $$
CREATE PROCEDURE `image_update`(
    IN `_image_id`                      INT,
    IN `_image_name`                    VARCHAR(255),
    IN `_image_size`                    INT,
    IN `_image_content_type`            VARCHAR(30),
    IN `_image_data`                    MEDIUMBLOB,
    IN `_image_created_at`              TIMESTAMP,
    IN `_image_modified_at`             TIMESTAMP,
    IN `_image_active`                  BOOLEAN
)
BEGIN
    UPDATE
        `images`
    SET
        `image_name`                    = IFNULL(`_image_name`, `image_name`),
        `image_size`                    = IFNULL(`_image_size`, `image_size`),
        `image_content_type`            = IFNULL(`_image_content_type`, `image_content_type`),
        `image_data`                    = IFNULL(`_image_data`, `image_data`),
        `image_created_at`              = IFNULL(`_image_created_at`, `image_created_at`),
        `image_modified_at`             = NOW(),
        `image_active`                  = IFNULL(`_image_active`, `image_active`)
    WHERE
        `image_id` = `_image_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `image_find_by_id` $$
CREATE PROCEDURE `image_find_by_id`(
    IN `_image_id`                      INT
)
BEGIN
    SELECT
        `image_id`                      AS `id`,
        `image_name`                    AS `name`,
        `image_size`                    AS `size`,
        `image_content_type`            AS `contentType`,
        `image_data`                    AS `data`,
        `image_created_at`              AS `createdAt`,
        `image_modified_at`             AS `modifiedAt`,
        `image_active`                  AS `active`
    FROM
        `images`
    WHERE
        `image_id` = `_image_id`
        AND `image_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `image_find_one_profile_picture` $$
CREATE PROCEDURE `image_find_one_profile_picture`(
    IN `_image_id`                      INT
)
BEGIN
    SELECT
        i.`image_id`                    AS `id`,
        i.`image_name`                  AS `name`,
        i.`image_size`                  AS `size`,
        i.`image_content_type`          AS `contentType`,
        i.`image_data`                  AS `data`,
        i.`image_created_at`            AS `createdAt`,
        i.`image_modified_at`           AS `modifiedAt`,
        i.`image_active`                AS `active`
    FROM
        `images` AS i
    INNER JOIN
        `users` AS u
    ON
        i.`image_id` = u.`profile_picture`
    WHERE
        i.`image_id` = `_image_id`
        AND i.`image_active` = TRUE;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `lesson_create` $$
CREATE PROCEDURE `lesson_create`(
    IN  `_lesson_title`                 VARCHAR(50),
    IN  `_lesson_description`           VARCHAR(255),
    IN  `_level_id`                     INT,
    IN  `_video_id`                     INT,
    IN  `_image_id`                     INT,
    IN  `_document_id`                  INT,
    IN  `_link_id`                      INT,
    OUT `_lesson_id`                    INT
)
BEGIN
    INSERT INTO `lessons`(
        `lesson_title`,
        `lesson_description`,
        `level_id`,
        `video_id`,
        `image_id`,
        `document_id`,
        `link_id`
    )
    VALUES(
        `_lesson_title`,
        `_lesson_description`,
        `_level_id`,
        `_video_id`,
        `_image_id`,
        `_document_id`,
        `_link_id`
    );
    SET `_lesson_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `lesson_update` $$
CREATE PROCEDURE `lesson_update`(
    IN `_lesson_id`                     INT,
    IN `_lesson_title`                  VARCHAR(50),
    IN `_lesson_description`            VARCHAR(255),
    IN `_level_id`                      INT,
    IN `_video_id`                      INT,
    IN `_image_id`                      INT,
    IN `_document_id`                   INT,
    IN `_link_id`                       INT,
    IN `_lesson_created_at`             TIMESTAMP,
    IN `_lesson_modified_at`            TIMESTAMP,
    IN `_lesson_active`                 BOOLEAN
)
BEGIN
    UPDATE
        `lessons`
    SET
        `lesson_id`                     = IFNULL(`_lesson_id`, `lesson_id`),
        `lesson_title`                  = IFNULL(`_lesson_title`, `lesson_title`),
        `lesson_description`            = IFNULL(`_lesson_description`, `lesson_description`),
        `level_id`                      = IFNULL(`_level_id`, `level_id`),
        `video_id`                      = IFNULL(`_video_id`, `video_id`),
        `image_id`                      = IFNULL(`_image_id`, `image_id`),
        `document_id`                   = IFNULL(`_document_id`, `document_id`),
        `link_id`                       = IFNULL(`_link_id`, `link_id`),
        `lesson_created_at`             = IFNULL(`_lesson_created_at`, `lesson_created_at`),
        `lesson_modified_at`            = NOW(),
        `lesson_active`                 = IFNULL(`_lesson_active`, `lesson_active`)
    WHERE
        `lesson_id` = `_lesson_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `lesson_find_by_id` $$
CREATE PROCEDURE `lesson_find_by_id`(
    IN `_lesson_id`                     INT
)
BEGIN
    SELECT
        le.`lesson_id`                  AS `id`,
        le.`lesson_title`               AS `title`,
        le.`lesson_description`         AS `description`,
        le.`level_id`                   AS `levelId`,
        le.`video_id`                   AS `videoId`,
        le.`image_id`                   AS `imageId`,
        le.`document_id`                AS `documentId`,
        le.`link_id`                    AS `linkId`,
        le.`lesson_created_at`          AS `createdAt`,
        le.`lesson_modified_at`         AS `modifiedAt`,
        le.`lesson_active`              AS `active`,
        c.`course_id`                   AS `courseId`,
        c.`instructor_id`               AS `instructorId`,
        c.`course_is_complete`          AS `courseIsComplete`
    FROM
        `lessons` AS le
    INNER JOIN
        `levels` AS l ON le.`level_id` = l.`level_id`
    INNER JOIN
        `courses` AS c ON l.`course_id` = c.`course_id`
    WHERE
        `lesson_id` = `_lesson_id`
        AND `lesson_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `lesson_find_by_level` $$
CREATE PROCEDURE `lesson_find_by_level`(
    IN `_level_id`                      INT
)
BEGIN
    SELECT
        `lesson_id`                     AS `id`,
        `lesson_title`                  AS `title`,
        `lesson_description`            AS `description`,
        `level_id`                      AS `levelId`,
        `video_id`                      AS `videoId`,
        `image_id`                      AS `imageId`,
        `document_id`                   AS `documentId`,
        `link_id`                       AS `linkId`,
        `lesson_created_at`             AS `createdAt`,
        `lesson_modified_at`            AS `modifiedAt`,
        `lesson_active`                 AS `active`
    FROM
        `lessons`
    WHERE
        `level_id` = `_level_id`
        AND `lesson_active` = TRUE;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `level_create` $$
CREATE PROCEDURE `level_create`(
    IN  `_level_title`                  VARCHAR(50),
    IN  `_level_description`            VARCHAR(255),
    IN  `_level_is_free`                BOOLEAN,
    IN  `_course_id`                    INT,
    OUT `_level_id`                     INT
)
BEGIN
    INSERT INTO `levels`(
        `level_title`,
        `level_description`,
        `level_is_free`,
        `course_id`
    )
    VALUES(
        `_level_title`,
        `_level_description`,
        `_level_is_free`,
        `_course_id`
    );
    SET `_level_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `level_update` $$
CREATE PROCEDURE `level_update`(
    IN `_level_id`                      INT,
    IN `_level_title`                   VARCHAR(50),
    IN `_level_description`             VARCHAR(255),
    IN `_level_is_free`                 BOOLEAN,
    IN `_course_id`                     INT,
    IN `_level_created_at`              TIMESTAMP,
    IN `_level_modified_at`             TIMESTAMP,
    IN `_level_active`                  BOOLEAN
)
BEGIN
    UPDATE
        `levels`
    SET
        `level_title`                   = IFNULL(`_level_title`, `level_title`),
        `level_description`             = IFNULL(`_level_description`, `level_description`),
        `level_is_free`                 = IFNULL(`_level_is_free`, `level_is_free`),
        `course_id`                     = IFNULL(`_course_id`, `course_id`),
        `level_created_at`              = IFNULL(`_level_created_at`, `level_created_at`),
        `level_modified_at`             = NOW(),
        `level_active`                  = IFNULL(`_level_active`, `level_active`)
    WHERE
        `level_id` = `_level_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `level_find_by_id` $$
CREATE PROCEDURE `level_find_by_id`(
    IN `_level_id`                      INT
)
BEGIN
    SELECT
        l.`level_id`                    AS `id`,
        l.`level_title`                 AS `title`,
        l.`level_description`           AS `description`,
        l.`level_is_free`               AS `free`,
        l.`course_id`                   AS `courseId`,
        l.`level_created_at`            AS `createdAt`,
        l.`level_modified_at`           AS `modifiedAt`,
        l.`level_active`                AS `active`,
        c.`instructor_id`               AS `instructorId`,
        c.`course_is_complete`          AS `courseIsComplete`
    FROM
        `levels` AS l
    INNER JOIN
        `courses` AS c ON l.`course_id` = c.`course_id`
    WHERE
        `level_id` = `_level_id`
        AND `level_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `level_find_by_course` $$
CREATE PROCEDURE `level_find_by_course`(
    IN `_course_id`                     INT
)
BEGIN
    SELECT
        `level_id`                      AS `id`,
        `level_title`                   AS `title`,
        `level_description`             AS `description`,
        `level_is_free`                 AS `free`,
        `course_id`                     AS `courseId`,
        `level_created_at`              AS `createdAt`,
        `level_modified_at`             AS `modifiedAt`,
        `level_active`                  AS `active`
    FROM
        `levels`
    WHERE
        `course_id` = `_course_id`
        AND `level_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `level_find_user_complete` $$
CREATE PROCEDURE `level_find_user_complete`(
    IN _course_id                       INT,
    IN _user_id                         INT
)
BEGIN
    SELECT
        l.level_id AS `id`,   
        l.level_title AS `title`, 
        l.level_description AS `description`,
        l.level_is_free AS `free`,
        l.course_id AS `courseId`,
        l.level_created_at AS `createdAt`,
        l.level_modified_at AS `modifiedAt`,
        l.level_active AS `active`,
        ul.user_level_is_complete AS `isComplete`,
        ul.user_level_complete_at AS `completeAt`,
        CONCAT('[', GROUP_CONCAT(
            JSON_OBJECT(
                'id', le.lesson_id,
                'title', le.lesson_title,
                'description', le.lesson_description,
                'mainResource', find_main_resource(le.lesson_id),
                'isComplete', ule.user_lesson_is_complete,
                'completeAt', ule.user_lesson_complete_at,
                'videoDuration', IF(v.video_duration >= 3600, v.video_duration, RIGHT(v.video_duration, 5))
            )
        ), ']') AS `lessons`
    FROM `levels` AS l
    INNER JOIN `user_level` AS ul
    ON l.level_id = ul.level_id AND ul.user_id = _user_id
    INNER JOIN `lessons` AS le
    ON l.level_id = le.level_id AND le.lesson_active = TRUE
    INNER JOIN `user_lesson` AS ule
    ON le.lesson_id = ule.lesson_id AND ule.user_id = _user_id
    LEFT JOIN `videos` AS v
    ON le.video_id = v.video_id
    WHERE l.course_id = _course_id
    GROUP BY
        l.level_id;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `link_create` $$
CREATE PROCEDURE `link_create`(
    IN  `_link_name`                    VARCHAR(255),
    IN  `_link_address`                 VARCHAR(255),
    OUT `_link_id`                      INT
)
BEGIN
    INSERT INTO `links`(
        `link_name`,
        `link_address`
    )
    VALUES(
        `_link_name`,
        `_link_address`
    );
    SET `_link_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `link_update` $$
CREATE PROCEDURE `link_update`(
    IN `_link_id`                       INT,
    IN `_link_name`                     VARCHAR(255),
    IN `_link_address`                  VARCHAR(255),
    IN `_link_created_at`               TIMESTAMP,
    IN `_link_modified_at`              TIMESTAMP,
    IN `_link_active`                   BOOLEAN
)
BEGIN
    UPDATE
        `links`
    SET
        `link_name`                     = IFNULL(`_link_name`, `link_name`),
        `link_address`                  = IFNULL(`_link_address`, `link_address`),
        `link_created_at`               = IFNULL(`_link_created_at`, `link_created_at`),
        `link_modified_at`              = NOW(),
        `link_active`                   = IFNULL(`_link_active`, `link_active`)
    WHERE
        `link_id` = `_link_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `link_find_by_id` $$
CREATE PROCEDURE `link_find_by_id`(
    IN `_link_id`                       INT
)
BEGIN
    SELECT
        `link_id`                       AS `id`,
        `link_name`                     AS `name`,
        `link_address`                  AS `address`,
        `link_created_at`               AS `createdAt`,
        `link_modified_at`              AS `modifiedAt`,
        `link_active`                   AS `active`
    FROM
        `links`
    WHERE
        `link_id` = `_link_id`
        AND `link_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `message_create` $$
CREATE PROCEDURE `message_create`(
    IN  `_message_content`              VARCHAR(255),
    IN  `_user_id`                      INT,
    IN  `_chat_id`                      INT,
    OUT `_message_id`                   INT
)
BEGIN
    INSERT INTO `messages`(
        `message_content`,
        `user_id`,
        `chat_id`
    )
    VALUES(
        `_message_content`,
        `_user_id`,
        `_chat_id`
    );
    SET `_message_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `message_find_all_by_chat` $$
CREATE PROCEDURE `message_find_all_by_chat`(
    IN  `_chat_id`                      INT
)
BEGIN
    SELECT
        m.`message_id`                  AS `id`,
        m.`message_content`             AS `content`,
        m.`user_id`                     AS `userId`,
        m.`chat_id`                     AS `chatId`,
        m.`message_created_at`          AS `createdAt`,
        m.`message_modified_at`         AS `modifiedAt`,
        m.`message_active`              AS `active`,
        mv.`viewed_at`                  AS `viewedAt`
    FROM
        `messages` AS m
    LEFT JOIN
        `message_views` AS mv
    ON
        m.`message_id` = mv.`message_id`
    WHERE
        `chat_id` = `_chat_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `message_find_unread_messages` $$
CREATE PROCEDURE `message_find_unread_messages`(
    IN `_user_id`                       INT
)
BEGIN
    SELECT 
        COUNT(DISTINCT m.`message_id`) AS `unread_messages`
    FROM 
        `messages` AS m
    INNER JOIN 
        `chats` AS c 
    ON
        c.`chat_id` = m.`chat_id`
    INNER JOIN 
        `chat_participants` AS cp 
    ON
        cp.`chat_id` = c.`chat_id`
    LEFT JOIN 
        `message_views` AS v 
    ON
        v.`message_id` = m.`message_id` 
        AND v.`user_id` = `_user_id`
    WHERE 
        cp.`user_id` = `_user_id`
        AND m.`message_active` = TRUE
        AND v.`message_view_id` IS NULL 
        AND m.`user_id` <> `_user_id`;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `message_view_chat` $$
CREATE PROCEDURE `message_view_chat`(
    IN `_user_id`                       INT,
    IN `_chat_id`                       INT
)
BEGIN
    INSERT INTO `message_views`(
        `message_id`, 
        `user_id`
    )
    SELECT 
        m.`message_id`,
        `_user_id`
    FROM 
        `messages` m 
    WHERE 
        m.`chat_id` = `_chat_id`
        AND m.`user_id` != `_user_id`
        AND NOT EXISTS (
            SELECT 
                1 
            FROM 
                `message_views` mv 
            WHERE 
                mv.`message_id` = m.`message_id` 
                AND mv.`user_id` = `_user_id`
        );
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `payment_method_find_by_id` $$
CREATE PROCEDURE `payment_method_find_by_id`(
    IN `_payment_method_id`                 INT
)
BEGIN
    SELECT
        `payment_method_id`                 AS `id`,
        `payment_method_name`               AS `name`,
        `payment_method_created_at`         AS `createdAt`,
        `payment_method_mofified_at`        AS `modifiedAt`,
        `payment_method_active`             AS `active`
    FROM
        `payment_methods`
    WHERE
        `payment_method_id` = `_payment_method_id`
    LIMIT
        1;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `review_create` $$
CREATE PROCEDURE `review_create`(
    IN  `_review_message`               VARCHAR(255),
    IN  `_review_rate`                  TINYINT,
    IN  `_course_id`                    INT,
    IN  `_user_id`                      INT,
    OUT `_review_id`                    INT
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
    SET `_review_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `review_update` $$
CREATE PROCEDURE `review_update`(
    IN `_review_id`                     INT, 
    IN `_review_message`                VARCHAR(255), 
    IN `_review_rate`                   INT, 
    IN `_review_active`                 BOOLEAN
)
BEGIN
    UPDATE 
        `reviews`
    SET
        `review_message`                = IFNULL(`_review_message`, `review_message`),
        `review_rate`                   = IFNULL(`_review_rate`, `review_rate`),
        `review_modified_at`            = NOW(),
        `review_active`                 = IFNULL(`_review_active`, `review_active`)
    WHERE
        `review_id` = `_review_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `get_course_reviews` $$
CREATE PROCEDURE `get_course_reviews`(
    IN   `course_id`                    INT, 
    IN   `page_num`                     INT, 
    IN   `page_size`                    INT
)
BEGIN
    DECLARE offset_val INT;
    SET offset_val = (page_num - 1) * page_size;
    
    SELECT
        r.`review_id`                   AS `id`,
        r.`review_message`              AS `message`,
        r.`review_rate`                 AS `rate`,
        r.`course_id`                   AS `courseId`,
        r.`user_id`                     AS `userId`,
        r.`review_created_at`           AS `createdAt`,
        r.`review_modified_at`          AS `modifiedAt`,
        r.`review_active`               AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `userName`,
        u.`profile_picture`             AS `profilePicture`
    FROM
        `reviews` AS r
    INNER JOIN
        `users` AS u
    ON
        r.`user_id` = u.`user_id`
    WHERE
        r.`course_id` = course_id 
        AND r.`review_active` = TRUE
    ORDER BY
        r.`review_created_at` DESC
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
DROP PROCEDURE IF EXISTS `review_find_one_by_course_and_user` $$
CREATE PROCEDURE `review_find_one_by_course_and_user`(
    IN `_course_id`                     INT, 
    IN `_user_id`                       INT
)
BEGIN
    SELECT
        r.`review_id`                   AS `id`,
        r.`review_message`              AS `message`,
        r.`review_rate`                 AS `rate`,
        r.`course_id`                   AS `courseId`,
        r.`user_id`                     AS `userId`,
        r.`review_created_at`           AS `createdAt`,
        r.`review_modified_at`          AS `modifiedAt`,
        r.`review_active`               AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `userName`,
        u.`profile_picture`             AS `profilePicture`
    FROM
        `reviews` AS r
    INNER JOIN
        `users` AS u
    ON
        r.`user_id` = u.`user_id`
    WHERE
        r.`course_id` = `_course_id` 
        AND r.`review_active` = TRUE
        AND r.`user_id` = `_user_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `review_find_by_id` $$
CREATE PROCEDURE `review_find_by_id`(
    IN `_id`                            INT
)
BEGIN
    SELECT
        r.`review_id`                   AS `id`,
        r.`review_message`              AS `message`,
        r.`review_rate`                 AS `rate`,
        r.`course_id`                   AS `courseId`,
        r.`user_id`                     AS `userId`,
        r.`review_created_at`           AS `createdAt`,
        r.`review_modified_at`          AS `modifiedAt`,
        r.`review_active`               AS `active`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `userName`,
        u.`profile_picture`             AS `profilePicture`
    FROM
        `reviews` AS r
    INNER JOIN
        `users` AS u
    ON
        r.`user_id` = u.`user_id`
    WHERE
        r.`review_id` = `_id`
        AND r.`review_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `role_find_all_by_is_public` $$
CREATE PROCEDURE `role_find_all_by_is_public`(
    IN `_is_public`                     BOOLEAN
)
BEGIN
    SELECT
        `role_id`                       AS `id`,
        `role_name`                     AS `name`,
        `role_is_public`                AS `is_public`,
        `role_created_at`               AS `created_at`,
        `role_modified_at`              AS `modified_at`,
        `role_active`                   AS `active`
    FROM
        `roles`
    WHERE
        `role_is_public` = `_is_public`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `role_find_by_id_and_is_public` $$
CREATE PROCEDURE `role_find_by_id_and_is_public`(
    IN `_role_id`                       INT,
    IN `_is_public`                     BOOLEAN
)
BEGIN
    SELECT
        `role_id`                       AS `id`,
        `role_name`                     AS `name`,
        `role_is_public`                AS `is_public`,
        `role_created_at`               AS `created_at`,
        `role_modified_at`              AS `modified_at`,
        `role_active`                   AS `active`
    FROM
        `roles`
    WHERE
        `role_id` = `_role_id`
        AND `role_is_public` = `_is_public`
    LIMIT
        1;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `user_find_one_by_email` $$
CREATE PROCEDURE `user_find_one_by_email`(
    IN _email               VARCHAR(255)
)
BEGIN
    SELECT
        `user_id` AS `id`,
        `user_name` AS `name`,
        `user_last_name` AS `lastName`,
        `user_birth_date` AS `birthDate`,
        `user_gender` AS `gender`,
        `user_email` AS `email`,
        `user_password` AS `password`,
        `user_role` AS `role`,
        `profile_picture` AS `profilePicture`,
        `user_enabled` AS `enabled`,
        `user_created_at` AS `createdAt`,
        `user_modified_at` AS `modifiedAt`,
        `user_active` AS `active`
    FROM
        `users`
    WHERE
        `user_email` = _email
        AND `user_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `user_find_all` $$
CREATE PROCEDURE `user_find_all`(
    IN `_name`                  VARCHAR(255),
    IN `_role`                  INT
)
BEGIN
    SELECT
        `user_id` AS `id`, 
        `user_name` AS `name`, 
        `user_last_name` AS `lastName`, 
        `user_birth_date` AS `birthDate`, 
        `user_gender` AS `gender`, 
        `user_email` AS `email`, 
        `user_role` AS `role`,
        `profile_picture` AS `profilePicture`
    FROM
        `users`
    WHERE
        CONCAT(`user_name`, ' ', `user_last_name`) LIKE CONCAT("%", `_name`, "%")
        AND `user_role` <> `_role`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `user_find_all_instructors` $$
CREATE PROCEDURE `user_find_all_instructors`(
    IN _name                VARCHAR(255)
)
BEGIN
    SELECT
        `user_id` AS `id`, 
        `user_name` AS `name`, 
        `user_last_name` AS `lastName`, 
        `user_birth_date` AS `birthDate`, 
        `user_gender` AS `gender`, 
        `user_email` AS `email`, 
        `user_role` AS `role`,
        `profile_picture` AS `profilePicture`
    FROM
        `users`
    WHERE
        CONCAT(`user_name`, ' ', `user_last_name`) LIKE CONCAT("%", _name, "%")
        AND `user_role` = 2
        AND `user_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `user_create` $$
CREATE PROCEDURE `user_create`(
    IN  `_user_name`                VARCHAR(50),
    IN  `_user_last_name`           VARCHAR(50),
    IN  `_user_birth_date`          DATE,
    IN  `_user_gender`              ENUM('Masculino', 'Femenino', 'Otro'),
    IN  `_user_email`               VARCHAR(255),
    IN  `_user_password`            VARCHAR(255),
    IN  `_user_role`                INT,
    IN  `_profile_picture`          INT,
    OUT `_user_id`                  INT
)
BEGIN
    INSERT INTO `users`(
        `user_name`, 
        `user_last_name`, 
        `user_birth_date`,
        `user_gender`,
        `user_email`,
        `user_password`,
        `user_role`,
        `profile_picture`
    ) 
    VALUES(
        `_user_name`,
        `_user_last_name`,
        `_user_birth_date`,
        `_user_gender`,
        `_user_email`,
        `_user_password`,
        `_user_role`,
        `_profile_picture`
    );
    SET `_user_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `user_update` $$
CREATE PROCEDURE `user_update`(
    IN `_user_id`                       INT,
    IN `_user_name`                     VARCHAR(50),
    IN `_user_last_name`                VARCHAR(50),
    IN `_user_birth_date`               DATE,
    IN `_user_gender`                   ENUM('Masculino', 'Femenino', 'Otro'),
    IN `_user_email`                    VARCHAR(255),
    IN `_user_password`                 VARCHAR(255),
    IN `_user_role`                     INT,
    IN `_profile_picture`               INT,
    IN `_user_enabled`                  BOOLEAN,
    IN `_user_created_at`               TIMESTAMP,
    IN `_user_modified_at`              TIMESTAMP,
    IN `_user_active`                   BOOLEAN
)
BEGIN
    UPDATE
        `users`
    SET
        `user_id`                       = IFNULL(`_user_id`, `user_id`),
        `user_name`                     = IFNULL(`_user_name`, `user_name`),
        `user_last_name`                = IFNULL(`_user_last_name`, `user_last_name`),
        `user_birth_date`               = IFNULL(`_user_birth_date`, `user_birth_date`),
        `user_gender`                   = IFNULL(`_user_gender`, `user_gender`),
        `user_email`                    = IFNULL(`_user_email`, `user_email`),
        `user_password`                 = IFNULL(`_user_password`, `user_password`),
        `user_role`                     = IFNULL(`_user_role`, `user_role`),
        `profile_picture`               = IFNULL(`_profile_picture`, `profile_picture`),
        `user_enabled`                  = IFNULL(`_user_enabled`, `user_enabled`),
        `user_created_at`               = IFNULL(`_user_created_at`, `user_created_at`),
        `user_modified_at`              = NOW(),
        `user_active`                   = IFNULL(`_user_active`, `user_active`)
    WHERE
        `user_id` = `_user_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `user_find_by_id` $$
CREATE PROCEDURE `user_find_by_id`(
    IN `_user_id`                       INT
)
BEGIN
    SELECT 
        `user_id`                       AS `id`, 
        `user_name`                     AS `name`, 
        `user_last_name`                AS `lastName`, 
        `user_birth_date`               AS `birthDate`, 
        `user_gender`                   AS `gender`, 
        `user_email`                    AS `email`, 
        `user_password`                 AS `password`,
        `user_role`                     AS `role`, 
        `profile_picture`               AS `profilePicture`,
        `user_enabled`                  AS `enabled`,
        `user_created_at`               AS `createdAt`,
        `user_modified_at`              AS `modifiedAt`,
        `user_active`                   AS `active`
    FROM 
        `users` 
    WHERE
        `user_id` = `_user_id`
    LIMIT
        1;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `user_find_one_by_email_and_not_user_id` $$
CREATE PROCEDURE `user_find_one_by_email_and_not_user_id`(
    IN `_email`                         VARCHAR(255),
    IN `_user_id`                       INT
)
BEGIN
    SELECT 
        `user_id`                       AS `id`, 
        `user_name`                     AS `name`, 
        `user_last_name`                AS `lastName`, 
        `user_birth_date`               AS `birthDate`, 
        `user_gender`                   AS `gender`, 
        `user_email`                    AS `email`, 
        `user_password`                 AS `password`,
        `user_role`                     AS `role`, 
        `profile_picture`               AS `profilePicture`,
        `user_enabled`                  AS `enabled`,
        `user_created_at`               AS `createdAt`,
        `user_modified_at`              AS `modifiedAt`,
        `user_active`                   AS `active`
    FROM 
        `users` 
    WHERE
        `user_email` = `_email`
        AND user_id <> `_user_id`
    LIMIT
        1;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `user_find` $$
CREATE PROCEDURE `user_find`(
    IN `_user_id`                       INT,
    IN `_user_id_op`                    ENUM('=', '<>'),
    IN `_user_email`                    VARCHAR(255),
    IN `_user_email_op`                 ENUM('=', '<>')
)
BEGIN
    SELECT 
        `user_id`,
        `user_name`,
        `user_last_name`,
        `user_birth_date`,
        `user_gender`,
        `user_email`,
        `user_password`,
        `user_role`,
        `profile_picture`,
        `user_enabled`,
        `user_created_at`,
        `user_modified_at`,
        `user_active`
    FROM 
        `users`
    WHERE
        (
            `_user_id_op` IS NULL 
            OR (`_user_id_op` = '=' AND `user_id` = `_user_id`) 
            OR (`_user_id_op` = '<>' AND `user_id` <> `_user_id`)
        )
        AND 
        (
            `_user_email_op` IS NULL 
            OR (`_user_email_op` = '=' AND `user_email` = `_user_email`) 
            OR (`_user_email_op` = '<>' AND `user_email` <> `_user_email`)
        );
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `user_find_blocked` $$
CREATE PROCEDURE `user_find_blocked`()
BEGIN
    SELECT
        `user_id`                       AS `id`,
        `user_name`                     AS `name`,
        `user_last_name`                AS `lastName`,
        `user_birth_date`               AS `birthDate`,
        `user_gender`                   AS `gender`,
        `user_email`                    AS `email`,
        `user_password`                 AS `password`,
        `user_role`                     AS `role`,
        `profile_picture`               AS `profilePicture`,
        `user_enabled`                  AS `enabled`,
        `user_created_at`               AS `createdAt`,
        `user_modified_at`              AS `modifiedAt`,
        `user_active`                   AS `active`
    FROM
        `users`
    WHERE
        `user_enabled` = FALSE
        AND `user_role` <> 1;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `user_find_unblocked` $$
CREATE PROCEDURE `user_find_unblocked`()
BEGIN
    SELECT
        `user_id`                       AS `id`,
        `user_name`                     AS `name`,
        `user_last_name`                AS `lastName`,
        `user_birth_date`               AS `birthDate`,
        `user_gender`                   AS `gender`,
        `user_email`                    AS `email`,
        `user_password`                 AS `password`,
        `user_role`                     AS `role`,
        `profile_picture`               AS `profilePicture`,
        `user_enabled`                  AS `enabled`,
        `user_created_at`               AS `createdAt`,
        `user_modified_at`              AS `modifiedAt`,
        `user_active`                   AS `active`
    FROM
        `users`
    WHERE
        `user_enabled` = TRUE
        AND `user_role` <> 1;
END $$
DELIMITER ;
DELIMITER $$
DROP PROCEDURE IF EXISTS `video_create` $$
CREATE PROCEDURE `video_create`(
    IN  `_video_name`                   VARCHAR(255),
    IN  `_video_duration`               TIME,
    IN  `_video_content_type`           VARCHAR(30),
    IN  `_video_address`                VARCHAR(255),
    OUT `_video_id`                     INT
)
BEGIN
    INSERT INTO `videos`(
        `video_name`,
        `video_duration`,
        `video_content_type`,
        `video_address`
    )
    VALUES(
        `_video_name`,
        `_video_duration`,
        `_video_content_type`,
        `_video_address`
    );
    SET `_video_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `video_update` $$
CREATE PROCEDURE `video_update`(
    IN `_video_id`                      INT,
    IN `_video_name`                    VARCHAR(255),
    IN `_video_duration`                TIME,
    IN `_video_content_type`            VARCHAR(30),
    IN `_video_address`                 VARCHAR(255),
    IN `_video_created_at`              TIMESTAMP,
    IN `_video_modified_at`             TIMESTAMP,
    IN `_video_active`                  BOOLEAN
)
BEGIN
    UPDATE
        `videos`
    SET
        `video_name`                    = IFNULL(`_video_name`, `video_name`),
        `video_duration`                = IFNULL(`_video_duration`, `video_duration`),
        `video_content_type`            = IFNULL(`_video_content_type`, `video_content_type`),
        `video_address`                 = IFNULL(`_video_address`, `video_address`),
        `video_created_at`              = IFNULL(`_video_created_at`, `video_created_at`),
        `video_modified_at`             = NOW(),
        `video_active`                  = IFNULL(`_video_active`, `video_active`)
    WHERE
        `video_id` = `_video_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `video_find_by_id` $$
CREATE PROCEDURE `video_find_by_id`(
    IN `_video_id`                      INT
)
BEGIN
    SELECT
        `video_id`                      AS `id`,
        `video_name`                    AS `name`,
        `video_duration`                AS `duration`,
        `video_content_type`            AS `contentType`,
        `video_address`                 AS `address`,
        `video_created_at`              AS `createdAt`,
        `video_modified_at`             AS `modifiedAt`,
        `video_active`                  AS `active`
    FROM
        `videos`
    WHERE
        `video_id` = `_video_id`
        AND `video_active` = TRUE
    LIMIT
        1;
END $$
DELIMITER ;
DELIMITER $$
DROP TRIGGER IF EXISTS `update_document_lessons_trigger` $$
CREATE TRIGGER `update_document_lessons_trigger` 
AFTER UPDATE 
ON `documents` FOR EACH ROW
BEGIN
    IF NEW.`document_active` = FALSE THEN
        UPDATE `lessons`
        SET `document_id` = NULL
        WHERE `document_id` = OLD.`document_id`;
    END IF;
END $$
DELIMITER ;
DELIMITER $$
DROP TRIGGER IF EXISTS `after_insert_on_enrollment` $$
CREATE TRIGGER `after_insert_on_enrollment`
AFTER INSERT
ON `enrollments` FOR EACH ROW
BEGIN
    INSERT INTO `user_level`(
        `user_id`,
        `level_id`
    )
    SELECT
        new.`student_id`,
        `level_id`
    FROM
        `levels`
    WHERE
        `course_id` = new.`course_id`
        AND `level_active` = TRUE;
END $$
DELIMITER ;
DELIMITER $$
DROP TRIGGER IF EXISTS `update_image_lessons_trigger` $$
CREATE TRIGGER `update_image_lessons_trigger` 
AFTER UPDATE 
ON `images` FOR EACH ROW
BEGIN
    IF NEW.`image_active` = FALSE THEN
        UPDATE `lessons`
        SET `image_id` = NULL
        WHERE `image_id` = OLD.`image_id`;
    END IF;
END $$
DELIMITER ;
DELIMITER $$
DROP TRIGGER IF EXISTS `update_link_lessons_trigger` $$
CREATE TRIGGER `update_link_lessons_trigger` 
AFTER UPDATE 
ON `links` FOR EACH ROW
BEGIN
    IF NEW.`link_active` = FALSE THEN
        UPDATE `lessons`
        SET `link_id` = NULL
        WHERE `link_id` = OLD.`link_id`;
    END IF;
END $$
DELIMITER ;
DELIMITER $$
DROP TRIGGER IF EXISTS `after_insert_on_user_level` $$
CREATE TRIGGER `after_insert_on_user_level`
AFTER INSERT
ON `user_level` FOR EACH ROW
BEGIN
    INSERT INTO `user_lesson`(
        `user_id`,
        `lesson_id`
    )
    SELECT
        new.`user_id`,
        `lesson_id`
    FROM
        `lessons`
    WHERE
        `level_id` = new.`level_id`
        AND `lesson_active` = TRUE;
END $$
DELIMITER ;
DELIMITER $$
DROP TRIGGER IF EXISTS `update_video_lessons_trigger` $$
CREATE TRIGGER `update_video_lessons_trigger` 
AFTER UPDATE 
ON `videos` FOR EACH ROW
BEGIN
    IF NEW.`video_active` = FALSE THEN
        UPDATE `lessons`
        SET `video_id` = NULL
        WHERE `video_id` = OLD.`video_id`;
    END IF;
END $$
DELIMITER ;
DROP VIEW IF EXISTS `certificate`;
CREATE VIEW `certificate`
AS
SELECT
    e.`course_id`,
    e.`student_id`,
    e.`enrollment_finish_date`,
    e.`enrollment_certificate_uid`,
    CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `student`,
    CONCAT(i.`user_name`, ' ', i.`user_last_name`) AS `instructor`,
    c.`course_title`
FROM
    `enrollments` AS e
INNER JOIN
    `users` AS u
ON
    e.`student_id` = u.`user_id`
INNER JOIN
    `courses` AS c
ON
    e.`course_id` = c.`course_id`
INNER JOIN
    `users` AS i
ON
    c.`instructor_id` = i.`user_id`
WHERE
    `enrollment_is_finished` = TRUE;
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
    IFNULL(AVG(r.`review_rate`), 0) `rate`,
    COUNT(DISTINCT l.`level_id`) AS `levels`,
    get_course_video_duration(c.`course_id`) AS `video_duration`,
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
    AND r.`review_active` = TRUE
INNER JOIN
    `levels` AS l
ON
    c.`course_id` = l.`course_id` 
    AND l.`level_active` = TRUE
INNER JOIN
    `lessons` AS le
ON
    l.`level_id` = le.`level_id` 
    AND le.`lesson_active` = TRUE
GROUP BY
    c.`course_id`;
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
    IFNULL(AVG(r.`review_rate`), 'No hay reseñas') `rates`,
    CONCAT(u.`user_name`, ' ', u.`user_last_name`) `instructor`,
    IFNULL(get_course_video_duration(c.`course_id`), 0) AS `duration`,
    COUNT(DISTINCT e.`enrollment_id`) AS `enrollments`,
    IF(SUM(l.`level_is_free`) > 0, TRUE, FALSE) AS `levelFree`
FROM
    `courses` AS c
INNER JOIN
    `levels` AS l
ON
    c.`course_id` = l.`course_id` 
    AND l.`level_active` = TRUE
INNER JOIN
    `lessons` AS le
ON
    l.`level_id` = le.`level_id` 
    AND le.`lesson_active` = TRUE
LEFT JOIN
    `reviews` AS r
ON
    c.`course_id` = r.`course_id` 
    AND r.`review_active` = TRUE
INNER JOIN
    `users` AS u
ON
    c.`instructor_id` = u.`user_id`
LEFT JOIN
    `enrollments` AS e
ON
    c.`course_id` = e.`course_id` 
    AND e.`enrollment_is_paid` = TRUE
    AND e.`enrollment_active` = TRUE
GROUP BY
    c.`course_id`;
DROP VIEW IF EXISTS `course_enrollments`;
CREATE VIEW `course_enrollments`
AS
SELECT
    c.`course_id`,
    u.`user_id`,
    u.`user_name`,
    u.`user_last_name`,
    u.`profile_picture` AS `profile_picture`,
    e.`enrollment_enroll_date`,
    e.`enrollment_amount`,
    IFNULL(pm.`payment_method_name`, 'Version de prueba') AS `payment_method_name`,
    get_user_course_completion(u.`user_id`, c.`course_id`) AS `percentage_complete`,
    e.`enrollment_created_at`,
    e.`enrollment_modified_at`,
    e.`enrollment_active`
FROM 
    `courses` AS c
LEFT JOIN 
    `enrollments` AS e
ON 
    c.`course_id` = e.`course_id`
INNER JOIN 
    `users` AS u
ON 
    e.`student_id` = u.`user_id`
LEFT JOIN 
    `payment_methods` AS pm
ON 
    e.`payment_method_id` = pm.`payment_method_id`
WHERE
    c.`course_is_complete` = TRUE
    AND c.`course_approved` = TRUE
GROUP BY
    c.`course_id`,
    u.`user_id`;
DROP VIEW IF EXISTS `course_visor`;
CREATE VIEW `course_visor`
AS
SELECT
    le.`lesson_id`,
    le.`lesson_title`,
    le.`lesson_description`,
    le.`video_id`,
    le.`image_id`,
    le.`document_id`,
    lk.`link_id`,
    lk.`link_name`,
    lk.`link_address`,
    find_main_resource(`lesson_id`) AS `resource`,
    le.`lesson_created_at`,
    le.`lesson_modified_at`,
    le.`lesson_active`,
    l.`level_id`,
    l.`level_is_free`
FROM
    `lessons` AS le
INNER JOIN
    `levels` AS l
ON
    le.`level_id` = l.`level_id`
LEFT JOIN
    `links` AS lk
ON
    le.`link_id` = lk.`link_id`;
DROP VIEW IF EXISTS `instructor_courses_seen_by_others`;
CREATE VIEW `instructor_courses_seen_by_others`
AS
SELECT
    c.`course_id`,
    c.`course_title`,
    c.`course_image_id`,
    c.`course_price`,
    COUNT(e.`enrollment_id`) AS `enrollments`,
    IFNULL(SUM(e.`enrollment_amount`), 0) AS `amount`,
    IF(AVG(r.`review_rate`) IS NULL, 0, AVG(r.`review_rate`)) `rates`,
    c.`instructor_id`,
    c.`course_is_complete`,
    c.`course_approved`,
    c.`course_approved_by`,
    c.`course_approved_at`,
    c.`course_created_at`,
    c.`course_modified_at`,
    c.`course_active`
FROM
    `courses` AS c
LEFT JOIN
    `enrollments` AS e
ON
    c.`course_id` = e.`course_id`
LEFT JOIN
    `reviews` AS r
ON
    c.`course_id` = r.`course_id`
    AND r.`review_active` = TRUE
GROUP BY
    c.`course_id`;
DROP VIEW IF EXISTS `instructor_courses`;
CREATE VIEW `instructor_courses`
AS
SELECT
    c.`course_id`,
    c.`course_title`,
    c.`course_image_id`,
    COUNT(e.`enrollment_id`) AS `enrollments`,
    IFNULL(SUM(e.`enrollment_amount`), 0) AS `amount`,
    IFNULL(get_course_completion_percentage(c.`course_id`), 0) AS `average_level`,
    c.`instructor_id`,
    c.`course_is_complete`,
    c.`course_approved`,
    c.`course_approved_by`,
    c.`course_approved_at`,
    c.`course_created_at`,
    c.`course_modified_at`,
    c.`course_active`
FROM
    `courses` AS c
LEFT JOIN
    `enrollments` AS e
ON
    c.`course_id` = e.`course_id`
GROUP BY
    c.`course_id`;
DROP VIEW IF EXISTS `instructor_total_revenue`;
CREATE VIEW `instructor_total_revenue`
AS
SELECT
    u.`user_id`,
    pm.`payment_method_id`,
    pm.`payment_method_name`,
    IFNULL(p.`amount`, 0) AS `amount`
FROM
    `users` AS u
JOIN
    `payment_methods` AS pm
ON
    u.`user_role` = 2
LEFT JOIN (
    SELECT
        u.`user_id`,
        e.`payment_method_id`,
        SUM(e.`enrollment_amount`) AS `amount`
    FROM
        `users` AS u
    INNER JOIN
        `courses` AS c
    ON
        u.`user_id` = c.`instructor_id` AND u.`user_role` = 2
    INNER JOIN
        `enrollments` AS e
    ON
        c.`course_id` = e.`course_id`
    GROUP BY
        u.`user_id`,
        e.`payment_method_id`) AS p
ON
    u.`user_id` = p.`user_id` 
    AND pm.`payment_method_id` = p.`payment_method_id`;
DROP VIEW IF EXISTS `kardex`;
CREATE VIEW `kardex`
AS
SELECT
    c.`course_id`,
    c.`course_title`,
    c.`course_image_id`,
    e.`student_id`,
    IFNULL(e.`enrollment_enroll_date`, 'N/A') AS `enrollment_enroll_date`,
    IFNULL(e.`enrollment_last_time_checked`, 'N/A') AS `enrollment_last_time_checked`,
    IFNULL(e.`enrollment_finish_date`, 'N/A') AS `enrollment_finish_date`,
    e.`enrollment_is_finished`,
    IF(e.`enrollment_is_finished`, 'Acabado', 'En curso') AS `enrollment_status`,
    e.`enrollment_certificate_uid` AS `enrollment_certificate_uid`,
    e.`enrollment_created_at`,
    get_user_course_completion(e.`student_id`, c.`course_id`) AS `enrollment_progress`,
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
    `enrollments` AS e
ON
    c.`course_id` = e.`course_id`;
-- User roles
INSERT INTO 
    `roles` 
VALUES 
    (1,'Administrador',0,'2023-03-12 18:01:38','2023-03-12 18:01:38',1),
    (2,'Instructor',1,'2023-03-12 18:01:41','2023-03-12 18:01:41',1),
    (3,'Estudiante',1,'2023-03-12 18:01:45','2023-03-12 18:01:45',1);


-- Administrador
    INSERT INTO `images`(
        `image_name`,
        `image_size`,
        `image_content_type`,
        `image_data`
    )
    VALUES(
        'prueba.jpg',
        1,
        'image/jpg',
        '0'
    );
INSERT INTO `users` VALUES (DEFAULT,'admin','admin','2001-10-26','Masculino','root@root.com','$2y$10$lK4o1rqArg7UfdkkYmx7f.8S0bZ/VPq5J7lAjIFOB/4/wGXcgBWsW',1,1,1,'2023-03-12 18:03:46','2023-03-12 18:03:46',1);


INSERT INTO `payment_methods`(`payment_method_name`)
VALUES
    ('Tarjeta de crédito/débito'),
    ('PayPal');
