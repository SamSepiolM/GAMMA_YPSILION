<?php
    include('../controllers/paginacion.php');
?>

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
        //header("Location: login-signup.php");
        $username = -1;
    }
?>

<?php
    $query = "SELECT * FROM categoria";
    $resultadocategoria = mysqli_query($conn, $query);
?>

<?php
    $query = "SELECT * FROM usuario WHERE Rol_User = 2";
    $resultadousuarios = mysqli_query($conn, $query);
?>

<?php 
if (!isset($_POST['buscar'])){$_POST['buscar'] = '';}
if (!isset($_POST['buscacategoria'])){$_POST['buscacategoria'] = '';}
if (!isset($_POST["orden"])){$_POST["orden"] = '';}
if (!isset($_POST['buscaprecio'])){$_POST['buscaprecio'] = '';}
if (!isset($_POST['buscaUser'])){$_POST['buscaUser'] = '';}
if (!isset($_POST['fechainicio'])){$_POST['fechainicio'] = '';}
if (!isset($_POST['fechafin'])){$_POST['fechafin'] = '';}

?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina prinicpal</title>
    <link rel="shortcut icon" href="../assets/Imagenes/Logotipo.png">
    <link href="/assets/css/homeStyle.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <!--<?php  include_once "bootstrap.php" ?> -->
</head>

<body> 
    <header>
        <div>
            <div class="row">
                <div class="col-8 barra">
                       <img src="../assets/Imagenes/Logotipo.png">
                </div>

                <div class="col-4 text-right barra">
                    <input type="hidden" value="<?php echo $rol; ?>" id="rol">
                    <div class="buttons-user">
                        <?php if($username != -1){ ?>

                        <a href="" id="referencia">
                        <button class="user-button">Mi perfil</button>
                        </a>
                        <a href="/controllers/logout.php">
                            <button class="logout-button">Cerrar sesion</button>
                        </a>

                        <?php   }  else {   ?>
                        <a href="login-signup.php">
                        <button class="user-button">Iniciar sesion</button>
                        </a>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="main col">
        <div class="row justify-content-center align-content-center text-center">
            <div class="columna col-lg-6">
                <section class="section cursos">


                    <div class="row justify-content-center">
                        <form id="form2" name="form2" method="POST" action="home.php">
                            <input class="searcc-bar" type="text" placeholder="Buscar cursos" id="buscar" name="buscar" value="<?php echo $_POST["buscar"] ?>">

                            <button class="button_searcc" type="submit"><img src="/assets/Imagenes/searchwithmagnifierincircularbutton_80266.png"></button>

                        
                            <select id="assigned-tutor-filter" id="buscacategoria" name="buscacategoria" class="form-control mt-2">
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
                        
                           <select id="assigned-tutor-filter" id="orden" name="orden" class="form-control mt-2" >


                            <?php if ($_POST["orden"] != ''){ ?>
                                <?php 
                                    if ($_POST["orden"] == '1'){echo 'Ordenar por fecha de reciente a antigua';} 
                                    if ($_POST["orden"] == '2'){echo 'Ordenar por fecha de antigua a reciente';} 
                                    if ($_POST["orden"] == '3'){echo 'Ordenar por mejores calificados';} 
                                    if ($_POST["orden"] == '4'){echo 'Ordenar por mas vendidos';} 
                                ?>
                                </option>
                                <?php } ?>

                                <option value="1">Ordenar por fecha de reciente a antigua</option>
                                <option value="2">Ordenar por fecha de antigua a reciente</option>
                                <option value="3">Ordenar por mejores calificados</option>
                                <option value="4">Ordenar por mas vendidos</option>
                            </select>


                            <select id="assigned-tutor-filter" id="buscaprecio" name="buscaprecio" class="form-control mt-2" >
                            <?php if ($_POST["buscaprecio"] != ''){ ?>
                                <?php 
                                    if ($_POST["buscaprecio"] == '1'){echo 'Menor a $100';} 
                                    if ($_POST["buscaprecio"] == '2'){echo 'Menor a $250';} 
                                    if ($_POST["buscaprecio"] == '3'){echo 'Menor a $500';} 
                                    if ($_POST["buscaprecio"] == '4'){echo 'Mayor a $1000';} 
                                ?>
                                </option>
                                <?php } ?>
                                 <option value="">Todos los precios</option>
                                <option value="1">Menor a $100</option>
                                <option value="2">Menor a $250</option>
                                <option value="3">Menor a $500</option>
                                <option value="4">Mayor a $1000</option>
                            </select>
                            
                            <select id="assigned-tutor-filter" id="buscaUser" name="buscaUser" class="form-control mt-2" >
                            <?php if ($_POST["buscaUser"] != ''){ ?>
                                <option value="<?php echo $_POST["buscaUser"]; ?>"><?php echo $_POST["buscaUser"]; ?></option>
                                <?php } ?>
                                <option value="">Todos los usuarios</option>
                                 <?php 

                                    while($filauser=mysqli_fetch_assoc($resultadousuarios))
                                    {
                                ?>
                                    <option value=<?php echo $filauser['idUsuario']  ?> ><?php echo $filauser['Username']  ?></option>
                                <?php 
                                    }      
                                ?>
                            </select>

                            <label>Fecha inicio</label>
                            <input type="date" id="assigned-tutor-filter" id="fechainicio" name="fechainicio"
                            <?php 
                            if($_POST["fechainicio"] != '')?>
                                value=<?php echo $_POST["fechainicio"]
                            ?>  ></input>

                            <label>Fecha final</label>
                            <input type="date" id="assigned-tutor-filter" id="fechafin" name="fechafin"
                            <?php 
                            if($_POST["fechafin"] != '')?>
                                value=<?php echo $_POST["fechafin"]
                            ?>  ></input>


                            <?php 
                                if ($_POST['buscar'] == ''){ $_POST['buscar'] = ' ';}
                                $aKeyword = explode(" ", $_POST['buscar']);

                                    if ($_POST["buscar"] == '' AND $_POST['buscacategoria'] == '' ){ 
                                            $query ="SELECT * FROM filtros_cursos";
                                    }
                                    else{
                                        $query ="SELECT * FROM filtros_cursos ";


                                        if ($_POST["buscar"] != '' ){ 
                                        $query .= "WHERE (Titulo_Curso LIKE LOWER('%".$aKeyword[0]."%')) ";

                                            for($i = 1; $i < count($aKeyword); $i++) {
                                                if(!empty($aKeyword[$i])) {
                                                $query .= " OR Titulo_Curso LIKE '%" . $aKeyword[$i] . "%'";
                                            }
                                        }
                                    }
                                    if ($_POST["buscacategoria"] != '' ){
                                        $query .= " AND Categoria = '".$_POST['buscacategoria']."' ";
                                    }
                                    if ($_POST["buscaUser"] != '' ){
                                        $query .= " AND idUsuario = '".$_POST['buscaUser']."' ";
                                    }

                                    
                                    
                                    if ( $_POST['buscaprecio'] == '1' ){
                                        $query .= " AND Precio_Curso <= 100.00 ";
                                    }

                                    if ( $_POST['buscaprecio'] == '2' ){
                                        $query .= " AND Precio_Curso <= 250.00 ";
                                    }
                                    if ( $_POST['buscaprecio'] == '3' ){
                                        $query .= " AND Precio_Curso <= 500.00 ";
                                    }

                                    if ( $_POST['buscaprecio'] == '4' ){
                                        $query .= " AND Precio_Curso >= 1000.00 ";
                                    }

                                    if ($_POST["fechainicio"] != '' ){
                                        $query .= " AND Fecha >= '".$_POST['fechainicio']."' ";
                                    }
                      
                                    if ($_POST["fechafin"] != '' ){
                                        $query .= " AND Fecha <= '".$_POST['fechafin']."' ";
                                    }

                                    $query .= " AND EstadoCurso = 1 ";

                                    if ($_POST["orden"] == '1' ){
                                        $query .= " ORDER BY Fecha_Registro_Curso ASC ";
                                    }

                                    if ($_POST["orden"] == '2' ){
                                        $query .= " ORDER BY Fecha_Registro_Curso DESC ";
                                    }

                                    if ($_POST["orden"] == '3' ){
                                        $query .= " ORDER BY Calificados DESC ";
                                    }

                                    if ($_POST["orden"] == '4' ){
                                        $query .= " ORDER BY Vendidos DESC ";
                                    }

                                }
                                $sql = $conn->query($query);

                                if(!empty($_REQUEST["nume"])){ $_REQUEST["nume"] = $_REQUEST["nume"];}else{ $_REQUEST["nume"] = '1';}
                                if($_REQUEST["nume"] == "" ){$_REQUEST["nume"] = "1";}

                                $conn=mysqli_connect("localhost","root", "","cursosonline");
                                $cursos = mysqli_query($conn, $query );

                                $num_registros=mysqli_num_rows($cursos);
                                $registros= '9';
                                $pagina=$_REQUEST["nume"];
                                if (is_numeric($pagina))
                                    $inicio= (($pagina-1)*$registros);
                                else
                                $inicio=0;
                                    $busqueda=mysqli_query($conn," $query LIMIT $inicio,$registros; ");
                                $paginas=ceil($num_registros/$registros);

                            ?>

                        </form>
                    </div>
                    
                    <header class="section-header">
                        <h3 class="section-title">Cursos Online Recomendados:</h3>
                    </header>   
                </section>  
                <div class="grid episodios" id="Cusrso12">


                         <?php 
                            $idAnterior=-1;
                            while($resultado=$busqueda->fetch_assoc())
                            {
                                if($resultado['idCurso'] !=$idAnterior){
                                    $idAnterior = $resultado['idCurso'];
                                
                         ?>
                            <article class="cursos episodios">
                                <div class="c-thumb">
                                <figure><img src="data:image;base64,<?php echo base64_encode($resultado['ImagenCurso'] ) ?>"></figure>
                                </div>
                                <header class="c-header">
                                <span class="num-episodios">Curso <?php echo $resultado['idCurso']  ?></span>
                                <br><h2 class="c-title"><?php echo  $resultado['Titulo_Curso']  ?></h2>
                                <br><h2 class="c-title">  $ <?php echo  $resultado['Precio_Curso']  ?></h2>
                                </header>
                                <a href="/views/chapterList.php?idCurso=<?php echo $resultado['idCurso']?>" class="lnk-blk fa-play-circle">
                                <span aria-hidden="true" hidden="">Ver ahora</span></a>
                            </article>
                        <?php 
                            }  }    
                         ?>
                </div>           
            </div> 
        </div>

        <div class="page-container">
            <div class="container-fluid  col-12">
                <ul class="pagination pg-dark justify-content-center pb-5 pt-5 mb-0" style="float: none;" >
                    <li class="page-item">
                    <?php
                        if($_REQUEST["nume"] == "1" ){
                        $_REQUEST["nume"] == "0";
                        echo  "";
                        }else{
                        if ($pagina>1)
                        $ant = $_REQUEST["nume"] - 1;
                        echo "<a class='page-link' aria-label='Previous' href='home.php?nume=1'><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a>"; 
                        echo "<li class='page-item '><a class='page-link' href='home.php?nume=". ($pagina-1) ."' >".$ant."</a></li>"; }
                        echo "<li class='page-item active'><a class='page-link' >".$_REQUEST["nume"]."</a></li>"; 
                        $sigui = $_REQUEST["nume"] + 1;
                        $ultima = $num_registros / $registros;
                        if ($ultima == $_REQUEST["nume"] +1 ){
                        $ultima == "";}
                        if ($pagina<$paginas && $paginas>1)
                        echo "<li class='page-item'><a class='page-link' href='home.php?nume=". ($pagina+1) ."'>".$sigui."</a></li>"; 
                        if ($pagina<$paginas && $paginas>1)
                        echo "
                        <li class='page-item'><a class='page-link' aria-label='Next' href='home.php?nume=". ceil($ultima) ."'><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a>
                        </li>";
                    ?>
                </ul>
            </div>
        </div>
        
    </main>

    <footer>
        <div class="footer-bottom">
            <p> ©TODOS LOS DERECHOS RESERVADOS 2023 Creado por <span>Luis Jaime Mier Rodriguez y Pedro Gonzalez Martel</span></p>
        </div>
    </footer>
    <script src="../jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="/assets/js/inicioscript.js"></script>
</body>
</html>