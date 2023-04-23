DELIMITER $$
DROP FUNCTION IF EXISTS `get_course_completion_percentage` $$
CREATE FUNCTION `get_course_completion_percentage`(
    course_id       INT
) 
RETURNS DECIMAL(5,2)
BEGIN
  DECLARE completion DECIMAL(5,2);
  
  SELECT AVG(ule.user_lesson_is_complete) * 100 INTO completion
  FROM `courses` AS c
  LEFT JOIN `enrollments` AS e ON c.course_id = e.course_id
  INNER JOIN `levels` AS l ON c.course_id = l.course_id
  INNER JOIN `lessons` AS le ON l.level_id = le.level_id
  INNER JOIN `user_lesson` AS ule ON le.lesson_id = ule.lesson_id AND e.student_id = ule.user_id
  WHERE c.course_id = course_id 
  AND c.course_active = TRUE 
  AND c.course_approved = TRUE;
  
  RETURN completion;
END $$
DELIMITER ;


DELIMITER $$
DROP FUNCTION IF EXISTS `get_user_course_completion` $$
CREATE FUNCTION `get_user_course_completion`(
  _user_id INT,
  _course_id INT
) 
RETURNS FLOAT
BEGIN
  DECLARE course_completion FLOAT;
  SELECT AVG(ule.user_lesson_is_complete) * 100
  INTO course_completion
  FROM `user_lesson` AS ule
  INNER JOIN `lessons` AS le ON ule.lesson_id = le.lesson_id
  INNER JOIN `levels` AS l ON le.level_id = l.level_id
  WHERE `user_id` = _user_id AND l.course_id = _course_id;
  RETURN course_completion;
END $$
DELIMITER ;



SELECT l.lesson_id FROM user_lesson AS ul
INNER JOIN lessons AS l ON ul.lesson_id = l.lesson_id
WHERE ul.user_id = 4
AND ul.user_lesson_is_complete = IF(l.lesson_id, TRUE, FALSE)
AND (
    SELECT courses.course_id
    FROM courses
    JOIN levels ON levels.course_id = courses.course_id
    JOIN lessons ON lessons.level_id = levels.level_id
    WHERE lessons.lesson_id = ul.lesson_id
    LIMIT 1
) = 9
  ORDER BY l.lesson_created_at ASC
    LIMIT 1