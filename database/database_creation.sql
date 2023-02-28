CREATE TABLE user_roles(
    user_role_id    INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (user_role_id)
);

CREATE TABLE images(
    image_id        INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (image_id)
);

CREATE TABLE videos(
    video_id        INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (video_id)
);

CREATE TABLE documents(
    document_id     INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (document_id)
);

CREATE TABLE links(
    link_id         INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (link_id)
);

CREATE TABLE users(
    user_id         INT NOT NULL AUTO_INCREMENT,
    user_role_id    INT NOT NULL,
    profile_picture INT NOT NULL,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_role_id) REFERENCES user_roles(user_role_id),
    FOREIGN KEY (profile_picture) REFERENCES images(image_id)
);

CREATE TABLE courses(
    course_id       INT NOT NULL AUTO_INCREMENT,
    instructor_id   INT NOT NULL,
    approved_by     INT NOT NULL,
    image_id        INT NOT NULL,
    PRIMARY KEY (course_id),
    FOREIGN KEY (instructor_id) REFERENCES users(user_id)
    FOREIGN KEY (approved_by) REFERENCES users(user_id)
    FOREIGN KEY (image_id) REFERENCES images(image_id)
);

CREATE TABLE levels(
    level_id        INT NOT NULL AUTO_INCREMENT,
    course_id       INT NOT NULL,
    PRIMARY KEY (level_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

CREATE TABLE lessons(
    lesson_id       INT NOT NULL AUTO_INCREMENT,
    level_id        INT NOT NULL,
    image_id        INT NOT NULL,
    video_id        INT NOT NULL,
    document_id     INT NOT NULL,
    link_id         INT NOT NULL
    PRIMARY KEY (lesson_id),
    FOREIGN KEY (level_id) REFERENCES level(level_id),
    FOREIGN KEY (image_id) REFERENCES images(image_id),
    FOREIGN KEY (video_id) REFERENCES videos(video_id),
    FOREIGN KEY (document_id) REFERENCES documents(document_id),
    FOREIGN KEY (link_id) REFERENCES links(link_id)
);

CREATE TABLE categories(
    category_id         INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    approved_by         INT NOT NULL,
    created_by          INT NOT NULL,
    FOREIGN KEY (approved_by) REFERENCES users(user_id),
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

CREATE TABLE course_category(
    course_category_id  INT NOT NULL AUTO_INCREMENT,
    course_id           INT NOT NULL,
    category_id         INT NOT NULL,
    PRIMARY KEY (course_category_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

CREATE TABLE reviews(
    review_id           INT NOT NULL AUTO_INCREMENT,
    course_id           INT NOT NULL,
    user_id             INT NOT NULL,
    PRIMARY KEY (review_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE payment_methods(
    payment_method_id   INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (payment_method_id)
);

CREATE TABLE enrollments(
    enrollment_id       INT NOT NULL AUTO_INCREMENT,
    student_id          INT NOT NULL,
    course_id           INT NOT NULL,
    payment_method_id   INT NOT NULL,
    PRIMARY KEY (enrollment_id),
    FOREIGN KEY (student_id) REFERENCES users(user_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(payment_method_id)
);




CREATE TABLE user_level(
    user_level_id       INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id             INT NOT NULL,
    level_id            INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (level_id) REFERENCES levels(level_id)
);

CREATE TABLE user_lesson(
    user_lesson_id      INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id             INT NOT NULL,
    lesson_id           INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (lesson_id) REFERENCES lessons(lesson_id)
);

CREATE TABLE chats(
    chat_id             INT NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE chat_participants(
    chat_participant_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id             INT NOT NULL,
    chat_id             INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (chat_id) REFERENCES chats(chat_id)
);

CREATE TABLE messages(
    message_id          INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id             INT NOT NULL,
    chat_id             INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (chat_id) REFERENCES chats(chat_id)
);





ALTER TABLE users
    ADD CONSTRAINT users_user_roles_fk
        FOREIGN KEY (user_role)
        REFERENCES user_roles(user_role_id);