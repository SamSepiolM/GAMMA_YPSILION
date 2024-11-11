<?php
session_start();
    if(isset($_SESSION["AUTH"])) {
        //asignar a variable
        $usernameSesion = $_SESSION["AUTH"];
        $rolSesion = $_SESSION["ROL"];
        //asegurar que no tenga "", <, > o &
        $username = htmlspecialchars($usernameSesion);
        $rol = htmlspecialchars($rolSesion);
    } else {
        header("Location: home.php");
    }
?>

<?php
    include ("../API/conexion.php");
    $conn=mysqli_connect("localhost","root", "","cursosonline");

    if(isset($_FILES['foto']['name'])){
        if($_FILES['foto']['name'] != ''){
            $tipoArchivo  = $_FILES['foto']['type'];
            $nombreArchivo  = $_FILES['foto']['name'];
            $tamanoArchivo  = $_FILES['foto']['size'];
            $imagenSubida=fopen($_FILES["foto"]["tmp_name"] , 'r+');
            $binariosImagen=fread($imagenSubida, $tamanoArchivo);
            $binariosImagen=mysqli_escape_string($conn, $binariosImagen);

            $query = "UPDATE Usuario SET Foto_Perfil = '$binariosImagen' WHERE idUsuario = $username ";
	        $resultado = mysqli_query($conn, $query);

            echo '<script language="javascript">alert("Se actualizo la imagen");
                    window.location.href="/views/home.php"</script>';
        }
        
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link href="/assets/css/estiloEditar.css" rel="stylesheet" type="text/css"/>
</head>

<body> 
    <div class="row justify-content-center align-content-center text-center">
      <div class="Conteiner_Register">
        <h3> Edita tus datos de usuario </h3>
            <form method="post" action="../API/api.php" class="buscaUsuario">
                <input type="hidden" value="<?php echo $username; ?>" id="idUsuario">
                <input type="hidden" value="<?php echo $rol; ?>" id="rol">
                <input type="hidden" name="submit" id="submit">
            </form>

            <form action="" id="Register" name="Register" method="post" class="was-validated">

                
                <label>Nombre(s)</label> 
                <input type="text" placeholder="Nombre(s)" required maxlength="20" id="NombreEditar" name="NombreEditar"> 
                <label>Apellido Paterno</label> 
                <input type="text" placeholder="Apellido Paterno" required maxlength="30" id="ApellidoPEditar" name="ApellidoR">
                <label>Apellido Materno</label> 
                <input type="text" placeholder="Apellido Materno" required maxlength="30" id="ApellidoMEditar" name="ApellidoR">
                <label>Correo electronico</label> 
                <input type="email" placeholder="Correo electronico" required maxlength="35" id="CorreoEditar" name="ApellidoEditar">
                <label>Nombre de usuario</label> 
                <input type="text" placeholder="Nombre de usuario" maxlength="20"id="userEditar" name="userEditar">
                <label>Contraseña</label> 
                <input type="password" placeholder="Contrasena"  maxlength="12" minlength="8" required id="ContrasenaEditar" name="ContrasenaEditar">
                <label>Genero</label> 
                <select id="Genero">
                    <option value=1>Femenino</option>
                    <option value=2>Masculino</option>
                </select>
                <label>Fecha de Nacimiento</label> 
                <input type="date" max="1980-12-31" value="2022-01-01" name="fechaNacimiento" id="fechaNacimiento" requiered>

                <button type="submit" class="btn btn-primary" onclick="validacion()">Guardar cambios</button>
            </form>

            <br>

            <form id="Register" name="Register" class="was-validated" enctype="multipart/form-data" action="editUser.php" method="post">
                <h6 class="colorNombre">Imagen de perfil </h6>
                <input type="file" accept="image/*" name="foto" id="foto">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
            <a href="/views/home.php"><button class="Cancelar">Regresar</button></a>
      </div>  
    </div> 
    <script src="../jquery-3.6.1.min.js"></script>
    <script src="/assets/js/validacionEditar.js"></script>

</body>

</html>
