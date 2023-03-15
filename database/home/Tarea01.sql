CREATE DATABASE imlaundry;
USE imlaundry;

DROP DATABASE IF EXISTS employees;
CREATE TABLE IF NOT EXISTS employees(
    employee_id         INT NOT NULL AUTO_INCREMENT,
    email               VARCHAR(255) NOT NULL UNIQUE,
    password            VARCHAR(255) NOT NULL,
    name                VARCHAR(50) NOT NULL,
    last_name           VARCHAR(50) NOT NULL,
    phone               VARCHAR(12) NOT NULL,
    curp                CHAR(18) NOT NULL UNIQUE,
    rfc                 CHAR(13) NOT NULL UNIQUE,
    nss                 CHAR(11) NOT NULL UNIQUE,
    created_at          TIMESTAMP NOT NULL DEFAULT NOW(), 
    modified_at         TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    active              BOOLEAN NOT NULL DEFAULT TRUE,
    address_id          INT NOT NULL UNIQUE,
    PRIMARY KEY (user_id),
    FOREIGN KEY (address_id) REFERENCES addresses(address_id)
);

INSERT INTO employees(email, password, name, last_name, phone, curp, rfc, nss, address_id)
VALUES('a@a.com', '123', 'Eliam', 'Rodríguez', '8186909645', 'CURP', 'RFC', 'NSS', 1),
VALUES('b@b.com', '123', 'Eliza', 'Rodríguez', '8187659385', 'CURP', 'RFC', 'NSS', 2),
VALUES('c@c.com', '123', 'Aldo Iván', 'Rodríguez', '8186939583', 'CURP', 'RFC', 'NSS', 3);

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users(
    user_id             INT NOT NULL AUTO_INCREMENT,
    email               VARCHAR(255) NOT NULL UNIQUE,
    password            VARCHAR(255) NOT NULL,
    name                VARCHAR(50) NOT NULL,
    last_name           VARCHAR(50) NOT NULL,
    birth_date          DATE NOT NULL,
    phone               VARCHAR(12) NOT NULL,
    created_at          TIMESTAMP NOT NULL DEFAULT NOW(), 
    modified_at         TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    active              BOOLEAN NOT NULL DEFAULT TRUE,
    address_id          INT NOT NULL UNIQUE,
    image_id            INT NOT NULL UNIQUE,
    PRIMARY KEY (user_id),
    FOREIGN KEY (address_id) REFERENCES addresses(address_id),
    FOREIGN KEY (image_id) REFERENCES images(image_id)
);

INSERT INTO users(email, password, name, last_name, birth_date, phone, address_id, image_id)
VALUES('eliam@correo.com', '123', 'Eliam', 'Rodriguez', '2001-10-26', '8186909645', 1, 1),
VALUES('grecia@correo.com', '123', 'Grecia', 'Cadena', '2002-10-23', '8186909645', 2, 2),
VALUES('elias@correo.com', '123', 'Elias', 'Jalomo', '2002-02-23', '8186909645', 3, 3);

DROP TABLE IF EXISTS addresses;
CREATE TABLE IF NOT EXISTS addresses(
    address_id          INT NOT NULL AUTO_INCREMENT,
    address_one         VARCHAR(255) NOT NULL,
    address_two         VARCHAR(255) NOT NULL,
    name_google         VARCHAR(255) NOT NULL,
    latitude            VARCHAR(255) NOT NULL,
    longitude           VARCHAR(255) NOT NULL,
    vicinity            VARCHAR(255) NOT NULL,
    postal_code         VARCHAR(5) NOT NULL,
    PRIMARY KEY (address_id)
);

INSERT INTO addresses(address_one, address_two, name_google, latitude, longitude, vicinity, postal_code)
VALUES('1', '1', '1', '1', '1', '1', '66612'),
VALUES('2', '2', '2', '2', '2', '2', '66612'),
VALUES('3', '3', '3', '3', '3', '3', '66612');

DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products(
    product_id          INT NOT NULL AUTO_INCREMENT,
    name                VARCHAR(30) NOT NULL,
    price               DECIMAL(10, 2) NOT NULL,
    description         VARCHAR(255) NOT NULL,
    available           BOOLEAN NOT NULL,
    created_at          TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at         TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    image_id            INT NOT NULL UNIQUE,
    approved_by         INT DEFAULT NULL,
    approved_at         TIMESTAMP,
    PRIMARY KEY (products)
    FOREIGN KEY (image_id) REFERENCES images(image_id),
    FOREIGN KEY (approved_by) REFERENCES employees(employee_id)
);

INSERT INTO products(name, price, description, available, image_id)
VALUES('Producto1', 200.00, 'Producto1', TRUE, 4),
VALUES('Producto2', 300.00, 'Producto2', TRUE, 5),
VALUES('Producto3', 400.00, 'Producto3', TRUE, 6);

DROP TABLE IF EXISTS images;
CREATE TABLE IF NOT EXISTS images(
    image_id            INT NOT NULL AUTO_INCREMENT,
    name                VARCHAR(255) NOT NULL,
    size                INT NOT NULL,
    content_type        VARCHAR(30) NOT NULL,
    data                MEDIUMBLOB NOT NULL,
    created_at          TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at         TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    active              BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (image_id)
);

INSERT INTO images(name, size, content_type, data)
VALUES('a.png', 1235, 'image/png', '123456'),
VALUES('b.png', 66532, 'image/png', '123456'),
VALUES('c.png', 76242, 'image/png', '123456'),
VALUES('d.png', 23421, 'image/png', '123456'),
VALUES('e.png', 394214, 'image/png', '123456'),
VALUES('f.png', 394214, 'image/png', '123456');

DROP TABLE IF EXISTS bags;
CREATE TABLE IF NOT EXISTS bags(
    bag_id              INT NOT NULL AUTO_INCREMENT,
    total               DECIMAL(10, 2) NOT NULL,
    user_id             INT NOT NULL,
    created_at          TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at         TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    active              BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (bag_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

INSERT INTO bags(total, user_id)
VALUES(0, 1),
VALUES(0, 2),
VALUES(0, 3);

DROP TABLE IF EXISTS bag_items;
CREATE TABLE IF NOT EXISTS bag_items(
    bag_item_id         INT NOT NULL AUTO_INCREMENT,
    quantity            UNSIGNED INT NOT NULL,
    product_id          INT NOT NULL,
    bag_id              INT NOT NULL,
    created_at          TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at         TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    active              BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (bag_item_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (bag_id) REFERENCES bags(bag_id)
);

INSERT INTO bag_items(quantity, product_id, bag_id)
VALUES(1, 1, 1),
VALUES(2, 2, 2),
VALUES(3, 3, 3);

DELETE FROM bag_items WHERE bag_item_id = 1;
DELETE FROM bag_items WHERE bag_item_id = 2;


DROP TABLE IF EXISTS orders;
CREATE TABLE IF NOT EXISTS orders(
    order_id            INT NOT NULL AUTO_INCREMENT,
    user_id             INT NOT NULL,
    created_at          TIMESTAMP NOT NULL DEFAULT NOW(),
    modified_at         TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    active              BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (order_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
);

INSERT INTO orders(user_id)
VALUES(1),(2),(3);

DROP TABLE IF EXISTS shoppings;
CREATE TABLE IF NOT EXISTS shoppings(
	shopping_id				INT NOT NULL AUTO_INCREMENT,
    order_id				INT NOT NULL,
    product_id				INT NOT NULL,
    quantity				INT NOT NULL,
    amount					DECIMAL(10, 2),
    created_at          	TIMESTAMP DEFAULT NOW(),
    modified_at             TIMESTAMP,
    active					BOOLEAN DEFAULT TRUE,
    PRIMARY KEY (shopping_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

INSERT INTO shoppings(order_id, product_id, quantity, amount)
VALUES(1, 1, 1, 200.00),
(2, 2, 2, 300.00),
(3, 3, 3, 400.00)


UPDATE
    shoppings
SET
    order_id = 2,
    product_id = 2,
    quantity = 5,
    amount = 1000.00
WHERE
    shopping_id = 1;

UPDATE
    shoppings
SET
    order_id = 3,
    product_id = 3,
    quantity = 1,
    amount = 150.00
WHERE
    shopping_id = 2;


SELECT
    product_id, name, price, description, available, created_at, modified_at,
    image_id, approved_by, approved_at
FROM
    products
WHERE
    price >= 200.00
UNION ALL
SELECT
    product_id, name, price, description, available, created_at, modified_at,
    image_id, approved_by, approved_at
FROM
    products
WHERE
    available = TRUE
UNION ALL
SELECT
    product_id, name, price, description, available, created_at, modified_at,
    image_id, approved_by, approved_at
FROM
    products
WHERE
    created_at >= '2023-03-01'