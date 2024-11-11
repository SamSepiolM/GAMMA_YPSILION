<?php

	include_once 'consultaCursosHome.php';

	class cursos{

		function obtenerCursos()
		{

			$cursos = new consultaCursos();
			//$arrusuarios = array();
			$arrcursos["Resultados"] = array();

			$id = $_POST['id'];

			$res = $cursos->getCursos($id);

			if($res)
			{

				while($row = $res->fetch(PDO::FETCH_ASSOC))
				{
					$obj = array(
						"idCurso" => $row['idCurso'],
						"Titulo_Curso" => $row['Titulo_Curso'],
						"Descripcion_Curso" => $row['Descripcion_Curso'],
						"GradoCurso" => $row['GradoCurso'],
						"Fecha_Registro_Curso" => $row['Fecha_Registro_Curso'],
						"EstadoCurso" => $row['EstadoCurso'],
						"PrecioCurso" => $row['PrecioCurso'],
						"Creador_Curso" => $row['Creador_Curso'],
						"Categoria" => $row['Categoria']

					);
					array_push($arrcursos["Resultados"], $obj);
				}

				echo json_encode($arrcursos);

			}
			else
			{
				echo json_encode(array('mensaje' => 'No hay cursos con ese id'));
			}

		}

	}
	

	if(isset($_POST['submit']))
	{
		$var = new cursos();

		$var->obtenerCursos();
	}
	else
	{
		echo "Error q";
	}

?>