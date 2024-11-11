<?php
session_start();
    if(isset($_SESSION["AUTH"])) {
        header("Location: home.php");
    } 
?>


<?php
    $idUser=0;

    if(isset($_GET['idUsuario'])){
        $idUser = $_GET['idUsuario'];
    }

    if(isset($_FILES['foto']['name'])){
        if($_FILES['foto']['name'] != ''){
            $tipoArchivo  = $_FILES['foto']['type'];
            $nombreArchivo  = $_FILES['foto']['name'];
            $tamanoArchivo  = $_FILES['foto']['size'];
            $imagenSubida=fopen($_FILES["foto"]["tmp_name"] , 'r+');
            $binariosImagen=fread($imagenSubida, $tamanoArchivo);
            $binariosImagen=mysqli_escape_string($conn, $binariosImagen);

            $query = "UPDATE Usuario SET Foto_Perfil = '$binariosImagen' WHERE idUsuario = $idUser ";
	        $resultado = mysqli_query($conn, $query);

            echo '<script language="javascript">alert("Se actualizo la imagen");
                    window.location.href="/views/home.php"</script>';
        }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/estilos.css">
</head>
<body>

    <main>
        <div class="contenedor__todo">

            <div class="caja__trasera">

                <div class="caja__trasera-login">
                    <h3>Ya tienes una cuenta? Logeate!</h3>
                    <p>Inicia Sesion para entrar</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>

                <div class="caja__trasera-register">
                    <h3>No tienes una cuenta? Registrate gratis ahora!</h3>
                    <p>Registrate</p>
                    <button id="btn__registrarse">Registrarse</button>
                </div>

            </div>

            <div class="contenedor__login-register">

                <form action="" class="formulario__login" method="post" id="LoginUsuario" name="LoginUsuario">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" required placeholder="Nombre de usuario" name="LogUsuario" id="LogUsuario">
                    <input type="password" required placeholder="Contraseña" name="LogContrasena" id="LogContrasena">
                    <button type="submit" class="btn btn-primary" onclick="validacionLogin()">Iniciar sesion</button>
                </form>
     
                <?php if($idUser == 0) {   ?>
                <form action="" class="formulario__register" method="post" id="RegistroUsuario" name="RegistroUsuario">
                    <h2>Registrarse</h2>
                    <input type="text" required placeholder="Nombre de Usuario Ej. AzuMizu47" name="RegUsuario" id="RegUsuario">
                    <input type="text" required placeholder="Nombres Ej. Alexis Alejandro" name="RegNombre" id="RegNombre">
                    <input type="text" required placeholder="Apellido Paterno Ej. Perez" name="RegApellido" id="RegApellido">
                    <input type="text" required placeholder="Apellido Materno Ej. Mendoza" name="RegApellidoM" id="RegApellidoM">
                    <input type="text" required placeholder="Correo Electronico Ej. example@mail.com" name="RegCorreo" id="RegCorreo">
                    <input type="password" required placeholder="Contraseña min. 8 caracteres, una letra mayuscula y otra minuscula" name="RegContrasena" id="RegContrasena">
                    <select id="Rol">
                        <option value=1>Estudiante</option>
                        <option value=2>Profesor</option>
                    </select>

                    <select id="Genero">
                        <option value=1>Femenino</option>
                        <option value=2>Masculino</option>
                    </select>
                    <input type="date" max="1980-12-31" value="2022-01-01" name="fechaNacimiento" id="fechaNacimiento" requiered>

                    <button type="submit" class="btn btn-primary" onclick="validacionRegistro()">Registrate ahora</button>
                </form>
                <?php   }   ?>

                <?php if($idUser != 0) {   ?>

                <form action="" class="formulario__register" method="post" id="RegistroUsuario" name="RegistroUsuario">
                    <h2>Selecciona tu imagen</h2>

                    <input type="file" name="foto" id="foto">
                    <button type="submit" class="btn btn-primary" >Subir imagen</button>
                </form>
                <?php   }   ?>
            </div>
        </div>
    </main>
    <script src="../jquery-3.6.1.min.js"></script>
    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/validacion.js"></script>
</body>
</html>