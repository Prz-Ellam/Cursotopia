SELECT * FROM images;

INSERT INTO categories(
    category_name,
    category_description,
    category_created_by
)
VALUES(
    'Frontend',
    'Las tecnologías para crear proyectos del lado del cliente',
    2
);

INSERT INTO courses(
    `course_title`,
    `course_description`,
    `course_price`,
    `image_id`,
    `instructor_id`
)
VALUES(
    'Crea páginas web con HTML y CSS',
    '¿Te gustaria aprender a desarrollar tus propias web? Pues el primer paso es aprender HTML y CSS y en este curso aprenderas las bases de estas tecnologías creando tu propio portafolio personal',
    250.00,
    3,
    2
);

INSERT INTO course_category(
    course_id, 
    category_id
)
VALUES(
    1,
    1
);

UPDATE
    courses
SET
    course_approved = TRUE,
    course_approved_by = 1
WHERE
    course_id = 1;


-- Los niveles del curso
INSERT INTO levels(
    level_title,
    level_description,
    level_price,
    course_id
)
VALUES
(
    '¿Qué vamos a aprender?',
    'Introducción al curso, el entorno y los programas a descargar',
    250.00,
    1
),
(
    'Introducción al HTML y CSS',
    'Aquí aprenderemos todos los conceptos necesarios para entender estas dos tecnologías',
    250.00,
    1
),
(
    'Finalizando nuestro portafolio',
    'Aprenderemos conceptos más avanzados a la vez que hacemos un portafolio',
    250.00,
    1
),
(
    'Publicamos nuestro portafolio',
    'Aprenderemos como podemos publicar en internet una página web como la que hemos hecho',
    250.00,
    1
);



-- Ahora una leccion por cada nivel por ahora
-- Todas seran de video
INSERT INTO lessons(
    lesson_title,
    lesson_description,
    level_id,
    video_id,
    image_id,
    document_id,
    link_id
)
VALUES
(
    '¡Comenazamos!',
    '',
    1,
    1,
    NULL,
    NULL,
    NULL
),
(
    'Una imagen de como se vera',
    'Asi se va a ver',
    1,
    NULL,
    4,
    NULL,
    NULL
),
(
    'Breve historia del HTML y CSS!',
    'Repasamos la evolución de HTML y CSS a lo largo del tiempo',
    2,
    2,
    NULL,
    NULL,
    NULL
),
(
    '¿Qué nos queda por hacer?',
    'Vamos a ver más cosas',
    3,
    3,
    NULL,
    NULL,
    NULL
),
(
    'Casi casi...¿terminamos?',
    'Ya casi',
    4,
    4,
    NULL,
    NULL,
    NULL
);



INSERT INTO reviews(
    review_message,
    review_rate,
    course_id,
    user_id
)
VALUES(
    'Mensaje',
    5,
    1,
    2
);


INSERT INTO enrollments(
    course_id,
    student_id,
    enrollment_amount,
    payment_method_id
)
VALUES(
    1,
    2,
    200.00,
    1
);




SELECT
    l.level_id AS `id`,
    l.level_title AS `title`,
    l.level_description AS `description`,
    l.level_price AS `price`,
    l.course_id AS `courseId`,
    l.level_created_at AS `createdAt`,
    l.level_modified_at AS `modifiedAt`,
    l.level_active AS `active`,
    (
    SELECT 
        GROUP_CONCAT(
        '[',
        JSON_OBJECT(
            'title', le.lesson_title, 
            'description', le.lesson_description,
            'video', v.video_duration),
        ']'
    )
    FROM 
        lessons AS le
    INNER JOIN
        videos AS v
    ON
        le.video_id = v.video_id
    WHERE 
        level_id = l.level_id
    GROUP BY
        le.lesson_id
    ) AS `lessons`
FROM
    levels AS l
INNER JOIN
    lessons AS le
ON
    l.level_id = le.level_id
WHERE
    course_id = 1
GROUP BY
    l.level_id;


SELECT
    le.lesson_title,
    le.lesson_description,
    v.video_duration
FROM
    lessons AS le
INNER JOIN
    videos AS v
ON
    le.video_id = v.video_id;




SELECT
            `id`,
            `title`,
            `description`,
            `price`,
            `imageId`,
            `createdAt`,
            `modifiedAt`,
            `instructorName`,
            `rates`,
            `reviews`,
            `students`,
            `levels`,
            `duration`
        FROM
            `course_details`
        WHERE
            `id` = 1



SELECT * FROM enrollments;

SELECT * FROM user_level;


SELECT
    e.course_id,
    e.student_id,
    l.level_title,
    le.lesson_title,
    ule.user_lesson_is_complete
FROM
    user_lesson AS ule
INNER JOIN
    lessons AS le
ON
    ule.lesson_id = le.lesson_id
INNER JOIN
    user_level AS ul
ON
    ul.level_id = le.level_id
INNER JOIN
    levels AS l
ON
    le.level_id = l.level_id
INNER JOIN
    enrollments AS e
ON
    l.course_id = e.course_id;


INSERT INTO chats VALUES();
INSERT INTO chat_participants(user_id, chat_id) VALUES(2, 2), (6, 2);



SELECT
    c.chat_id AS `chatId`
FROM
    chats AS c
LEFT JOIN
    chat_participants AS cp
ON
    c.chat_id = cp.chat_id
WHERE
    cp.user_id = 2
    OR cp.user_id = 6
GROUP BY
    c.chat_id
HAVING
    COUNT(cp.user_id) >= 2;


INSERT INTO chats VALUES();
INSERT INTO chat_participants(user_id, chat_id) VALUES(2, 2), (6, 2);



SELECT
    c.chat_id AS `chatId`, 
    cp.user_id AS `userId`,
    CONCAT(u.user_name, ' ', u.user_last_name) AS `user`,
    u.profile_picture AS `profilePicture`
FROM 
    chats AS c 
INNER JOIN 
    chat_participants AS cp ON c.chat_id = cp.chat_id
INNER JOIN 
    users AS u ON cp.user_id = u.user_id
WHERE
    c.chat_id IN (
        SELECT 
            chat_id 
        FROM 
            chat_participants 
        WHERE 
            user_id = 6
    )
    AND cp.user_id != 6;



SELECT
    m.message_id,
    m.message_content,
    m.user_id,
    m.chat_id,
    m.message_created_at,
    m.message_modified_at,
    m.message_active,
    mv.viewed_at
FROM
    messages AS m
LEFT JOIN
    message_views AS mv
ON
    m.message_id = mv.message_id
WHERE
    chat_id = 11;



INSERT INTO message_views(
    message_id, 
    user_id
)
SELECT 
    m.message_id,
    6
FROM 
    messages m 
WHERE 
    m.chat_id = 11 
    AND m.user_id != 6
    AND NOT EXISTS (
        SELECT 
            1 
        FROM 
            message_views mv 
        WHERE 
            mv.message_id = m.message_id 
            AND mv.user_id = 6
    )


-- La esta que aun no ha sido vista
SELECT
    le.lesson_id,
    le.lesson_title,
    ule.user_lesson_is_complete
FROM
    lessons AS le
INNER JOIN
    user_lesson AS ule
ON
    le.lesson_id = ule.lesson_id
INNER JOIN
    levels AS l
ON
    le.level_id = l.level_id
INNER JOIN
    enrollments AS e
ON
    l.course_id = e.course_id
WHERE
    e.course_id = 5
    AND ule.user_id = 6
    AND ule.user_lesson_is_complete = FALSE
LIMIT
    1;





SELECT
    `user_id`,
    `user_name`,
    `user_last_name`,
    `user_birth_date`,
    `user_gender`,
    `user_email`,
    `user_password`,
    `user_role`,
    `profile_picture`,
    `user_enabled`,
    `user_created_at`,
    `user_modified_at`,
    `user_active`
FROM
    `users`
WHERE
    `user_id` = IFNULL(NULL, `user_id`)
    AND `user_name` = IFNULL(NULL, `user_name`)
    AND `user_last_name` = IFNULL(NULL, `user_last_name`)
    AND `user_birth_date` = IFNULL(NULL, `user_birth_date`)
    AND `user_gender` = IFNULL(NULL, `user_gender`)
    AND `user_email` = IFNULL(NULL, `user_email`)
    AND `user_password` = IFNULL(NULL, `user_password`)
    AND `user_role` = IFNULL(NULL, `user_role`)
    AND `profile_picture` = IFNULL(NULL, `profile_picture`)
    AND `user_enabled` = IFNULL(NULL, `user_enabled`)
    AND `user_created_at` = IFNULL(NULL, `user_created_at`)
    AND `user_modified_at` = IFNULL(NULL, `user_modified_at`)
    AND `user_active` = IFNULL(NULL, `user_active`);


        SELECT
            c.course_id AS `id`,
            c.course_title AS `title`,
            c.course_description AS `description`,
            c.course_price AS `price`,
            c.course_image_id AS `imageId`,
            c.instructor_id AS `instructorId`,
            c.course_approved AS `approved`,
            c.course_approved_by AS `approvedBy`,
            c.course_created_at AS `createdAt`,
            c.course_modified_at AS `modifiedAt`,
            c.course_active AS `active`,
            COUNT(DISTINCT l.level_id) AS `levels`,
            IF(AVG(r.review_rate) IS NULL, 'No reviews', AVG(r.review_rate)) `rates`,
            CONCAT(u.user_name, ' ', u.user_last_name) `instructor`,
            SUM(TIME_TO_SEC(v.video_duration)) / 3600.0 AS `duration`,
            COUNT(DISTINCT e.enrollment_id) AS `enrollments`
        FROM
            `courses` AS c
        INNER JOIN
            levels AS l
        ON
            c.course_id = l.course_id
        INNER JOIN
            lessons AS le
        ON
            l.level_id = le.level_id
        LEFT JOIN
            videos AS v
        ON
            le.video_id = v.video_id
        LEFT JOIN
            reviews AS r
        ON
            c.course_id = r.course_id
        INNER JOIN
            users AS u
        ON
            c.instructor_id = u.user_id
        LEFT JOIN
            enrollments AS e
        ON
            c.course_id = e.course_id
        WHERE
            c.course_active = TRUE
            AND c.course_approved = TRUE
        GROUP BY
            c.course_id
        ORDER BY
            `course_created_at` DESC



-- La ultima leccion pendiente



-- Completar una lección
@user_id
@course_id
@lesson_id

-- Actualizar la leccion como vista
UPDATE 
    `user_lesson`
SET 
    `user_lesson_is_complete` = TRUE
    AND `user_lesson_complete_at` = NOW()
WHERE 
    `lesson_id` = 8 
    AND `user_id` = 4;

-- Buscar el nivel al que pertenece esa leccion
SELECT le.level_id FROM user_lesson AS ule
INNER JOIN lessons AS le
ON ule.lesson_id = le.lesson_id
WHERE ule.lesson_id = 8 AND ule.user_id = 4;

-- Buscar todas las lecciones de ese nivel
-- De todas las lecciones de ese nivel checar si todas estan en complete
SELECT SUM(ule.user_lesson_is_complete) = COUNT(ule.user_lesson_is_complete) 
FROM lessons AS le
INNER JOIN user_lesson AS ule
ON le.lesson_id = ule.lesson_id
WHERE le.level_id = 8 AND ule.user_id = 4;

-- Si devuelve 1 entonces actualizamos el user_level
UPDATE
    `user_level`
SET
    `user_level_is_complete` = TRUE,
    `user_level_complete_at` = NOW()
WHERE
    `user_id` = 4
    AND `level_id` = 8;

SELECT `course_id` 
FROM `levels` AS l 
INNER JOIN `user_level` AS ul 
ON l.level_id = ul.level_id
WHERE ul.level_id = 8 AND ul.user_id = 4; 

-- Buscar todos los niveles de ese curso
SELECT SUM(ul.user_level_is_complete) = COUNT(ul.user_level_is_complete) 
FROM levels AS l
INNER JOIN user_level AS ul
ON l.level_id = ul.level_id
WHERE l.course_id = 9 AND ul.user_id = 4;

-- Actualizar el enrollment
UPDATE
    `enrollments`
SET
    `enrollment_is_finished` = TRUE,
    `enrollment_finish_date` = NOW(),
    `enrollment_certificate_uid` = UUID()




SELECT
    l.level_id AS `id`,   
    l.level_title AS `title`, 
    l.level_description AS `description`,
    l.level_is_free AS `free`,
    l.course_id AS `courseId`,
    l.level_created_at AS `createdAt`,
    l.level_modified_at AS `modifiedAt`,
    l.level_active AS `active`,
    ul.user_level_is_complete AS `isComplete`,
    ul.user_level_complete_at AS `completeAt`,
    CONCAT('[', GROUP_CONCAT(
        JSON_OBJECT(
            'lesson_id', le.lesson_id,
            'lesson_title', le.lesson_title,
            'lesson_description', le.lesson_description,
            'main_resource', find_main_resource(le.lesson_id),
            'lesson_is_complete', ule.user_lesson_is_complete,
            'lesson_complete_at', ule.user_lesson_complete_at,
            'video_duration', IF(v.video_duration >= 3600, v.video_duration, RIGHT(v.video_duration, 5))
        )
    ), ']') AS `lessons`
FROM `levels` AS l
INNER JOIN `user_level` AS ul
ON l.level_id = ul.level_id AND ul.user_id = 5
INNER JOIN `lessons` AS le
ON l.level_id = le.level_id
INNER JOIN `user_lesson` AS ule
ON le.lesson_id = ule.lesson_id AND ule.user_id = 5
LEFT JOIN `videos` AS v
ON le.video_id = v.video_id
WHERE l.course_id = 9
GROUP BY
    l.level_id;




SELECT
    JSON_OBJECT(
        'lesson_id', le.lesson_id,
        'lesson_title', le.lesson_title,
        'lesson_description', le.lesson_description,
        'main_resource', find_main_resource(le.lesson_id),
        'lesson_is_complete', ule.user_lesson_is_complete,
        'lesson_complete_at', ule.user_lesson_complete_at,
        'video_duration', IF(v.video_duration >= 3600, v.video_duration, RIGHT(v.video_duration, 5))
    )
FROM `lessons` AS le
INNER JOIN `user_lesson` AS ule
ON le.lesson_id = ule.lesson_id AND ule.user_id = 5
LEFT JOIN `videos` AS v
ON le.video_id = v.video_id
WHERE `level_id` = 6;


SELECT
    le.lesson_id AS `lesson_id`,
    le.lesson_title AS `lesson_title`,
    le.lesson_description AS `lesson_description`,
    find_main_resource(le.lesson_id) AS `main_resource`,
    ule.user_lesson_is_complete AS `lesson_is_complete`,
    ule.user_lesson_complete_at AS `lesson_complete_at`,
    IF(v.video_duration >= 3600, v.video_duration, RIGHT(v.video_duration, 5)) AS `video_duration`
FROM `lessons` AS le
INNER JOIN `user_lesson` AS ule
ON le.lesson_id = ule.lesson_id AND ule.user_id = 5
LEFT JOIN `videos` AS v
ON le.video_id = v.video_id
WHERE `level_id` = 6;


