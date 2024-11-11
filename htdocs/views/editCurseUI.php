<?php
    session_start();
    if(isset($_SESSION["AUTH"])) {
        $rolSesion = $_SESSION["ROL"];
        if($rolSesion != 2){
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
?>

<?php
    include ("../API/conexion.php");

    $idCurso = $_GET['idCurso'];

	$conn=mysqli_connect("localhost","root", "","cursosonline");
    $query = "SELECT * FROM curso WHERE idCurso = $idCurso AND EstadoCurso = 1 AND Creador_Curso= $username LIMIT 1";
	$resultado = mysqli_query($conn, $query);

    if(!$fila=mysqli_fetch_assoc($resultado)){
        header("Location: home.php");
    }

    $query = "SELECT * FROM Capitulo WHERE Curso = $idCurso";
	$resultadocapitulo = mysqli_query($conn, $query);

    $query = "SELECT ImagenCurso FROM Curso WHERE idCurso = $idCurso";
	$resultadoCurso = mysqli_query($conn, $query);
    $filaCurso=mysqli_fetch_assoc($resultadoCurso);
?>
        
<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link href="/assets/css/editCurseUI.css" rel="stylesheet" type="text/css"/>
    </head>
    
    <body>
        <header>
            <div>
                <div class="row">
                    <div class="col-8 barra">
                           <img src="/assets/Imagenes/Logotipo.png">
                    </div>
                </div>
            </div>
        </header>


        <main class="main col">
            <div class="row justify-content-center">
                <div class="columna col-lg-6">
                    <section class="section top"> 

                        <h3>Menu para editar cursos</h3>

                        <article class="cursos-single"> 
                            <header class="c-header"> 
                                <h1 class="c-title"><?php echo $fila['Titulo_Curso']  ?></h1> 

                            <a href="/views/editCurse.php?idCurso=<?php echo $fila['idCurso']?>"><button class="button-edit-profile" id="editar">          
                                <span class="curse-icon">■</span> <span>Editar curso</span>
                                </button>
                            </a>

                            <a href="/views/uploadVideo.php?idCurso=<?php echo $fila['idCurso']?>"><button class="button-edit-profile" id="editar">          
                                <span class="curse-icon">■</span> <span>Agregar capitulo</span>
                                </button>
                            </a>


                            </header> <div class="c-thumb"> 
                                <figure><img src="https://idital.com/wp-content/uploads/2021/03/Base-de-datos.png"></figure> 
                            </div> 

                        </article> 
                    </section> 
                    <div class="columns"> 
                        <section class="section"> 
                            <header class="section-header"> 
                                <h3 class="section-title">Seleccione el Capitulo que desea editar</h3> 
                            </header> 
                            <div class="capitulos-list"> 


                                <?php 
                                    while($fila1=mysqli_fetch_assoc($resultadocapitulo))
                                    {
                                ?>
                                <article class="cursos capitulo sm"> 
                                    <div class="c-thumb"> 
                                    
                                        <figure><img src="data:image;base64,<?php echo base64_encode($filaCurso['ImagenCurso'] ) ?>"></figure> 
                                    </div> 
                                    <header class="c-header"> 
                                        <h2 class="c-title"><?php echo $fila1['TituloCapitulo']?></h2> 
                                        <time><?php echo $fila1['FechaRegCap']?></time> 
                                    </header> 
                                    <a href="/views/editVideo.php?IdCapitulo=<?php echo $fila1['IdCapitulo']?>" class="lnk-blk fa-play">
                                        <span aria-hidden="true" hidden="">Ver ahora</span>
                                    </a> 
                                </article> 
                                <?php 
                                    }      
                                ?>
                                
                            </div> 
                        </section> 
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
