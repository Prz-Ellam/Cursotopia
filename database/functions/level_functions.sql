-- Busca el recurso de mayor prioridad que este existente
DELIMITER $$
DROP FUNCTION IF EXISTS `find_main_resource` $$
CREATE FUNCTION `find_main_resource`(
    _lesson_id       INT
)
RETURNS VARCHAR(50)
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
    WHERE `lesson_id` = _lesson_id;
    
    RETURN main_resource;
END $$
DELIMITER ;