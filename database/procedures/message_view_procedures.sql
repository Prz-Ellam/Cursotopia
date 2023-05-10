DELIMITER $$
DROP PROCEDURE IF EXISTS `message_view_chat` $$
CREATE PROCEDURE `message_view_chat`(
    IN `_user_id`                       INT,
    IN `_chat_id`                       INT
)
BEGIN
    INSERT INTO `message_views`(
        `message_id`, 
        `user_id`
    )
    SELECT 
        m.`message_id`,
        `_user_id`
    FROM 
        `messages` m 
    WHERE 
        m.`chat_id` = `_chat_id`
        AND m.`user_id` != `_user_id`
        AND NOT EXISTS (
            SELECT 
                1 
            FROM 
                `message_views` mv 
            WHERE 
                mv.`message_id` = m.`message_id` 
                AND mv.`user_id` = `_user_id`
        );
END $$
DELIMITER ;