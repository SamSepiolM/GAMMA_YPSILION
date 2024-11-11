<?php

	include_once '../conexion.php';

	class consultaCursos extends Conexion{

		function getCursos($id){
			//$query = $this->connect()->call("SELECT * FROM Usuario WHERE idUsuario =  '$id'  ");

			//return $query;

			$sql = 'SELECT * FROM Curso WHERE Creador_Curso =  ?';
			$stmt = $this->connect()->prepare($sql);

			$stmt->bindParam(1, $id, PDO::PARAM_INT, 10);

			$stmt->execute();

			return $stmt;

		}

	}
?>