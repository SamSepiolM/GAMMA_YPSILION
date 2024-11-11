CREATE TABLE IF NOT EXISTS `cursosOnline`.`BitacoraUsuario` (
  `idBitacora` INT NOT NULL AUTO_INCREMENT,
   `FechaEjecucion` DATETIME,
   `executesSQL` VARCHAR(2000) DEFAULT NULL,
   `reverseSQL` VARCHAR(2000) DEFAULT NULL,
   
  PRIMARY KEY (`idBitacora`),
  UNIQUE INDEX `idBitacora_UNIQUE` (`idBitacora`))
ENGINE = InnoDB;



DROP TRIGGER IF EXISTS after_insert_usuario;
DELIMITER //
CREATE TRIGGER after_insert_usuario
	AFTER INSERT ON usuario 
	FOR EACH ROW
BEGIN	
	INSERT INTO bitacorausuario (FechaEjecucion, executesSQL, reverseSQL)
    values(
	now(),
		CONCAT("INSERT INTO usuario (idUsuario, Nombre_Usuario, Apellido_Paterno_Usuario, Apellido_Materno_Usuario, Correo_Usuario, Contrasenia_Usuario, Username) VALUES 
        (",NEW.idUsuario,", """,NEW.Nombre_Usuario,""",""" ,NEW.Apellido_Paterno_Usuario,""", """ ,NEW.Apellido_Materno_Usuario, """, """ ,NEW.Correo_Usuario, """, """,NEW.Contrasenia_Usuario,""", """ ,NEW.Username,");"),
		/*Instruccion de apoyo por si se quiere borrar un usuario desde la DB*/
        CONCAT("DELETE FROM usuario WHERE idUsuario = ",  NEW.idUsuario,";")
	);
END//
DELIMITER ;
select * from bitacorausuario;



DROP TRIGGER IF EXISTS after_delete_usuario;
DELIMITER //
CREATE TRIGGER after_delete_usuario
	AFTER DELETE ON usuario 
	FOR EACH ROW
BEGIN	
	INSERT INTO bitacorausuario (FechaEjecucion, executesSQL, reverseSQL)
    values(
	now(),
		CONCAT("DELETE FROM usuario WHERE idUsuario = ",OLD.idUsuario,";"), 
        CONCAT("INSERT INTO usuario (idUsuario, Nombre_Usuario, Apellido_Paterno_Usuario, Apellido_Materno_Usuario, Correo_Usuario, Contrasenia_Usuario, Username) VALUES 
        (",OLD.idUsuario,", """,OLD.Nombre_Usuario,""",""" ,OLD.Apellido_Paterno_Usuario,""", """ ,OLD.Apellido_Materno_Usuario, """, """ ,OLD.Correo_Usuario, """, """,OLD.Contrasenia_Usuario,""", """ ,OLD.Username,");")
	);
END//
DELIMITER ;
select * from bitacorausuario;



DROP TRIGGER IF EXISTS after_update_usuario;
DELIMITER //
CREATE TRIGGER after_update_usuario
	AFTER UPDATE ON usuario 
	FOR EACH ROW
BEGIN	
	INSERT INTO bitacorausuario (FechaEjecucion, executesSQL, reverseSQL)
    values(
	now(),
		CONCAT("UPDATE usuarios SET idUsuario = ",NEW.idUsuario,", """,NEW.Nombre_Usuario,""",""" ,NEW.Apellido_Paterno_Usuario,""", """ ,NEW.Apellido_Materno_Usuario, """, """ ,NEW.Correo_Usuario, """, """,NEW.Contrasenia_Usuario,""", """ ,NEW.Username, "WHERE idUsuario = ",OLD.idUsuario,",);"),
        CONCAT("UPDATE usuarios SET idUsuario = ",OLD.idUsuario,", """,OLD.Nombre_Usuario,""",""" ,OLD.Apellido_Paterno_Usuario,""", """ ,OLD.Apellido_Materno_Usuario, """, """ ,OLD.Correo_Usuario, """, """,OLD.Contrasenia_Usuario,""", """ ,OLD.Username, "WHERE idUsuario = ",NEW.idUsuario,",);")
	);
END//
DELIMITER ;
select * from bitacorausuario;


CREATE TABLE IF NOT EXISTS `cursosOnline`.`UsuarioRespaldo` (
  `idUsuarioR` INT NOT NULL AUTO_INCREMENT,
  `Nombre_UsuarioR` VARCHAR(45) NOT NULL,
  `Apellido_Paterno_UsuarioR` VARCHAR(45) NOT NULL,
  `Apellido_Materno_UsuarioR` VARCHAR(45) NOT NULL,
  `Correo_UsuarioR` VARCHAR(45) NOT NULL,
  `Contrasenia_UsuarioR` VARCHAR(45) NOT NULL,
  `UsernameR` VARCHAR(45) NOT NULL,
  `Foto_PerfilR` BLOB,
  `Estado_UsuarioR` TINYINT NOT NULL,
  `Rol_UserR` INT NOT NULL,
  `GeneroR` INT NOT NULL,
  `Fecha_NacimientoR` DATE NOT NULL,
  `Fecha_RegistroR` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `Fecha_ModificacionR` DATETIME ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idUsuarioR`),
  UNIQUE INDEX `idUsuarioR_UNIQUE` (`idUsuarioR`))
ENGINE = InnoDB;



DROP TRIGGER IF EXISTS insert_usuario;
DELIMITER //
CREATE TRIGGER insert_usuario
	AFTER INSERT ON usuario 
	FOR EACH ROW
BEGIN	
	INSERT INTO usuariorespaldo (idUsuarioR, Nombre_UsuarioR, Apellido_Paterno_UsuarioR, Apellido_Materno_UsuarioR, Correo_UsuarioR, Contrasenia_UsuarioR, UsernameR,
  Foto_PerfilR, Estado_UsuarioR, Rol_UserR, GeneroR, Fecha_NacimientoR, Fecha_RegistroR, Fecha_ModificacionR) VALUES
(NEW.idUsuario, NEW.Nombre_Usuario, NEW.Apellido_Paterno_Usuario, NEW.Apellido_Materno_Usuario, NEW.Correo_Usuario, NEW.Contrasenia_Usuario, NEW.Username, 
NEW.Foto_Perfil, NEW.Estado_Usuario, NEW.Rol_User, NEW.Genero, NEW.Fecha_Nacimiento, NEW.Fecha_Registro, NEW.Fecha_Modificacion);
END//
DELIMITER ;
select * from UsuarioRespaldo;



DELIMITER $$
CREATE TRIGGER after_insert_CapituloCompletado
AFTER INSERT
ON CapituloCompletado FOR EACH ROW
BEGIN
	DECLARE elementos INT;
    DECLARE elementosTotales INT;
    IF NEW.Estado_Completado = 1 THEN
		
		SET @elementos = (SELECT COUNT(*) FROM CapituloCompletado WHERE IdCapituloCompletado = NEW.IdCapituloCompletado);
        SET @elementosTotales = (SELECT COUNT(*) FROM CursoComprado CC INNER JOIN Curso C ON CC.IdCurso = C.idCurso WHERE CC.IdCursoComprado = NEW.IdCursoComprado);
        IF @elementos = @elementosTotales THEN
			UPDATE CursoComprado SET Estado_Completado = 1, FechaCompletado = NOW() WHERE IdCursoComprado = NEW.IdCursoComprado;
        END IF;
        
    END IF;
END$$
DELIMITER ;
