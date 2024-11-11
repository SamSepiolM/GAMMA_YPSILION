USE cursosOnline

-- Procedure Crear Categoria
DELIMITER //
CREATE PROCEDURE SP_RegCategoria(
	IN _nombre_categoria VARCHAR(45),
    IN _descripcion_categoria VARCHAR(200),
    IN _creador_categoria INT
    )
BEGIN

	DECLARE IdCategoriaRegistrada INT;
    DECLARE Mensaje VARCHAR(500);
	SET @IdCategoriaRegistrada = 0;
    SET @Mensaje  = '';
    
	IF NOT EXISTS (select idCategoria from categoria WHERE Nombre_categoria = _nombre_categoria AND EstadoCategoria = 1) THEN 

		INSERT INTO categoria(Nombre_categoria, Descripcion_categoria, Creador_categoria)
		VALUES(_nombre_categoria, _descripcion_categoria, _creador_categoria);
		
        SET IdCategoriaRegistrada = last_insert_id();
		SELECT '' AS mensaje;
    ELSE
		SET @Mensaje = 'Nombre de categoria ya existe';
	SELECT @Mensaje AS mensaje;
	END IF;   
END//
DELIMITER ;

-- Procedure Editar Categoria
DELIMITER //
CREATE PROCEDURE SP_EditCategoria(
	IN _nombre_categoria VARCHAR(45),
    IN _descripcion_categoria VARCHAR(200),
    IN _idcategoria INT
)
BEGIN

	DECLARE _Respuesta TINYINT;
    DECLARE _Mensaje VARCHAR(500);
    
	SET _Respuesta = 1;
	SET _Mensaje  = '';
    IF NOT EXISTS (select * from categoria WHERE Nombre_categoria = _nombre_categoria AND idCategoria != _idcategoria AND EstadoCategoria = 1) THEN
		UPDATE categoria SET Nombre_categoria = _nombre_categoria, Descripcion_categoria = _descripcion_categoria WHERE idCategoria = _idcategoria;
	ELSE
		SET _Respuesta = 0;
		SET _Mensaje = 'Error en la categoria ingresada, favor de revisarla';
	END IF;  
END//
DELIMITER ;

-- Procedure Eliminar Categoria
DELIMITER //
CREATE PROCEDURE SP_EliminCategoria(
	IN _idcategoria INT
)
BEGIN
	DELETE FROM categoria WHERE idCategoria = _idcategoria;
END//
DELIMITER ;

-- Procedure Eliminar Logica Categoria
DELIMITER //
CREATE PROCEDURE SP_EliminLogCategoria(
	IN _estadocategoria INT,
	IN _idcategoria INT
)
BEGIN
	UPDATE categoria SET EstadoCategoria = _estadocategoria WHERE idCategoria = _idcategoria;
END//
DELIMITER ;
