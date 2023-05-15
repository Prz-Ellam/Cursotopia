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
