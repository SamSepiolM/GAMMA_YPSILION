<?php

	include_once '../conexion.php';

	class consultaCursos extends Conexion{

		function getCursos($id){
			//$query = $this->connect()->call("SELECT * FROM Usuario WHERE idUsuario =  '$id'  ");

			//return $query;
			$estado = 1;

			$sql = 'SELECT * FROM Curso WHERE EstadoCurso = ?';
			$stmt = $this->connect()->prepare($sql);

			$stmt->bindParam(1, $estado, PDO::PARAM_INT, 10);

			$stmt->execute();

			return $stmt;

		}

	}
?>