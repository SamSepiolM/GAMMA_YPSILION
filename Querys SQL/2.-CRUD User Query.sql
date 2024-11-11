USE cursosOnline
-- Procedure Crear Usuario
DELIMITER //
CREATE PROCEDURE SP_RegUsuario(
	IN nombre_usuario VARCHAR(45),
	IN _apellido_paterno_usuario VARCHAR(45),
	IN _apellido_materno_usuario VARCHAR(45),
	IN _correo_usuario VARCHAR(45),
	IN _contrasenia_usuario VARCHAR(45),
	IN _username VARCHAR(45),
	IN _rol_user INT,
    IN _genero TINYINT,
    IN _fecha_nacimiento DATE
    )
BEGIN

    DECLARE IdUsuarioRegistrado INT;
    DECLARE Mensaje VARCHAR(500);
	SET @IdUsuarioRegistrado = 0;
    SET @Mensaje  = '';
    
	IF NOT EXISTS (select idUsuario from usuario WHERE Username = _username) THEN 
		IF NOT EXISTS (select idUsuario from usuario WHERE Correo_Usuario = _correo_usuario) THEN
			INSERT INTO usuario(Nombre_Usuario, Apellido_Paterno_Usuario, Apellido_Materno_Usuario, Correo_Usuario, Contrasenia_Usuario, Username, Estado_Usuario, Rol_User, Genero, Fecha_Nacimiento)
			VALUES(nombre_usuario, _apellido_paterno_usuario,_apellido_materno_usuario, _correo_usuario, _contrasenia_usuario, _username, 1, _rol_user, _genero, _fecha_nacimiento);
			SET IdUsuarioRegistrado = last_insert_id();
			select '' as mensaje;
		ELSE 
			SET @Mensaje = 'Correo electronico ya existe';
            select @Mensaje as mensaje;
		END IF; 
    ELSE
		SET @Mensaje = 'Nombre de usuario ya existe';
        select @Mensaje as mensaje;
	END IF;   
END//
DELIMITER ;


-- Procedure Editar Usuario
DELIMITER //
CREATE PROCEDURE SP_EditUsuario(
	IN _idusuario INT,
	IN _nombre_usuario VARCHAR(45),
	IN _apellido_paterno_usuario VARCHAR(45),
	IN _apellido_materno_usuario VARCHAR(45),
	IN _correo_usuario VARCHAR(45),
	IN _contrasenia_usuario VARCHAR(45),
	IN _username VARCHAR(45),
	IN _rol_user INT,
    IN _genero TINYINT,
    IN _fecha_nacimiento DATE
    
)
BEGIN

	DECLARE _Respuesta TINYINT;
    DECLARE _Mensaje VARCHAR(500);
    
	SET _Respuesta = 1;
	SET _Mensaje  = '';
    
    IF NOT EXISTS (select * from usuario WHERE Correo_Usuario = _correo_usuario AND idUsuario != _idusuario) THEN
		UPDATE usuario SET Nombre_Usuario = _nombre_usuario, Apellido_Paterno_Usuario = _apellido_paterno_usuario, Apellido_Materno_Usuario = _apellido_materno_usuario, Correo_Usuario = _correo_usuario, 
		Contrasenia_Usuario = _contrasenia_usuario, Username = _username, Estado_Usuario = 1, Rol_User = _rol_user, Genero = _genero, Fecha_Nacimiento = _fecha_nacimiento WHERE idUsuario = _idusuario;
	ELSE
		SET _Mensaje = 'Este Username ya esta ocupado';
	END IF;  
END//
DELIMITER ;

-- Procedure Eliminar Logicamente Usuario
DELIMITER //
CREATE PROCEDURE SP_EliminLogUsuario(
	IN _idusuario INT
)
BEGIN
	UPDATE usuario SET Estado_Usuario = 0 WHERE idUsuario = _idusuario;
END//
DELIMITER ;


-- Procedure Eliminar Usuario (Solo para Administrador)
DELIMITER //
CREATE PROCEDURE SP_EliminUsuario(
	IN _idusuario INT
)
BEGIN

	DECLARE pasoreglas TINYINT;
    DECLARE Respuesta TINYINT;
    DECLARE Mensaje VARCHAR(500);
    
	SET Respuesta = 0;
	SET Mensaje  = '';
    SET pasoreglas = 1;
    
    
	-- En caso de que sea Administrador
	IF EXISTS(select * from usuario as u 
    inner join categoria as c on u.idUsuario = c.Creador_categoria where u.idUsuario = _idusuario) 
    THEN
		SET pasoreglas = 0;
		SET Respuesta = 0;
		SET Mensaje  = Mensaje + 'El usuario cuenta con categorias a su nombre, por lo que no puede ser eliminado';
	END IF; 
    
    
	-- En caso de que sea Maestro
    IF EXISTS(select * from usuario as u inner join curso as c on u.idUsuario = c.Creador_Curso where u.idUsuario = _idusuario) 
    THEN
		SET pasoreglas = 0;
		SET Respuesta = 0;
		SET Mensaje  = Mensaje + 'El usuario cuenta con cursos a su nombre, por lo que no puede ser eliminado';
	END IF; 
    
	-- En caso de que sea Alumno
    IF EXISTS(select * from usuario as u inner join calificacion as c on u.idUsuario = c.Usuario_calificador where u.idUsuario = _idusuario) 
    THEN
		SET pasoreglas = 0;
		SET Respuesta = 0;
		SET Mensaje  = Mensaje + 'El usuario cuenta con actividad en la pagina, por lo que no puede ser eliminado';
	END IF; 
    
     -- En caso de que sea Maestro/Alumno
	IF EXISTS(select * from usuario as u inner join mensajes as m on u.idUsuario = m.Emisor where u.idUsuario = _idusuario) 
    THEN
		SET pasoreglas = 0;
		SET Respuesta = 0;
		SET Mensaje  = Mensaje + 'El usuario cuenta con actividad en la pagina, por lo que no puede ser eliminado';
	END IF; 
    
	IF (pasoreglas = 1) THEN
		DELETE FROM usuario WHERE idUsuario = _idusuario;
        SET Respuesta = 1;
    END IF;  
END//
DELIMITER ;


DELIMITER //
CREATE PROCEDURE SP_MostrarUsuario(IN idusuario1 INT)
BEGIN
	SELECT idUsuario, Nombre_Usuario, Apellido_Paterno_Usuario, Apellido_Materno_Usuario, Correo_Usuario, Contrasenia_Usuario, Username, 
Estado_Usuario, Rol_User, Genero, Fecha_Nacimiento, Fecha_Registro, Fecha_Modificacion, Intentos_Fallidos FROM usuario WHERE idUsuario = idusuario1;
END//
DELIMITER ;

