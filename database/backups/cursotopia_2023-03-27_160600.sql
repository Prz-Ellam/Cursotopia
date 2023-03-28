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
INSERT INTO `images` VALUES (1,'profilePicture-1679954729',18007,'image/jpeg','ÿØÿâ4ICC_PROFILE\0\0\0$appl\0\0\0mntrRGB XYZ á\0\0\0\r\0\0 acspAPPL\0\0\0\0APPL\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0öÖ\0\0\0\0\0Ó-applÊ\Z•‚%M8™ÕÑê‚\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\ndesc\0\0\0ü\0\0\0ecprt\0\0d\0\0\0#wtpt\0\0ˆ\0\0\0rXYZ\0\0œ\0\0\0gXYZ\0\0°\0\0\0bXYZ\0\0Ä\0\0\0rTRC\0\0Ø\0\0\0 chad\0\0ø\0\0\0,bTRC\0\0Ø\0\0\0 gTRC\0\0Ø\0\0\0 desc\0\0\0\0\0\0\0Display P3\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0text\0\0\0\0Copyright Apple Inc., 2017\0\0XYZ \0\0\0\0\0\0óQ\0\0\0\0ÌXYZ \0\0\0\0\0\0ƒß\0\0=¿ÿÿÿ»XYZ \0\0\0\0\0\0J¿\0\0±7\0\0\n¹XYZ \0\0\0\0\0\0(8\0\0\0\0È¹para\0\0\0\0\0\0\0\0ff\0\0ò§\0\0\rY\0\0Ğ\0\0\n[sf32\0\0\0\0\0B\0\0Şÿÿó&\0\0“\0\0ıÿÿû¢ÿÿı£\0\0Ü\0\0ÀnÿÛ\0C\0\n\r	\n\n\r\r\Z\Z\ZÿÛ\0C\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\Z\ZÿÀ\0\0å\0ú\"\0ÿÄ\0\0\0\0\0\0\0\0\0\0\0\0\0\0	ÿÄ\0M\0\0\0!1A\"Qaq2B‘¡#$R±Áğ3b‚Ñár%4CSc¢ñ6Tdƒ’²„“”¤ÒÿÄ\0\Z\0\0\0\0\0\0\0\0\0\0\0\0ÿÄ\0-\0\0\0\0\0\0\0!12A\"Qqa3Á#±ğB‘¡ÿÚ\0\0\0?\0ğ‚¹BàŒ(	–a×	ı¶\ZNºEö`±2¤‚zc›{c¹/¸í¤¢5û Ÿ|xğMÁçö,ømqJ${ànöš§Ü`Ÿ„ePq”/ìÃo®ØŞZƒ€\\°ü\rGC‰”?Æ]õh6¶#‡C‰•™*Ë.ÇA±ôÁG“%Á),²ùÃ3ë|ÈI‘‹uÔzâ~KÅ·¸êq)¼­óÃ$*&»áÁHS¢\r÷6üğß\Z bm…±¨{•VMC™ÒUÒ¢É=<Ë,H÷e,\rÅÅ÷“ân6Íø§9‹6Í\Z®HğB#\0)$>·8agßµLrÀƒ¾\0!ÍfcU˜:=uD•.‚ÊemDŞß,\"©¬ÙOÓÇt0¦ÿ\0?ôÆ™9/kÜ®÷<+íJ¡u.äcşø™Êøfº²\n™cÆ°l%™T²ÚûzíˆFsQ,@›6ÊĞ_YUdùw25djyÎƒ¬±¶ı±ç~\rUägTA©”µÂ–8F Ö‹5¿®_IQIQ<ÔÅ_m›b\r·o.WK³GWX‰ã-[ù_%mLI\Z–i\\\"íë‹~ÎdÎk²¬”T\Z|–8ÃªÒ“ç\'Yşğ÷/†–²§2²	àÉòÏ¨/ú²®Fñª·Û*m¸ë†^¿ÇKœTU ’YØHÌÔ­7˜’ONq.E­¿Áf/b_,—â}uÙŒ)šUÖF©JX	a½ı±ùájêcM’e¨%bŸuµ¬qÄÁ!Ì\"èÓğãìÄéÔú6\n+©g\\±\'hd4Æ5$R‹€\0\'±¿®Ò‘ë}Ew”¹^%¥faÿ\0Zd1÷?{·ÏgTOK”M]”ÕIOYO$rE49¨”+’7é€84â\\µaŠD”T]‚F7`v\'C!ÈjPÇ8,VÍ-c¿MKÓ“İÇÛ$NçŸÚCdá¬Z:œ¯,ÌkäkKK—jeTØ’Ò·cØe¿Úz²Zzjé¢–»”¢¥Ú\Z»÷`ÃÖÃÕSğ1Ê©k£9õDµ¹}S:É$*¿¬U“ì›õ\0í‹W$“Ãgá,¨×B’×H‰+/&Ü· ]T_a‹pÏ$ÛÕ*dYqÂ	8ÆÑ\'Å¿Ú_5¥Ëj`¥‚‹D¨È!ú÷÷Ås—xáZbEjZIèBØ2ñ‡¸^³„_ôp†’¯í	nÀÇ—p^M\n¥EeTµª!n{áêrOJ•‰xÔ–­4Yƒã–«3Ï³zDÌq3SÁpQ`}pÜø³Ã·û6ÿ\0ô£<AUfé&XñÉàpÉL‹å,:1·|·/¹ıÿ\0ı¼s\')=Os¦§¥%±X!½öÂÔâïmú`.\n‘Æ§ª`O@bJ“#‰j™$b=\0Åš‘|NP2Üã\\Øíö0~<?¤¶©^rmsfÆ×€rñ÷e>ÅñšÑº[!8=”åÜHB‘û2›ıp*M£íÒQåù…5|¦©Œ#¹kş8‹Ã@ÅÄÙ´jHî\0¶=ì&©èİM†$²EÕZªœ/†4Q¯ës¥ù‚£\nÒp^U–TsK¬‡M¬]{àÓ Z°rX¼¬«ÔHŸ¬aŞø´äåË˜ƒ¶äL1xo…‘™Ÿ3-sÓşØ\'4Á9.@µÀ\\\'³1\0íc¿®	8* ‘ÍÏ.²X8GÙí¶é€nÂHÈÓï\r~‹ë„ÙlHÜoĞáëÓ6ÎÛè1%–d+VB³8oQm.FF.\\ vÛµÚìE±idÜHúd©ıj_ìéÜâÃ ğË‡ª(H–c\rºÈ/«é|¨‡Ç¦›Vy¢6	(r—qóí‡tµb(ö&å·îm‹»6ğ\"†išL²²X¡µôééõşX©xÃ…*¸C64•,eîĞO§Nµ}½F	IKsÅ(+cÊ\Z¤–‚xLŠó1ŞŞŸN˜ê®¶:8Uô$ÓG`¾à±Hö8„rÔóÅ:]dXÁ—`AS·Öş˜tsÏ˜Ë–Qó#›—$³¥ÌµÊŠÂØôa\'\rÕespÅFSIC]UŸfõb™!µĞ¡û!Hó|7ğì3~\\N¥U–W‘ G—ùá\'â:\\§‡¦¢¢©•ó	ãF§––PP7fµÁ·al?ğÉ˜E™±©b„“X!¿_Po‰é¥&TÊ(×.c‡ŒBÙ„Í ¥·7Ëxz£>£Í&¥©ÔÑµ\"³+Ik{~8ãé^–bÿ\0³‚/:Êzãÿ\0\\PqV^î”:ËÕˆæmÀRñ€VøLÔœVFÁ¥\'¨Wø£„x§„ş;/ƒ+LÅœˆµ´ˆ4°U®o¾àbw/á±ÅYîYÃ™oÁ5Ml÷#*”ERI±ÚŞø€â>9ÎøÏ8^n0´ÑÈâ nYUcæ:Ï}†ø/<a7	«æ<&sóUb–YÒ W·SlŒšWÈ*QNMÆ>\nñ/×p¤¹}m\nV,Õ5p,²²†T\0ºc¾›íŞø\'áÏ²® ¶–´Â9Áš\0-ËÔ5ß¶û{b–ã¸³ˆ©Q8Â\\ÎcNÍğl±r+Ÿ6Ö}}0ó&ãŒù¢áººUª–H•èä–óªŸ  u\"øº\niÊ;‘IÎi¨ËbïñÂÊ<—‡3Jés9DÉÌpÀ\\ÔmŠš’¯%uåå)5Hk`>ÕğW›RñgPUEU“fºd;;ÜFÆí|CÃá7²¤±RD)*$\ræoÃp}°Õš0Ÿöã¹”åîJĞÇ-\\’Šº¢~&­’–•VüˆF¹\\×è1*<Eá•\0CÁ<cdi*üÄv\'ßYÉ©u–@ïUÌyR`4Íf±RO]½1NWp¾[ñµ?Y1s[DzÏ‘nl:öeY·’ÛüúsÇ±RD,4“2U“NÛbN\n$¨¨cóÛğÅl¹Öfı¬í‡YVo™VT[Ø-úá©;!´‘d.UV2I4‡­ÙÈÆ†UJÖ²œ‡mVk›,Œa ±·ÛÃYk³Œ³WÈÏ×qaZ.\Z¸\"¢Êkš•LdDMÁ¹¸÷Å+U<²ÏVÏ,—¸?lâÏáé¤¨ài^v.í—cÔïŠ²}¥«¿¶<‡!²]”êf?æ8‘È£V®\0‹ùOSˆèşÉÄ–DGÇ€Û\r\'í— ”!FÛplH\0r,:à¦£n›ÜolI¼­ÚØ|Éñ3SØ\"¯¯Sél!+>Ui°í‡3oß\r·,TnI?S‰Ÿ%K€‹(…kµÈË«B‚¯kÿ\0é‚Ì’yÀïì½/„|=¢d†yFFV÷%n&hh§Z¢`MZMöQ°Ç>s¹4tñc¨¦XY]KN… kX™=:´	µ$\0|Ş¸È2ùšDÚ¬\0:Bïï|Ò»Q4Š‰rÑ…[úÛıñè–5¶Äòå°òÖ†ãpLQ¾=äHÜ(j„_®¢ªGBà7•¾‡oÃ|õ5\0á€p	7÷À_ŠyGÆpFojîü†pzŸ/›ù:é¢i«‹G‘©”‰ébb\nÈÁïkŞÇyŒRÃ”:E>K\\*Û¶#xBÌ3ú©Ì|È©éÙ×Wf°QüNø…9y5@\0oLİ;m‡·¹ÌJÕ•¯”vşx²¼/ILŸ+›Õ/¡b>¿¿ü±\\(²ì7°Å›áe7>›3aOÎÒè	ø.}…×¸¶\'c‹½ñ¢Ì#ÔgPuÄ‰½ÏeØõÂõñşÍ#¢&… ­Jî,8Í%Z.8ÈJP-Z‰¡ı”Ó´bCªöÓ}ğëŒkåân1Î+¹+Nõ5O‹§.Èü¸ÅhL6Ş¶GdZ8«8z›.fªbĞ‰H¸\'ìNø¶ó¿sé2‡Š\Zjâ³#EÏ¤h¶Œ‡b-Ó¦+?èåÈ¼Dá©%xfcTÚHb÷l7¶øõ-wÉ1uŠ&:×d•ÉüÆ-ÅIİÎy-ª<åÅœ9Ç¹´	—fùªL’jIáKØ¼À\\Ÿ\\p§WeYD´tªg‚v•äÔ|ï`5[¡ÁkW6w™ÓÇ+¹Uo.äàº†Zú:JHÚ‚EÒÄ[OLYéÇ›¶KêI:¡÷Š¸«-Êfšš\0‘ib$MW±ô«Ï¸å·.‚\nJº¥Ö&ºìz€z–¸ò«5ªálÂ\nJ	y’(Ue]Ç˜`3\'Ë³ºJ$©Ëª&­tg†>»^Âø[ÃÉI­ÆG6E“H…­ñ33¶§,ÎWMK„Ç;Òƒ\"„©\'©À\0áà6š‡¾úŒ=}ğş¦“;Ìó:ç­wø‘)Tmı-Ó\r›‡smGUl×¾ÿ\0¯ÿ\0|S±ß¦”EË,2~£oè¢Àr¾[µı0ï&†C]{[È{á„Nà€­ùaöS4¢µ´¹]­rÆÕñH%bTÚç|7Ã©ßÕÈÆMÛbpè1ŒÔZ¼6Ià\'éıÜ½ñXO¼µŸLYü6/ÀOí‡óÅc>ÒV}0˜ò:\\!¤dâC$?¶şCˆø¾Ë|±#€s¹ê§(\\¸düÄénÛo‰?¼[ÛU+eai¾“çŠ2lM…Úd…MSš	G‘-¥ï#X¶•õ6Û€Ú›I\r{õÁŸæ¡ª`Ì‡L¾¡æ”î%Sÿ\05ÆE‡4Ï2)«|Tê•2$zUæİ¶ÿ\0”¯ã|ò56´pÇÓŒ“İ–d4Qğ·ÓÆÁZr5”¾í#»ˆŠl«<Z%Ìë3ü«%IX´q×ÔˆOùÆŞ¤[ß|\\ÒÏWÃYA$U¾×Ä,<9N•‚Hê\0rÑI%M\\\"W.„1n\nj_±ÒÂÇajíù-Íq/ñ«Ñæ´T<E˜S‹\\ƒQ[ßí)êN˜»i ƒ2Q-+êU{í½ºßPã<ºó˜Å+™¬-h„jƒ`H^ÚöØ_ Ç <(Î¹9JÑÉ{¡(‹›oÇ¶µR\Zœ¢ÿ\0î*ãšşÌ¡¥§ıÉ‘-zÜÀS4l~Ëj;[¯\\:®“5©‚:lâ\ZyW1’7§:£!Ô¯‘Á*ûúb3<ğåx‹7„C$QR%Ds…àék…a8knPHé¶	ø{ááš–jwŠ:y™$’’ÊS¬‰`®‰{+<Ä[QÜ‹àÚØSTÏ*xo“NxO;ÌÖ–nJ4qK1JímG©¹è:[|Hñ)¾M9ÿ\0åŸøb×Íé¡È¼ı6\\æº™E­gZ¹ğÑmûâ¦âW¾IQØü3Ä`–â\'’*AÓé‹;Â´‰¨ó6”Bm\"\0dYIû\'¦çŠÀ}¦-Ÿæeù¥äåê•q‚şSØ|fNÆïAAS\r‹ü5Z)Òª˜s¹é=5ïqq†u4•|sÆ™‹e”ëÆÕÕT•\Zªİş€_\\#ğîOÇ×ñ#4°ÓQ²™ÀÖ,»óÅq[œŠ9kkò¹MOSS,$‚Å¶\0ıLfş’§ûôú­´xIMÁ~,peLÊÙ„3,í`\\˜ÙC)èwÇ¦ë¼@Ë …£(•Qœ(- ‹ı1çÏrqâ‡5<Y\\sZ\Z|º©ADE¥mE.Š7µíp;cĞqo†O$QH3½5‹½¯İ}1^)5\\‘&XÅäu+Qâ.K–fó²ÇVÀ*/R/‡GÄÌ®QM$ti‘˜€-lTø¥á%rã5®‚ã\Z5KK%µÒúq\"Ş$øJÉ—ËeG$5\Zù%!r\Zİ{bN•IèÖ–küR¢^Ì. *Là¸áßó,×\'¢Ñ¥ñÆÈÕbÁY¾àô8#â¼Ì2—€ç™z´è\n§_å¶—Œ¼=4påÊï¥#†6<ËƒÔ\\S”—¸ô´Â/ØÊŸ‰øÉçÌsò Ë;jûl}?†G”W¼hÍQfPNığUYGÃ|¹iS’Yjé)»…\'aoã†°ø•CxQ¨%tºb—9>ĞŒW¿cÌ§uEÄ¾C,sÉ22r‡qˆWÉÖø–á¨ØÕÉqÿ\0fqÍ\\—up´í~ÄÛ_®f;T7Ìá ÷Àš¸-~#ş’ı9rVsÿ\0{[ôÅ•ÃW<	 ÿ\0Â“øâµ©¿6³NØTyc_kF¿¦$r=³\0{iÄt?|{bG!Ş¼ğœ6¡sía-Jİ	ìÃRŸ×9=ÎêòZİm€Ù€æ¿üØ¯2ª#éİÙ5’4s\Zú)Û—\rM-Ëi¾†ƒúokàï$Ê¡|Š¯)«…)³Œ–±giPxÁµ,Š{‚¾Sí¤â³¥©Š®¦‘ÄsC db./èGpzƒ\Z&Jî*¡©hšYÿ\0fçXeqc¹ë½­éaOQ	·q;6XhÓ.†Zy¿&r*½ÒÛm†3*\nc*‚Åv\"ıo†U\"Fk¡ò‹öÃ¼½$428 É8‡¤ukP3•ÖS®}\ZW=Ä	¾çnßLYüù….wšÁ#TGñ7Ò‚åAÜïcŠç:	‘çG5É´´ÉÀÅ­ufm.,;oíƒOó\\îš«ê\'VI¯‰Óf˜€EŠŞÁ—©ßqlSÜ¬Zš…Å—ı§I#mK{è}ìpñYF½‰7è}ñ”ÌËMYä˜µ¹*…f=n@\0_äçUëAI<ò±Æ›ˆÇ›~¶÷µñK[I.Jcè\'áåå•åÌóJÌÒD–2¦5$òÔ“–\'ÜUÜGeÈç#ağæß†,~=ÏÏ×WVÅSÒÓ!¦¦…ÈÔz±¶×\'·¥±]ñ@ÓÃõ§ìÇğ°Ç’¤K–Z¥eJ“él[¾´ë”æ†*ˆK„¨Š?»×Î.~˜¨ÇÙ÷¶.o`wÈó]1;†¨Au¡IÀòz±¸ù^Ñx{Ñoğoå™İiªÎ«„b®6VGxÉ´`Ø’»m{ãÏ¹ÚÆ2\n–Œë¢P­êš€.Q´µ5UÙ¬9}==§•$Kê;[Mö½¾·Åš­øbA¥™®ƒüKÛ\Z¶„v ¤ıòŞËkÃ«(®ã`Ìê#äµsÏ©ôj³èùcÓ§‡8h<LgŒ²5Åêµ~Xó÷ğ\\rñÇ„Éw,ÕğİUd,YYI\Zlzuü=Ü\'1ss&Ğ	ë\ZÄuº	éí!œ’“÷™\0pkš­?19K)Ô}qâ‡9KÃ6[$4ÒÒ£47a¸&äbr³Ã%Ì3ÿ\0éW^LA‘¹Àïˆ~KGC%6e¨Ò«fãíí@ÆKWyŞğ®cáı5uzSfŸ£âÃ)êN AÚÛœMe<A[Y˜çUKGD°¤Ò*/N1Zf¼9;øqô5\\À´Ñ\\­üÄ°ò§„+ø¯#Ê²|£0†1t2yÈ`,;|¯†úP“Z¢©‘\'¦@¿pTş çùÎeœÖ*äY}L‘šoÍÒl>Û÷8-Vàz`!”¶Œhó9\'m·7Ãî9©ƒø^‡…²AÉdBé;ŸW>¤˜ƒÁöªç4ñ*‡³uÜ_|\ZÅÅdÉ-)ğ¾õ¥	<xã®K—öy>×·|Nğå¾6NŞLBÓ\'6tN×Á6A¹ü €‡Gä9?\0îgÿ\0Yoù\Z<Íª[æpÍp¢Õá¯ıÅ”áH?<VµòÖ|†,®ßæöKş8­ªõÕŸO¦XÇÂ\ZC÷†%xpÍÓIŠ„ìØ˜áuÕ› tœ;z“±ıÕHB8[‘¤àqûCñbÆªLdØAöÅu?–¦Kşş/ê•QÍèÙ¾„lÆ…|tõqÎ	nSò÷±¾9œ\r^Ã}ı0ÔRLæhÄl^8‹²…;(\0“øãŸ\'àéÅy=)Qp¸m˜u#×ëÕuÁG¨3ìZàõë„^µ\'Ëh³\n6CE[IÕptIm$ÛÌ¤ö#MTe·g²ÁÒ€Xn˜âc‹Õ¹ô–”%™½9œ´3UMU¥ˆu§‰Cô#WC¿[bÏàüâ–’—/¦Lƒ0”S;Ë‰Õ5³.’_·b=pÃåS‡ø—0­­sm_01oğÿ\09ù-–UÕ\Z}*ŒC”×mút1½ö\Z·¹3aWÀ!È«é`fTÒ«mˆ·™·Û¦5Ç§áÙİ»»G\Z‹^îò*¾¸›Ì31iQ=È½ÇqŠGÆÚ¼Û‰e á^ŠzÜÊ3úV½)˜	a¢F÷fmÇ”úaé7$G–QQtGVØPæA3Ikà_‹íú\n§`/Jmø;áúŠê\ræóÉQY1‘İ¤ûV½€>ûoóÃ.-?ôÃÒ™¿€Ç‰®ÊŒtßÓ\'ƒğ,¹.fÏoûJ=$’ıÏU;bšgWƒ­ybf’½RÖM2³·ØØ›°,=è{Äü?_QU=|Tß*4“GJêŠ:}íğÏ‡²ˆó8`Jš× ^ièÈ$_¯ËmÅS¯\rf™DuĞÇ\"¬¬Y×Ø°Õÿ\0¦*ºŠid£ jx@¨ä…ïßğÆ5N:F¦õ½EÍ—d\'0ñ³‚éò!UC!d|ÆA%Ğj®‹XzbÆâL¶»!‰ê–e×àÈaŠAå±÷$bƒá2ªƒÄş©…Å4Ù~Y%è—“±ÖJ–7¯L\\œ]Æ±SäZüŞÑÕMÊ+ñë-Ë.ÂÃ†•FWb\Z“Êåò,?âüîy²ÜÅ©`[ş³Y7Û }Ç<%ÑRe‘O˜üL,‘Ëæ7rOúb£‡Å—á(`«Ë3~KÍ©\Z5pu\0@½°¦oâwÄ”y-Tù´ÓC<5RrÕln\r‡N¶Áë„b“»3LÜŞš Â\r³\\ç‡`¨‚¶¥˜–•ÒÀ1¸îz`€ø=¿ãŠŠª©¡£¦†5EŠ9ùj¢írG_|P‡5Îèó^‚<î³àZ˜ÌÜ½WêGLz#³yçµõÕrJt2!g¸PÄ‹nØ¿M,ÒKö#ÍÔG§Å)|nUœ;Oˆ¾0VæU¨ï—SU$}¨Ú%úÚçu¹uuM3×ÇA+FWIò•$[òÃêi¸g‡¸Û‹DK£.…Ú´úl¿™Ç˜M(©&z¶W¨—Ï+ÅËÉüqWQÒÆY¥Ú;\"Ÿª”zxJ½ÒİşågêÙXlÀßù-Vš– }Â1€j7ÃÌ¾uŠrXìW Ç)lt$¬g™6ª†\'­Î\Z®WXÊJ÷\'F	>˜\0ËS…	ÿ\0çÿ\0‘ÿ\0+j¥­:bÊáE\'êmb¶©®­Ã\n[61ğ†Q¿,Opˆ¾yúi8‚„Úÿ\0,p^ùò¶Bpü]ñ—ôåô×Ä4²ô;b¯«uZ™u~ñÅ«XÅ©êd¾á	¿§½ğ\'	UÖğ|¼SNºé)ê¾v@Oš×7·M ©$şòúã£×µ(åLNjLšueÒ½q%‘f5™^kIšÑòÄÅ¥…Lâñ1hômú2±¿ÏÓ£{»`Ï,ªo	VPæT\rW‘qÓ¯Ÿ[ĞÖS0.µqŒ!¿Lr[³´•pMÒT‹&0É×ğ»H>:‘˜=NOTF–Y…ãb.¯m,6ÙÃ5¬T“+™*¨äÿ\0³mÊOlf4õY#­^]Xµ¤ Ì¨Ø„™?vEê¬AG\0üÅ!¢«–y´ìiäêL[ş^˜D±E½K’ˆæ’Z_CYK®\Z´L-x˜é&ş‡¾/<ƒòŠZz:SQNîïÊ“^Öè,/íly³!ã™(•YA’æHB²f4²â!ğßÓ±ñ+.£ÈE ã9R&§16_Âü=]u?p×Th·ªÆæØf<m0x¤ø™â¦[ÃÙTË•ËÙôë¦’›N¦‚à^YP7°êÆİ†)>ñş¬Ìs*šQÄ¾kšæ¯pt`ÈU¬nŞ¢ÛXíš…f’¤eAOTÌ) ÖóTNÇï49ÜîlBæËGKGLO,™¤‰\"æ˜À7‘óØí¾İ®hŞ.ÑšÉ°yÃüQ‘Ñğïè™«e§ª@T\Z˜J+ôÜHúÛ¸¦ÓpäòÀñÍ¦o<nvî1RÍW%iF¨`ì±ª‚Ê¢À[2­³¼Ò ÒÉ2‘ÕYH½ºv÷±Âê¸PßH1“è//%1ğöcûA„ü_OÒùİ¶ÿ\0<Q€Z1òÇ <Ì\Z#Pªk|Ü³\0?ï7ü1>nÁøÌÏ«ê\"®Š9¢ziÑy—);±·ıå¯ø`b«1)Ê ×#Ô–!wks\0é‹+2³QÑÇKlö\Z§jš†—1HRSn„mí€~$¢æd´B´Â•M€ûœÀOğÇ¿áÆ;Õ-¨sáõ\\ø«“ÔCHÒ)¤”ø~a-¤ï¤õÅËâ,|Ù$WQ•V«Cg H€k\\âŸà Ê*<PÉ*Ö‚(i£Ê^#«vTi4·›mşX¿xš >QDô|7”æ:êĞÅSí·_0·L]³|«ÓÁFWœ±d£¦– X€c¾ú°GœËM>A”OEO\0ARÅP[¡ÃlÔfTSÍÑ,-#Ş!SĞßYºÍUÂ9l“d	DR–§W*KÚÿ\0.ØöjÑÉ¸SÖö*®/««‡-¡ø}$´0€ÅG—È×õœlr?S4\rkVU.–½á×»t¿`p5ÄœE¦¦Ëªèli¡‰ÚUo¶4`;mƒ~+Ê!ÍüÌóÈÃU”ÒÒÒ“ÜÊ~`op«,2ãq|ËÓc,Šk”?yˆşÍ½E´ÉUS\nµ[È1SÓR#SBÌ‚å½±mp•?üCı™x¢\\ù|b¨/r#pNß qPÁ=G\".Z±MM‡kbëõù¶D’Å4¼R*ü¦·(4ÑÓfÌòë%œzzá\\ŞL¦c’@én¡®1NQ&ÛHÃˆš1;›‹˜å§±cNÆu-­Ç¯¦8I4\\Z÷ÇSı³óÂ`_§\\\0e»ÁÖn¨¶şW+\Z±ûEzA‰Ê./ªÊxsôF_AäÕÎ¨“Ì@?u >æşØ´…Œ„±&÷=ğ„÷\ZÕÑÂ.‘æ6\'·\\9¢Ì*2ÙÄôÉ˜j*\ZÃävÃ{Xc’ut&÷Á¦cCú¼û3®WJºé¥ŠB5FO”Û¦Ø3ğÄ\n>Ì3Ü¿‰)¥­án%ÊåËsXa@ò%üĞÎŠH£)±;©aßó†vÔõXã›n\r¾XÙ7.X1Š†ÑT?¬zed ~l\0Ğ6²½¯r7ùbG,â8¨èóL¢9çÈs’´Àµ=J$ñÿ\0‰nËş$f{?`ob·÷8ÛFÃ¨ÆPV*ešFxåĞ\\Y?³ ÷Ç	\r&Ú”—oöÆ€d7BTúáâÕS:Ú¶­ıí<†?1b§ğñ‡ÅìÎWÜÀ[øp¶Y‘Rªjksùê@,iòÎG6ÿ\0}4–_˜Fù`&8ò‡	dÌéã=JÃÄ~k|Xyx7M—™3ù¼IÌs\0?º¡‚Š†úå6ÿ\0.·[‚™ıI©¬š¤SÍ—Æ|¥«+~\"¥‡øŞÀşèUØ…yâ¥£­§–*jÒ1¨=8V\r¨XÚíÒÄ°qx…ÃpÓ\ZOx/á¦ +æ5õ’fµæİÕÜ¢¿ªDvlWŒ’gœ’ìK3HÛ’z÷8ÆÍJ‡ç725ç§‰F…@‘Â†0ØyHëµÉ½É$÷Ç9ÍN_+AJ³GL ‰¦YP)ø™¦Äù5_Nı\Z\ni]5b¾¡lÔØc¸èõ_xØÀ³ÿ\0ø‹~xÂäl²²€.éc¿ÓW‡ş\'Rğ_>_˜dâ®	¦æóÓ–î§M­¥ÅˆÚıFZˆ)Ë g\ZTT\"ã¹=†\ZÒªÈ­Ê²Ø–#¾(©*c!\'h¾óî4àœúŠŠ~­’6™X×C]H)w\0¤‚Pß~‡é‡“Ï5	Ìc‘éšKˆRåĞÊµº±çö…tiuŞ÷µ»bO)Ïs,†Dl®­£@CrZÏXŞÅßÃ\0áğ5Iù=+ÆÕÙD8äMÂ4Á¤s|9Js¬—îû¦Ãß‰#¨á¸*8£ôœÉYuÓ™)µ—üv¾<åqU?x…“æ_¢bËk~áªéá„ÕÅ4Ê‰#À#ª’t‘±±Ç«¸R<”ğà¤Í(hnl…_-ø`TÀ{aÚ›Év„éQÅI?ä©Í_…Ut´5Sg	M ‘Ò_Š’éfÜkàÃÀù‡	H8v®²\\ºwŠI%sËRH,C÷ÅâüUœÄ<=*´¬¹\\rX ‘È;í¶ø³|5«ËsÜŠ\ni´ÒI[•H²†M‹›Ÿl\'7Qx•%v;OY^îŠ³3áœË3Íê93Ç\r#E\ZFÌ¤í ~âÅán:Ê)x/‰øsŠa¨xs*\'£„ÓÅÌı`V#°\rmı±md‘¶šY+Qå1†å3\n@ÿ\0[\rg	Ã±Ö*±‹.ÔíÜnx7p}1T°¸bY>Y#<ırœÇ(áùè³Ú&9fk®µ!‰ÁRÄuµñVf	ÅÙ]}U\r&^f‚–g†94ı¥R@?P1é~+4Ü“Ò×Ò²GI<Q/WÍm&?]ïÓCÆ#Ã=_)Š‚QİMº|KªQn_#O	%·ÎÀ‘[¦:	í„¾XØSmX¤€Ü¼¢Ûtí…¨i~&UX±&ÃoÏ\r›~ÛöÁ~MB´YcO\"ƒ$ÃJ:(;Ÿ®–zbSÓâõg_m8„éµ€ƒgsõÄ¦c1y$1\'k|ñà‚o…Aì;*IÒ8mì:_„$°µíõ;cÓ×\n¢¡·èeüôÏDşLµ¯÷ØmØc úolkM‡@-…XzúãÅ4wM½Æ5ğë`@#äm…\r‡®T¸;ÿ\0e…¡1¿Ã¿b\'mKÏrŠ…gB/ÜŒH,Fû~àcªŠqğš”ºM«¯İ\0à”x¼Œü«u`nòÆæ“™±\\\\.ûÁ%ešdÙ^m‘Ğ×ĞS5e]i‰¤Šz°\",æHEå‹*…ûM{’]&™%E‰ä¨bé1QµÂ‚Ik\rVÜ˜t®1²x%)Pİm`}Î‘ø\rÿ\0…£fBZc¶÷BşíÏçÒHQŒë{÷Âm”¬qFÆìYÛ÷çñ7Â‡T„kfbv\0ØÚ¦Ûµ¾ğ²GĞ[s½†04„Y\0Š€¬–qamÆøa\Zˆó‹¸bmÛ®ãJ¡ZÊ^†İÇ|DÖD”²XùF™Fÿ\0B0H\\Õ4Ç’By{yGoëé…7”1]EÖPØ‘±şx“£¥×f×òìm·\\	L!®TˆªZ‰òú¨j¨İâ©ÃÇ\"ìU‡C¶=IEâI¦á,£‰r\nz‹«æQTÓKQ4¼¹,5-°…FóemEÛ¶ûvÁ?\0fE¾;‡êæ”RV©©…CYELjtŸó.¥ü0ŠÌô“Çcßx«0ãLîƒ:ÎE4SÉL´ñÅNHãˆ w¹¹\'ß/åb£ƒ*jc6–!¯]nÇùb›âúŠiiòXéyâH©ØTsXd,O–İ­‹ƒ‚³u¥É*(M×âø~>…·Ä=BÓéù‡¾VSe\\]PÉSÖ×e3Ñë‚ªWBº&àÜZÛã|Y‘Uqo…¹va•¡—2ÊÀ~J—Œ}«ˆlqAäõÒç2ÉHkÌœØ×DïÒZÌ,\rÆÛãĞY\ZÓpPeSÃ$YeKÎd‘µ½+a¿qØãµ/êeÁÎE‰IÏåò,öÄ~\nƒ)âbŸ¥V)I·0²ÀöqmÆ|R~Î±‰^@æ»[kâk1á¼³*”ÔÂ\\‡0”;¼\'zw=Hè/‰eà/p\Z‹ˆL”Ä^&j{–NÄû[éhºeéµÁà°bªn1—`¶áaLª·gùãZy…í‹ÎIÌ#TÈ¶¾ø3ÍæQÑÂ…®!X‘-©Ï`:“|PÓ¡¬§D³<²,`\n	bäì:õ;_<m’ğïƒMYšTÇÅ~\'TFE]\ZÜQdªàYÁ»5ê,H¾­#ÊÓe©\"Ì8?–yş¹&‚`“3^Â%7*}	ğ…Œ‘™[@\nÖ`§}÷½½=ğAX±äÚã#™W1:¦Ów{‹YGİ[ö\ZthßaĞö;©ôÁ¤*Øª@]œÆ9šS`Rv™ÃªÈÖ\Z™á[	X~e˜ÿ\0÷_øB¾—.©«Ÿ1£zØ~VÒ•-.«xØìC\re|¤oê:âHÁÆ–_¼	 äã7Û³¾øèn	Öï-ˆ\0ì{_‘ÂÊ—ë·¿o[ğb.×Ã˜ã\'C|q\Z’ ƒ¹8{in–ö¶<61:XÛa×ß$|Ø\"WÚò:ôéª2?ˆÄ„0†[i [ğÿ\0_èaX¨~\'JQË]]${_Ï\Z¹,M¯idø)Ã!¸W?ã)Ù¾§;¤’PàÅ­ÏF\'yã¯o\\RyŒëW˜ÔÕÄ4Å<²Í±¶–Úß@0OU™f<s:ºJz|ê’¢‡1…c¥uDòˆÉBü´RzqĞàSív\n-eUÜØ{üğÙIéÒs£‹Lİˆ‘æ°íĞØUXü1Š·$p¼q›ëúş¾XHôã/~‡Óâ§c¾›ØÜ1[gş·ş¿–¢¾ \"˜“×}º,\Z¢4xÊ·˜:[ùb+5œ›)b¬¯{„XÛÚà`Ú<‹DÜº°óÖ*s\ZUhÓ÷¥r4B.[lCUÉ—Í™,3ëiK¬3ËF)©ƒ:ı—#T…wÜìz°I›•rt)EKCEÃ›U\"U2òèè£\Z§˜’|Öû¨=M¯Ğ_Ç„ü’x”¶Y”g‰“ñÂ´G’æpF°fuXªWÌò\0w\0†‘À6ñf¢–£¹nOG\r;ä´IQKïªFHí«šw&ë¸²ƒ¤0).uKYH¨cø´ŒÑh1´>ğîŒ-Ôb…‰ru9qËL6¯û	8¯‡+²LÊ|§8Ëj²¬Æ™9“QÕÇ¦T ‘m}Ií{°K#eùÍë`c™\Zãçé‹£ÆzÎ&áØ2_)$âh©.2Œí¦1æt§M†¹ó&ÃsçërÃlV•Õ¢dÀDè¿Ş€6÷?,&p¥h¥u‘Î«\"ßü’Q	ŒÑs>Û‡,\0µ¼ä[ß\nGù«w\"z\\Š%PWHûL-~ûb¯ãéêó*AIB ‹–åXc†7}ú|‡¦¸S4X²êà´É¾ÌWÌàqÍÍn) ğ´¦ÀÈâš²zÚl±ÖMQ0…!N¢ÛZı¶Ç¤åàÚ>0áø9ÂùşTÚCk¾±o4mìM÷ìqSğßˆSæ”4™4E[Ç+*AßsÔm±eA–Ã=&}Ï¬ Õ´sS¢ ¶­ì}n}0ÈÓİ8µ³ò\\—6§É%—†M,LV»)«Ø~éô=¤Î*b‘ã9{	F+¡M+nÂİ†køËˆ8?5¤«Í#zJË~£0†?ÕÏ,Šva¿C¿¦£şĞğè^oe2Éa©ÅK.£ÜÚÛ|±|1Í«Š´Lçéº>{(æ5‹móÆÚİá4èm…t¢&æìqJ9çtèÓJª—Õ(Sco|HÔÕ\n2Â›\\•Dó&fÜ«¾¶;’pÆVBVı–m öµûO|N×AM’Sü-‰š¡Iøb5~„÷Çcí…Iî\Zàjú†©¤Ï 3q k[Øzc+ØMQ$ğ3IæuU!ˆ‚§¯|#=<”Òæ²ºõ\0ßóH›)Qp·½½ñ¦ ™MpBº$‘¤Y[÷”28ùpÛA\nX-íÓFZÃQSËk·íĞú|JÍL`¤jiã€á[©Ùî:ïøàn‚vÕ‘*Å.€^¥OCş˜uO8Õaånš¿Èá¯oõÆh&ã¯±ÆÕ™¸ğLD5mc¯ºô?ï‡±!!o¶Ö=1d±Ú7T˜|›uqÌ|·rnÎ=ˆûßOÏ°ie¸òÅ½Â¾k\0lGÏúş¿LÒÓ\"JìÀ‚H¸µúúõúşC\'§…â‰9‚×$Û®Öş¯ï×1)¡B‚@=±\"Öèwş»ã\'ĞâÄœ`W<z©ù[‘5h-poåÂöŞÃøüğ6/ \\\\XtÄïTŒKË!£­Ì?Kì‚Ş›ùâÖ£{ƒúş¿–\ngÏË|ŒÜJI;_{\0\\9Œªmkÿ\0ëú÷Æ’6o*ƒlHPÓG¦Y Ãnlõ,VMö½¼Ò6ÖĞ¿Ë†i§B”TR¡İ’œùL®›ô°vnÖ\0“‚eTÉ˜RGT5ò)\"\nd1›Ôıå¤OVkÉnŞ‘¹}|•IZM&PFÌ1-\\Äîé![”şöÖ½ËvÂ†:„–:hş–Ayaæ—’sÔ¼óm¬“.Ê=\\Qmò#/W[CvGæ\\êªcK4CF$Ö™u„Ó«úË.í;ö½ÚÇ¸aµe:ËLË0Y\r™c@¡;‹\r*6zîO®%j2á1ˆ¤B4¨;ZÛ€úb0¨ä¹?;Ê«ØÚÿ\0,:”QË”§’[îMÉT8‹‰tZÊÇš‚5=$Fw1ér@ê6\'{ô8ˆ§Ê3Âz™ÿ\0W“üÚyj%ÑS³&Íó¶êêª2ùTòÉŒ³)*u\0z~8sGæM=T…êMM„Ïçw\Zof\'¨¸KÀìŠŞ§È¾c!š®Fz¡V¨Ä\n˜RÊ~kÿ\0ùÛ	åyWÓæ9\\Èg„9‚@Õ® B=¶:iæ¢LRéIÊÿ\0xöõ÷ëˆöìÙ‚ôÏoıqén.!neKQL2h«¢h\'Z4æ#0\'¡>äXıpgÃ—ı\ZôÉ¥ÚHØG¯î1¿òÀ^cG&_[MGPÅå§@’ßÏÕ¯ïsƒ®‡â(êUTŸ	+%¶7·o|ròí©…{	•²Ş)63¦*¦)¶éÓÓ~¸¼d©ÏòÌ¤ÃGVd2B‘5Î®S0Gmúb“-Ÿ1Éh×>Êisyáæb\'@ÃP¿¦Pg¹¶MYE™¤RRÈ’jJY—(`NävÇ£=C4–çøÑ•|dœsM—EhšS2Ç§nŸ|Q¾İñ+ÿ\0øQúÑ$BO0NtƒM÷µ­¶\"óix–ksêõÉ³I\"Yf–8•ÔA^İzß‡û6ñA$ÁÄ¹D‘°Ş2ö=qJ–¹qd²Y“Ù\'ÿ\0‡D,{ae¦Ü]¶ùã¢­mŞ˜á•ÏsŠHÉ\\¢)\'•¥·Ã\"ŞS~Š7?ÃÙœT™GÁ¤tqÁQK—Gñd(óT;\\›“Ëâİ¬}ğÛƒ²ˆó)©(ªí=\\ê*¤é¢A–w¿ Š91Ä9¬•ÑšÉ•R§2’ZéÑz+–\0|—HùbkÕ&Ê¤´F(¬·ÄÈµ-ÍÏ²yK[lk¹Â²(X/æ7?L9!1JğH²FBº›‚wş†	xsº2º™bxÚR‡«!µíÔ{‚ßÇ¹~²É%5õ\0Ë¤.«ÉB;í¸öùl\rXÈÉÄi\"ÈÔu.¸Üdß{Œ<«Y]Kh”_P±õ6ëîvÜî;á³Ç§Ì¤ìAÇ“ÇÊ6Ñ$;âsƒ2:÷;l»5ª’ˆšHªP€P¨&Öï¨…_mWÄ8·[æ:aÎWU½4Õ2ŠxJI Ce¿B@÷¶\Z½Å;­‚ì¶fæåŒ-C|U%HXì]âu!˜^ÚŠ¹ÛÚş„M–\nv,\n€úwkßŞÿ\0_ËÓ|æùÔfõ³å•š	k^¦Q¤²ép§§r/Ó¡¸JÕU(ÜÜÒ¡Ì–*E¬Ş¦ß<‹{huËtµ¹%Ä1ºK)Wš¿,\r”\0¾Àöü\0Ä5-;’áI#§_ëúúIÖÓTÔOÍÌ³ÈÒ\"8Ô–p5mÜ\"ÿ\0îq%+•ñR±bVÊ±ô–=(6D³ÇU’‘Ò<‘ÂZ2cS4²VºF£n½Ù×¾û|0ød§ª­‚¬Ç-\\&–5˜‘Ë+ö™GÙâÂûo‡9KC™B‚w©^3W¢&~\\	2ÊìtìEĞ7õÂ:t±ºe]e]Tó7^ëcòÜã`·6MtüAV´sIËWX–æ‹µ»q!@ÕyµBC	%	}=qfš\ZÀ’j”\0İÜ}q`SSey<Z³Ä\\Â¥”4y=3ÙlCT¹µö7Òl›wÃu¨‹¦y{v_/”pK,o5DŒLµgÏ\n½ù}9aĞyGrp1˜ÔAJÒ4nÒ÷‹o\'¸öü½1=ÅE<ì‹˜4ZSh(i¼±Æ X\0-{zjí{o€YõH÷˜k‹µ¾èÿ\0\\›—%Xp{qîşFU2¼ó¼’1f>¸É$Jjf‘ìäéˆi$/«|û`yÈ,Äl/°öÄúÔ$52¢ r¦ìMÉ¹¿OÃI\'m\nÌ)¦†y9õ×¶­êOòÂSC2Ò]yjÊêåZÃ˜¾ŸA|LdÑüF[;çU¸°>·Ä`\r5‰`Ò¥FİÒß•°É-€ƒ©²J“üÄ‚0±”`R	ßêúß†Ù€Êê¾6H–¢8hæ-v¶+\nb¯K,b×¦•eıÖºŸÏN,n\ndXêùNš	›}ûr:•í£±ƒ¼°¨üTËè_–;¡+.2äôµûÎó|îš<Áj4¹3HƒÈu]k\\UóRÀù•¯¤ƒUzmÛŒœ/I›Ó¢æ²OPÙl¶Û¥ğœpÇ\ZÕt>Rœ·‰ÇŒ3e™Ÿ|7ÓTËUX‚*’òtbËÜÜ–Çœˆ™U*j£U\n\'p\0ôµñè™ü/áÙà--CéÜ1˜ƒ†û(áşSîd8µfÇ‡e¿Ú#xrdß¦ÏsZØÅwvUë¨Û	áæWNj«cˆucaóÅmÒ²(§)$å.(xo>¬‰2ÑÇ•Ó±[‘5kÙÿ\0ş´ş¦¸†§âs4}•UUö\0m‚~%©4“C€&c˜Væ\0Ûí$zi¡ß½´LÌp	4†Y“¹ë…El2näháZ¡ŒêHÂhHÆçkm°ß¼ˆaöS$‘Õ_Ù\"íæÒvÜßtƒ¸=½ÅÆÿ\0,v¡ZÛjØŸl\0Cêú¾|†@B™|ÒUïXl§Ô\r¯¸Û\rci¡!âXÜ[|d³™DcBF¶Qû£ßëŒŠH„TDÍR#h`m±îûÛ¸ïG­®&¼Í‰¡Mj.®»}-ë–œr¢”²³-§e:n6ïıtÃ8Õ\Z$6³\0Ç¶û<;„°£‘MÁ‰Ã}A±ş8óØ(«d¦W2¦£!p$_;-·î­å;v?—S\"rrôõ-–Ê’E<ó\nùB-œ—ˆh6”$mÓ¶éFİ\0kìv;`«(U’\n²E‡ÁÔ\rˆx[`OËëÚı0:š,ÇŠ9U2J‚¶J9`£iaækumJB/æSfşìØ‹^ã\rbYXÌ ˜ã%S¦ÀÛ®Öôaz¶Œ¼—‘Gš¥t)µ†§÷ÿ\0ñÂ–wcpÍ¬ü»[&éB1ÖÕy&rzm5p9ˆÈ¨ëdÌDìU—u îo®UÌ“f}LL)ëå’ÚÄ\nÆB´Š<¬×½ÊØ÷ÜáL¸\nz:ª„ÜÃ°°Ü¤—ûwÃyà4y…wÙa•Ğ\"Õu„ÔÀ‘ßS[çøáJM;:ÒÄ–:kgşÿ\0„Èj¢ôRE<ñI¦ »G1¾‰´±RCu\"àİ1Õ&q\\Ğ˜)Üg,dÒ5}Xú[éÛ<qTÁœpçÒÂâ®\' ¤x¯«õó¯ÅHöz‚¦œ,Š©d»Q<¸õºn@¹ê~WÅÓ8z›T‰åD\ZE›âjY­-K©1£¡;»ÿ\0[b.k&Ûõ$êµïîG_åKS32¾ ª;*¯¢°Nbdˆ˜Á-kmßlÄ¨f:8I*©Ø(Û!dt9GÕ?G/è	J\ZYH±(5)ëc«U…ú[ŠÇ‹ò1ªØ7áŠÑIOp5ì6¾ı?Ï–”Ï¨¡”\'*½^ŒêØÊ@#üÀ`?.ªäÌ¥M·ÈÁÎe:Ue+YJTÕR0©O_%˜Ÿ¥±Jv‰šÒÈLŞIâŒ«;ÔBĞ2¥ˆ·ã©p_Â™ª­<ZÁı)¸¥ôÀÆbAŸÕ,	¡âxµşä¾u?-ÎğfiAœV-DeÒª’JXÆŞRH;ßåls³Á´Òäéa4ßêj«é³Xhá—Ñ˜CŸ¼NÂş›âÙÌ8â®…*c˜WÕËEPi*™Äq«…À·\\UY¬ã4ªZŠ\Z5 ¬‰ÔkÖotè@;¶\'ó$©â9Ş¦±cI˜†•cF·µ‹ë„¸9µ°å5¦OâlÜG\\w¶õ _ğÄqãºûŸÙ«şyÃú_³ï*¯†ërÜĞ·›áS‹ìAïˆ‡àî*Ù…\\²’	€‹ãÕ›s)£1v‰€õ¶åueŒÕHH/¤²Ü\r­ş§“2=\'÷€©¶á·Äu:|4	{‹ÈÇ³7ş\n1dìCk—ÁS_=ZADÒK2éÕØ‘e‹h_A©˜Øw\'×ÕĞşÅ¶Á-ˆG ôhÈ6úåƒHÄŒR\"Ü‚ÖØD’E¯‰yÃLÆ—5Ö–şâE:‡Ğôúb2 ]Ø“ÑIùãZ£ç¡Æ†ØÅÜc¶\0#´+qå¿O\\tUí}{œj%Ôàc¹]D|˜Í×«‘÷ûcÆA’fF½ä‰ÂÛ÷€¸ÿ\0ñÂô·¨šdÍ2’®¡â1”‘Ô»,h“ò‰\"öº1ÆâV‚ª2msm7ù6<Ãƒ÷#Šsç¸°¡¯ô±Á[PÑ,ºCjåM°SpyM×úùâHJJ¯\n9†Gqm¹‹}€ßf˜{I8Ü«lA¹µ¼Œ>‡\0Ñnib5Ö5•¨¥HIå`ms¾ı°Ô×$\rÏ_\r4&€÷¨‘›`,µÑHï„é	u\ZXíõ89v¢|tò7ù\n)cæåü©	_ˆš8u±°ŸÍ{ûÏx/‡‡ñF[“9hÓ‰8‚‘Ø7š8o;•ûAÅ\\ñ->‚‰Ä[Y\0…\'°]úŸ¦<=¬“‡ªæ¯bôuÙI›U”‘7=7ÃÀßY*zÉgÈ7^ûü…Õyı.uânÇ”p´&Z Íè„„0\na’:kĞdmí¤Qµ4K,”r¨¼,àX>_å‹‚¦òú:¬½ŒBZe2òÍ×\\†Û©ëó8¬³Ğ[1š[ÙÜîGï¶.’Üà§Dñ•fd½Ù{ƒê0š.Vk…B×Çl;œ­±ö=Æ\ZJÂ‘Ì²X­»o¸ü±;¤5\n	æ0IOÎ~T +)7¿Gwß~Ør³¯)÷Ãy,$m6û`B;ŒØŞÿ\0‡ûâ+§£x³Œá¨`\0Lwi$Ÿ‘Àèë¿å…Ãî‹÷8$èÆ¬!¬Îc¬ÌçjwéÌAN&êª‹eù\r¯×ç‡5ÑO-{Ë“Taµyµ%‰¸ëÑ¾\rRˆ$w{)(é\nı»àº±\"Êõ4QÕÁJÜá7¹”+üˆuS…äİØì{ÇOÁ!“Î3Z]DU\r¹Ãşñßÿ\0\\)^95Ôò¡6”é`;ØÊë²ª\\Â\Zº)&Ë¥G¹Y¤#ºŸb0QYMM\\9¹4ÑÔ›RD$QÚß\\\'tÆª’¡´•IAÆ­®á\\³2ÛÒätÃ¦—3F*¹¼ìªl\nÖ‚ö7éN$Ë*iQj$§›D›Ëu¸\rß¦ƒ#W†6LÂ•”¼Ğ,-Ó(¦z3kfŒª7Ëq2„ÌB \n¡E€é²ü±˜Ì1÷!qı7öˆ°¶[ã´€IÈ¬W@{ã1˜p\rDõ\'ñÄÏäƒ95…§0r#i[ŞçŒÆUä	p*KØ_tÿ\0|EM.Ûß{tÆc1ƒn˜ê\r*ƒ¸¿óÆc1ŒÒF%èòşÓÛØ0â™U©®ºŞ*ˆ£RÛÙY$$[æ£ğÆc0Oƒ#Ü‰(]G¼\Zº€œØÉ:dÖÅAö`z0í·¾Ì¤ZJ…ˆ få†æôv½±·­¯ŒÆaEóí±½¦Ì«Ô4‚İÁş8|Ì²Õ•Ğ:ík’7n‡·×ŒÃ%Â\'ÅËû¦óN…À‘yÁeW\Z„¶±óz‹[ ë‡Â¾¶jœÓ.¥¨åRÉA=#,ËÎ<ŠQ7ò´qo/¡¶3ÇÜ;¨ÛÆ¡â\nìê,ê£0ç–«/¤¢‘œïËl-k/O|Ö³JÒ³±$µşBı1˜ÌRÛ|œÈ¥ïàfë[›’FøNqp—?½ümü±˜Ì-BqF%AöÇ3GÊrºµ[ŒÂÑ¬Oµ÷8ÌfÉâO*¤øŠ¸\"#HªX $\\ß\\7H­%,IZÃ=$—ıÏ0üF3>àŞ{Ô0 6¾I­IxÛÕIŒÀ‹%©xƒ3¥@°ÖK§¦—:…¾¸uÿ\0Öw¥¢\'ÔÀ7Æc0-+3\\—ÿÙ','2023-03-27 22:05:29','2023-03-27 22:05:29',1);
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
INSERT INTO `payment_methods` VALUES (1,'Tarjeta de crÃ©dito/dÃ©bito','2023-03-27 22:05:42','2023-03-27 22:05:42',1),(2,'PayPal','2023-03-27 22:05:42','2023-03-27 22:05:42',1);
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
