<?php
	include ("../API/conexion.php");

	$conn=mysqli_connect("localhost","root", "","cursosonline");
	$por_pagina = 100;

	if(isset($_GET['pagina']))
	$pagina=$_GET['pagina'];

	else{
		$pagina=1;
	}
	$empieza=($pagina-1) * $por_pagina;
	$query="SELECT * FROM categoria LIMIT $empieza,$por_pagina";
	$resultado12=mysqli_query($conn,$query);


	$query = "SELECT * FROM categoria WHERE EstadoCategoria = 1";
	$resultado12 = mysqli_query($conn, $query);

    $total_registros=mysqli_num_rows($resultado12);
    $total_paginas=ceil($total_registros/$por_pagina);
?>