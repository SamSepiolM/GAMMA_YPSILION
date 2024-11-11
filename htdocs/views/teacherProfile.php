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



    include ("../API/conexion.php");

	$conn=mysqli_connect("localhost","root", "","cursosonline");
    $query = "SELECT * FROM curso WHERE Creador_Curso = $username AND EstadoCurso = 1";
	$resultado = mysqli_query($conn, $query);

    $query = "SELECT * FROM usuario WHERE idUsuario = $username";
	$resultadoUser = mysqli_query($conn, $query);
    $filaUser=mysqli_fetch_assoc($resultadoUser);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil Maestro</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/perfilMaestro.css">

    </head>
    <body>
        <div class="cabecera">
            <form method="post" action="../API/api.php" class="buscaUsuario">
                <!-- ID: <input type="text" name="id" id="idEstudiante"> -->
                <!-- <input type="text" value="<%= Session["AUTH"].ToString() %>" id="mivariable"-->
                <input type="hidden" value="<?php echo $username; ?>" id="idUsuario">
                <input type="hidden" value="<?php echo $rol; ?>" id="rol">
                <input type="hidden" name="submit" id="submit">
                
            </form>

            <img class="avatar" src="data:image;base64,<?php echo base64_encode($filaUser['Foto_Perfil'] ) ?>">
            <h1 class="colorNombre" id="NickName">(Nombre de usuario)</h1>
        </div>
        
        <ul class="datosSociales">
            <li>
                <a href="">Facebook</a>
            </li>
            <li>
                <a href="">Whatsapp</a>
            </li>
            <li>
                <a href="">Instagram</a>
            </li>
        </ul>
        <ul class="datos">
            <li id="Nombre"> Nombre real </li>
            <li id="Fecha"> Fecha de Nacimiento </li>
        </ul>
        <div class="datosSociales">
            <h3 id="Descripcion">Descripcion</h3>
            <p id="Descripcion2">
                Ejemplo de descripcion
            </p>
             <a href="/views/editUser.php"><button class="button-edit-profile" id="editar">          
                <span class="profile-icon">⇪</span> <span>Editar perfil</span>
            </button>
            </a>
            <a href="/views/uploadCurse.php"><button class="button-upload-curse" id="subirCurso">
                <span class="curse-icon">■</span> <span>Crear curso</span>
            </button>
            </a>
            <a href="/views/uploadVideo.php"><button class="button-upload-video" id="subir">
                <span class="video-icon">⇪</span> <span>Subir video</span>
            </button>
            </a><br><br>
            <a href="/views/ChatMaestro.php"><button class="button-edit-profile" id="editar">          
                <span class="profile-icon">☺</span> <span>Revisar chat</span>
            </button>
            </a>

            <a href="/views/Reportes.php"><button class="button-report" id="reportes">          
                <span class="report-icon">®</span> <span>Reportes</span>
            </button>
            </a>
            <a href="/views/categorieCRUD.php"><button class="button-upload-curse" id="subircategoria">
                <span class="curse-icon">■</span> <span>Categorias</span>
            </button>
            </a>
            <a href=""><button class="button-delete-profile" id="eliminar">          
                <span class="delete-icon">✘</span> <span>Borrar perfil</span>
            </button>
            </a>
        </div>
        <main class="main col">
            <div class="row justify-content-center align-content-center text-center">
                <div class="columna col-lg-6">
                    <section class="section cursos">
                        <header class="section-header">
                            <h3 class="section-title">Selecciona un curso para mas opciones:</h3>
                        </header>   
                    </section>  
                    <div class="grid episodios" id="episodios">
    
                        <?php 
                            while($fila=mysqli_fetch_assoc($resultado))
                            {
                        ?>
                            <article class="cursos episodios">
                                <div class="h-thumb">
                                <figure><img src="data:image;base64,<?php echo base64_encode($fila['ImagenCurso'] ) ?>" ></figure>
                                </div>
                                <header class="h-header">
                                <span class="num-episodios">Curso <?php echo $fila['idCurso']  ?></span>
                                <br><h2 class="h-title"><?php echo $fila['Titulo_Curso']  ?>  </h2>
                                <br><h2 class="h-title"> $ <?php echo $fila['Precio_Curso']  ?></h2>
                                </header>
                                <a href="/views/editCurseUI.php?idCurso=<?php echo $fila['idCurso']?>" class="lnk-blk fa-play-circle">
                                <span aria-hidden="true" hidden="">Ver ahora</span></a>
                            </article>
                        <?php 
                            }      
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

        <script src="../jquery-3.6.1.min.js"></script>
        <!--<script src="/assets/js/cursosTeacher.js"></script> -->
        <script src="/assets/js/profile.js"></script>
        
    </body>
</html>