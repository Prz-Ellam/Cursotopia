
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



INSERT INTO courses(course_title, course_description, course_price, image_id, instructor_id)
VALUES('Dummy course', 'Dummy desc', 1, 10, 1);




SELECT
    *
FROM
    enrollments
WHERE
    student_id = 2;