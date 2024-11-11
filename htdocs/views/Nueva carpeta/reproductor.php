<?php
include ("../API/conexion.php");  
include ("../Middleware/middlewareVideo.php");

$valorModificado = $_GET['QueryCapitulo'];
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
                        <a href="/views/chapterList.php">
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
                            


                        





                                    <h1 class="c-title">Curso de: <br> Capitulo: </h1>
                                    <video width="1280" height="720" controls>
                                        <source src="https://www.youtube.com/watch?v=J6qIzKxmW8Y&ab_channel=GrissiniProject" type="video/">
                                        Tu explorador no soporta video
                                    </video>










<?php
   echo  $valorModificado;
?>

                    </div>
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