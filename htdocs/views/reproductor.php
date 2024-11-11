<?php
include ("../API/conexion.php");  
include ("../Middleware/middlewareVideo.php");

//$valorModificado = $_GET['QueryCapitulo'];
?>

<?php

session_start();
    if(isset($_SESSION["AUTH"])) {
        $rolSesion = $_SESSION["ROL"];
        if($rolSesion != 2){
            //header("Location: home.php");
        }
        //asignar a variable
        $usernameSesion = $_SESSION["AUTH"];
        //asegurar que no tenga "", <, > o &
        $username = htmlspecialchars($usernameSesion);
        $rol = htmlspecialchars($rolSesion);
    } else {
        header("Location: home.php");
    }



    $conn=mysqli_connect("localhost","root", "","cursosonline");

    $visto = 0;
    $idCurso = $_GET['idCurso'];
    $idCursoComprado = $_GET['IdCursoComprado'];
    $idCapitulo = $_GET['IdCapitulo'];
    if(isset($_POST['Visto'])){
        $visto= $_POST['Visto'];

        foreach($_POST['Visto'] as $selected){
            $visto = $selected;
        }
    }
    else{
        
        $query = "SELECT * FROM CapituloCompletado WHERE IdCapitulo = $idCapitulo AND IdCursoComprado = $idCursoComprado";
	    $resultadoCapitulo = mysqli_query($conn, $query);
        $filaCapitulo12=mysqli_fetch_assoc($resultadoCapitulo);

        if($filaCapitulo12){
            $visto = 1;
        }
    }

    

    //echo '<script language="javascript">console.log("$visto");   </script>';

	
    $query = "UPDATE CursoComprado SET FechaUltimoIngreso = NOW() WHERE IdCursoComprado = $idCursoComprado";
	$resultado = mysqli_query($conn, $query);

    $query = "SELECT * FROM Curso WHERE idCurso = $idCurso";
	$resultadoCurso = mysqli_query($conn, $query);
    $filaCurso=mysqli_fetch_assoc($resultadoCurso);

    $query = "SELECT * FROM Capitulo WHERE IdCapitulo = $idCapitulo";
	$resultadoCapitulo = mysqli_query($conn, $query);
    $filaCapitulo=mysqli_fetch_assoc($resultadoCapitulo);


    if ($visto == 'on'){
        $query = "SELECT * FROM CapituloCompletado WHERE IdCapitulo = $idCapitulo AND IdCursoComprado = $idCursoComprado";
	    $resultadoCapitulo = mysqli_query($conn, $query);
        $filaCapitulo1=mysqli_fetch_assoc($resultadoCapitulo);

        if($filaCapitulo1){
            $query = "UPDATE CapituloCompletado SET Estado_Completado = 1 WHERE IdCapitulo = $idCapitulo AND IdCursoComprado = $idCursoComprado";
            $resultado1 = mysqli_query($conn, $query);
        }
        else{
            $query = "INSERT INTO CapituloCompletado (IdCapitulo, IdCursoComprado, Estado_Completado) VALUES($idCapitulo, $idCursoComprado, 1 )";
            $resultado1 = mysqli_query($conn, $query);
        }
        
    } 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reproductor</title>
        <link rel="shortcut icon" href="../assets/Imagenes/Logotipo.png">
        <link rel="stylesheet" href="/assets/css/videoStyle.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">


    </head>

<body>
    <header>
        <div>
            <div class="row">
                <div class="col-8 barra">
                       <img src="/assets/Imagenes/Logotipo.png">
                </div>

                <div class="col-4 text-right barra">
                    <div class="buttons-user">
                        <a href="/views/chapterList.php?idCurso=<?php echo $idCurso?>">
                        <button class="user-button">Volver a la lista</button>
                        </a>
                        <a href="/views/home.php">
                            <button class="logout-button">Explorar cursos</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

        <main class="main col">
            <div class="row justify-content-center align-content-center text-center">
                <div class="columna col-lg-6">
                        <div class="row justify-content-center">

                            <?php
                                $middleware = new middlewareVideo();
                                $var = $filaCapitulo['IdCapitulo'];


                                $datosCapitulo = $middleware->validarVideo2($var);
                                        
                            ?>


                            <div class="description-area">
                            <h4 >Curso de: <?php echo ($filaCurso['Titulo_Curso'] )?>   <br> Capitulo: <?php echo ($datosCapitulo['TituloCapitulo'] )?> </h4>

                            </div>
                            <video width="1280" height="720" controls>
                                <source src="data:video/mp4;base64,<?php echo base64_encode($datosCapitulo['VideoCapitulo'] ) ?>" type="video/mp4">
                                    Tu explorador no soporta video
                            </video>

                            <input type="hidden" class="line-area" placeholder="Ingresa el titulo" id="titulo" name="titulo" value=<?php
                            echo $visto
                            ?>  ></input>


                    </div>
                    <br>
                    <div class="description-area">
                        <h4>Descripcion del curso </h4>
                        <div class="comment-container"> 
                            <p> <?php echo $datosCapitulo['Descripcion'] ?> </p>
                        </div>
                    </div>
                    <br>
                    <?php
                        if($visto == 0 && $idCursoComprado != 0) {   ?>
                    
                    <form name="Registro1" id="Registro1" action="reproductor.php?idCurso=<?php echo $idCurso?>&IdCursoComprado=<?php echo $idCursoComprado?>&IdCapitulo=<?php echo $idCapitulo?>" method="post">
                    <div class="video-area">
            
                        <div class="video-insert">El nivel fue completado?<br>
                        <input type="checkbox" name="Visto[]" id="Visto" /></div>
                    </div>
                            
                        <div class="button-container">
                        <button type="submit" class="button-upload-video">
                            <span class="video-icon">⇪</span> <span>Guardar</span>
                        </button>
                    </div>
                    </form>

                    <?php   }   ?>

                    
                
                </div>
            </div>
        </main> 

         <footer>
            <div class="footer-bottom">
                <p> ©TODOS LOS DERECHOS RESERVADOS 2023 Creado por <span>Luis Jaime Mier Rodriguez y Pedro Gonzalez Martel</span></p>
            </div>
        </footer>
</body>

</html>