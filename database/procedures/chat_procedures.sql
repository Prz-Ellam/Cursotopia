DELIMITER $$
DROP PROCEDURE IF EXISTS `chat_insert` $$
CREATE PROCEDURE `chat_insert`()
BEGIN
    INSERT INTO `chats` VALUES();
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `find_chat` $$
CREATE PROCEDURE `find_chat`(
    IN `_user_one`                      INT,
    IN `_user_two`                      INT
)
BEGIN
    SET @chat_id = (
        SELECT
            c.`chat_id` AS `chatId`
        FROM
            `chats` AS c
        LEFT JOIN
            `chat_participants` AS cp
        ON
            c.`chat_id` = cp.`chat_id`
        WHERE
            cp.`user_id` = `_user_one`
            OR cp.`user_id` = `_user_two`
        GROUP BY
            c.`chat_id`
        HAVING
            COUNT(cp.`user_id`) >= 2
        LIMIT
            1
    );

    IF @chat_id IS NULL THEN
        INSERT INTO `chats` VALUES();
        SET @chat_id = LAST_INSERT_ID();

        INSERT INTO `chat_participants`(`user_id`, `chat_id`)
        VALUES (`_user_one`, @chat_id), (`_user_two`, @chat_id);
    END IF;

    SELECT @chat_id AS `chatId`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `find_all_by_user` $$
CREATE PROCEDURE `find_all_by_user`(
    IN `_user_id`                       INT
)
BEGIN
    SELECT
        c.`chat_id`                     AS `id`, 
        cp.`user_id`                    AS `userId`,
        CONCAT(u.`user_name`, ' ', u.`user_last_name`) AS `user`,
        u.`profile_picture`             AS `profilePicture`,
        (
            SELECT 
                COUNT(m.`message_id`) 
            FROM 
                `messages` m 
            WHERE 
                m.`chat_id` = c.`chat_id` 
                AND m.`user_id` != `_user_id` 
                AND NOT EXISTS (
                    SELECT 
                        1 
                    FROM 
                        `message_views` mv 
                    WHERE 
                        mv.`message_id` = m.`message_id` 
                        AND mv.`user_id` = `_user_id`
                )
        ) AS `unseenMessagesCount`,
        (
            SELECT 
                `message_content`
            FROM 
                `messages` m2
            WHERE 
                m2.`chat_id` = c.`chat_id`
            ORDER BY 
                `message_created_at` DESC
            LIMIT 
                1
        ) AS `lastMessageContent`,
        (
            SELECT 
                m.`message_created_at` 
            FROM 
                `messages` m 
            WHERE 
                m.`chat_id` = c.`chat_id` 
            ORDER BY 
                m.`message_created_at` DESC 
            LIMIT 
                1
        ) AS `lastMessageCreatedAt`
    FROM 
        `chats` AS c 
    INNER JOIN 
        `chat_participants` AS cp 
    ON 
        c.`chat_id` = cp.`chat_id`
    INNER JOIN 
        `users` AS u 
    ON
        cp.`user_id` = u.`user_id`
    WHERE
        c.`chat_id` IN (
            SELECT 
                `chat_id` 
            FROM 
                `chat_participants` 
            WHERE 
                user_id = `_user_id`
        )
        AND cp.`user_id` != `_user_id`
    ORDER BY
        ISNULL(`lastMessageCreatedAt`) DESC, 
        `lastMessageCreatedAt` DESC;
END $$
DELIMITER ;
