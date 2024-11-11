<?php
session_start();
    if(isset($_SESSION["AUTH"])) {
        $rolSesion = $_SESSION["ROL"];
        if($rolSesion != 3){
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
?>

<?php
    $query = "SELECT * FROM categoria";
    $resultadocategoria = mysqli_query($conn, $query);
    $resultadocategoria1 = mysqli_query($conn, $query);
?>

<?php 
if (!isset($_POST['buscacategoria1'])){$_POST['buscacategoria1'] = '';}
if (!isset($_POST["estado1"])){$_POST["estado1"] = '';}
if (!isset($_POST['fechainicio1'])){$_POST['fechainicio1'] = '';}
if (!isset($_POST['fechafin1'])){$_POST['fechafin1'] = '';}
if (!isset($_POST['cambiarEstado']))  {
  $_POST['cambiarEstado'] = '';
}
else {
  $query = "UPDATE USUARIO SET Estado_Usuario = '".$_POST['cambiarEstado']."' , Intentos_Fallidos = 0 WHERE idUsuario = '".$_POST['idUser']."'";
  $resultadoUpdate = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cursos</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link href="/assets/css/Reportes.css" rel="stylesheet" type="text/css"/>
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

      <div class="container">
          <form class="filtro" id="form2" name="form2" method="POST" action="adminUsuarios.php">
            <label>Fecha inicio</label>
            <input type="date" id="assigned-tutor-filter" id="fechainicio1" name="fechainicio1"
            <?php 
            if($_POST["fechainicio1"] != '')?>
              value=<?php echo $_POST["fechainicio1"]
            ?>
            ></input>

            <label>Fecha final</label>
              <input type="date" id="assigned-tutor-filter" id="fechafin1" name="fechafin1"
              <?php 
                if($_POST["fechafin1"] != '')?>
                  value=<?php echo $_POST["fechafin1"]
              ?>></input>

            <label>Estado de usuario</label>
            <select id="assigned-tutor-filter" id="estado1" name="estado1">
                <option value="">Todos</option>

                <option value="1" 
                <?php 
                  if ($_POST["estado1"] == '1'){?>
                    selected
                <?php } ?>  >Activos</option>

                <option value="2"
                <?php 
                  if ($_POST["estado1"] == '2'){1?>
                    selected
                <?php } ?>  >Inactivos</option>

              </select><br>
            <button>Buscar</button>
          </form>
          <table>
            <thead>
              <tr>
                <th colspan="2">Logo</th>
                <th colspan="8">Usuarios en Gamma Ypsilion</th>
                
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Username</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Fecha de inscripcion</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Genero</th>
                <th>Estado</th>
                <th>ACT/DES</th>
              </tr>
            </thead>
            
             <tbody>
             <?php 
              
              $query ="SELECT * FROM adminUsuarios ";

              if ($rolSesion == 3){
                $query .= " WHERE idUsuario != -1 ";
              }
         

              if ($_POST["estado1"] == '1' ){
                $query .= " AND Estado_Usuario = 1 ";
              }

              if ($_POST["estado1"] == '2' ){
                $query .= " AND Estado_Usuario = 0 ";
              }

              if ($_POST["fechainicio1"] != '' ){
                $query .= " AND Fecha1 >= '".$_POST['fechainicio1']."' ";
              }

              if ($_POST["fechafin1"] != '' ){
                $query .= " AND Fecha1 <= '".$_POST['fechafin1']."' ";
              }
            
            $sql = $conn->query($query);

            if(!empty($_REQUEST["nume"])){ $_REQUEST["nume"] = $_REQUEST["nume"];}else{ $_REQUEST["nume"] = '1';}
            if($_REQUEST["nume"] == "" ){$_REQUEST["nume"] = "1";}

            $conn=mysqli_connect("localhost","root", "","cursosonline");
            $cursos = mysqli_query($conn, $query );

          ?>

            
            <?php 
              
              while($resultado=$cursos->fetch_assoc())
                { 
                  ?>

                  <tr>
                  <td><?php echo $resultado['Username']?></td>
                  <td><?php echo $resultado['Nombre_Usuario']?></td>
                  <td><?php echo $resultado['Apellido_Paterno_Usuario']?></td>
                  <td><?php echo $resultado['Apellido_Materno_Usuario']?></td>
                  <td><?php echo $resultado['Fecha1']?></td>
                  <td><?php echo $resultado['Correo_Usuario']?></td>
                  <td><?php echo $resultado['Nombre_Rol']?></td>
                  <td><?php echo $resultado['Nombre_Genero']?></td>
                  <td><?php 
                    if($resultado['Estado_Usuario'] == 1){
                      echo 'ACTIVO';
                    }
                    if($resultado['Estado_Usuario'] == 0){
                      echo 'INACTIVO';
                    }
                  
                  ?></td>
                  <td><form class="filtro1" id="form2" name="form2" method="POST" action="adminUsuarios.php"> 
                  <input type="hidden" id="assigned-tutor-filter" id="cambiarEstado" name="cambiarEstado" value=
                    <?php 
                      if($resultado['Estado_Usuario'] == 1)
                        echo '0';
                      else{ 
                        echo '1';
                      }
                    ?>
                  ></input>
                  <input type="hidden" id="assigned-tutor-filter" id="idUser" name="idUser" value=
                    <?php 
                      echo $resultado['idUsuario']
                    ?>
                  ></input>
                  <button>Cambiar</button>
                  </form></td>
                  </tr>
                <?php 
                
              } ?>

                  
            </tbody>
          </table>
        </div>


        <footer>
            <div class="footer-bottom">
                <p> ©TODOS LOS DERECHOS RESERVADOS 2023 Creado por <span>Luis Jaime Mier Rodriguez y Pedro Gonzalez Martel</span></p>
            </div>
        </footer>
    </body>
</html>