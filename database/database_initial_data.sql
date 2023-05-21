-- User roles
INSERT INTO 
    `roles` 
VALUES 
    (1,'Administrador',0,'2023-03-12 18:01:38','2023-03-12 18:01:38',1),
    (2,'Instructor',1,'2023-03-12 18:01:41','2023-03-12 18:01:41',1),
    (3,'Estudiante',1,'2023-03-12 18:01:45','2023-03-12 18:01:45',1);


-- Administrador
    INSERT INTO `images`(
        `image_name`,
        `image_size`,
        `image_content_type`,
        `image_data`
    )
    VALUES(
        'prueba.jpg',
        1,
        'image/jpg',
        '0'
    );
INSERT INTO `users` VALUES (DEFAULT,'admin','admin','2001-10-26','Masculino','root@root.com','$2y$10$lK4o1rqArg7UfdkkYmx7f.8S0bZ/VPq5J7lAjIFOB/4/wGXcgBWsW',1,1,1,'2023-03-12 18:03:46','2023-03-12 18:03:46',1);


INSERT INTO `payment_methods`(`payment_method_name`)
VALUES
    ('Tarjeta de crédito/débito'),
    ('PayPal');
