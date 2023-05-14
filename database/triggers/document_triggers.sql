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
