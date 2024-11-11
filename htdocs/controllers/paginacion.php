<?php
	include ("../API/conexion.php");

	$conn=mysqli_connect("localhost","root", "","cursosonline");
	$por_pagina = 9;

	if(isset($_GET['pagina']))
	$pagina=$_GET['pagina'];

	else{
		$pagina=1;
	}
	$empieza=($pagina-1) * $por_pagina;
	$query="SELECT * FROM curso WHERE EstadoCurso = 1 LIMIT $empieza,$por_pagina";
	$resultado=mysqli_query($conn,$query);


	$query = "SELECT * FROM curso WHERE EstadoCurso = 1";
	$resultado = mysqli_query($conn, $query);

    $total_registros=mysqli_num_rows($resultado);
    $total_paginas=ceil($total_registros/$por_pagina);
?>