DELIMITER //
CREATE FUNCTION PorcentajeLikes(_idCurso INT, _Ilike INT) RETURNS DECIMAL(10,2) DETERMINISTIC
  BEGIN
    DECLARE elementosTotales DECIMAL(10,2);
    DECLARE elementos DECIMAL(10,2);
    SET @elementosTotales = (select count(Calificacion) as elementos from CursoComprado WHERE Calificacion != -1 AND idCurso= _idCurso);
    SET @elementos = (select count(*) as elementos from CursoComprado WHERE Calificacion = _Ilike AND idCurso= _idCurso);
    IF @elementosTotales = 0 THEN
      RETURN  0.00;
    ELSE
      RETURN  (@elementos/ @elementosTotales) * 100;
    END IF;
    
  END//
DELIMITER ;

DELIMITER //
CREATE FUNCTION IngresosCurso(_idCurso INT, _formaPago INT) RETURNS DECIMAL(10,2) DETERMINISTIC
  BEGIN
    DECLARE elementosTotales DECIMAL(10,2);
    DECLARE elementos DECIMAL(10,2);
    IF _formaPago = 0 THEN
		SET @elementosTotales = (SELECT SUM(PrecioPagado) AS Ingresos FROM CursoComprado WHERE IdCurso = _idCurso);
    ELSE
		SET @elementosTotales = (SELECT SUM(PrecioPagado) AS Ingresos FROM CursoComprado WHERE IdCurso = _idCurso AND FormaPago = _formaPago);
	END IF;
    
    IF @elementosTotales IS NULL THEN
      RETURN  0.00;
    ELSE
      RETURN  @elementosTotales;
    END IF;
    
  END//
DELIMITER ;


DELIMITER //
CREATE FUNCTION NivelCursado(_IdCursoComprado INT) RETURNS DECIMAL(10,2) DETERMINISTIC
  BEGIN
    DECLARE elementosTotales DECIMAL(10,2);
    DECLARE elementos DECIMAL(10,2);
	SET @elementos = (SELECT COUNT(*) AS Cursados FROM CapituloCompletado WHERE IdCursoComprado = _IdCursoComprado AND Estado_Completado = 1);
    SET @elementosTotales = (SELECT COUNT(*) AS Cursados FROM CursoComprado CC INNER JOIN Capitulo C ON CC.IdCurso = C.Curso WHERE CC.IdCursoComprado = _IdCursoComprado);
    IF @elementosTotales = 0 THEN
      RETURN  0.00;
    ELSE
      RETURN  (@elementos/ @elementosTotales) * 100;
    END IF;
    
  END//
DELIMITER ;

DELIMITER //
CREATE FUNCTION NivelPromedioCursado(_idCurso INT) RETURNS DECIMAL(10,2) DETERMINISTIC
  BEGIN
    DECLARE elementosTotales DECIMAL(10,2);
    DECLARE elementos DECIMAL(10,2);
    SET @elementos = (SELECT AVG(NivelCursado(CC.IdCursoComprado)) AS Cursados FROM CapituloCompletado CAPC INNER JOIN CursoComprado CC ON CAPC.IdCursoComprado = CC.IdCursoComprado WHERE CC.IdCurso = _idCurso AND CAPC.Estado_Completado = 1);
	-- SET @elementos = (SELECT COUNT(*) AS Cursados FROM CapituloCompletado CAPC INNER JOIN CursoComprado CC ON CAPC.IdCursoComprado = CC.IdCursoComprado WHERE CC.IdCurso = _idCurso AND CAPC.Estado_Completado = 1);
    -- SET @elementosTotales = (SELECT COUNT(*) AS Cursados FROM Capitulo WHERE Curso = _idCurso);
     IF @elementos IS NULL THEN
       RETURN  0.00;
     ELSE
       RETURN  @elementos;
     END IF;
    
  END//
DELIMITER ;

