DELIMITER $$
DROP PROCEDURE IF EXISTS `create_level` $$
CREATE PROCEDURE `create_level`(
    _title                      VARCHAR(50),
    _description                VARCHAR(255),
    _price                      DECIMAL(10, 2)
    _course_id                  INT
)
BEGIN
    INSERT INTO levels(
        `level_title`,
        `level_description`,
        `level_price`,
        `course_id`
    )
    SELECT
        _title,
        _description,
        _price,
        _course_id
    FROM
        dual
    WHERE
        _title IS NOT NULL
        AND _description IS NOT NULL
        AND _price IS NOT NULL
        AND _course_id IS NOT NULL;
END $$
DELIMITER ;