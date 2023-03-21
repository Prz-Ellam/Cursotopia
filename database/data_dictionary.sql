-- Images
ALTER TABLE `images` MODIFY COLUMN `image_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'ID de la imagen';
ALTER TABLE `images` MODIFY COLUMN `image_name` 
VARCHAR(255) NOT NULL COMMENT 'Nombre de la imagen';
ALTER TABLE `images` MODIFY COLUMN `image_size` 
INT NOT NULL COMMENT 'Peso de la imagen en Bytes';
ALTER TABLE `images` MODIFY COLUMN `image_content_type` 
VARCHAR(30) NOT NULL COMMENT 'MIME de la imagen';
ALTER TABLE `images` MODIFY COLUMN `image_date`
MEDIUMBLOB NOT NULL COMMENT 'Contenido de la imagen';
ALTER TABLE `images` MODIFY COLUMN `image_created_at`
TIMESTAMP NOT NULL COMMENT 'Fecha de creación de la imagen';
ALTER TABLE `images` MODIFY COLUMN `image_modified_at`
TIMESTAMP NOT NULL COMMENT 'Fecha de última actualización de la imagen';
ALTER TABLE `images` MODIFY COLUMN `image_active`
BOOLEAN NOT NULL COMMENT 'Estado actual de la imagen';

-- Videos
ALTER TABLE `videos` MODIFY COLUMN `video_id`
INT NOT NULL AUTO_INCREMENT COMMENT 'ID del video';
ALTER TABLE `videos` MODIFY COLUMN `video_name`
VARCHAR(255) NOT NULL COMMENT 'Nombre del video';
ALTER TABLE `videos` MODIFY COLUMN `video_duration`
INT NOT NULL COMMENT 'Duración del video en segundos';
ALTER TABLE `videos` MODIFY COLUMN `video_address`
VARCHAR(255) NOT NULL COMMENT 'Ubicación del video en el sistema de archivos';

-- Documents
ALTER TABLE `documents` MODIFY COLUMN `document_id`
INT NOT NULL AUTO_INCREMENT COMMENT 'ID del documento'

-- Links
ALTER TABLE `links` MODIFY COLUMN `link_id`
INT NOT NULL AUTO_INCREMENT COMMENT 'ID del enlace'

-- User Roles

-- Users
ALTER TABLE `users` MODIFY COLUMN `user_id` 
INT NOT NULL AUTO_INCREMENT COMMENT 'ID del usuario';
ALTER TABLE `users` MODIFY COLUMN `user_name`
VARCHAR(50) NOT NULL COMMENT 'Nombre o nombres del usuario';
ALTER TABLE `users` MODIFY COLUMN `user_last_name`
VARCHAR(50) NOT NULL COMMENT 'Apellido o apellidos del usuario';
ALTER TABLE `users` MODIFY COLUMN `user_birth_date`
DATE NOT NULL COMMENT 'Fecha de nacimiento del usuario';
ALTER TABLE `users` MODIFY COLUMN `user_gender`
INT NOT NULL COMMENT 'Género del usuario';
ALTER TABLE `users` MODIFY COLUMN `user_email`
VARCHAR(255) NOT NULL COMMENT 'Correo electrónico del usuario';

-- Courses
ALTER TABLE `courses` MODIFY COLUMN `course_id`
INT NOT NULL AUTO_INCREMENT COMMENT 'ID del curso'

-- Levels
ALTER TABLE `levels` MODIFY COLUMN `level_id`
INT NOT NULL AUTO_INCREMENT COMMENT 'ID del nivel'

-- Lessons
ALTER TABLE `lessons` MODIFY COLUMN `lesson_id`
INT NOT NULL AUTO_INCREMENT COMMENT 'ID de la lección'

-- Categories
ALTER TABLE `categories` MODIFY COLUMN `category_id`
INT NOT NULL AUTO_INCREMENT COMMENT 'ID de la categoría'

-- Reviews
ALTER TABLE `reviews` MODIFY COLUMN `review_id`
INT NOT NULL AUTO_INCREMENT COMMENT 'ID de la reseña'

-- Payment Methods

-- Enrollments

-- Users Levels

-- Users Lessons

-- Courses Categories

-- Chat

-- Chat Participants

-- Messages