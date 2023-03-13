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




