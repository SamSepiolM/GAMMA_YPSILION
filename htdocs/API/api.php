<?php

	include_once 'consultaUsers.php';

	class users{

		function obtenerUsuarios()
		{

			$usuarios = new consultaUsers();
			//$arrusuarios = array();
			$arrusuarios["Resultados"] = array();

			$id = $_POST['id'];

			$res = $usuarios->getUsers($id);

			if($res)
			{

				while($row = $res->fetch(PDO::FETCH_ASSOC))
				{
					$obj = array(
						"idUsuario" => $row['idUsuario'],
						"Nombre_Usuario" => $row['Nombre_Usuario'],
						"Apellido_Paterno_Usuario" => $row['Apellido_Paterno_Usuario'],
						"Apellido_Materno_Usuario" => $row['Apellido_Materno_Usuario'],
						"Correo_Usuario" => $row['Correo_Usuario'],
						"Contrasenia_Usuario" => $row['Contrasenia_Usuario'],
						"Username" => $row['Username'],
						"Estado_Usuario" => $row['Estado_Usuario'],
						"Rol_User" => $row['Rol_User'],
						"Genero" => $row['Genero'],
						"Fecha_Nacimiento" => $row['Fecha_Nacimiento']

					);
					array_push($arrusuarios["Resultados"], $obj);
				}

				echo json_encode($arrusuarios);

			}
			else
			{
				echo json_encode(array('mensaje' => 'No hay usuarios con ese id'));
			}

		}

	}
	

	if(isset($_POST['submit']))
	{
		$var = new users();

		$var->obtenerUsuarios();
	}
	else
	{
		echo "Error q";
	}

?>