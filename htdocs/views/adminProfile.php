<?php
session_start();
    if(isset($_SESSION["AUTH"])) {
        $rolSesion = $_SESSION["ROL"];
        if($rolSesion != 3){
            header("Location: home.php");
        }
        else{
        //asignar a variable
        $usernameSesion = $_SESSION["AUTH"];
        
        //asegurar que no tenga "", <, > o &
        $username = htmlspecialchars($usernameSesion);
        $rol = htmlspecialchars($rolSesion);
        }
    } else {
        header("Location: home.php");
    }
?>

<?php
    include ("../API/conexion.php");

	$conn=mysqli_connect("localhost","root", "","cursosonline");
    $query = "SELECT * FROM usuario WHERE idUsuario = $username";
	$resultadoUser = mysqli_query($conn, $query);
    $filaUser=mysqli_fetch_assoc($resultadoUser);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="shortcut icon" href="/assets/Imagenes/Logotipo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/estiloAdmin.css">
</head>

<body>

    <header>
	    <div class="interior">
            <a class="logo" target="blank"><img src="/assets/Imagenes/Logotipo.png" alt="Logo"></a>
            <nav class="navegacion">
                <ul>
                    <!--<li><a target="blank">Inicio</a></li>-->
                    <li class="submenu">
                      <a href="/views/categorieCRUD.php" id="EditarCategorias">Categorias</a>
                    </li>

                    <li class="submenu">
                      <a href="/views/adminComentarios.php" id="VerComentarios">Comentarios</a>
                    </li>

                    <li class="submenu">
                      <a href="/views/adminUsuarios.php" id="EditarUsuarios">Usuarios</a>
                    </li>

                    <li>
                        <a href="Reportes.php" id="Reportes">Reportes</a>
                    </li>

                    <li>
                        <a href="/controllers/logout.php" id="CerrarSession">Cerrar Sesion</a>
                    </li>
                  </ul>
            </nav>
        </div>
        <div class="head">
        </div>
    </header>


    <div class="cabecera">
        <form method="post" action="../API/api.php" class="buscaUsuario">
            <!-- ID: <input type="text" name="id" id="idEstudiante"> -->
            <!-- <input type="text" value="<%= Session["AUTH"].ToString() %>" id="mivariable"-->
            <input type="hidden" value="<?php echo $username; ?>" id="idUsuario">
            <input type="hidden" value="<?php echo $rol; ?>" id="rol">
            <input type="hidden" name="submit" id="submit">
                
        </form>

        <img class="avatar" src="data:image;base64,<?php echo base64_encode($filaUser['Foto_Perfil'] ) ?>">
        <h1 class="colorNombre" id="NickName">(Nombre de administrador)</h1>
    </div>
    <br>
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
    </div>


    <main class="main col">
        <div class="row justify-content-center align-content-center text-center">
            <br><br><br>
        </div>

        <div class="paage"></div>

    </main>
    

    <footer>
        <div class="footer-bottom">
            <p> ©TODOS LOS DERECHOS RESERVADOS 2023 Creado por <span>Luis Jaime Mier Rodriguez y Pedro Gonzalez Martel</span></p>
        </div>
    </footer>


    <script src="../jquery-3.6.1.min.js"></script>
    <script src="/assets/js/admin.js"></script>
    <script src="/assets/js/profile.js"></script>
</body>

</html>
