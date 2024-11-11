<?php
session_start();
    if(isset($_SESSION["AUTH"])) {
        $rolSesion = $_SESSION["ROL"];
        if($rolSesion != 1){
            //header("Location: home.php");
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
?>

<?php 
if (!isset($_POST['buscacategoria'])){$_POST['buscacategoria'] = '';}
if (!isset($_POST["estado"])){$_POST["estado"] = '';}
if (!isset($_POST["estado2"])){$_POST["estado2"] = '';}
if (!isset($_POST['fechainicio'])){$_POST['fechainicio'] = '';}
if (!isset($_POST['fechafin'])){$_POST['fechafin'] = '';}
?>


<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Kardex</title>

    <link href="/assets/css/kardexStyle.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
       

    </style>
</head>


<body>
    <header>
        <div>
            <div class="row">
                <div class="col-8 barra">
                       <img src="../assets/Imagenes/Logotipo.png">
                </div>
                <div class="col-4 text-right barra">
                </div>
            </div>
        </div>
    </header>

<main class="main col">
        <div class="row justify-content-center align-content-center text-center">
            <div class="columna col-lg-6">
            <h1>
                KARDEX Oficial de GAMMA YPSILION
            </h1>

            <form class="filtro" id="form2" name="form2" method="POST" action="kardex.php">
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

            <label>Estado de curso</label>
              <select id="assigned-tutor-filter" id="estado2" name="estado2">
                <option value="">Todos</option>

                <option value="1" 
                <?php 
                  if ($_POST["estado2"] == '1'){?>
                    selected
                <?php } ?>  >Terminanos</option>

                <option value="0"
                <?php 
                  if ($_POST["estado2"] == '2'){1?>
                    selected
                <?php } ?>  >Inconclusos</option>

              </select><br>

            <button>Buscar</button>
          </form>

            <table style="width:100%;font-size:12px;" class="border">
                <thead>
                    <tr style="background-color:#FFD200">
                        <th width="35%">Nombre de curso</th>
                        <th width="15%">Fecha Inscripcion</th>
                        <th width="15%">Ultima Fecha Ingreso</th>
                        <th width="10%">Progreso</th>
                        <th width="10%">Curso Completo</th>
                        <th width="15%">Fecha Terminacion</th>
                    </tr>

                        <?php 
              
                            $query ="SELECT * FROM kardex ";

                            $query .= " WHERE IdUser = $username ";
                            if ($_POST["buscacategoria"] != '' ){
                                $query .= " AND idCategoria = '".$_POST['buscacategoria']."' ";
                            }
           

                            if ($_POST["estado"] == '1' ){
                                $query .= " AND EstadoCurso = 1 ";
                            }

                            if ($_POST["estado"] == '2' ){
                                $query .= " AND EstadoCurso = 0 ";
                            }

                            if ($_POST["estado2"] == '1' ){
                                $query .= " AND Estado_Completado = 1 ";
                            }

                            if ($_POST["estado2"] == '0' ){
                                $query .= " AND Estado_Completado = 0 ";
                            }

                            if ($_POST["fechainicio"] != '' ){
                                $query .= " AND FechaCompra >= '".$_POST['fechainicio']."' ";
                            }

                            if ($_POST["fechafin"] != '' ){
                                $query .= " AND FechaCompra <= '".$_POST['fechafin']."' ";
                            }
              
                            $sql = $conn->query($query);

                            if(!empty($_REQUEST["nume"])){ $_REQUEST["nume"] = $_REQUEST["nume"];}else{ $_REQUEST["nume"] = '1';}
                            if($_REQUEST["nume"] == "" ){$_REQUEST["nume"] = "1";}

                            $conn=mysqli_connect("localhost","root", "","cursosonline");
                            $cursos = mysqli_query($conn, $query );

                        ?>

                        <?php 
                            $idAnterior=-1;
                            while($resultado=$cursos->fetch_assoc())
                            { 
                                if($resultado['IdCursoComprado'] !=$idAnterior){
                                $idAnterior = $resultado['IdCursoComprado'];  
                        ?>

                                <tr>
                                <th><?php echo $resultado['Titulo_Curso']?></th>
                                <th><?php echo $resultado['FechaCompra']?></th>
                                <th><?php echo $resultado['FechaUltimoIngreso']?></th>
                                <th><?php echo $resultado['NivelCursado']?>%</th>
                                <th><?php echo $resultado['Estado_Completado']?></th>
                                <th><?php echo $resultado['FechaCompletado']?></th>
                                </tr>
                        <?php 
                                } 
                            } ?>
                <thead>
            </table>

            <a href="/views/studentProfile.php"><button class="button-upload-video" id="subir">
                <span class="video-icon">Ø</span> <span>Atras</span>
            </button>
        </div>
    </div>
</main>
  <footer>
        <div class="footer-bottom">
            <p> ©TODOS LOS DERECHOS RESERVADOS 2023 Creado por <span>Luis Jaime Mier Rodriguez y Pedro Gonzalez Martel</span></p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="/assets/js/inicioscript.js"></script>
</body>
</html>