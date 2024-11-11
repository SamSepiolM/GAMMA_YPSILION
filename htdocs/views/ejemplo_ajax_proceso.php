<?php 
//$resultado = $_POST['nombre'] . $_POST['categoria']; 
$mensaje= "Hola usted esta buscando un curso con las caracteristicas de Nombre: " . $_POST['nombre'] . ", Categoria: "
. $_POST['categoria'] . ", Con una fecha de: " . $_POST['fecha'] . ", Y con un top de: " . $_POST['top'];
$resultado = $mensaje; 
echo $resultado;
?>