
-- User Roles
INSERT INTO user_roles(
    user_role_name, 
    user_role_is_public
)
VALUES(
    'Administrador',
    FALSE
);

INSERT INTO user_roles(
    user_role_name, 
    user_role_is_public
)
VALUES(
    'Instructor',
    TRUE
);

INSERT INTO user_roles(
    user_role_name, 
    user_role_is_public
)
VALUES(
    'Estudiante',
    TRUE
);