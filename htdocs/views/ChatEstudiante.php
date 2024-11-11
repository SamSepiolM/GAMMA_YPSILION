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
        header("Location: login-signup.php");
    }
?>
<?php

    include ("../API/conexion.php");
    $Emisor = $_GET['receptor_id'];

    $conn=mysqli_connect("localhost","root", "","cursosonline");

    $queryusuario = "SELECT * FROM Usuario WHERE idUsuario = $Emisor";
    $resultadousuario = mysqli_query($conn, $queryusuario); 

     $querymen = "SELECT M.Emisor, E.Username, M.Mensaje, M.Fecha_envio, M.Receptor, R.Username FROM Mensajes M INNER JOIN usuario E ON E.idUsuario = M.Emisor INNER JOIN usuario R ON R.idUsuario = M.Receptor WHERE (M.Emisor = $username AND M.Receptor = $Emisor) OR (M.Emisor = $Emisor AND M.Receptor = $username) ORDER BY Fecha_envio ASC";
    $resultadomen = mysqli_query($conn, $querymen);

     $query = "SELECT M.Emisor, M.Fecha_envio, E.Username FROM Mensajes M INNER JOIN usuario E ON E.idUsuario = M.Emisor WHERE (M.Emisor = $username AND M.Receptor = $Emisor) OR (M.Emisor = $Emisor AND M.Receptor = $username) ORDER BY Fecha_envio ASC";
    $resultadousu = mysqli_query($conn, $query); 

    $querycreador = "SELECT * FROM Usuario WHERE idUsuario = $Emisor";
    $resultadousuario = mysqli_query($conn, $queryusuario); 
?>



<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>chat</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link href="/assets/css/ChatStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    
    <body>
        <div class="wrapper">
          <section class="chat-area">
            <header>

              <?php 
                  $fila=mysqli_fetch_assoc($resultadousuario);
              ?>
              <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
              <img src="data:image;base64,<?php echo base64_encode($fila['Foto_Perfil'] ) ?>">
              <div class="details">
              
                <span><?php echo $fila['Nombre_Usuario']  ?> <?php echo $fila['Apellido_Paterno_Usuario']  ?> <?php echo $fila['Apellido_Materno_Usuario']  ?></span>
                <p> <?php echo $fila['Username']  ?></p>
              </div>
            </header>
            <div class="chat-box">
      
              <?php 
                while($fila1=mysqli_fetch_assoc($resultadomen))
                {
                  $fila2=mysqli_fetch_assoc($resultadousu);
              ?>

              <label class="fecha">Enviado a las: <?php echo $fila1['Fecha_envio']  ?></label><br>
              <label class="nickname"><?php echo $fila2['Username']  ?></label><label style="background-color: #c7c8ca; border-radius: 10px; padding: 1px 5px 1px 5px;" ><?php echo $fila1['Mensaje']  ?></label><br>
              <?php  
                }
              ?>
            </div>



            <form action="" class="typing-area" id="typing-area" method="POST">
              
              <?php
              $fila3=mysqli_fetch_assoc($resultadousuario);
               
              ?>

              <input type="text" class="emisor_id" name="emisor_id" id="emisor_id" value="<?php echo $username ?>" hidden>
              <input type="text" class="receptor_id" name="receptor_id" id="receptor_id" value="<?php echo $Emisor?>" hidden>
              <input type="text" required name="message" id="message" class="input-field" placeholder="Escribe tu mensaje aquí...">
              <button><img src="../assets/Imagenes/iconSend.png" onclick="sendMessage()"></button>

            </form>
          </section>
        </div>
      
        <script src="https://code.jquery.com/jquery-3.7.0.slim.min.js" integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
        <script src="/assets/js/Chat.js"></script>

        
      </body>
</html>
