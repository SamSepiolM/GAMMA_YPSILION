<?php
session_start();
    if(isset($_SESSION["AUTH"])) {
        //require_once "./views/home.php";
        //header("Location: ./diploma.php");
        //console.log($_SESSION["AUTH"]);

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
        //include_once "./views/login-signup.php";
        //require_once "./home.php";
        header("Location: home.php");
    }



    include ("../API/conexion.php");

	$conn=mysqli_connect("localhost","root", "","cursosonline");
    $query = "SELECT * FROM cursos_estudiante WHERE IdUser = $username AND Estado_Completado = 0";
	$resultado = mysqli_query($conn, $query);

    $query = "SELECT * FROM cursos_estudiante WHERE IdUser = $username AND Estado_Completado = 1";
	$resultado1 = mysqli_query($conn, $query);

    $query = "SELECT * FROM usuario WHERE idUsuario = $username";
	$resultadoUser = mysqli_query($conn, $query);
    $filaUser=mysqli_fetch_assoc($resultadoUser);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil Estudiante</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/estiloEstudian.css">

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

              <a href="/views/kardex.php"><button class="button-kardex" id="kardex">          
                <span class="kardex-icon">✓</span> <span>Kardex</span>
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
                            <h3 class="section-title">Cursos Pendientes por cuncluir:</h3>
                        </header>   
                    </section>  
                    <div class="grid episodios">

                        <?php 
                            while($fila=mysqli_fetch_assoc($resultado))
                            {
                        ?>
                            <article class="cursos episodios">
                            <div class="h-thumb">
                            <figure><img src="data:image;base64,<?php echo base64_encode($fila['ImagenCurso'] ) ?>"></figure>
                            </div>
                            <header class="h-header">
                            <span class="num-episodios">Curso <?php echo $fila['idCurso']  ?></span>
                            <h2 class="h-title"><?php echo $fila['Titulo_Curso']  ?></h2>
                            </header>
                            <a href="/views/chapterList.php?idCurso=<?php echo $fila['idCurso']?>" class="lnk-blk fa-play-circle"><span aria-hidden="true" hidden="">Ver ahora</span></a>
                        </article>
                        <?php 
                            }      
                        ?>
    
                        
                    </div> 
                    
                    <section class="section cursos">
                        <header class="section-header">
                            <h3 class="section-title">Cursos Online que cuncluiste:</h3>
                        </header>   
                    </section>  
                    <div class="grid episodios">
    
                    <?php 
                            while($fila=mysqli_fetch_assoc($resultado1))
                            {
                        ?>
                            <article class="cursos episodios">
                            <div class="h-thumb">
                            <figure><img src="data:image;base64,<?php echo base64_encode($fila['ImagenCurso'] ) ?>"></figure>
                            </div>
                            <header class="h-header">
                            <span class="num-episodios">Curso <?php echo $fila['idCurso']  ?></span>
                            <h2 class="h-title"><?php echo $fila['Titulo_Curso']  ?></h2>
                            </header>
                            <a href="/views/chapterList.php?idCurso=<?php echo $fila['idCurso']?>" class="lnk-blk fa-play-circle"><span aria-hidden="true" hidden="">Ver ahora</span></a>
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
        <script src="/assets/js/profile.js"></script>

    </body>
</html>