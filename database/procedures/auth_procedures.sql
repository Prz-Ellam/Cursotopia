SELECT 
    user_id, 
    user_password, 
    user_enabled 
FROM
    users AS u
INNER JOIN
    roles AS ur
ON
    u.user_role = ur.role_id
WHERE
    user_email = 'eliam@correo.com' 
    AND user_active = TRUE