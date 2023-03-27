-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: cursotopia
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `category_description` varchar(255) NOT NULL,
  `category_is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `category_approved_by` int(11) DEFAULT NULL,
  `category_created_by` int(11) NOT NULL,
  `category_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name_uniq` (`category_name`),
  KEY `category_approved_by_fk` (`category_approved_by`),
  KEY `category_created_by_fk` (`category_created_by`),
  CONSTRAINT `category_approved_by_fk` FOREIGN KEY (`category_approved_by`) REFERENCES `users` (`user_id`),
  CONSTRAINT `category_created_by_fk` FOREIGN KEY (`category_created_by`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chat_participants`
--

DROP TABLE IF EXISTS `chat_participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_participants` (
  `chat_participant_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `chat_participant_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `chat_participant_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `chat_participant_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`chat_participant_id`),
  KEY `chat_participant_user_fk` (`user_id`),
  KEY `chat_participant_chat_fk` (`chat_id`),
  CONSTRAINT `chat_participant_chat_fk` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`chat_id`),
  CONSTRAINT `chat_participant_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_last_message` varchar(255) DEFAULT NULL,
  `chat_last_message_at` datetime DEFAULT NULL,
  `chat_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `chat_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `chat_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `course_category`
--

DROP TABLE IF EXISTS `course_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_category` (
  `course_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `course_category_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `course_category_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `course_category_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`course_category_id`),
  KEY `course_category_course_fk` (`course_id`),
  KEY `course_category_category_fk` (`category_id`),
  CONSTRAINT `course_category_category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  CONSTRAINT `course_category_course_fk` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `course_details`
--

DROP TABLE IF EXISTS `course_details`;
/*!50001 DROP VIEW IF EXISTS `course_details`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `course_details` AS SELECT
 1 AS `id`,
  1 AS `title`,
  1 AS `description`,
  1 AS `price`,
  1 AS `imageId`,
  1 AS `instructorId`,
  1 AS `approved`,
  1 AS `approvedBy`,
  1 AS `createdAt`,
  1 AS `modifiedAt`,
  1 AS `active`,
  1 AS `levels`,
  1 AS `reviews`,
  1 AS `rates`,
  1 AS `instructor`,
  1 AS `duration`,
  1 AS `enrollments` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_title` varchar(50) NOT NULL,
  `course_description` varchar(255) NOT NULL,
  `course_price` decimal(10,2) NOT NULL,
  `course_image_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `course_approved` tinyint(1) NOT NULL DEFAULT 0,
  `course_approved_by` int(11) DEFAULT NULL,
  `course_approved_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `course_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `course_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `course_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `course_image_id` (`course_image_id`),
  UNIQUE KEY `course_image_id_uniq` (`course_image_id`),
  KEY `course_instructor_fk` (`instructor_id`),
  KEY `course_approved_by_fk` (`course_approved_by`),
  CONSTRAINT `course_approved_by_fk` FOREIGN KEY (`course_approved_by`) REFERENCES `users` (`user_id`),
  CONSTRAINT `course_image_fk` FOREIGN KEY (`course_image_id`) REFERENCES `images` (`image_id`),
  CONSTRAINT `course_instructor_fk` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `course_price_chk` CHECK (`course_price` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(255) NOT NULL,
  `document_content_type` varchar(30) NOT NULL,
  `document_address` varchar(255) NOT NULL,
  `document_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `document_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `document_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`document_id`),
  UNIQUE KEY `document_name_uniq` (`document_name`),
  CONSTRAINT `document_content_type_chk` CHECK (`document_content_type` = 'application/pdf')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `enrollment_is_finished` tinyint(1) NOT NULL DEFAULT 0,
  `enrollment_enroll_date` datetime DEFAULT NULL,
  `enrollment_finish_date` datetime DEFAULT NULL,
  `enrollment_certificate_uid` varchar(36) DEFAULT NULL,
  `enrollment_amount` decimal(10,2) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `enrollment_last_time_checked` datetime DEFAULT NULL,
  `enrollment_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `enrollment_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `enrollment_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`enrollment_id`),
  UNIQUE KEY `course_student_uniq` (`course_id`,`student_id`),
  KEY `enrollment_student_fk` (`student_id`),
  KEY `enrollment_payment_method_fk` (`payment_method_id`),
  CONSTRAINT `enrollment_course_fk` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  CONSTRAINT `enrollment_payment_method_fk` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`payment_method_id`),
  CONSTRAINT `enrollment_student_fk` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `enrollment_amount_chk` CHECK (`enrollment_amount` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER IF NOT EXISTS `after_insert_on_enrollment`
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
        `course_id` = new.`course_id`;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) NOT NULL,
  `image_size` int(11) NOT NULL,
  `image_content_type` varchar(30) NOT NULL,
  `image_data` mediumblob NOT NULL,
  `image_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`image_id`),
  UNIQUE KEY `image_name_uniq` (`image_name`),
  CONSTRAINT `image_size_chk` CHECK (`image_size` > 0 and `image_size` <= 8 * 1024 * 1024),
  CONSTRAINT `image_content_type_chk` CHECK (`image_content_type` in ('image/jpeg','image/jpg','image/png'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `instructor_courses`
--

DROP TABLE IF EXISTS `instructor_courses`;
/*!50001 DROP VIEW IF EXISTS `instructor_courses`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `instructor_courses` AS SELECT
 1 AS `id`,
  1 AS `title`,
  1 AS `imageId`,
  1 AS `enrollments`,
  1 AS `amount`,
  1 AS `averageLevel`,
  1 AS `instructorId` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `kardex`
--

DROP TABLE IF EXISTS `kardex`;
/*!50001 DROP VIEW IF EXISTS `kardex`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `kardex` AS SELECT
 1 AS `course_id`,
  1 AS `student_id`,
  1 AS `course_title`,
  1 AS `enrollment_enroll_date`,
  1 AS `enrollment_last_time_checked`,
  1 AS `enrollment_finish_date`,
  1 AS `enrollment_is_finished`,
  1 AS `enrollment_certificate_uid`,
  1 AS `user_lesson_id`,
  1 AS `enrollment_progress` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_title` varchar(50) NOT NULL,
  `lesson_description` varchar(255) NOT NULL,
  `lesson_number` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `link_id` int(11) DEFAULT NULL,
  `lesson_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `lesson_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `lesson_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`lesson_id`),
  KEY `lesson_level_fk` (`level_id`),
  KEY `lesson_video_fk` (`video_id`),
  KEY `lesson_image_fk` (`image_id`),
  KEY `lesson_document_fk` (`document_id`),
  KEY `lesson_link_fk` (`link_id`),
  CONSTRAINT `lesson_document_fk` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`),
  CONSTRAINT `lesson_image_fk` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`),
  CONSTRAINT `lesson_level_fk` FOREIGN KEY (`level_id`) REFERENCES `levels` (`level_id`),
  CONSTRAINT `lesson_link_fk` FOREIGN KEY (`link_id`) REFERENCES `links` (`link_id`),
  CONSTRAINT `lesson_video_fk` FOREIGN KEY (`video_id`) REFERENCES `videos` (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `levels` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_title` varchar(50) NOT NULL,
  `level_description` varchar(255) NOT NULL,
  `level_price` decimal(10,2) NOT NULL,
  `level_number` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `level_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `level_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `level_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`level_id`),
  KEY `level_course_idx` (`course_id`),
  CONSTRAINT `level_course_fk` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  CONSTRAINT `level_price_chk` CHECK (`level_price` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(255) NOT NULL,
  `link_address` varchar(255) NOT NULL,
  `link_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `link_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `link_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`link_id`),
  UNIQUE KEY `link_name_uniq` (`link_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `message_views`
--

DROP TABLE IF EXISTS `message_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_views` (
  `message_view_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`message_view_id`),
  KEY `message_view_message_fk` (`message_id`),
  KEY `message_view_user_fk` (`user_id`),
  CONSTRAINT `message_view_message_fk` FOREIGN KEY (`message_id`) REFERENCES `messages` (`message_id`),
  CONSTRAINT `message_view_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_content` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `message_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `message_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `message_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`message_id`),
  KEY `message_user_fk` (`user_id`),
  KEY `message_chat_fk` (`chat_id`),
  CONSTRAINT `message_chat_fk` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`chat_id`),
  CONSTRAINT `message_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_methods` (
  `payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method_name` varchar(50) NOT NULL,
  `payment_method_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method_mofified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_method_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`payment_method_id`),
  UNIQUE KEY `payment_method_name_uniq` (`payment_method_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `review_message` varchar(255) NOT NULL,
  `review_rate` tinyint(4) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `review_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `review_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`review_id`),
  KEY `idx_course_id` (`course_id`),
  KEY `review_user_fk` (`user_id`),
  CONSTRAINT `review_course_fk` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  CONSTRAINT `review_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `review_rate_chk` CHECK (`review_rate` between 1 and 10)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `role_is_public` tinyint(1) NOT NULL DEFAULT 1,
  `role_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name_uniq` (`role_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_lesson`
--

DROP TABLE IF EXISTS `user_lesson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_lesson` (
  `user_lesson_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `user_lesson_is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `user_lesson_complete_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_lesson_last_time_checked` datetime DEFAULT NULL,
  `user_lesson_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_lesson_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_lesson_id`),
  UNIQUE KEY `user_lesson_unique` (`user_id`,`lesson_id`),
  KEY `user_lesson_lesson_fk` (`lesson_id`),
  CONSTRAINT `user_lesson_lesson_fk` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`),
  CONSTRAINT `user_lesson_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_level`
--

DROP TABLE IF EXISTS `user_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_level` (
  `user_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `user_level_is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `user_level_complete_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_level_last_access_date` datetime DEFAULT NULL,
  `user_level_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_level_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_level_id`),
  UNIQUE KEY `user_level_unique` (`user_id`,`level_id`),
  KEY `user_level_level_fk` (`level_id`),
  CONSTRAINT `user_level_level_fk` FOREIGN KEY (`level_id`) REFERENCES `levels` (`level_id`),
  CONSTRAINT `user_level_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER IF NOT EXISTS `after_insert_on_user_level`
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
        `level_id` = new.`level_id`;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_birth_date` date NOT NULL,
  `user_gender` enum('Masculino','Femenino','Otro') NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` int(11) NOT NULL,
  `profile_picture` int(11) NOT NULL,
  `user_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `user_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_email_uniq` (`user_email`),
  KEY `idx_user_email` (`user_email`),
  KEY `users_images_fk` (`profile_picture`),
  KEY `users_roles_fk` (`user_role`),
  CONSTRAINT `users_images_fk` FOREIGN KEY (`profile_picture`) REFERENCES `images` (`image_id`),
  CONSTRAINT `users_roles_fk` FOREIGN KEY (`user_role`) REFERENCES `roles` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `video_name` varchar(255) NOT NULL,
  `video_duration` time NOT NULL,
  `video_content_type` varchar(30) NOT NULL,
  `video_address` varchar(255) NOT NULL,
  `video_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `video_modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `video_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`video_id`),
  UNIQUE KEY `video_name_uniq` (`video_name`),
  CONSTRAINT `video_content_type_chk` CHECK (`video_content_type` in ('video/mp4','video/webm','video/ogg'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `course_details`
--

/*!50001 DROP VIEW IF EXISTS `course_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `course_details` AS select `c`.`course_id` AS `id`,`c`.`course_title` AS `title`,`c`.`course_description` AS `description`,`c`.`course_price` AS `price`,`c`.`course_image_id` AS `imageId`,`c`.`instructor_id` AS `instructorId`,`c`.`course_approved` AS `approved`,`c`.`course_approved_by` AS `approvedBy`,`c`.`course_created_at` AS `createdAt`,`c`.`course_modified_at` AS `modifiedAt`,`c`.`course_active` AS `active`,count(distinct `l`.`level_id`) AS `levels`,count(distinct `r`.`review_id`) AS `reviews`,if(avg(`r`.`review_rate`) is null,'No reviews',avg(`r`.`review_rate`)) AS `rates`,concat(`u`.`user_name`,' ',`u`.`user_last_name`) AS `instructor`,sum(time_to_sec(`v`.`video_duration`)) / 3600.0 AS `duration`,count(distinct `e`.`enrollment_id`) AS `enrollments` from ((((((`courses` `c` join `levels` `l` on(`c`.`course_id` = `l`.`course_id`)) join `lessons` `le` on(`l`.`level_id` = `le`.`level_id`)) left join `videos` `v` on(`le`.`video_id` = `v`.`video_id`)) left join `reviews` `r` on(`c`.`course_id` = `r`.`course_id`)) join `users` `u` on(`c`.`instructor_id` = `u`.`user_id`)) left join `enrollments` `e` on(`c`.`course_id` = `e`.`course_id`)) group by `c`.`course_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `instructor_courses`
--

/*!50001 DROP VIEW IF EXISTS `instructor_courses`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `instructor_courses` AS select `c`.`course_id` AS `id`,`c`.`course_title` AS `title`,`c`.`course_image_id` AS `imageId`,count(`e`.`enrollment_id`) AS `enrollments`,ifnull(sum(`e`.`enrollment_amount`),0) AS `amount`,1 AS `averageLevel`,`c`.`instructor_id` AS `instructorId` from (`courses` `c` left join `enrollments` `e` on(`c`.`course_id` = `e`.`course_id`)) where `c`.`course_active` = 1 and `c`.`course_approved` = 1 group by `c`.`course_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `kardex`
--

/*!50001 DROP VIEW IF EXISTS `kardex`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `kardex` AS select `c`.`course_id` AS `course_id`,`e`.`student_id` AS `student_id`,`c`.`course_title` AS `course_title`,ifnull(`e`.`enrollment_enroll_date`,'N/A') AS `enrollment_enroll_date`,ifnull(`e`.`enrollment_last_time_checked`,'N/A') AS `enrollment_last_time_checked`,ifnull(`e`.`enrollment_finish_date`,'N/A') AS `enrollment_finish_date`,if(`e`.`enrollment_is_finished`,'Acabado','En curso') AS `enrollment_is_finished`,`e`.`enrollment_certificate_uid` AS `enrollment_certificate_uid`,`ule`.`user_lesson_id` AS `user_lesson_id`,sum(`ule`.`user_lesson_is_complete`) / count(`ule`.`user_lesson_is_complete`) AS `enrollment_progress` from (((((`courses` `c` left join `enrollments` `e` on(`c`.`course_id` = `e`.`course_id`)) join `levels` `l` on(`e`.`course_id` = `l`.`course_id`)) left join `user_level` `ul` on(`l`.`level_id` = `ul`.`level_id`)) join `lessons` `le` on(`l`.`level_id` = `le`.`level_id`)) left join `user_lesson` `ule` on(`le`.`lesson_id` = `ule`.`lesson_id` and `e`.`student_id` = `ule`.`user_id`)) group by `e`.`student_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-27 16:12:29
