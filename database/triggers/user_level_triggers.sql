DELIMITER $$
DROP TRIGGER IF EXISTS `after_insert_on_user_level`;
CREATE TRIGGER IF NOT EXISTS `after_insert_on_user_level`
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
END $$
DELIMITER ;

-- Este query puede sacar el progreso de un curso y un usuario
