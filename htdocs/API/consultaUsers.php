<?php

	include_once 'conexion.php';

	class consultaUsers extends Conexion{

		function getUsers($id){
			//$query = $this->connect()->call("SELECT * FROM Usuario WHERE idUsuario =  '$id'  ");

			//return $query;

			$sql = 'CALL SP_MostrarUsuario(?)';
			$stmt = $this->connect()->prepare($sql);

			$stmt->bindParam(1, $id, PDO::PARAM_INT, 10);

			$stmt->execute();

			return $stmt;

		}

	}
?>