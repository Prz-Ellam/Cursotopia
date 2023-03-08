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


DROP DATABASE IF EXISTS users;
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
    approved_by         INT NOT NULL,
    approved_at         TIMESTAMP NOT NULL,
    PRIMARY KEY (products)
    FOREIGN KEY (image_id) REFERENCES images(image_id),
    FOREIGN KEY (approved_by) REFERENCES employees(employee_id)
);

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

CREATE TABLE shoppings(
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