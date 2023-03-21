DELIMITER $$
CREATE PROCEDURE mi_procedimiento_almacenado(
    IN p_campo1 VARCHAR(255),
    IN p_campo2 VARCHAR(255),
    IN p_campo3 VARCHAR(255),
    OUT p_id INT,
    OUT p_num_filas_afectadas INT
)
BEGIN
    -- Insertar el registro en la tabla
    INSERT INTO mi_tabla (campo1, campo2, campo3) VALUES (p_campo1, p_campo2, p_campo3);
    
    -- Obtener el ID del registro insertado
    SET p_id = LAST_INSERT_ID();
    
    -- Obtener el número de filas afectadas por la inserción
    SET p_num_filas_afectadas = ROW_COUNT();
END $$
DELIMITER ;
