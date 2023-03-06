CREATE DATABASE cursotopia;

USE cursotopia;

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images`(
    `image_id`                  UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `image_name`                VARCHAR(255) NOT NULL,
    `image_size`                UNSIGNED BIGINT NOT NULL,
    `image_content_type`        VARCHAR(30) NOT NULL,
    `image_data`                MEDIUMBLOB NOT NULL,
    `image_created_at`          TIMESTAMP NOT NULL DEFAULT NOW(),
    `image_modified_at`         TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `image_active`              BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `image_pk`
        PRIMARY KEY (`image_id`)
);

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos`(
    `video_id`                  UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `video_name`                VARCHAR(255) NOT NULL,
    `video_duration`            UNSIGNED INT NOT NULL,
    `video_address`             VARCHAR(255) NOT NULL,
    `video_created_at`          TIMESTAMP NOT NULL DEFAULT NOW(),
    `video_modified_at`         TIMESTAMP NOT NULL DEFAULT NOW(),
    `video_active`              BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `video_pk`
        PRIMARY KEY (`video_id`)
);

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents`(
    `document_id`               UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `document_name`             VARCHAR(255) NOT NULL,
    `document_address`          VARCHAR(255) NOT NULL,
    `document_created_at`       TIMESTAMP NOT NULL DEFAULT NOW(),
    `document_modified_at`      TIMESTAMP NOT NULL DEFAULT NOW(),
    `document_active`           BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `document_pk`
        PRIMARY KEY (`document_id`)
);

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links`(
    `link_id`                       UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `link_name`                     VARCHAR(255) NOT NULL,
    `link_address`                  VARCHAR(255) NOT NULL,
    `link_created_at`               DATETIME NOT NULL DEFAULT NOW(),
    `link_modified_at`              DATETIME NOT NULL DEFAULT NOW(),
    `link_active`                   BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `link_pk`
        PRIMARY KEY (`link_id`)
);

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles`(
    `user_role_id`              UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `user_role_name`            VARCHAR(50) NOT NULL,
    `user_role_created_at`      DATETIME NOT NULL DEFAULT NOW(),
    `user_role_modified_at`     DATETIME NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `user_role_active`          BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `user_role_pk`
        PRIMARY KEY (`user_role_id`)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`(
    `user_id`                   INT NOT NULL AUTO_INCREMENT,
    `user_name`                 VARCHAR(50) NOT NULL,
    `user_last_name`            VARCHAR(50) NOT NULL,
    `user_birth_date`           DATE NOT NULL,
    `user_gender`               SMALLINT NOT NULL,
    `user_email`                VARCHAR(255) NOT NULL UNIQUE,
    `user_password`             VARCHAR(255) NOT NULL,
    `user_role`                 INT NOT NULL,
    `profile_picture`           INT NOT NULL,
    `user_enabled`              BOOLEAN NOT NULL,
    `user_created_at`           TIMESTAMP NOT NULL DEFAULT NOW(),
    `user_modified_at`          TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    `user_active`               BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `users_pk`
        PRIMARY KEY (`user_id`)
    CONSTRAINT `users_images_fk`
        FOREIGN KEY (`profile_picture`) REFERENCES images(`image_id`)
    CONSTRAINT `users_user_roles_fk`
        FOREIGN KEY (`user_role`) REFERENCES user_roles(`user_role_id`)
);

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses`(
    `course_id`                 UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `course_title`              VARCHAR(50) NOT NULL,
    `course_description`        VARCHAR(255) NOT NULL,
    `course_price`              DECIMAL(10, 2) NOT NULL,
    `image_id`                  UNSIGNED INT NOT NULL,
    `instructor_id`             UNSIGNED INT NOT NULL,
    `course_approved`           BOOLEAN NOT NULL DEFAULT FALSE,
    `course_approved_by`        UNSIGNED INT DEFAULT NULL,
    `course_created_at`         DATETIME NOT NULL DEFAULT NOW(),
    `course_modified_at`        DATETIME NOT NULL DEFAULT NOW(),
    `course_active`             BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `course_pk`
        PRIMARY KEY (`course_id`)
);

DROP TABLE IF EXISTS `levels`;
CREATE TABLE IF NOT EXISTS `levels`(
    `level_id`                  UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `level_title`               VARCHAR(50) NOT NULL,
    `level_description`         VARCHAR(255) NOT NULL,
    `level_price`               DECIMAL(10, 2) NOT NULL,
    `course_id`                 UNSIGNED INT NOT NULL,
    `level_created_at`          DATETIME NOT NULL DEFAULT NOW(),
    `level_modified_at`         DATETIME NOT NULL DEFAULT NOW(),
    `level_active`              BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT `level_pk`
        PRIMARY KEY (`level_id`)
);

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons`(
    `lesson_id`                 UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `lesson_title`              VARCHAR(50) NOT NULL,
    `lesson_description`        VARCHAR(255) NOT NULL,
    `level_id`                  UNSIGNED INT NOT NULL,
    `video_id`                  UNSIGNED INT NOT NULL,
    `image_id`                  UNSIGNED INT NOT NULL,
    `document_id`               UNSIGNED INT NOT NULL,
    `link_id`                   UNSIGNED INT NOT NULL,
    `lesson_created_at`         DATETIME NOT NULL DEFAULT NOW(),
    `lesson_modified_at`        DATETIME NOT NULL DEFAULT NOW(),
    `lesson_active`             BOOLEAN NOT NULL DEFAULT TRUE
);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories`(
    `category_id`           UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `category_name`         VARCHAR(50) NOT NULL,
    `category_description`  VARCHAR(255) NOT NULL,
    `category_approved`     BOOLEAN NOT NULL DEFAULT FALSE,
    `category_approved_by`  UNSIGNED INT DEFAULT NULL,
    `category_created_by`   UNSIGNED INT NOT NULL,
    `category_created_at`   DATETIME NOT NULL DEFAULT NOW(),
    `category_modified_at`  DATETIME NOT NULL DEFAULT NOW(),
    `category_active`       BOOLEAN NOT NULL DEFAULT TRUE
);

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews`(
    `review_id`             UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `review_message`        VARCHAR(255) NOT NULL,
    `review_rate`           UNSIGNED INT NOT NULL,
    `course_id`             UNSIGNED INT NOT NULL,
    `user_id`               UNSIGNED INT NOT NULL,
    `review_created_at`     DATETIME NOT NULL DEFAULT NOW(),
    `review_modified_at`    DATETIME NOT NULL DEFAULT NOW(),
    `review_active`         BOOLEAN NOT NULL DEFAULT TRUE
);

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods`(
    `payment_method_id`             UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `payment_method_name`           VARCHAR(50) NOT NULL,
    `payment_method_created_at`     DATETIME NOT NULL DEFAULT NOW(),
    `payment_method_mofified_at`    DATETIME NOT NULL DEFAULT NOW(),
    `payment_method_active`         BOOLEAN NOT NULL DEFAULT TRUE
);

DROP TABLE IF EXISTS `enrollments`;
CREATE TABLE IF NOT EXISTS `enrollments`(
    `enrollment_id`             UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `course_id`                 UNSIGNED INT NOT NULL,
    `student_id`                UNSIGNED INT NOT NULL,
    `enrollment_is_finished`    BOOLEAN NOT NULL DEFAULT FALSE,
    `enrollment_enroll_date`    DATETIME,
    `enrollment_finish_date`    DATETIME,
    `enrollment_certificate_uid` VARCHAR(36),
    `enrollment_amount`         DECIMAL(10, 2) NOT NULL,
    `payment_method_id`         UNSIGNED INT NOT NULL,
    `enrollment_last_time_checked` DATETIME,
    `enrollment_created_at`     DATETIME NOT NULL DEFAULT NOW(),
    `enrollment_modified_at`    DATETIME NOT NULL DEFAULT NOW(),
    `enrollment_active`         BOOLEAN NOT NULL DEFAULT TRUE
);

DROP TABLE IF EXISTS `user_level`;
CREATE TABLE IF NOT EXISTS `user_level`(
    `user_level_id`             UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `user_id`                   UNSIGNED INT NOT NULL,
    `level_id`                  UNSIGNED INT NOT NULL,
    `user_level_is_complete`    BOOLEAN NOT NULL DEFAULT FALSE,
    `user_level_complete_at`    TIMESTAMP,
    `user_level_last_time_checked` DATETIME,
    `user_level_created_at`     TIMESTAMP NOT NULL DEFAULT NOW(),
    `user_level_modified_at`    TIMESTAMP NOT NULL DEFAULT NOW(),
);

DROP TABLE IF EXISTS `user_lesson`;
CREATE TABLE IF NOT EXISTS `user_lesson`(
    `user_lesson_id`            UNSIGNED INT NOT NULL AUTO_INCREMENT,

);

DROP TABLE IF EXISTS `course_category`;
CREATE TABLE IF NOT EXISTS `course_category`(
    `course_category_id`            UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `course_id`                     UNSIGNED INT NOT NULL,
    `category_id`                   UNSIGNED INT NOT NULL,
    `course_category_created_at`    TIMESTAMP NOT NULL DEFAULT NOW(),
    `course_category_modified_at`   TIMESTAMP NOT NULL DEFAULT NOW(),
    `course_category_active`        BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS `chats`(
    `chat_id`               UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `chat_last_message`     VARCHAR(255) NOT NULL,
    `chat_last_message_at`  DATETIME NOT NULL,
    `chat_created_at`       DATETIME NOT NULL DEFAULT NOW(),
    `chat_modified_at`      DATETIME NOT NULL DEFAULT NOW(),
    `chat_active`           BOOLEAN NOT NULL DEFAULT TRUE
);

DROP TABLE IF EXISTS `chat_participants`;
CREATE TABLE IF NOT EXISTS `chat_participants`(
    `chat_participant_id`           UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `user_id`                       UNSIGNED INT NOT NULL,
    `chat_id`                       UNSIGNED INT NOT NULL,
    `chat_participant_created_at`   TIMESTAMP NOT NULL DEFAULT NOW(),
    `chat_participant_modified_at`  TIMESTAMP NOT NULL DEFAULT NOW(),
    `chat_participant_active`       BOOLEAN NOT NULL DEFAULT TRUE
);

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages`(
    `message_id`                    UNSIGNED INT NOT NULL AUTO_INCREMENT,
    `message_content`               VARCHAR(255) NOT NULL,
    `chat_id`                       UNSIGNED INT NOT NULL,
    `user_id`                       UNSIGNED INT NOT NULL,
    `message_created_at`            TIMESTAMP NOT NULL DEFAULT NOW(),
    `message_modified_at`           TIMESTAMP NOT NULL DEFAULT NOW(),
    `message_active`                BOOLEAN NOT NULL DEFAULT TRUE
);