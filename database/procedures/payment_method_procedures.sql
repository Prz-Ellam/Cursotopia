DELIMITER $$
DROP PROCEDURE IF EXISTS `payment_method_find_by_id` $$
CREATE PROCEDURE `payment_method_find_by_id`(
    IN `_payment_method_id`                 INT
)
BEGIN
    SELECT
        `payment_method_id`                 AS `id`,
        `payment_method_name`               AS `name`,
        `payment_method_created_at`         AS `createdAt`,
        `payment_method_mofified_at`        AS `modifiedAt`,
        `payment_method_active`             AS `active`
    FROM
        `payment_methods`
    WHERE
        `payment_method_id` = `_payment_method_id`
    LIMIT
        1;
END $$
DELIMITER ;
