<?php
session_start();
    if(isset($_SESSION["AUTH"])) {
        $rolSesion = $_SESSION["ROL"];
        if($rolSesion != 1){
            header("Location: home.php");
        }
        //asignar a variable
        $usernameSesion = $_SESSION["AUTH"];
        //asegurar que no tenga "", <, > o &
        $username = htmlspecialchars($usernameSesion);
        $rol = htmlspecialchars($rolSesion);
    } else {
        header("Location: home.php");
    }

    $IdCursoComprado = $_GET['IdCursoComprado'];

    $conn=mysqli_connect("localhost","root", "","cursosonline");
    $querycom = "SELECT * FROM diploma WHERE IdCursoComprado = $IdCursoComprado && Estado_Completado = 1" ;
    $resultado = mysqli_query($conn, $querycom);

    if(!$fila=mysqli_fetch_assoc($resultado)){
      header("Location: home.php");
    }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Certificado</title>
    <link rel="shortcut icon" href="../assets/Imagenes/Logotipo.png">
    <link href="/assets/css/diplomaStyle.css" rel="stylesheet" type="text/css">
  </head>
  <body id="cuerpo">
    <div id="background">
			<div id="Background"><img src="/assets/Imagenes/images_Certificado/Background.png"></div>
			<div id="BG"><img src="/assets/Imagenes/images_Certificado/BG.png"></div>
			<div id="Capa1"><img src="/assets/Imagenes/images_Certificado/Capa1.png"></div>
			<div id="lines"><img src="/assets/Imagenes/images_Certificado/lines.png"></div>
			<div id="Elements2"><img src="/assets/Imagenes/images_Certificado/Elements2.png"></div>
			<div id="Elements"><img src="/assets/Imagenes/images_Certificado/Elements.png"></div>
			<div id="Shape24copy2"><img src="/assets/Imagenes/images_Certificado/Shape24copy2.png"></div>
			<div id="NOMBREDIRECTORDIRECT"><img src="/assets/Imagenes/images_Certificado/NOMBREDIRECTORDIRECT.png"></div>
			<div id="Shape24copy2_0"><img src="/assets/Imagenes/images_Certificado/Shape24copy2_0.png"></div>
			<div id="NOMBREPROFESORDOCENT"> <img src="/assets/Imagenes/images_Certificado/NOMBREPROFESORDOCENT.png"></div>

      <div id="NOMBREPROFESOR">
      <p style="font-size: 50px"><?php echo $fila['NombreProfesor']?></p></div>

      <div id="NOMBREDIRECTOR">
      <p style="font-size: 50px"><?php echo $fila['NombreDirector']?></p></div>

			<div id="Curso">  <!--<img src="/assets/Imagenes/images_Certificado/Curso.png">-->
      <p style="font-size: 110px"><?php echo $fila['Titulo_Curso']?></p></div>
			<div id="PORHABERCOMPLETADOSA"><img src="/assets/Imagenes/images_Certificado/PORHABERCOMPLETADOSA.png"></div>
			<div id="Nombre">  <!--<img src="/assets/Imagenes/images_Certificado/Nombre.png"> -->
      <p style="font-size: 200px"><?php echo $fila['NombreEstudiante']?></p></div>
			<div id="OTORGADOA"><img src="/assets/Imagenes/images_Certificado/OTORGADOA.png"></div>
			<div id="CertificadodeReconoc"><img src="/assets/Imagenes/images_Certificado/CertificadodeReconoc.png"></div>
			<div id="deReconocimiento"><img src="/assets/Imagenes/images_Certificado/deReconocimiento.png"></div>
      <div id="Shape24copy2_1"><img src="/assets/Imagenes/images_Certificado/Shape24copy2_0.png"></div>
			<div id="Fecha"><img src="/assets/Imagenes/images_Certificado/Fecha.png"></div>
      <div id="DATOS_FECHA">
      <p style="font-size: 60px"><?php echo $fila['Fecha']?></p></div>

      <button type="submit" class="btnImprimir" id="btnImprimir">Imprimir</button>
		</div>
    
    <script src="/assets/js/diploma.js"></script>
 </body>
 </html>