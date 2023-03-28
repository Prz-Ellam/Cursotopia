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
-- Dumping data for table `categories`
--

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

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
-- Dumping data for table `chat_participants`
--

/*!40000 ALTER TABLE `chat_participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_participants` ENABLE KEYS */;

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
-- Dumping data for table `chats`
--

/*!40000 ALTER TABLE `chats` DISABLE KEYS */;
/*!40000 ALTER TABLE `chats` ENABLE KEYS */;

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
-- Dumping data for table `course_category`
--

/*!40000 ALTER TABLE `course_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_category` ENABLE KEYS */;

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
-- Dumping data for table `courses`
--

/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;

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
-- Dumping data for table `documents`
--

/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;

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

--
-- Dumping data for table `enrollments`
--

/*!40000 ALTER TABLE `enrollments` DISABLE KEYS */;
/*!40000 ALTER TABLE `enrollments` ENABLE KEYS */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'profilePicture-1679954729',18007,'image/jpeg','����4ICC_PROFILE\0\0\0$appl\0\0\0mntrRGB XYZ �\0\0\0\r\0\0 acspAPPL\0\0\0\0APPL\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0��\0\0\0\0\0�-appl�\Z��%M8�����\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\ndesc\0\0\0�\0\0\0ecprt\0\0d\0\0\0#wtpt\0\0�\0\0\0rXYZ\0\0�\0\0\0gXYZ\0\0�\0\0\0bXYZ\0\0�\0\0\0rTRC\0\0�\0\0\0 chad\0\0�\0\0\0,bTRC\0\0�\0\0\0 gTRC\0\0�\0\0\0 desc\0\0\0\0\0\0\0Display P3\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0text\0\0\0\0Copyright Apple Inc., 2017\0\0XYZ \0\0\0\0\0\0�Q\0\0\0\0�XYZ \0\0\0\0\0\0��\0\0=�����XYZ \0\0\0\0\0\0J�\0\0�7\0\0\n�XYZ \0\0\0\0\0\0(8\0\0\0\0ȹpara\0\0\0\0\0\0\0\0ff\0\0�\0\0\rY\0\0�\0\0\n[sf32\0\0\0\0\0B\0\0����&\0\0�\0\0����������\0\0�\0\0�n��\0C\0\n\r	\n\n\r\r\Z\Z\Z��\0C\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z��\0\0�\0�\"\0��\0\0\0\0\0\0\0\0\0\0\0\0\0\0	��\0M\0\0\0!1A\"Qaq�2B��#$R���3b���r%4CSc��6Td����������\0\Z\0\0\0\0\0\0\0\0\0\0\0\0��\0-\0\0\0\0\0\0\0!12A\"Qqa3��#��B����\0\0\0?\0���B��(	��a�	��\Z�N�E�`�2��zc�{c�/�퍤�5� �|x�M���,�mqJ${�n����`��ePq�/��o���Z��\\��\rGC��?�]�h6�#�C���*�.�A���G�%�),���3�|�I��u�z�~K�ŷ��q)����$*&����HS�\r�6���\Z bm���{�VMC��UҢ�=<�,H�e,\r�����n6���9�6�\Z��H�B#\0)$>�8agߵ�Lr���\0!�fcU�:=uD�.��emD��,\"���O��t0��\0?�ƙ9/kܮ�<+�J�u.�c�����f��\n�cư�l%�T���z�FsQ,@�6��_YUd�w25djy΃������~\rU�gTA���8F ��5��_IQIQ<��_m�b\r�o.WK�GWX��-[�_%mLI\Z�i\\\"��~�d�k���T\Z|��8êғ�\'Y���/����2��	���ώ�/���F��*m��^��K�TU��Y�H�ԭ7��ON�q.E���f/b_,��}uٌ)�U�F�JX	a�����j�cM�e�%b�u��q��!�\"���������6\n+�g\\�\'hd4�5�$R��\0\'���Ҏ��}Ew��^%�fa�\0Zd1�?{��gTOK�M]��IOYO$rE49��+�7�84�\\�a�D�T]�F7`v\'C!�jP�8,V�-c�MK�����$N��C�dᬞZ:��,�k�kKK�jeTؒ��c�e��z�Zzj颖�����\Z��`����S�1ʩk�9�D��}S:�$*��U���\0�W$��g�,��B��H�+/&ܷ ]T_a�p�$��*dYq�	8��\'ſ�_5��j`���D��!����s�x�ZbEjZI�B��2���^��_�p����	n���p^M\n�EeT��!n{��rOJ��xԖ�4Y��㖫3ϳzD��q3S�pQ`}p���÷�6�\0��<A�Uf�&X���p�L��,:1�|�/����\0��s\')=Os���%�X!������m�`�.\n�Ƨ�`O@bJ��#��j�$b=\0Ś�|NP2��\\���0~<?���^rmsf�׀r��e>��Ѻ[!8=���HB��2��p*M����Q���5|���#�k�8��@��ٴjH�\0�=�&���M�$�E�Z��/�4Q��s����\n�p^U�TsK��M�]{�ӠZ�rX����H��a�����˘���L1xo����3-sӝ��\'4��9.@��\\\'�1\0�c��	8��*�����.�X�8�G����n�H���\r~���lH�o����6����1%�d+VB�8oQ�m.FF.\\ �v����E�id�H�d��j_����à�ˇ�(H��c\r��/��|��Ǧ�Vy�6	(r�q��t�b(�&��m��6�\"�i�L��X�������X�xÅ*�C64�,e���O�N�}�F	IK�s�(+c�\Z���xL��1�ޟN�ꮶ:8U�$�G`���H�8�r���:]dX��`AS����tsϘ˖Q�#���$����������a\'\r�esp�FSIC]U�f�b�!�С�!H�|7��3�~\\N�U�W� �G���\'�:\\��������	�F���PP7f���al?�ɘE����b��X!�_Po��&T��(�.c���Bل� ���7�xz�>��&���ѵ\"�+Ik{~8��^�b�\0��/:�z���\0\\PqV^�:�Ո�m�R�V�LԜV�F��\'�W����x���;/�+LŜ����4�U�o��bw/��Y�YÙo�5Ml�#*�ERI������>9��ύ8^n0���� nYUc�:�}��/<a7	��<&s�Ub�YҠW�Sl��W�*QNM�>\n�/�p��}m\nV,�5p,���T\0�c�����\'���� ����9��\0-��5߶�{b������Q8�\\�cN��l�r+�6�}}0�&���ẺU��H�����  u\"��\ni�;�I�i��b����<��3J�s9D��p�\\��m����%u��)5Hk`>��W�R�gPUEU�f�d;;�F��|C��7���RD)*$\r�o�p}�՚0��㹞���J��-\\����~&����V��F�\\���1*<E�\0C�<cdi*��v\'�Y�ɩu�@�U�yR`4�f�RO]�1NWp�[�?Y1s[Dzϑnl:��e�Y�����s��RD,4�2�U�N�bN\n$��c����l��f����YVo�VT�[�-��;!��d.UV2I4����ƆUJ����mVk�,�a ����Yk���W���qaZ.\Z�\"��k��LdDM�����+U<��V�,��?l���館�i^v.��c�}����<�!�]��f?�8�ȣV�\0��OS����ĖDGǀ�\r\'��� �!F�plH\0r,:ণn��olI����|��3S�\"��S�l!+>Ui��3o�\r�,TnI?S��%K��(�k��˫B��k�\0�̒�y���/�|=�d�yFFV�%n&hh�Z�`MZM�Q��>s�4t�c��XY]KN���kX�=:�	�$\0|ޞ��2���Dڬ\0:B��|һQ4��rх[�����5�����ֆ�pLQ�=�H�(j�_���GB�7���o�|�5\0�p	7��_�yG�pFoj���pz�/��:�i��G�����bb\n���k��y�RÔ:E�>K\\*۶#xB�3���|ȩ���Wf�Q�N��9y5@\0oL�;m����JՕ��v�x��/IL�+��/�b>����\\(��7�ś�e7>�3aO���	�.}��׸�\'c����#�gPuĉ��e��������#��&���J�,8�%Z.8�JP-Z����ӴbC���}��k��n1�+�+N�5O��.����hL6޶GdZ8��8z�.f�bЉH�\'��N���s�2���\Zj�#EϤh���b-Ӧ+?��ȼD�%xfcT�Hb�l7���-w�1u�&:�d����-ŏI��y-�<�Ŝ9ǹ�	�f��L�jI�K���\\�\\p�WeYD�t�g�v���|�`5[��kW6w���+�Uo.�ຆZ�:JHڂE��[OLY�Ǜ�K�I:�����-�f���\0�ib$MW���ϸ�垷.�\nJ���&��z�z���5��l�\nJ	y�(Ue]ǘ`3\'˳�J$�˪&�tg�>�^��[Í�I��G6E�H���3�3��,�WMK��;҃\"��\'��\0��6�����=}����;��:�w��)Tm�-�\r��smGUl׾�\0��\0|S��ߦ�E�,2~�o��r�[��0�&�C]{[�{�N����a�S4����]��r���H%bT��|7é����M�bp��1��Z�6I�\'��ܝ��XO���LY�6/�O����c>�V}0��:\\!�d�C$?���C����|�#��s���(\\�d���n�o��?�[�U+ea�i���2lM��d�MS�	G�-��#X���6��ڛI\r{������`̇L����%S�\05�E�4�2)�|T�2$zU�ݶ�\0���|�56��p�ӌ�ݖd4Q����Zr5���#����l�<Z%��3��%IX�q�Ԉ�O��ޤ[�|\\��W�YA$U���,<9N��H�\0r�I%M\\\"W.�1n\nj_����aj��-�q/���T<E�S�\\�Q[��)�N��i �2Q-+�U{���P�<���+��-h�j�`H^ڎ��_�Ǡ<(ι9J��{�(��o���R\Z���\0�*��̡���ɑ-z��S4l~�j;[�\\:��5��:l�\ZyW1��7�:�!ԯ��*��b3<��x�7�C$QR%Ds����k�a8knPH�	�{��ᚖjw�:y�$���S��`��{+<�[Q܋���ST�*xo�NxO;�֖nJ4qK1�J��mG���:[|H�)�M9�\0��b���ȼ�6\\溙E�gZ���m���W�IQ��3�`��\'�*A��;´���6�Bm\"\0dYI�\'����}��-��e������q��S�|fN��AAS\r��5Z)Ҫ��s��=5�qq�u4�|sƙ�e�����T�\Z�ݎ��_\\#���O���#4��Q����,����q[��9kk�MOSS,$���\0�Lf��������xIM�~,peL�ل3,�`\\��C)�wǦ�@� ��(�Q�(-���1��rq��5<Y\\sZ\Z|��ADE�mE.�7��p;c�qo�O$QH3��5����}1^)5�\\�&X��u+Q�.K�f��V�*/R/�G�̮QM$ti���-lT���%r�5����\Z5KK%���q\"�$�Jɗ�eG$5\Z�%!r\Z�{b�N�I�֖k��R�^�.��*L������,�\'��ѥ����b�Y���8#���2���z��\n��_����=4p�����#�6<˞��\\S������/�ʟ�����s� �;j�l}?�G�W�h�QfPN��UYG�|��iS�Yj�)��\'aoㆰ��CxQ�%t��b�9>��W�c��uEľC,s�22r�q�W��������q�\0fq�\\��up��~��_�f;T7������-~#���9rVs�\0{[�ŕ�W<	 �\0�⵩�6�N�Tyc_kF��$r=�\0{i�t?|{bG!޼�6�s�a-J�	��R��9=���Z�m�ـ��د2�#���5�4s\Z�)ۗ\rM-�i�����ok��$ʡ|��)��)����giPx��,�{��S�⳥��������sC db./�Gpz�\Z&J�*��h��Y�\0f��Xeqc�뽭�a�OQ	�q;�6Xh�.�Zy�&r*����m�3*\nc*��v\"�o�U\"Fk���ü�$428 ��8��ukP3��S�}\ZW=Ď	��n�LY���.w��#TG�7҂�A��c��:	��G5ɴ���ŭufm.,;o�O�\\���\'VI���f��E������qlSܬZ��ŗ��I#mK{�}�p�YF��7�}����MY䘵��*�f=n@\0_��U�AI<�ƛ�Ǜ~����K[I.Jc��\'������J��D�2�5$����\'�U�Ge��#a��߆,~=���WV�S��!�����z���\'���]�@�������ǒ�K�Z�eJ��l[����*��K���?���.~������.o`w��]1;��Au�I��z���^�x{�o�o��i�Ϋ�b�6VGxɴ`ؒ�m{�Ϲ��2\n����P�Ꚁ�.Q��5U٬9}==��$K�;[M��������bA������K�\Z��v������k��(��`��#�sϩ�j���cӧ�8h<Lg��5��~X���\\r�Ǆ�w,���Ud�,YYI\Zlzu��=�\'1ss&�	�\Z�u�	��!������\0p�k��?19�K)�}q��9KÐ6[$4�ң47a�&�br��%�3�\0�W^LA����~KGC%6e�ҫf���@�KWy��c��5uzSf����)�N�A�ۜMe<A[Y��UKGD���*/N�1Zf�9;�q�5\\���\\�����+��#ʲ|�0�1t2y�`,;|���P�Z���\'�@�pT� ���e��*�Y}L���o��l>��8-V�z`!���h�9\'m�7��9����^���A�d�B�;�W>��������4�*��u�_|\Z��d�-)���	<x�K��y>׷|N��6N�LB�\'6tN��6A������G�9?\0�g�\0Yo��\Z<��[�p�p����Ŕ�H?<V���|�,�߁���K�8���՟O�X��\ZC��%xp��I���ؘ�u՛ t�;z����HB8[���q�C��bƪ�Ld�A��u?��K��/�Q��پ�lƅ|t�q�	nS����9�\r^�}�0�RL�h�l^8���;(\0���\'���y=)Qp�m�u#���u��G�3�Z���^�\'�h�\n6CE[I�ptIm$�̤�#M�Te�g���ҀXn��c�չ���%��9��3UMU��u���C�#WC�[b���▒�/�L�0�S;���5�.�_�b=p��S���0��sm_01o��\09�-�U�\Z}*�C��m�t1��\Z��3aW�!ȫ�`f�Tҫm����ۦ5�����ݐ��G\Z�^��*�����31iQ=���q�G�ڼۉe��^�z��3�V�)�	a��F�fm�ǔ�a�7$G�QQtGV�P�A3Ik�_���\n�`/Jm�;����\r���QY1�ݤ�V��>�o��.-?��ҙ��ǉ�ʌt��\'��,�.f�o�J=$���U;b�gW��ybf��R��M2���؏���,=�{��?_QU=|T�*4�GJ�:}��χ���8`J�נ^i��$_��m�S�\rf�Du���\"��Y�ذ��\0�*��id��jx�@�������5N:F���E͗d\'0���!UC!�d|�A%�j��Xzb��L��!��e���a�A��$b��2�������4�~Y%藓��J�7�L\\�]ƱS�Z����M�+��-�.�����FWb\Z����,�?���y��ũ`[��Y7۠}�<%��Re�O��L,���7rO�b��ŗ�(`��3~Kͩ\Z5pu\0@���o�wĔy-T���C<5Rr�ln\r�N���b��3L�ޚ��\r�\\�`���������1��z`���=�㊊������5E�9�j��rG_|P�5���^�<��Z����ܽW�GLz#��y���rJt2!g�PċnؿM,�K�#��G��)|nU�;O��0V�U��SU$}���%���u��uuM3��A+FWI�$[���i�g��ۋDK�.�����l��ǘM(�&z�W���+����qWQ��Y��;\"���zxJ�����g��Xl���-V�� }�1�j7�̾u�rX�W��)lt$�g�6��\'��\Z�WX�J�\'F	>�\0�S�	�\0���\0��\0�+j���:b��E\'��mb�����\n[61��Q�,Op��y�i8����\0,p^���Bp�]�������4��;b��uZ�u~�ūXũ�d��	����\'	U��|�SN��)�v@O��7�M �$����׵(�LNjL�ueҽq%�f5�^kI����ť�L��1h�m�2�����{�`�,�o	VP�T\rW�q����[��S0.��q�!�Lr[���pM�T�&�0���H>:��=NOTF�Y��b.�m,6��5��T�+�*���\0�mʏOlf4�Y#�^]X���̨؄�?vE�AG\0�Ŏ!���y��i��L[�^�D�E�K���Z_�CYK�\Z�L-x��&���/<���Zz:SQN��ʓ^��,/�ly�!�(�YA��HB�f4��!�����+.��E �9R&�16_��=]u?p�T�h�����f<m0�x����[��T˕���릒�N���^YP7���݆)>����s*�Q��k��pt`�U�nޢ�X���f��e�AOT�)���TN��4�9���lB��GKGL�O,���\"����7�����ݮh�.��ɰy��Q����虫e��@T\Z�J+��H�����p������o<nv�1R�W%iF�`챪�ʢ�[2���� ��2��YH��v����P�H1��//%1��c�A��_O��ݶ�\0<Q�Z1�Ǡ<�\Z#P�k|ܳ\0?�7�1>n��̐ϫ�\"���9�zi�y�);�����`b�1�)� �#�Ԗ!wks\0��+2��Q��Kl�\Z�j���1�HRSn�m�~$��d�B�M����O�ǿ��;�-�s��\\����CH�)����~a-������,|�$WQ�V�Cg�H�k\\��� �*<P�*ւ(i��^#�vTi4��m�X�x��>QD�|7��:���S�_0�L]�|����FW���d��� X�c���G��M>A�OEO\0AR�P[��l�fTS��,-#�!S��Y��U�9l�d	DR��W*K��\0.��j�ɸS��*�/���-��}$�0��G�����lr?S4\rkV�U.���׻t�`p5ĜE��˪�li���Uo�4�`;m�~+�!������U���ғ��~`op�,2�q|��c�,�k�?y����E��US\n��[�1S�R#SB̂����mp�?�C��x�\\�|b�/r#pN� qP�=G\".Z�MM�kb����D��4�R*���(4��f���%�zz�\\�L��c�@�n��1NQ&�HÈ�1;���姱cN�u-�ǯ�8I4\\Z��S����`_�\\\0e���n���W�+\Z��Ez�A��./��xs�F_A��Ψ��@?u�>���������&�=���\Z���.��6\'�\\9��*2���ɘj*\Z��v�{Xc�ut&���cC���3�WJ�饊B5FO�ۦ�3���\n>�3ܿ�)���n%���sXa@�%��ΊH��)�;�a��v��X�n\r�X�7.X1���T?�zed�~l\0���6���r7�bG,�8���L��9��s����=J�$��\0�n��$f{?`ob��8�Fè�PV*e��Fx��\\Y�?� ���	\r&ڔ�o�ƀd7BT����S:ڶ����<�?1b������W��[�p�Y�R�jks��@,i��G6�\0}4�_�F�`&8�	d���=J��~k|Xyx7M��3��I�s\0?�������6�\0.�[���I����S͗�|��+~\"�������U؅y⥣����*j�1��=8V\r�X�����q�x��p�\ZOx/� +�5��f��������DvlW��g���K3Hےz��8��J��725秉F�@�0�yH�ɽ�$��9�N_+AJ�GL ��YP)������5_N�\Z\ni]5b��l��c���_x؎���\0��~x��l���.�c��W��\'R�_>_�d�	���Ӗ�M��ň��FZ�)� g\ZTT\"�=�\ZҪȏ�ʲ؎�#�(�*c!\'h���4�����~���6�X�C]H)w\0��P�~�釓�5	�c��K�R����������tiu����bO)�s,�Dl���@CrZ�X����\0��5I�=+���D�8�M4���s|9Js���������#��*8����Yuә)���v�<�qU?x���_�b�k~�����4��#���#��t���ǫ�R<����(hnl�_-�`T�{aڛ�v��Q�I?��_�Ut�5Sg	M ��_���f�k������	H8v��\\�w�I%s�RH,C����U��<=*���\\rX ���;���|5��s܊\ni��I[�H��M���l\'7Qx�%v;OY^3��3��93�\r#E\ZF̤�~���n:�)x/��s�a�xs*\'������`V#�\rm��md���Y+Q�1��3\n@�\0[\rg	ñ�*��.����nx7p}1T��bY>Y#<���r��(����&9fk��!���R�u��Vf	��]}U\r&^f��g�94��R@?P1�~+4����ҲGI<Q/�W�m&?]��C�#�=_)��Q��M�|K�Qn_#O	%����[�:	턾X�SmX��ܼ��t텨i~&UX��&�o�\r�~���~MB�YcO\"�$�J:(;���zbS���g_m8�鵀�gs�Ħc1y$1\'k|���o�A�;*I�8m�:_�$�����;c��\n�����e���D�L�����m�c��olkM��@-�Xz���4wM��5��`@#�m�\r��T�;�\0e��1�ÿb\'mK�r��gB/��H,F�~�c��q��M���\0���x����u`n��擙�\\\\.�����%e�d�^m����S5e]i���z�\",�HE�*��M{��]&�%E��b�1Q�Ik\rVܞ�t�1�x%)P�m`}Α�\r�\0��fBZc���B�����HQ��{��m��qF��Y������7T�kfbv\0��ڦ۵���G�[s��04�Y\0�����qam��a\Z����bmۮ�J�Z�^���|D�D��X�F��F�\0B0H\\�4ǒBy{yGo��7�1]�E�P؏���x����f���m�\\	L!�T��Z����j��⩁��\"�U�C�=IE�I��,��r\nz���QT�KQ4��,5�-���F�emE۶�v�?\0fE�;���RV���CYELjt��.��0������c�x�0�L�:�E4S�L���NH㈐�w��\'�/�b��*jc6��!�]n��b����ii�X�y�H��TsXd,O�ݭ����u��*(M���~>���=B�����VSe\\]P�S��e3�낪WB�&��Z��|Y�Uqo��va���2��~J��}��lqA����2�Hk̜��D��Z�,\r�����Y\Z�pPeS�$YeK�d���+a�q��/�e�ΏE�I���,���~\n�)�b��V)I�0����qm�|R~α�^@��[k�k1ἳ*���\\�0�;�\'zw=H�/�e��/p\Z��L��^&j{�NĞ�[�h�e����b�n1�`��aL��g��Zy���I�#Tȶ��3��Q��!X�-���`:�|Pӡ��D�<�,`\n	b��:�;_<m���MY�T��~\'TFE]\Z�Qd��Y��5��,H��#��e��\"�8?�y��&�`�3^�%7*}	�����[@\n�`�}���=�AX����#�W1:��w{�YG�[�\Zth��a��;����*ت@]��9�S`Rv�ê��\Z��[�	X~e��\0�_�B��.���1�z�~Vҕ-.�x��C\re|�o�:�H�Ɩ_�	 ���7۳���n	��-�\0�{_��ʗ뷿o��[�b.�Ø�\'C|q\Z�����8{in���<61:X�a��$|�\"W��:��2?�Ą0�[i [��\0_�aX�~\'JQ�]]${_�\Z�,M�id�)�!�W?�)پ�;��P����F\'y��o\\Ry��W����4�<��������@0OU�f<s:��Jz|꒢�1�c�uD��B��Rz�q��S�v\n-eU��{���I��s��L݈�����UX�1��$��p�q������XH��/~���c����1[g��������\"����}�,\Z�4xʷ�:[�b+5���)b��{�X���`�<�Dܺ���*s\Z�Uh���r4B�.[lCUɗ͙,3�iK�3�F)��:��#T�w��z��I��rt)EKCE��U\"U2���\Z���|���=M��_Ǆ��x���Y�g���´�G��pF�fuX�W��\0w\0���6��f�����nOG\r;�IQK�FH�w&븲��0).uKYH�c����h1�>��-�b��ru9q�L6��	8��+�L�|�8�j��ƙ9�Q�ǦT �m�}I�{�K#e���`c�\Z�����z�&��2_)$�h�.2��1�t�M���&�s��r�lV����d��D���6�?,&p�h�u�Ϋ\"���Q	��s>ۇ,\0���[�\nG��w\"z\\�%PWH�L-~�b�����*AIB ���X�c�7}�|���S4X�����ɾ�W��q��n)����⚲z�l��MQ0�!N��Z��Ǥ���>0��9���T�Ck��o4m�M��qS�߈S�4�4E�[�+*A�s�m�eA��=&}Ϭ���sS������}n}0����8���\\�6��%��M,LV�)��~��=��*b��9{	F+�M+n�݆k�ˈ8?5���#zJ�~�0�?��,�va�C�������^oe2�a��K.����|�|1ͫ��L��>{(�5�m�����4�m�t�&��qJ9�t��J���(Sco|H��\n2\\�D�&fܫ��;�pƁVBV��m ���O|N�AM�S�-���I�b5~���c�I�\Z�j������ �3q k[�zc+�MQ$�3I�uU!����|#=<��沺�\0��H�)Qp���񦏠�MpB�$��Y[��28�p�A\nX-��FZ�QS�k����|J�L`�ji㐀�[�ف�:���n�vՑ*�.�^�OC��uO8�a�n����o��h&㯱�ՙ��LD5mc���?!!o��=1d��7T��|�uq�|�rn�=���Oϰie��Ž��k\0lG����L��\"J���H�������C\'����9��$ۮ�����1)��B�@=�\"��w���\'��Ĝ`W<z��[�5h-po��������6/�\\\\Xt��T�K�!���?K�ޛ��֣{�����\ng��|��JI;_{\0\\9��mk�\0���ƒ6o*��lHP�G�Y���nl�,VM����6�п��i�B�T�R�ݒ���L����vn�\0��eTɘRGT5�)\"\nd1����OVk�nޑ�}|�IZM&P�F�1-\\���![���ֽ�v:��:h��Aya旒sԼ�m��.�=\\Qm�#/W[CvG�\\�cK4�CF$֙u�ӫ��.�;���Ǹa�e:�L�0Y\r�c@�;�\r*6z�O�%j2�1���B4�;Zۀ�b0�乎?;�ʫ���\0,:�Q˔��[�M�T8��tZ�ǚ��5=$Fw1�r@�6\'{�8���3�z��\0W���yj%�S�&�����2�T����)*u\0z~8sG�M=T��MM���w\Zof\'���K��ާȾc!��Fz�V��\n�R�~k�\0��	�y�W��9\\�g�9�@�����B=�:i梏L�R�I��\0x������ق��o�q�n.!neKQL2h��h\'Z4�#0\'�>�X�pg×�\Z�ɥ�H�G��1���^cG&_[MGP��@���կ�s����(�UT�	+%�7�o|r����{�	���)�6�3�*�)����~��d���̤�GVd2B�5ήS0Gm�b�-�1�h�>�isy��b\'@�P��Pg��MYE��RRȒjJY��(`N�vǣ=C4���ѕ|d�sM�Eh�S2ǧn�|Q���+�\0�Q�ѝ$BO0Nt�M����\"�ix��ks��ɳI\"Yf�8��A^�z���6�A$�ĹD���2�=qJ��qd�Y��\'�\0��D,{ae��]��㢭m�ޘ��s�H�\\��)\'����\"�S~�7?�ٜT�G��tq�QK�G�d(�T;\\��ˍ�ݬ}�ۃ���)�(��=\\�*�额A�w���91�9��њɕR�2�Z��z+�\0|�H�bk�&ʤ�F(�����-͏��yK[lk�²(X/�7?L9!1J�H�FB���w��	�xs�2��bx�ځ�R��!���{�����~��%5�\0ˤ.���B;���l\rX���i\"��u.��d�{�<�Y]Kh�_P��6��v��;�ǧ̤�AǓ��6�$;�s�2:�;l�5����H�P�P�&�洞_mW�8�[��:a�WU�4�2�xJI Ce�B@��\Z��;���f��-C|U%HX�]�u!�^ڊ�����M�\nv,\n��wk���\0_��|��Ԑf����	k^��Q���p��r/ӡ�J�U(��ҡ̖*E�ަ�<�{hu�t��%�1�K)W��,\r�\0����\0�5-;��I#�_���I��T�O�̳��\"8Ԗp5m�\"�\0�q%+��R�bV����=(6D��U���<��Z2cS4�V�F�n��׾�|0�d������-\\&�5���+��G����o�9KC�B�w��^3W�&~\\	2��t�E�7��:t���e]e]T�7^�c���`�6Mt�AV�sI�WX�拵�q!@�y�BC	%	}=qf�\Z��j�\0��}q`SSey<Z��\\¥�4y=3�lCT���7�l�w�u�����y{v_/��pK,o5D�L�g�\n��}9�a�yGrp1��AJ�4n���o\'����1=�E<싘4ZSh(i��ƠX\0-{zj�{o�Y�H���k�����\0\\��%Xp{q��FU2��1f>���$Jjf����i$/�|�`y�,�l/�����$52� r��Mɹ�O�I\'m\n�)��y9�׶���O��SC2�]yj���ZØ��A|Ld��F[;�U��>��`\r5�`�ҥF��ߕ��-����J��Ă0��`R	������ـ��6H��8h�-v�+\nb�K,bצ�e�ֺ��N,n\ndX���N�	�}�r:�������T���_�;�+.2���������|��<�j4�3H��u]k\\U�R������Uzm���/I�Ӣ�OP�l�ۥ�p�\Z�t>R���ǌ3e��|7�T�UX�*��t�b����ǜ��U*j�U\n\'p\0�����/���--C��1����(��S�d8�fǇe��#xrdߏ��sZ��wvU��	��WNj�c�uca��mҲ(�)$�.(xo>��2�Ǖӱ[�5k��\0���������s4}�UU�\0m�~%�4�C�&c�V�\0��$zi�߽�L�p	4�Y���El2n�h�Z����H�hH��k�m����a�S$��_�\"���v��t��=����\0,v��Z�j؟l\0C���|�@B�|�U��Xl��\r���\rci�!�X�[|d��DcBF�Q���댊H�TD�R#h`m���۸�G��&����Mj.��}-뎖�r����-�e:n6��t�8�\Z$6�\0Ƕ�<;����M���}A��8��(�d�W2��!p$_;-���;v?�S\"rr��-���E<�\n�B-����h6�$mӶ�F�\0k�v;`�(U�\n�E���\r�x[`O����0:�,Ǌ9U2J��J9`�ia�kumJB/�Sf��؋^�\rbYX̠��%S��ۮ��az�����G��t)�����\0���wcpͬ��[&�B1��y&rzm5p9�Ȩ�d��D�U�u �o�U̓f}LL)����\n�B��<�׽�����L�\nz:������ܐ����w�y�4y�w�a��\"�u�����S[���JM;:�Ė:kg��\0��j��RE<�I���G1����RCu\"���1�&q\\И)�g,d�5}X�[��<q�T��p���⮏\'��x�����H�z���,���d�Q<���n@��~W��8z�T��D\ZE��jY�-K�1���;��\0[b.k&��$���G_�KS32���;*����Nbd���-km�lĨf:8I*��(��!dt9G�?G/�	J\ZYH�(5)�c�U��[����1��7ነ�IOp5�6��?�ϖ�Ϩ��\'*�^����@#��`?.��̥M����e:Ue+YJT�R0��O_%����Jv����L��I⌫;�B�2����p_����<Z��)�����b�A��,	��x���u?-��fiA�V-DeҪ�JX��RH;��ls������a�4��j��XhᗞјC��N������8⮅*c�W��EPi*��q����\\UY��4�Z�\Z5����k�ot�@;�\'�$��9ަ�cI���c�F���넸9���5�O�l��G\\w���_��q���٫�y��_��*����r�з��S��A��*���\\��	���Ս�s)��1v�����ue��HH/���\r����2=\'������u:|4	{��ǳ7�\n1d��C�k��S_=ZAD�K2��ؑe�h_A���w\'����Ŷ�-�G �h�6��HČR\"܂��D�E��y�LƗ5֖��E:����b2 ]ؓ�I��Z���Ɔ���c�\0#�+q�O\\tU�}{�j%��c�]D|��׫����c�A�fF��������\0������d�2����1��Ի,h��\"��1��V��2msm�7�6<Ã�#�s縰�����[P�,�Cj�M�SpyM����HJJ�\n9�Gqm��}��f�{I8ܫlA����>�\0�nib5�5���HI�`ms������$\r�_��\r4&�����`,���H��	u\ZX��89v�|t�7�\n)c����	_��8u����{��x/���F[�9hӉ8����7�8�o;���A�\\�->���[Y\0�\'�]���<=�����b�u�I�U��7=7���Y*z�gȞ7^����y�.u�nǔp�&Z �脄0\na�:kЎdm�Q�4�K,�r��,�X�>_勂���:���BZe2���\\�۩��8���[1�[ٝ��G�.���D�fd��{��0�.�Vk�B��l;�����=�\ZJ��̲X��o���;�5\n	�0IO�~T�+)7�Gw�~�r��)��y,$m6�`B;����\0���+��x����`\0�Lwi$����������8$�Ƭ!��c���jw���AN&ꪋe�\r���5�O-{˓Ta�y�%���с�\rR��$w{)(�\n���ຎ�\"��4Q��J��7��+��uS�����{�O�!��3Z]DU\r������\0\\)^95��6��`;�؏�벪\\�\Z�)&˥G�Y�#��b0QYMM\\9�4���RD$Q��\\\'tƪ����IAƭ��\\�2���tæ�3F*���l\nւ�7�N$�*iQj$��D��u�\rߦ�#W�6L���,-�(�z3kf���7�q2��B \n�E�鲁����1�!q�7����[㴀IȬW@{�1�p�\rD�\'����95��0r#i[�����U�	p*K�_t�\0|EM.��{t�c1��n��\r*�����c1��F%������0�U����*��R��Y$$[���c0O�#܉(]G��\Z�����:d��A�`z0�̤ZJ�� f���v�������aE���̫�4�ݍ��8|̲Օ�:�k�7n�����%�\'�����N���y�eW\Z����z�[��¾�j��.���R�A=#,��<��Q7�q�o/��3���;��ơ�\n��,�0�疫/������l-k/O|ֳJҳ�$��B�1��R�|�ȥ��f�[��F�Nqp�?��m����-�BqF%A��3G�r��[��ѬO��8�f��O*����\"#H�X $\\��\\7H�%,IZ�=$���0�F3�>��{��0 6�I��Ix��I���%�x�3�@��K���:���u�\0�w��\'��7�c0-+3\\���','2023-03-27 22:05:29','2023-03-27 22:05:29',1);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;

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
-- Dumping data for table `lessons`
--

/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;

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
-- Dumping data for table `levels`
--

/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;

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
-- Dumping data for table `links`
--

/*!40000 ALTER TABLE `links` DISABLE KEYS */;
/*!40000 ALTER TABLE `links` ENABLE KEYS */;

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
-- Dumping data for table `message_views`
--

/*!40000 ALTER TABLE `message_views` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_views` ENABLE KEYS */;

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
-- Dumping data for table `messages`
--

/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'Tarjeta de crédito/débito','2023-03-27 22:05:42','2023-03-27 22:05:42',1),(2,'PayPal','2023-03-27 22:05:42','2023-03-27 22:05:42',1);
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;

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
-- Dumping data for table `reviews`
--

/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador',0,'2023-03-13 00:01:38','2023-03-13 00:01:38',1),(2,'Instructor',1,'2023-03-13 00:01:41','2023-03-13 00:01:41',1),(3,'Estudiante',1,'2023-03-13 00:01:45','2023-03-13 00:01:45',1);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

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
-- Dumping data for table `user_lesson`
--

/*!40000 ALTER TABLE `user_lesson` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_lesson` ENABLE KEYS */;

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

--
-- Dumping data for table `user_level`
--

/*!40000 ALTER TABLE `user_level` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_level` ENABLE KEYS */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','2001-10-26','Masculino','root@root.com','$2y$10$lK4o1rqArg7UfdkkYmx7f.8S0bZ/VPq5J7lAjIFOB/4/wGXcgBWsW',1,1,1,'2023-03-13 00:03:46','2023-03-13 00:03:46',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

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
-- Dumping data for table `videos`
--

/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;

--
-- Final view structure for view `course_details`
--

/*!50001 DROP VIEW IF EXISTS `course_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
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
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
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
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
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

-- Dump completed on 2023-03-27 16:06:25
