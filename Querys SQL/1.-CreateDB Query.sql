CREATE SCHEMA IF NOT EXISTS `cursosOnline`;
USE `cursosOnline`;

-- Tabla de Genero
CREATE TABLE IF NOT EXISTS `Genero` (
  `idGenero` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Genero` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idGenero`),
  UNIQUE INDEX `idGenero_UNIQUE` (`idGenero`),
  UNIQUE INDEX `Nombre_Genero_UNIQUE` (`Nombre_Genero`));

-- Tabla de Rol
CREATE TABLE IF NOT EXISTS `Rol` (
  `idRol` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Rol` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRol`),
  UNIQUE INDEX `idRol_UNIQUE` (`idRol`),
  UNIQUE INDEX `Nombre_Rol_UNIQUE` (`Nombre_Rol`));
  
-- Tabla de Usuario
CREATE TABLE IF NOT EXISTS `Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `Nombre_Usuario` VARCHAR(45) NOT NULL,
  `Apellido_Paterno_Usuario` VARCHAR(45) NOT NULL,
  `Apellido_Materno_Usuario` VARCHAR(45) NOT NULL,
  `Correo_Usuario` VARCHAR(45) NOT NULL,
  `Contrasenia_Usuario` VARCHAR(45) NOT NULL,
  `Username` VARCHAR(45) NOT NULL,
  `Foto_Perfil` LONGBLOB NULL DEFAULT NULL,
  `Estado_Usuario` TINYINT NOT NULL,
  `Rol_User` INT NOT NULL,
  `Genero` INT NOT NULL,
  `Fecha_Nacimiento` DATE NOT NULL,
  `Fecha_Registro` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `Fecha_Modificacion` DATETIME ON UPDATE CURRENT_TIMESTAMP,
  `Intentos_Fallidos` INT NULL DEFAULT 0,
  PRIMARY KEY (`idUsuario`),
  UNIQUE INDEX `idUsuario_UNIQUE` (`idUsuario`),
  UNIQUE INDEX `Correo_Usuario_UNIQUE` (`Correo_Usuario`),
  UNIQUE INDEX `Username_UNIQUE` (`Username`),
  
  INDEX `Rol_index` (`Rol_User`),
  CONSTRAINT `Rol`
    FOREIGN KEY (`Rol_User`)
    REFERENCES `Rol` (`idRol`),
    
  INDEX `Genero_index` (`Genero`),
  CONSTRAINT `Genero`
    FOREIGN KEY (`Genero`)
    REFERENCES `Genero` (`idGenero`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Tabla de Categorias
CREATE TABLE IF NOT EXISTS `Categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `Nombre_categoria` VARCHAR(45) NOT NULL,
  `Descripcion_categoria` VARCHAR(200) NOT NULL,
  `Creador_categoria` INT NOT NULL,
  `Fecha_Creacion_categoria` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `EstadoCategoria` TINYINT DEFAULT 1,
  PRIMARY KEY (`idCategoria`),
  
  INDEX `Creador_index` (`Creador_categoria`),
  CONSTRAINT `Creador`
    FOREIGN KEY (`Creador_categoria`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Tabla de Cursos
CREATE TABLE IF NOT EXISTS `Curso` (
  `idCurso` INT NOT NULL AUTO_INCREMENT,
  `Titulo_Curso` VARCHAR(45) NOT NULL,
  `Descripcion_Curso` VARCHAR(200) NOT NULL,
  `GradoCurso` VARCHAR(45) NOT NULL,
  `Fecha_Registro_Curso` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `EstadoCurso` TINYINT NOT NULL,
  `Precio_Curso` DECIMAL(10,2) NOT NULL,
  `Creador_Curso` INT NOT NULL,
  `ImagenCurso` LONGBLOB NULL DEFAULT NULL,
  PRIMARY KEY (`idCurso`),
  INDEX `Creador_index` (`Creador_Curso`),
  CONSTRAINT `CreadorCurso`
    FOREIGN KEY (`Creador_Curso`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Crear la tabla que almacena varias categorias
CREATE TABLE IF NOT EXISTS `CategoriaCurso` (
  `idCategoriaCurso` INT NOT NULL AUTO_INCREMENT,
  `idCategoria` INT NOT NULL,
  `idCurso` INT NOT NULL,
  PRIMARY KEY (`idCategoriaCurso`),
  
  INDEX `Categoria_index` (`idCategoria`),
  CONSTRAINT `CategoriaCurso`
    FOREIGN KEY (`idCategoria`)
    REFERENCES `Categoria` (`idCategoria`),
  INDEX `Curso_index` (`idCurso`),
  CONSTRAINT  `idCursoC`
  FOREIGN KEY (`idCurso`)
  REFERENCES `cursosonline`.`Curso` (`idCurso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Tabla de Calificacion
CREATE TABLE IF NOT EXISTS `Calificacion` (
  `idCalificacion` INT NOT NULL AUTO_INCREMENT,
  `Nombre_calificacion` VARCHAR(45) NULL,
  `Comentario` VARCHAR(200) NULL,
  `Usuario_calificador` INT NOT NULL,
  `Curso_Calificado` INT NOT NULL,
  `Fecha_Calificacion` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `Estado_Calificacion` TINYINT NULL DEFAULT 1,
  PRIMARY KEY (`idCalificacion`),
  
  INDEX `Calificador_index` (`Usuario_calificador`),
  INDEX `Calificacion_index` (`Curso_Calificado`),
  CONSTRAINT `Calificador`
    FOREIGN KEY (`Usuario_calificador`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Calificacion`
    FOREIGN KEY (`Curso_Calificado`)
    REFERENCES `Curso` (`idCurso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Tabla de Mensajes
CREATE TABLE IF NOT EXISTS `Mensajes` (
  `idMensajes` INT NOT NULL AUTO_INCREMENT,
  `Mensaje` VARCHAR(500) NOT NULL,
  `Emisor` INT NOT NULL,
  `Receptor` INT NOT NULL,
  `Fecha_envio` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idMensajes`),
  INDEX `Emisor_index` (`Emisor`),
  INDEX `Receptor_index` (`Receptor`, `Emisor`),
  
  CONSTRAINT `Emisor`
    FOREIGN KEY (`Emisor`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Receptor`
    FOREIGN KEY (`Receptor`)
    REFERENCES `Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Tabla de Capitulos (donde se guardaran los capitulos de los cursos)
CREATE TABLE IF NOT EXISTS `Capitulo` (
  `IdCapitulo` INT NOT NULL AUTO_INCREMENT,
  `TituloCapitulo` VARCHAR(45) NOT NULL,
  `VideoCapitulo` LONGBLOB DEFAULT NULL,
  `Descripcion` VARCHAR(45) NOT NULL,
  `FechaRegCap` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `Curso` INT NOT NULL,
  `Gratis` TINYINT DEFAULT 0,
  
  PRIMARY KEY (`IdCapitulo`),
  
  INDEX `Curso_index` (`Curso`),
  CONSTRAINT `CursoCap`
    FOREIGN KEY (`Curso`)
    REFERENCES `Curso` (`idCurso`)
    
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Tabla de CursosComprados (donde se guardaran los cursos comprados de los usuarios)
CREATE TABLE IF NOT EXISTS `CursoComprado` (
  `IdCursoComprado` INT NOT NULL AUTO_INCREMENT,
  `FechaCompra` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `FechaUltimoIngreso` TIMESTAMP,
  `IdCurso` INT NOT NULL,
  `IdUser` INT NOT NULL,
  `Estado_Completado` TINYINT DEFAULT 0,
  `Comprado_Completo` TINYINT DEFAULT 0,
  `Calificacion` TINYINT DEFAULT -1,
  `FechaCompletado` TIMESTAMP NULL,
  `PrecioPagado` DECIMAL(10,2) NOT NULL,
  `FormaPago` TINYINT DEFAULT 0,
  
  PRIMARY KEY (`IdCursoComprado`),
  
  INDEX `Capitulo_index` (`IdCurso`),
  CONSTRAINT `CursoCompra`
    FOREIGN KEY (`IdCurso`)
    REFERENCES `Curso` (`idCurso`),
    
  INDEX `User_index` (`IdUser`),
  CONSTRAINT `User`
    FOREIGN KEY (`IdUser`)
    REFERENCES `Usuario` (`idUsuario`)
    
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Tabla de CapitulosCompletados (donde se guardaran los capitulos completados de los cursos)
CREATE TABLE IF NOT EXISTS `cursosOnline`.`CapituloCompletado` (
  `IdCapituloCompletado` INT NOT NULL AUTO_INCREMENT,
  `FechaRegCompl` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `IdCapitulo` INT NOT NULL,
  `IdCursoComprado` INT NOT NULL,
  `Estado_Completado` TINYINT NOT NULL,
  
  PRIMARY KEY (`IdCapituloCompletado`),
  
  INDEX `Capitulo_index` (`IdCapitulo`),
  CONSTRAINT `CapCom`
    FOREIGN KEY (`IdCapitulo`)
    REFERENCES `cursosOnline`.`Capitulo` (`IdCapitulo`),
    
  INDEX `Curso_index` (`IdCursoComprado`),
  CONSTRAINT `Curso`
    FOREIGN KEY (`IdCursoComprado`)
    REFERENCES `cursosOnline`.`CursoComprado` (`IdCursoComprado`)
    
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
