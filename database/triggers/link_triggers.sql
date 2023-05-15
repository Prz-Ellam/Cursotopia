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
