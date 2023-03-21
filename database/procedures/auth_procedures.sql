SELECT 
    user_id, 
    user_password, 
    user_enabled 
FROM
    users AS u
INNER JOIN
    user_roles AS ur
ON
    u.user_role = ur.user_role_id
WHERE
    user_email = 'eliam@correo.com' 
    AND user_active = TRUE