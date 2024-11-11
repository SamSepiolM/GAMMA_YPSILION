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
  $query = "SELECT * FROM mensajes WHERE Receptor = $username ";
  $resultado = mysqli_query($conn, $query);
?>
<?php
    $querymen = "SELECT DISTINCT m.Emisor, u.Username, m.Receptor, u.Username, u.Foto_Perfil FROM mensajes m INNER JOIN usuario u ON m.Emisor = u.idUsuario AND m.Receptor = $username" ;
    $resultado = mysqli_query($conn, $querymen);
    $queryUser = "SELECT DISTINCT m.Emisor, u.Username, m.Receptor, u.Username, u.Foto_Perfil FROM mensajes m INNER JOIN usuario u ON m.Receptor = u.idUsuario AND m.Receptor = $username" ;
    $resultado = mysqli_query($conn, $querymen);
    $queryusuario = "SELECT * FROM Usuario WHERE idUsuario = $username";
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
        <link href="/assets/css/ChatMaestroStyle.css" rel="stylesheet" type="text/css"/>
    </head>
    

<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
         
   
          <?php 
              $fila1=mysqli_fetch_assoc($resultadousuario);
          ?>
          <img src="data:image;base64,<?php echo base64_encode($fila1['Foto_Perfil'] ) ?>" alt="">
          <div class="details">
            
            <span><?php echo $fila1['Username']?></span>

          </div>
        </div>
        <a href="/views/home.php" class="logout">Volver</a>
      </header>
      <div class="search">
        <span class="text">Selecciona un usuario para conversar</span>
      </div>
      <div class="users-list">

        <?php 
          while($fila=mysqli_fetch_assoc($resultado))
          {
        ?>
        <a href="/views/Chat.php?receptor_id=<?php echo $fila['Emisor']?>">
          <div class="details">

          <img src="data:image;base64,<?php echo base64_encode($fila['Foto_Perfil'] ) ?>" alt=""><span class="nickname">Usuario <?php echo $fila['Username']?></span>
          </div>
        </a>
        <?php 
          }      
        ?>
      </div>
    </section>
  </div>

  <script src=""></script>

</body>

</html>