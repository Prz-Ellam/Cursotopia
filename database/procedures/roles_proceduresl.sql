DELIMITER $$
DROP PROCEDURE IF EXISTS `role_find_all_by_is_public` $$
CREATE PROCEDURE `role_find_all_by_is_public`(
    IN `_is_public`                     BOOLEAN
)
BEGIN
    SELECT
        `role_id`                       AS `id`,
        `role_name`                     AS `name`,
        `role_is_public`                AS `is_public`,
        `role_created_at`               AS `created_at`,
        `role_modified_at`              AS `modified_at`,
        `role_active`                   AS `active`
    FROM
        `roles`
    WHERE
        `role_is_public` = `_is_public`;
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `role_find_by_id_and_is_public` $$
CREATE PROCEDURE `role_find_by_id_and_is_public`(
    IN `_role_id`                       INT,
    IN `_is_public`                     BOOLEAN
)
BEGIN
    SELECT
        `role_id`                       AS `id`,
        `role_name`                     AS `name`,
        `role_is_public`                AS `is_public`,
        `role_created_at`               AS `created_at`,
        `role_modified_at`              AS `modified_at`,
        `role_active`                   AS `active`
    FROM
        `roles`
    WHERE
        `role_id` = `_role_id`
        AND `role_is_public` = `_is_public`
    LIMIT
        1;
END $$
DELIMITER ;