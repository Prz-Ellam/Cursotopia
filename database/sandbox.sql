SELECT * 
FROM `courses`
WHERE
    `course_is_complete` = TRUE
    AND `course_approved` = TRUE
    AND `course_active` = TRUE
    -- Filtro por titulo del curso
    AND (`course_title` LIKE CONCAT('%', _title ,'%') OR _title IS NULL)
    -- Filtro por fecha
    AND (`course_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
    -- Por categoria
    AND (EXISTS(
        SELECT `category_id` 
        FROM `course_category` AS cc 
        WHERE cc.`course_id` = `course_id` 
        AND cc.`category_id` = _category_id 
        AND cc.`course_category_active` = TRUE
    ) OR _category_id IS NULL)
    -- Por instructor
    AND (`instructor_id` = _instructor_id OR _instructor_id IS NULL)



SELECT 
    `course_id`,
    `course_title`,
    `course_price`,
    `course_image_id`,
    `instructor_id`,
    `instructor_name`,
    `rate`,
    `levels`,
    `video_duration`
FROM 
    `course_card`
WHERE
    `course_is_complete` = TRUE
    AND `course_approved` = TRUE
    AND `course_active` = TRUE
    -- Filtro por titulo del curso
    AND (`course_title` LIKE CONCAT('%', _title ,'%') OR _title IS NULL)
    -- Filtro por fecha
    AND (`course_created_at` BETWEEN IFNULL(_from, '1000-01-01') AND IFNULL(_to, '9999-12-31'))
    -- Por categoria
    AND (EXISTS(SELECT `category_id` 
        FROM `course_category` AS cc WHERE cc.`course_id` = `course_id` 
        AND cc.`category_id` = _category_id AND cc.`course_category_active` = TRUE) 
        OR 2 IS NULL)
    -- Por instructor
    AND (`instructor_id` = _instructor_id OR _instructor_id IS NULL)



-- Categorias no aprobadas
SELECT * 
FROM `categories`
WHERE `category_is_approved` = FALSE;

-- Aprobar una categoría
UPDATE `categories`
SETasmr gibi magic
`category_is_approved` = TRUE,
`category_approved_by` = :admin_id,
`category_created_by` = NOW()

SELECT `image_id` FROM `images`;


CALL `course_search`(
    null,
    2,
    1,
    '2023-05-01',
    '2023-05-02',
    100,
    0
)

SELECT (EXISTS(
SELECT COUNT(`category_id`) 
FROM `course_category` AS cc WHERE cc.`course_id` = 1 
AND cc.`category_id` = 1 AND cc.`course_category_active` = TRUE) 
OR 1 IS NULL)

SELECT `category_id` 
FROM `course_category` AS cc WHERE cc.`course_id` = 15
AND cc.`category_id` = 1 AND cc.`course_category_active` = TRUE


SELECT l.level_is_free, e.enrollment_is_paid, c.course_price FROM `lessons` AS le
INNER JOIN `levels` AS l
ON le.level_id = l.level_id
INNER JOIN `enrollments` AS e
ON l.course_id = e.course_id AND e.student_id = 3
INNER JOIN `courses` AS c
ON e.course_id = c.course_id
WHERE `video_id` = 3

SELECT l.level_is_free, e.enrollment_is_paid FROM `lessons` AS le
INNER JOIN `levels` AS l
ON le.level_id = l.level_id
INNER JOIN `enrollments` AS e
ON l.course_id = e.course_id AND e.student_id = 4
WHERE `document_id` = 3

SELECT l.level_is_free, e.enrollment_is_paid FROM `lessons` AS le
INNER JOIN `levels` AS l
ON le.level_id = l.level_id
INNER JOIN `enrollments` AS e
ON l.course_id = e.course_id AND e.student_id = 4
WHERE `link_id` = 3


        SELECT
            `lesson_id` AS `id`,
            `lesson_title` AS `title`,
            `lesson_description` AS `description`,
            `video_id` AS `videoId`,
            `image_id` AS `imageId`,
            `document_id` AS `documentId`,
            `link_id` AS `linkId`,
            `link_name` AS `linkName`,
            `link_address` AS `linkAddress`,
            `resource`,
            `lesson_created_at` AS `createdAt`,
            `lesson_modified_at` AS `modifiedAt`,
            `lesson_active` AS `active`,
            `level_id` AS `levelId`,
            `level_is_free` AS `levelFree`
        FROM
            `course_visor`
        WHERE
            `lesson_id` = 31




        SELECT
            `id`,
            `title`,
            `description`,
            `price`,
            `imageId`,
            `instructorId`,
            `approved`,
            `approvedBy`,
            `createdAt`,
            `modifiedAt`,
            `active`,
            `levels`,
            `rates`,
            `reviews`,
            `instructor` AS `instructorName`,
            `duration`,
            `enrollments` AS `students`,
            `levelFree`
        FROM
            `course_details`
        WHERE
            `id` = 13


