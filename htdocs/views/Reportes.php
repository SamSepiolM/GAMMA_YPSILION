<?php
session_start();
    if(isset($_SESSION["AUTH"])) {
        $rolSesion = $_SESSION["ROL"];
        if($rolSesion != 2 && $rolSesion != 3){
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
if (!isset($_POST['buscacategoria'])){$_POST['buscacategoria'] = '';}
if (!isset($_POST["estado"])){$_POST["estado"] = '';}
if (!isset($_POST['fechainicio'])){$_POST['fechainicio'] = '';}
if (!isset($_POST['fechafin'])){$_POST['fechafin'] = '';}


if (!isset($_POST['buscacategoria1'])){$_POST['buscacategoria1'] = '';}
if (!isset($_POST["estado1"])){$_POST["estado1"] = '';}
if (!isset($_POST['fechainicio1'])){$_POST['fechainicio1'] = '';}
if (!isset($_POST['fechafin1'])){$_POST['fechafin1'] = '';}
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
          <form class="filtro" id="form2" name="form2" method="POST" action="Reportes.php">
            <label>Fecha inicio</label>
            <input type="date" id="assigned-tutor-filter" id="fechainicio" name="fechainicio"
            <?php 
            if($_POST["fechainicio"] != '')?>
              value=<?php echo $_POST["fechainicio"]
            ?>
            ></input>

            <label>Fecha final</label>
              <input type="date" id="assigned-tutor-filter" id="fechafin" name="fechafin"
              <?php 
                if($_POST["fechafin"] != '')?>
                  value=<?php echo $_POST["fechafin"]
              ?>
              ></input>
            <label>Buscar por:</label>
            
              <select id="assigned-tutor-filter" id="buscacategoria" name="buscacategoria" >
              <?php if ($_POST["buscacategoria"] != ''){ ?>
              <option value="<?php echo $_POST["buscacategoria"]; ?>"><?php echo $_POST["buscacategoria"]; ?></option>
              <?php } ?>
              <option value="">Todas las categorias</option>
                <?php 
                  while($fila1=mysqli_fetch_assoc($resultadocategoria))
                    {
                  ?>
                      <option value=<?php echo $fila1['idCategoria']  ?> ><?php echo $fila1['Nombre_categoria']  ?></option>
                  <?php 
                     }      
                  ?>
              </select>

            <label>Estado de curso</label>
              <select id="assigned-tutor-filter" id="estado" name="estado">
                <option value="">Todos</option>

                <option value="1" 
                <?php 
                  if ($_POST["estado"] == '1'){?>
                    selected
                <?php } ?>  >Activos</option>

                <option value="2"
                <?php 
                  if ($_POST["estado"] == '2'){1?>
                    selected
                <?php } ?>  >Inctivos</option>

              </select><br>

            <button>Buscar</button>
          </form>
          <table>
            <thead>
              <tr>
                <th colspan="2">Logo</th>
                <th colspan="5">Reporte de tus cursos en Gamma Ypsilion</th>
                
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Curso</th>
                <th>Cantidad de alumnos inscrito</th>
                <th>Nivel promedio cursado</th>
                <th>Costo de curso</th>
                <th>Ingresos PAYPAL</th>
                <th>Ingresos EFECTIVO</th>
                <th>Total de ingresos</th>
              </tr>
            </thead>
            <tbody>


            <?php 
              
                $query ="SELECT * FROM reporte_cursos ";

                if ($rolSesion == 2){
                  $query .= " WHERE Creador_Curso = $username ";
                }
                else{
                  $query .= " WHERE idCurso != -1 ";
                }
                
                if ($_POST["buscacategoria"] != '' ){
                  $query .= " AND idCategoria = '".$_POST['buscacategoria']."' ";
                }
           

                if ($_POST["estado"] == '1' ){
                  $query .= " AND EstadoCurso = 1 ";
                }

                if ($_POST["estado"] == '2' ){
                  $query .= " AND EstadoCurso = 0 ";
                }

                if ($_POST["fechainicio"] != '' ){
                  $query .= " AND Fecha >= '".$_POST['fechainicio']."' ";
                }

                if ($_POST["fechafin"] != '' ){
                  $query .= " AND Fecha <= '".$_POST['fechafin']."' ";
                }
              
              $sql = $conn->query($query);

              if(!empty($_REQUEST["nume"])){ $_REQUEST["nume"] = $_REQUEST["nume"];}else{ $_REQUEST["nume"] = '1';}
              if($_REQUEST["nume"] == "" ){$_REQUEST["nume"] = "1";}

              $conn=mysqli_connect("localhost","root", "","cursosonline");
              $cursos = mysqli_query($conn, $query );

            ?>

              
              <?php 
                $idAnterior=-1;
                $Ingresos_PAYPAL = 0.00;
                $Ingresos_EFECTIVO = 0.00;
                while($resultado=$cursos->fetch_assoc())
                  { 
                    if($resultado['idCurso'] !=$idAnterior){
                    $idAnterior = $resultado['idCurso'];  
              ?>

                    <tr>
                    <td><?php echo $resultado['Titulo_Curso']?></td>
                    <td><?php echo $resultado['Alumnos_Inscritos']?></td>
                    <td><?php echo $resultado['NivelCursado']?>%</td>
                    <td>$<?php echo $resultado['Precio_Curso']?></td>
                    <td>$<?php echo $resultado['IngresosPAYPAL']?></td>
                    <td>$<?php echo $resultado['IngresosEFECTIVO']?></td>
                    <td>$<?php echo $resultado['Ingresos']?></td>
                    </tr>
              <?php 
                    $Ingresos_PAYPAL = $Ingresos_PAYPAL + $resultado['IngresosPAYPAL'];
                    $Ingresos_EFECTIVO = $Ingresos_EFECTIVO + $resultado['IngresosEFECTIVO'];
                    } 
                  } ?>

                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> Ingresos PAYPAL: $<?php echo number_format($Ingresos_PAYPAL, 2)?></td>
                    <td> Ingresos Efectivo: $<?php echo number_format($Ingresos_EFECTIVO, 2)?></td>
                    <td>Ingresos Totales: $<?php echo number_format($Ingresos_PAYPAL + $Ingresos_EFECTIVO, 2)?></td>
                  </tr>
            
            
              
            
                
              

            </tbody>
             <tbody>
            </tbody>
          </table>
        </div>


      <div class="container">
          <form class="filtro" id="form2" name="form2" method="POST" action="Reportes.php">
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

            <label>Buscar por:</label>
              <select id="assigned-tutor-filter" id="buscacategoria1" name="buscacategoria1" >
              <?php if ($_POST["buscacategoria1"] != ''){ ?>
              <option value="<?php echo $_POST["buscacategoria1"]; ?>"><?php echo $_POST["buscacategoria1"]; ?></option>
              <?php } ?>
              <option value="">Todas las categorias</option>
                <?php 
                  while($fila14=mysqli_fetch_assoc($resultadocategoria1))
                    {
                  ?>
                      <option value=<?php echo $fila14['idCategoria']  ?> ><?php echo $fila14['Nombre_categoria']  ?></option>
                  <?php 
                     }      
                  ?>
              </select>

            <label>Estado de curso</label>
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
                <?php } ?>  >Inctivos</option>

              </select><br>
            <button>Buscar</button>
          </form>
          <table>
            <thead>
              <tr>
                <th colspan="2">Logo</th>
                <th colspan="7">Ventas de tus cursos en Gamma Ypsilion</th>
                
              </tr>
            </thead>
            <thead>
              <tr>
                <th>Username</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Fecha de inscripcion</th>
                <th>Curso inscrito</th>
                <th>Nivel promedio cursado</th>
                <th>Precio pagado</th>
                <th>Forma de pago</th>
              </tr>
            </thead>
            
             <tbody>
             <?php 
              
              $query ="SELECT * FROM reporte_cursos2 ";

              if ($rolSesion == 2){
                $query .= " WHERE Creador_Curso = $username ";
              }
              else{
                $query .= " WHERE idCurso != -1 ";
              }
              
              if ($_POST["buscacategoria1"] != '' ){
                $query .= " AND idCategoria = '".$_POST['buscacategoria1']."' ";
              }
         

              if ($_POST["estado1"] == '1' ){
                $query .= " AND EstadoCurso = 1 ";
              }

              if ($_POST["estado1"] == '2' ){
                $query .= " AND EstadoCurso = 0 ";
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
              $idAnterior=-1;
              $Ingresos_PAYPAL1 = 0.00;
              $Ingresos_EFECTIVO1 = 0.00;
              while($resultado=$cursos->fetch_assoc())
                { 
                  if($resultado['idCursoComprado'] !=$idAnterior){
                  $idAnterior = $resultado['idCursoComprado'];  ?>

                  <tr>
                  <td><?php echo $resultado['Username']?></td>
                  <td><?php echo $resultado['Nombre_Usuario']?></td>
                  <td><?php echo $resultado['Apellido_Paterno_Usuario']?></td>
                  <td><?php echo $resultado['Apellido_Materno_Usuario']?></td>
                  <td><?php echo $resultado['Fecha']?></td>
                  <td><?php echo $resultado['Titulo_Curso']?></td>
                  <td><?php echo $resultado['NivelCursado']?>%</td>
                  <td>$<?php echo $resultado['PrecioPagado']?></td>
                  <td><?php 
                    if($resultado['FormaPago'] == 1){
                      echo 'PAYPAL';
                    }
                    if($resultado['FormaPago'] == 2){
                      echo 'EFECTIVO';
                    }
                  
                  ?></td>
                  </tr>
                <?php 
                  if($resultado['FormaPago'] == 1){
                    $Ingresos_PAYPAL1 = $Ingresos_PAYPAL1 + $resultado['PrecioPagado'];
                  }
                  if($resultado['FormaPago'] == 2){
                    $Ingresos_EFECTIVO1 = $Ingresos_EFECTIVO1 + $resultado['PrecioPagado'];
                  }
                
                }
              } ?>

                  <tr>
                  <td></td>
                    <td> Ingresos PAYPAL: $<?php echo number_format($Ingresos_PAYPAL1, 2)?></td>
                    <td></td>
                    <td></td>
                    <td> Ingresos Efectivo: $<?php echo number_format($Ingresos_EFECTIVO1, 2)?></td>
                    <td></td>
                    <td></td>
                    <td>Ingresos Totales: $<?php echo number_format($Ingresos_PAYPAL1 + $Ingresos_EFECTIVO1, 2)?></td>
                    <td></td>
                  </tr>
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