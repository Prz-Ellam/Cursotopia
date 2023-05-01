DROP VIEW IF EXISTS `course_visor`;
CREATE VIEW `course_visor`
AS
SELECT
    le.`lesson_id`,
    le.`lesson_title`,
    le.`lesson_description`,
    le.`video_id`,
    le.`image_id`,
    le.`document_id`,
    le.`link_id`,
    find_main_resource(`lesson_id`) AS `resource`,
    le.`lesson_created_at`,
    le.`lesson_modified_at`,
    le.`lesson_active`,
    l.`level_id`,
    l.`level_is_free`
FROM
    `lessons` AS le
INNER JOIN
    `levels` AS l
ON
    le.`level_id` = l.`level_id`;