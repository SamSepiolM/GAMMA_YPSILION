<?php
    include('../controllers/paginacionCat.php');
?>
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
?>

<?php
    //include ("../API/conexion.php");

    if(isset($_GET['update'])){
        $update = $_GET['update'];
    }
    $idCurso = $_GET['idCurso'];

	//$conn=mysqli_connect("localhost","root", "","cursosonline");
    $query = "SELECT * FROM curso WHERE idCurso = $idCurso AND EstadoCurso = 1 AND Creador_Curso= $username LIMIT 1";
	$resultado = mysqli_query($conn, $query);

    if(!$fila=mysqli_fetch_assoc($resultado)){
        header("Location: home.php");
    }
?>

<?php
    if(isset($_FILES['foto']['name'])){
        if($_FILES['foto']['name'] != ''){
            $tipoArchivo  = $_FILES['foto']['type'];
            $nombreArchivo  = $_FILES['foto']['name'];
            $tamanoArchivo  = $_FILES['foto']['size'];
            $imagenSubida=fopen($_FILES["foto"]["tmp_name"] , 'r+');
            $binariosImagen=fread($imagenSubida, $tamanoArchivo);
            $binariosImagen=mysqli_escape_string($conn, $binariosImagen);

            $query = "UPDATE CURSO SET ImagenCurso = '$binariosImagen' WHERE idCurso = $idCurso ";
	        $resultado = mysqli_query($conn, $query);

            echo '<script language="javascript">alert("Se actualizo la imagen");
                    window.location.href="/views/home.php"</script>';
        }
        
    }
?>


<!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
      
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

          <link rel="stylesheet" href="/assets/css/editarCurso.css">
            
          <title>Editar Curso</title>
        </head>
          <body>
            <div class="main-container">
                
                <input type="hidden" value="<?php echo $fila['idCurso']; ?>" id="idCurso">

                <form  method="post" name="RegistroCurso" id="RegistroCurso" enctype="multipart/form-data">

                    <div class="title-area">
                        <h4>Ingresa un titulo para tu curso</h4>
                        <input class="line-area" placeholder="Ingresa el titulo" id="titulo" name="titulo" value="<?php echo $fila['Titulo_Curso']; ?>"></input>
                    </div><br>


                    <div class="description-area">
                        <h4>Agrega una descripcion para el curso </h4>
                        <textarea placeholder="Ingresa una descripcion" id="description" name="description"><?php echo $fila['Descripcion_Curso']; ?></textarea>
                    </div>


                    <div class="description-area">
                        <h4>Elige el nivel de dificultad del curso</h4>
                    </div>
                    <div class="dropdown">
                        <select name="grade" id="grade" class="grade">
                            <option  disbled=""> Selecciona el grado </option>
                            <option <?php 
                                if($fila['GradoCurso'] == 'Principiante'){
                                    echo 'selected=""';
                                }
                            ?> value= "Principiante"> Principiante </option>
                            <option <?php 
                                if($fila['GradoCurso'] == 'Intermediario'){
                                    echo 'selected=""';
                                }
                            ?> value= "Intermediario"> Intermediario </option>
                            <option <?php 
                                if($fila['GradoCurso'] == 'Experto'){
                                    echo 'selected=""';
                                }
                            ?> value= "Experto"> Experto </option>
                        </select>  
                    </div>


                    <div class="title-area">
                        <h4>Ingresa el precio de tu curso (ejemplo 100.00)</h4>
                        <input class="line-area" placeholder="Ingresa el titulo" id="precio" name="precio" value="<?php echo $fila['Precio_Curso']; ?>"></input>
                    </div>
                          

                    <div class="categorie-area">
                        <h4>Elige las categorias para tu curso</h4>
                    </div>
                          
                    <div class="dropdown">
                        <select name="categorie" id="categorie" class="categorie" multiple="multiple">
                            <?php 
                                while($fila=mysqli_fetch_assoc($resultado12))
                                    {
                            ?>
                            <option value= <?php echo $fila['idCategoria']  ?>  
                            <?php 
                                $querycom = "SELECT * FROM select_categorias WHERE idCurso = $idCurso" ;
                                $resultadoCategorias = mysqli_query($conn, $querycom);

                                while($filaCAT=mysqli_fetch_assoc($resultadoCategorias))
                                {
                                    if($filaCAT['idCategoria'] ==  $fila['idCategoria']){   ?>
                                       selected
                                    <?php   }   }
                            ?>
                            > <?php echo $fila['Nombre_categoria']  ?> </option>
                            <?php 
                                }      
                            ?>
                        </select>  
                    </div>
  

                    <div class="button-container">
                        <button type="submit" class="button-upload-video" onclick="validacionCurso()">
                            <span class="video-icon">⇪</span> <span>Editar Curso</span>
                        </button>
                        <button type="submit" class="button-delete-profile" onclick="EliminarCurso()" id="eliminar">          
                            <span class="delete-icon">✘</span> <span>Borrar curso</span>
                    </button>
                    </div>

                                <br>
                </form>
                <form name="RegistroImagen" id="RegistroImagen" enctype="multipart/form-data" action="editCurse.php?idCurso=<?php echo $idCurso ?>" method="post">
                          
                    <div class="video-area">
            
                        <div class="video-insert">Selecciona tu miniatura<br>
                        <input type="file" accept="image/*" name="foto" id="foto"/></div>
                    </div>
                    

                    <div class="button-container">
                        <button type="submit" class="button-upload-video">
                            <span class="video-icon">⇪</span> <span>Editar Imagen</span>
                        </button>

                    </div>

                </form>
                <div class="button-cancel-container">
                    <a href="/views/teacherProfile.php">
                        <button type="submit" class="button-cancel" id="subir">
                            <span>Cancelar</span>
                        </button>
                    </a>
                </div>
            </div> 
        <script src="/assets/js/editarCurso.js"></script>
        </body>
        </html>
