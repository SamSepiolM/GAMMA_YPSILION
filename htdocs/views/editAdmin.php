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

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar usuario</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link href="/assets/css/editAdmin.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <div class="main-container">
            <h2>Menu para editar/eliminar usuario</h2>
            
            <form class="searcc-bar">
                <input type="text" placeholder="Buscar por Username" id="Username">
                <button type="submit"><img src="/assets/Imagenes/searchwithmagnifierincircularbutton_80266.png"></button>
            </form>
            <form class="searcc-bar">
                <input type="text" placeholder="Buscar por Id" id="IdBuscar">
                <button type="submit"><img src="/assets/Imagenes/searchwithmagnifierincircularbutton_80266.png"></button>
            </form>

            <form  method="post" name="EditarUsuario" id="EditarUsuario">

                <div class="title-area">
                    <label>Correo electronico</label> 
                    <input type="email" class="line-area" placeholder="Ingresa el Correo electronico" id="Correo" name="Correo"></input>
                </div>
                <div class="title-area">
                    <label>  Username  </label> 
                    <input class="line-area" placeholder="Ingresa el Nombre de Usuario" id="Usuario" name="Usuario"></input>
                </div>
                <div class="title-area">
                    <label>   Contraseña  </label> 
                    <input type="password" class="line-area" placeholder="Ingresa la Contraseña" id="Contrasenia" name="Contrasenia"></input>
                </div>

                <div class="title-area">
                    <label> Estado de usuario  </label> 
                    <select name="grade" id="grade" class="grade">
                        <option value= 1> Activo </option>
                        <option value= 0> Inactivo </option>
                    </select> 
                </div>

                <div class="button-container">
                    <button type="submit" class="button-update-user" onclick="validacion()">
                        <span class="user-icon">⇪</span> <span>Guardar cambios</span>
                    </button>
                    
                     <button class="button-delete-profile" id="eliminar">          
                            <span class="delete-icon">✘</span> <span>Borrar perfil</span>
                    </button>
                </div>

             
          

                
            </form>
            <div class="button-cancel-container">
                <a href="/views/adminProfile.php">
                    <button type="submit" class="button-cancel" id="subir">
                        <span>Cancelar</span>
                    </button>
                </a>
            </div>

            <h2>Menu para registrar administrador</h2>
            
            <form  method="post" name="RegistrarUsuario" id="RegistrarUsuario">


                <div class="title-area">
                    <label>Nombres de usuari@</label> 
                    <input class="line-area" placeholder="Ingresa los Nombres" id="NombreAdmin" name="NombreAdmin"></input>
                </div>
                <div class="title-area">
                    <label>  Apellido Paterno  </label> 
                    <input class="line-area" placeholder="Ingresa el Apellido Paterno" id="PaternoAdmin" name="PaternoAdmin"></input>
                </div>
                <div class="title-area">
                    <label>   Apellido Materno </label> 
                    <input class="line-area" placeholder="Ingresa el Apellido Materno" id="MaternoAdmin" name="MaternoAdmin"></input>
                </div>
                <div class="title-area">
                    <label>Correo electronico</label> 
                    <input type="email" class="line-area" placeholder="Ingresa el Correo electronico" id="CorreoAdmin" name="CorreoAdmin"></input>
                </div>
                <div class="title-area">
                    <label>  Username  </label> 
                    <input class="line-area" placeholder="Ingresa el Nombre de Usuario" id="UsuarioAdmin" name="UsuarioAdmin"></input>
                </div>
                <div class="title-area">
                    <label>   Contraseña  </label> 
                    <input type="password" class="line-area" placeholder="Ingresa la Contraseña" id="ContraseniaAdmin" name="ContraseniaAdmin"></input>
                </div>
                <div class="title-area">
                    <label> Genero del usuario  </label> 
                    <select name="gender" id="gender" class="grade">
                        <option value=1>Femenino</option>
                        <option value=2>Masculino</option>
                    </select> 
                </div><br>
                <div class="title-area">
                    <label>   Fecha de nacimiento  </label> 
                    <input type="date" max="2005-12-31" name="FechaAdmin" id="FechaAdmin" requiered>
                </div><br>

                <div class="title-area">
                    <label>   Foto de perfil  </label> 
                    <input type="file" name="imagenAdmin" id="imagenAdmin">
                </div>


                <div class="button-container">
                    <button type="submit" class="button-upload-usuario" onclick="validacionAdministrador()">
                        <span class="admin-icon">✓</span> <span>Registrar</span>
                    </button>
                </div>
            </form>
            <div class="button-cancel-container">
                <a href="/views/adminProfile.php">
                    <button type="submit" class="button-cancel" id="subir">
                        <span>Cancelar</span>
                    </button>
                </a>
            </div>
        </div>
            
    <script src="/assets/js/validarAdmin.js"></script>
    </body>
</html>