DELIMITER $$
DROP PROCEDURE IF EXISTS `find_chat`;
CREATE PROCEDURE IF NOT EXISTS `find_chat`(
    _user_one       INT,
    _user_two       INT
)
BEGIN
    SET @chat_id = (
        SELECT
            c.chat_id AS `chatId`
        FROM
            chats AS c
        LEFT JOIN
            chat_participants AS cp
        ON
            c.chat_id = cp.chat_id
        WHERE
            cp.user_id = _user_one
            OR cp.user_id = _user_two
        GROUP BY
            c.chat_id
        HAVING
            COUNT(cp.user_id) >= 2
        LIMIT
            1
    );

    IF @chat_id IS NULL THEN
        INSERT INTO `chats` VALUES();
        SET @chat_id = LAST_INSERT_ID();

        INSERT INTO `chat_participants`(user_id, chat_id)
        VALUES (_user_one, @chat_id), (_user_two, @chat_id);
    END IF;

    SELECT @chat_id AS `chatId`;
END $$
DELIMITER ;


