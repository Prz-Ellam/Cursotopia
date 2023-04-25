DELIMITER $$
DROP PROCEDURE IF EXISTS `complete_lesson` $$
CREATE PROCEDURE `complete_lesson`(
    IN _user_id             INT,
    IN _lesson_id           INT
)
BEGIN
    DECLARE _level_id INT;
    DECLARE _course_id INT;
    DECLARE is_level_complete BOOLEAN;
    DECLARE is_course_complete BOOLEAN;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    -- Iniciar la transacción
    START TRANSACTION;

    -- Completa la lección
    UPDATE 
        `user_lesson`
    SET 
        `user_lesson_is_complete` = TRUE,
        `user_lesson_complete_at` = COALESCE(`user_lesson_complete_at`, NOW())
    WHERE 
        `lesson_id` = _lesson_id 
        AND `user_id` = _user_id;

    -- Buscar el id del nivel al que pertenece esa lección
    SELECT 
        le.level_id INTO _level_id 
    FROM 
        `user_lesson` AS ule
    INNER JOIN 
        `lessons` AS le
    ON 
        ule.lesson_id = le.lesson_id
    WHERE 
        ule.lesson_id = _lesson_id 
        AND ule.user_id = _user_id
    LIMIT
        1;

    -- Buscar todas las lecciones de ese nivel
    -- De todas las lecciones de ese nivel checar si todas estan en complete
    SELECT SUM(ule.user_lesson_is_complete) = COUNT(ule.user_lesson_is_complete)
    INTO is_level_complete
    FROM `lessons` AS le
    INNER JOIN `user_lesson` AS ule
    ON le.lesson_id = ule.lesson_id
    WHERE le.level_id = _level_id AND ule.user_id = _user_id;

    -- Si devuelve 1 entonces actualizamos el user_level
    IF (is_level_complete = 1) THEN
        UPDATE
            `user_level`
        SET
            `user_level_is_complete` = TRUE,
            `user_level_complete_at` = COALESCE(`user_level_complete_at`, NOW())
        WHERE
            `user_id` = _user_id
            AND `level_id` = _level_id;
    END IF;

    SELECT `course_id` INTO _course_id 
    FROM `levels` AS l 
    INNER JOIN `user_level` AS ul 
    ON l.level_id = ul.level_id
    WHERE ul.level_id = _level_id AND ul.user_id = _user_id; 

    -- Buscar todos los niveles de ese curso
    SELECT SUM(ul.user_level_is_complete) = COUNT(ul.user_level_is_complete) 
    INTO is_course_complete
    FROM levels AS l
    INNER JOIN user_level AS ul
    ON l.level_id = ul.level_id
    WHERE l.course_id = _course_id AND ul.user_id = _user_id;

    -- Actualizar el enrollment
    IF (is_course_complete = 1) THEN
        UPDATE
            `enrollments`
        SET
            `enrollment_is_finished` = TRUE,
            `enrollment_finish_date` = COALESCE(`enrollment_finish_date`, NOW()),
            `enrollment_certificate_uid` = COALESCE(`enrollment_certificate_uid`, UUID())
        WHERE
            `course_id` = _course_id
            AND `student_id` = _user_id;
    END IF;

    COMMIT;
END $$
DELIMITER ;
