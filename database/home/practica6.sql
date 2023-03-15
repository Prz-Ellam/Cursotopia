-- Active: 1672167333219@@127.0.0.1@3306

CREATE DATABASE IF NOT EXISTS practica6;

USE practica6;

DROP TABLE IF EXISTS escenarios;
CREATE TABLE IF NOT EXISTS escenarios(
	id	INT NOT NULL AUTO_INCREMENT,
    riesgo INT NOT NULL,
    tiempo INT NOT NULL,
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS personajes;
CREATE TABLE IF NOT EXISTS personajes(
	id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    inteligencia INT NOT NULL,
    habilidad INT NOT NULL,
    fuerza INT NOT NULL,
    escenario_id INT NOT NULL,
    dominador_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (escenario_id) REFERENCES escenarios(id),
    FOREIGN KEY (dominador_id) REFERENCES personajes(id)
);

DROP TABLE IF EXISTS objetos;
CREATE TABLE IF NOT EXISTS objetos(
	id INT NOT NULL AUTO_INCREMENT,
    codigo INT NOT NULL,
    tiempo TIME NOT NULL,
    personaje_id INT NOT NULL,
    escenario_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (escenario_id) REFERENCES escenarios(id),
    FOREIGN KEY (personaje_id) REFERENCES personajes(id)
);


DELIMITER $$
DROP PROCEDURE IF EXISTS sp_escenarios;
CREATE PROCEDURE IF NOT EXISTS sp_escenarios(
	_id	INT,
    _riesgo INT,
    _tiempo INT,
    _opc INT
)
BEGIN
    IF _opc = 1 THEN
        INSERT INTO escenarios(riesgo, tiempo)
        VALUES(_riesgo, _tiempo);
    ELSE
        UPDATE escenarios 
        SET riesgo = _riesgo,
        tiempo = _tiempo
        WHERE id = _id;
    END IF;
END $$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS sp_personajes;
CREATE PROCEDURE IF NOT EXISTS sp_personajes(
	_id INT,
    _nombre VARCHAR(50),
    _inteligencia INT,
    _habilidad INT,
    _fuerza INT,
    _escenario_id INT,
    _dominador_id INT,
    _opc INT
)
BEGIN
    IF _opc = 1 THEN
	    INSERT INTO personajes(nombre, inteligencia, habilidad, fuerza, escenario_id, dominador_id)
        VALUES (_nombre, _inteligencia, _habilidad, _fuerza, _escenario_id, _dominador_id);
    ELSE
        UPDATE personajes
        SET nombre = _nombre,
        inteligencia = _inteligencia,
        habilidad = _habilidad,
        fuerza = _fuerza,
        escenario_id = _escenario_id,
        dominador_id = _dominador_id
        WHERE id = _id;
    END IF;
END $$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS sp_objetos;
CREATE PROCEDURE IF NOT EXISTS sp_objetos(
	_id INT,
    _codigo INT,
    _tiempo TIME,
    _escenario_id INT,
    _personaje_id INT,
    _opc INT
)
BEGIN
    IF _opc = 1 THEN
	    INSERT INTO objetos(codigo, tiempo, escenario_id, personaje_id)
        VALUES (_codigo, _tiempo, _escenario_id, _personaje_id);
    ELSE
        UPDATE objetos
        SET codigo = _codigo,
        tiempo = _tiempo,
        escenario_id = _escenario_id,
        personaje_id = _personaje_id
        WHERE id = _id;
    END IF;
END $$
DELIMITER ;