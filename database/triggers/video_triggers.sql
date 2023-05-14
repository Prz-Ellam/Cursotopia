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
