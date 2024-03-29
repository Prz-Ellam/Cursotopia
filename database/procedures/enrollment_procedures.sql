DELIMITER $$
DROP PROCEDURE IF EXISTS `enrollment_find_one_by_course_and_student` $$
CREATE PROCEDURE `enrollment_find_one_by_course_and_student`(
    IN `_course_id`                     INT,
    IN `_student_id`                    INT
)
BEGIN
    SELECT
        `enrollment_id` AS `id`,
        `course_id` AS `courseId`,
        `student_id` AS `studentId`,
        `enrollment_is_finished` AS `isFinished`,
        `enrollment_enroll_date` AS `enrollDate`,
        `enrollment_finish_date` AS `finishDate`,
        `enrollment_certificate_uid` AS `certificateUid`,
        `enrollment_amount` AS `amount`,
        `payment_method_id` AS `paymentMethod`,
        `enrollment_is_paid` AS `isPaid`,
        `enrollment_last_time_checked` AS `lastTimeChecked`,
        `enrollment_created_at` AS `createdAt`,
        `enrollment_modified_at` AS `modifiedAt`,
        `enrollment_active` AS `active`
    FROM
        `enrollments`
    WHERE
        `course_id` = `_course_id`
        AND `student_id` = `_student_id`
    LIMIT
        1;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `enrollment_pay` $$
CREATE PROCEDURE `enrollment_pay`(
    IN  `_course_id`                    INT,
    IN  `_student_id`                   INT,
    IN  `_amount`                       DECIMAL(10,2),
    IN  `_payment_method_id`            INT,
    OUT `_enrollment_id`                INT
)
BEGIN
    DECLARE num_rows INT;
    SELECT COUNT(`enrollment_id`) INTO num_rows FROM `enrollments` WHERE `course_id` = `_course_id` AND `student_id` = `_student_id`;
    IF num_rows = 0 THEN
        INSERT INTO `enrollments`(
            `course_id`,
            `student_id`,
            `enrollment_amount`,
            `payment_method_id`
        )
        VALUES(
            `_course_id`,
            `_student_id`,
            `_amount`,
            `_payment_method_id`
        );
        SET `_enrollment_id` = LAST_INSERT_ID();
    ELSE
        UPDATE
            `enrollments`
        SET
            `enrollment_amount` = IFNULL(`_amount`, `enrollment_amount`),
            `payment_method_id` = IFNULL(`_payment_method_id`, `payment_method_id`)
        WHERE
            `course_id` = `_course_id`
            AND `student_id` = `_student_id`;
        SET `_enrollment_id` = (SELECT `enrollment_id` FROM `enrollments` WHERE `course_id` = `_course_id` AND `student_id` = `_student_id` LIMIT 1);
    END IF;

    UPDATE
        `enrollments`
    SET
        `enrollment_is_paid` = CASE WHEN `enrollment_amount` IS NOT NULL AND `payment_method_id` IS NOT NULL THEN true ELSE false END
    WHERE
        `course_id` = `_course_id`
        AND `student_id` = `_student_id`;
END $$
DELIMITER ;



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



DELIMITER $$
DROP PROCEDURE IF EXISTS `visit_lesson` $$
CREATE PROCEDURE `visit_lesson`(
    IN _student_id                      INT,
    IN _lesson_id                       INT
)
BEGIN
    DECLARE _level_id INT;
    DECLARE _course_id INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    UPDATE
        `user_lesson`
    SET
        `user_lesson_last_time_checked` = NOW()
    WHERE
        `lesson_id` = _lesson_id
        AND `user_id` = _student_id;

    -- Buscar el nivel
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
        AND ule.user_id = _student_id
    LIMIT
        1;

    UPDATE
        `user_level`
    SET
        `user_level_last_access_date` = NOW()
    WHERE
        `level_id` = _lesson_id
        AND `user_id` = _student_id;

    SELECT `course_id` INTO _course_id 
    FROM `levels` AS l 
    INNER JOIN `user_level` AS ul 
    ON l.level_id = ul.level_id
    WHERE ul.level_id = _level_id AND ul.user_id = _student_id; 

    UPDATE
        `enrollments`
    SET
        `enrollment_last_time_checked` = NOW()
    WHERE
        `course_id` = _course_id
        AND `student_id` = _student_id;

    COMMIT;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_sales_report` $$
CREATE PROCEDURE `course_sales_report`(
    IN _instructor_id                   INT,
    IN _category_id                     INT,
    IN _from                            DATE,
    IN _to                              DATE,
    IN _active                          BOOLEAN,
    IN _limit                           INT,
    IN _offset                          INT
)
BEGIN
    SELECT
        `course_id`                     AS `id`,
        `course_title`                  AS `title`,
        `course_image_id`               AS `imageId`,
        `enrollments`,
        `amount`,
        `average_level`                 AS `averageLevel`,
        `instructor_id`                 AS `instructor_id`,
        `course_created_at`             AS `createdAt`
    FROM
        `instructor_courses`            AS ic
    WHERE
        `instructor_id` = _instructor_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND (`course_active` = TRUE OR _active = FALSE)
        AND (`course_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = ic.`course_id` 
            AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL)
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `course_sales_report_total` $$
CREATE PROCEDURE `course_sales_report_total`(
    IN _instructor_id                   INT,
    IN _category_id                     INT,
    IN _from                            DATE,
    IN _to                              DATE,
    IN _active                          BOOLEAN
)
BEGIN
    SELECT
        IFNULL(COUNT(`course_id`), 0)   AS `total`
    FROM
        `instructor_courses` AS ic
    WHERE
        `instructor_id` = _instructor_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND (`course_active` = TRUE OR _active = FALSE)
        AND (`course_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = ic.`course_id` 
            AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL);
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `instructor_courses_seen_by_others_report` $$
CREATE PROCEDURE `instructor_courses_seen_by_others_report`(
    IN _instructor_id                   INT,
    IN _limit                           INT,
    IN _offset                          INT
)
BEGIN
    SELECT
        `course_id`                     AS `id`,
        `course_title`                  AS `title`,
        `course_image_id`               AS `imageId`,
        `course_price`                  AS `price`,
        `enrollments`,
        `amount`,
        `rates`                         AS `rate`,
        `instructor_id`                 AS `instructor_id`,
        `course_created_at`             AS `createdAt`
    FROM
        `instructor_courses_seen_by_others`
    WHERE
        `instructor_id` = _instructor_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND `course_active` = TRUE
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `instructor_courses_seen_by_others_report_total` $$
CREATE PROCEDURE `instructor_courses_seen_by_others_report_total`(
    IN _instructor_id                   INT
)
BEGIN
    SELECT
        IFNULL(COUNT(`course_id`), 0) AS `total`
    FROM
        `instructor_courses_seen_by_others`
    WHERE
        `instructor_id` = _instructor_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND `course_active` = TRUE;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `kardex_report` $$
CREATE PROCEDURE `kardex_report`(
    IN _student_id                      INT,
    IN _from                            DATE,
    IN _to                              DATE,
    IN _category_id                     INT,
    IN _complete                        BOOLEAN,
    IN _active                          BOOLEAN,
    IN _limit                           INT,
    IN _offset                          INT
)
BEGIN
    SELECT
        `course_id`                     AS `id`,
        `course_title`                  AS `title`,
        `course_image_id`               AS `imageId`,
        `student_id`                    AS `studentId`,
        --`enrollment_enroll_date` AS `enrollDate`,
        `enrollment_created_at`         AS `enrollDate`,
        `enrollment_last_time_checked`  AS `lastTimeChecked`,
        `enrollment_finish_date`        AS `finishDate`,
        `enrollment_is_finished`        AS `isFinished`,
        `enrollment_status`             AS `status`,
        `enrollment_certificate_uid`    AS `certificateUid`,
        `enrollment_progress`           AS `progress`
    FROM
        `kardex` AS k
    WHERE
        `student_id` = _student_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND (`enrollment_is_finished` = TRUE OR _complete = FALSE)
        AND (`course_active` = TRUE OR _active = FALSE)
        AND (`enrollment_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = k.`course_id` 
            AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL
        )
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `kardex_report_total` $$
CREATE PROCEDURE `kardex_report_total`(
    IN _student_id                      INT,
    IN _from                            DATE,
    IN _to                              DATE,
    IN _category_id                     INT,
    IN _complete                        BOOLEAN,
    IN _active                          BOOLEAN
)
BEGIN
    SELECT
        IFNULL(COUNT(`course_id`), 0) AS `total`
    FROM
        `kardex` AS k
    WHERE
        `student_id` = _student_id
        AND `course_is_complete` = TRUE
        AND `course_approved` = TRUE
        AND (`enrollment_is_finished` = TRUE OR _complete = FALSE)
        AND (`course_active` = TRUE OR _active = FALSE)
        AND (`course_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
        AND (EXISTS(
            SELECT `category_id` 
            FROM `course_category` AS cc WHERE cc.`course_id` = k.`course_id` 
            AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
            OR _category_id IS NULL
        );
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_enrollments_report` $$
CREATE PROCEDURE `course_enrollments_report`(
    IN _course_id                       INT,
    IN _from                            DATE,
    IN _to                              DATE,
    IN _limit                           INT,
    IN _offset                          INT
)
BEGIN
    SELECT 
        ce.`course_id` AS `courseId`,
        ce.`user_id` AS `userId`,
        CONCAT(ce.`user_name`, ' ', ce.`user_last_name`) AS `username`,
        ce.`profile_picture` AS `profilePicture`,
        ce.`enrollment_enroll_date` AS `enrollmentDate`,
        ce.`enrollment_created_at` AS `createdAt`,
        ce.`enrollment_amount` AS `amount`,
        ce.`payment_method_name` AS `paymentMethodName`,
        ce.`percentage_complete` AS `percentageComplete`
    FROM
        `course_enrollments` AS ce
    WHERE
        ce.`course_id` = _course_id
        AND (ce.`enrollment_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
    LIMIT
        _limit
    OFFSET
        _offset;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `course_enrollments_report_total` $$
CREATE PROCEDURE `course_enrollments_report_total`(
    IN _course_id                       INT,
    IN _from                            DATE,
    IN _to                              DATE
)
BEGIN
    SELECT 
        COUNT(ce.`course_id`) AS `total`
    FROM
        `course_enrollments` AS ce
    WHERE
        ce.`course_id` = _course_id
        AND (ce.`enrollment_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'));
END $$
DELIMITER ;


-- Bien hecho
DELIMITER $$
DROP PROCEDURE IF EXISTS `certificate_find_one` $$
CREATE PROCEDURE `certificate_find_one`(
    IN `_student_id`                    INT,
    IN `_course_id`                     INT
)
BEGIN
    SELECT
        `student`,
        `instructor`,
        `course_title` AS `course`,
        `enrollment_finish_date` AS `finishDate`,
        `enrollment_certificate_uid` AS `certificateId`
    FROM
        `certificate`
    WHERE
        `student_id` = `_student_id`
        AND `course_id` = `_course_id`
    LIMIT
        1;
END $$
DELIMITER ;
