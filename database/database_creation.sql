--DROP DATABASE cursotopia;
CREATE DATABASE IF NOT EXISTS `cursotopia`;
USE `cursotopia`;

-- Almacena imagenes en formato BLOB, las imagenes solo pueden pesar un maximo de 8MB y 
-- deben tener formato jpg o png
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
        PRIMARY KEY (`link_id`),
    CONSTRAINT `link_name_uniq`
        UNIQUE (`link_name`)
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
    `course_is_approved`            BOOLEAN NOT NULL DEFAULT FALSE,
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
    `level_price`                   DECIMAL(10, 2) NOT NULL,
    `level_number`                  INT NOT NULL,
    `course_id`                     INT NOT NULL,
    `level_created_at`              TIMESTAMP NOT NULL DEFAULT NOW(),
    `level_modified_at`             TIMESTAMP NOT NULL DEFAULT NOW(),
    `level_active`                  BOOLEAN NOT NULL DEFAULT TRUE,
    INDEX `level_course_idx` (`course_id`),
    CONSTRAINT `level_pk`
        PRIMARY KEY (`level_id`),
    CONSTRAINT `level_course_fk`
        FOREIGN KEY (`course_id`) 
        REFERENCES `courses`(`course_id`),
    CONSTRAINT `level_price_chk`
        CHECK (`level_price` >= 0)
);

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons`(
    `lesson_id`                     INT NOT NULL AUTO_INCREMENT,
    `lesson_title`                  VARCHAR(50) NOT NULL,
    `lesson_description`            VARCHAR(255) NOT NULL,
    `lesson_number`                 INT NOT NULL,
    `level_id`                      INT NOT NULL,
    `video_id`                      INT DEFAULT NULL,
    `image_id`                      INT DEFAULT NULL,
    `document_id`                   INT DEFAULT NULL,
    `link_id`                       INT DEFAULT NULL,
    `lesson_created_at`             TIMESTAMP NOT NULL DEFAULT NOW(),
    `lesson_modified_at`            TIMESTAMP NOT NULL DEFAULT NOW(),
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

-- Aprobada
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories`(
    `category_id`                   INT NOT NULL AUTO_INCREMENT,
    `category_name`                 VARCHAR(50) NOT NULL,
    `category_description`          VARCHAR(255) NOT NULL,
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
        CHECK (`review_rate` BETWEEN 1 AND 10)
);

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods`(
    `payment_method_id`             INT NOT NULL AUTO_INCREMENT,
    `payment_method_name`           VARCHAR(50) NOT NULL,
    `payment_method_created_at`     TIMESTAMP NOT NULL DEFAULT NOW(),
    `payment_method_mofified_at`    TIMESTAMP NOT NULL DEFAULT NOW(),
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
    `enrollment_amount`             DECIMAL(10, 2) NOT NULL,
    `payment_method_id`             INT NOT NULL,
    `enrollment_last_time_checked`  DATETIME,
    -- enrollment_last_access_date DATETIME
    `enrollment_created_at`         TIMESTAMP NOT NULL DEFAULT NOW(),
    `enrollment_modified_at`        TIMESTAMP NOT NULL DEFAULT NOW(),
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
    `user_level_modified_at`        TIMESTAMP NOT NULL DEFAULT NOW(),
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
    `message_content`               VARCHAR(255) NOT NULL,
    `user_id`                       INT NOT NULL,
    `chat_id`                       INT NOT NULL,
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
