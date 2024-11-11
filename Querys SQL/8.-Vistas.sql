CREATE VIEW diploma AS
SELECT cc. IdCursoComprado, cast(cc.FechaCompletado as Date) as Fecha, cc.Estado_Completado, c.Titulo_Curso, CONCAT(e.Nombre_Usuario, " ", e.Apellido_Paterno_Usuario, " ", e.Apellido_Materno_Usuario) NombreEstudiante, 
	CONCAT(p.Nombre_Usuario, " ", p.Apellido_Paterno_Usuario, " ", p.Apellido_Materno_Usuario) NombreProfesor, "GAMMA YPSILION" NombreDirector FROM CursoComprado cc INNER JOIN Curso c ON c.idCurso = cc.IdCurso 
	INNER JOIN Usuario e ON cc.IdUser = e.idUsuario INNER JOIN Usuario p ON c.Creador_Curso = p.idUsuario;


CREATE VIEW capitulo_curso AS
SELECT * FROM Capitulo INNER JOIN curso ON Capitulo.Curso = curso.idCurso;


CREATE VIEW cursos_estudiante AS
SELECT curso.idCurso, curso.Titulo_Curso, curso.ImagenCurso, CursoComprado.IdUser, CursoComprado.Estado_Completado FROM curso INNER JOIN CursoComprado ON curso.idCurso = CursoComprado.IdCurso;


CREATE VIEW comentario_cursos AS
SELECT c.idCalificacion, c.Nombre_calificacion, c.Comentario, c.Usuario_calificador, c.Curso_Calificado, 
c.Fecha_Calificacion, c.Estado_Calificacion, u.Username FROM calificacion c INNER JOIN usuario u ON c.Usuario_calificador = u.idUsuario;


CREATE VIEW select_categorias AS
select c.idCurso, cat.idCategoria, cat.Nombre_categoria from curso c INNER JOIN CategoriaCurso cc ON c.idCurso = cc.idCurso
INNER JOIN categoria cat ON cat.idCategoria = cc. idCategoria;


CREATE VIEW reporte_cursos AS
SELECT C.idCurso, C.Titulo_Curso, cast(C.Fecha_Registro_Curso as Date) as Fecha, C.Fecha_Registro_Curso, C.EstadoCurso, C.Creador_Curso, NivelPromedioCursado(C.idCurso) AS NivelCursado, FORMAT(C.Precio_Curso, 2) AS Precio_Curso, CAT.idCategoria, CAT.Nombre_categoria,  
(SELECT COUNT(*) FROM CursoComprado CC WHERE CC.IdCurso = C.idCurso) AS Alumnos_Inscritos, (SELECT FORMAT(IngresosCurso(C.idCurso, 1), 2)) AS IngresosPAYPAL, (SELECT FORMAT(IngresosCurso(C.idCurso, 2), 2)) AS IngresosEFECTIVO, (SELECT FORMAT(IngresosCurso(C.idCurso, 0), 2)) AS Ingresos FROM curso C
INNER JOIN CategoriaCurso CAC ON CAC.idCurso = C.idCurso INNER JOIN Categoria CAT ON CAT.idCategoria = CAC.idCategoria
GROUP BY C.idCurso, CAT.idCategoria;


CREATE VIEW reporte_cursos2 AS
SELECT C.idCurso, CC.IdCursoComprado AS idCursoComprado, C.Titulo_Curso, C.Fecha_Registro_Curso, C.EstadoCurso, NivelCursado(CC.IdCursoComprado) AS NivelCursado, C.Creador_Curso, date_format(cast(CC.FechaCompra as Date), "%d-%b-%Y") as Fecha, (cast(CC.FechaCompra as Date)) AS Fecha1,
CC.FechaCompra, FORMAT(CC.PrecioPagado, 2) AS PrecioPagado, CC.FormaPago, U.Username, U.Nombre_Usuario, U.Apellido_Paterno_Usuario, U.Apellido_Materno_Usuario, CAT.idCategoria, CAT.Nombre_categoria 
FROM curso C INNER JOIN CursoComprado CC ON C.idCurso = CC.idCurso 
INNER JOIN CategoriaCurso CAC ON CAC.idCurso = C.idCurso INNER JOIN Categoria CAT ON CAT.idCategoria = CAC.idCategoria
INNER JOIN usuario U ON CC.IdUser = U.idUsuario
ORDER BY CC.idCurso;


CREATE VIEW filtros_cursos AS
SELECT c.idCurso, c.Titulo_Curso, c.Descripcion_Curso, c.GradoCurso, cast(c.Fecha_Registro_Curso as Date) as Fecha, c.Fecha_Registro_Curso, c.EstadoCurso, c.Precio_Curso, 
c.Creador_Curso, c.ImagenCurso, CAT.idCategoria AS Categoria, CAT.Nombre_categoria, u.idUsuario, u.Username, 
(SELECT COUNT(*) FROM CursoComprado WHERE Comprado_Completo =1 AND IdCurso = c. idCurso)AS Vendidos, (SELECT SUM(Calificacion) FROM CursoComprado 
WHERE Calificacion =1 AND IdCurso = c. idCurso) AS Calificados FROM curso c INNER JOIN CategoriaCurso CC ON c.idCurso = CC.idCurso 
INNER JOIN Categoria CAT ON CAT.idCategoria = CC.idCategoria INNER JOIN Usuario u ON u.idUsuario = c.Creador_Curso
ORDER BY c.idCurso;



CREATE VIEW kardex AS
SELECT C.idCurso, CC.IdCursoComprado, CC.IdUser, C.Titulo_Curso, cast(CC.FechaCompra as Date) as FechaCompra, NivelCursado(CC.IdCursoComprado) AS NivelCursado, C.EstadoCurso, 
CC.Estado_Completado, cast(CC.FechaCompletado as Date) as FechaCompletado, cast(CC.FechaUltimoIngreso as Date) as FechaUltimoIngreso, CAT.idCategoria, CAT.Nombre_categoria FROM Curso C 
INNER JOIN CursoComprado CC ON C.idCurso = CC.IdCurso INNER JOIN CategoriaCurso CATC ON c.idCurso = CATC.idCurso
INNER JOIN Categoria CAT ON CAT.idCategoria = CATC.idCategoria;


CREATE VIEW adminUsuarios AS
select U.idUsuario, U.Username, U. Nombre_Usuario, U.Apellido_Paterno_Usuario, U.Apellido_Materno_Usuario, 
U.Correo_Usuario, U.Contrasenia_Usuario, U.Fecha_Nacimiento, U.Fecha_Registro, (cast(U.Fecha_Registro as Date)) AS Fecha1, U.Estado_Usuario, U.Intentos_Fallidos, R.idRol, R.Nombre_Rol, G.idGenero, G.Nombre_Genero
from usuario U INNER JOIN Rol R ON U.Rol_User = R.idRol INNER JOIN Genero G ON U.Genero = G.idGenero
ORDER BY U.idUsuario;


CREATE VIEW admincomentario AS
SELECT c.idCalificacion, c.Nombre_calificacion, c.Comentario, c.Usuario_calificador, u.Username, c.Curso_Calificado, CU.Titulo_Curso,
c.Fecha_Calificacion, (cast(c.Fecha_Calificacion as Date)) AS Fecha1, c.Estado_Calificacion FROM calificacion c INNER JOIN usuario u ON c.Usuario_calificador = u.idUsuario
INNER JOIN Curso CU ON c.Curso_Calificado = CU.idCurso
ORDER BY c.idCalificacion;

