DELIMITER $$
DROP PROCEDURE IF EXISTS `message_create` $$
CREATE PROCEDURE `message_create`(
    IN  `_message_content`              VARCHAR(255),
    IN  `_user_id`                      INT,
    IN  `_chat_id`                      INT,
    OUT `_message_id`                   INT
)
BEGIN
    INSERT INTO `messages`(
        `message_content`,
        `user_id`,
        `chat_id`
    )
    VALUES(
        `_message_content`,
        `_user_id`,
        `_chat_id`
    );
    SET `_message_id` = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `message_find_all_by_chat` $$
CREATE PROCEDURE `message_find_all_by_chat`(
    IN  `_chat_id`                      INT
)
BEGIN
    SELECT
        m.`message_id`                  AS `id`,
        m.`message_content`             AS `content`,
        m.`user_id`                     AS `userId`,
        m.`chat_id`                     AS `chatId`,
        m.`message_created_at`          AS `createdAt`,
        m.`message_modified_at`         AS `modifiedAt`,
        m.`message_active`              AS `active`,
        mv.`viewed_at`                  AS `viewedAt`
    FROM
        `messages` AS m
    LEFT JOIN
        `message_views` AS mv
    ON
        m.`message_id` = mv.`message_id`
    WHERE
        `chat_id` = `_chat_id`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `message_find_unread_messages` $$
CREATE PROCEDURE `message_find_unread_messages`(
    IN `_user_id`                       INT
)
BEGIN
    SELECT 
        COUNT(DISTINCT m.`message_id`) AS `unread_messages`
    FROM 
        `messages` AS m
    INNER JOIN 
        `chats` AS c 
    ON
        c.`chat_id` = m.`chat_id`
    INNER JOIN 
        `chat_participants` AS cp 
    ON
        cp.`chat_id` = c.`chat_id`
    LEFT JOIN 
        `message_views` AS v 
    ON
        v.`message_id` = m.`message_id` 
        AND v.`user_id` = `_user_id`
    WHERE 
        cp.`user_id` = `_user_id`
        AND m.`message_active` = TRUE
        AND v.`message_view_id` IS NULL 
        AND m.`user_id` <> `_user_id`;
END $$
DELIMITER ;