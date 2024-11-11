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

    $IdCapitulo = $_GET['IdCapitulo'];

	$conn=mysqli_connect("localhost","root", "","cursosonline");
    $query = "SELECT * FROM curso WHERE Creador_Curso = $username AND EstadoCurso = 1";
	$resultado = mysqli_query($conn, $query);

    $query = "SELECT * FROM capitulo_curso WHERE IdCapitulo = $IdCapitulo AND Creador_Curso=$username LIMIT 1";
	$resultadocapitulo = mysqli_query($conn, $query);

    if(!$fila1=mysqli_fetch_assoc($resultadocapitulo)){
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

            $query = "UPDATE Capitulo SET VideoCapitulo = '$binariosImagen' WHERE IdCapitulo = $IdCapitulo ";
	        $resultado = mysqli_query($conn, $query);

            echo '<script language="javascript">alert("Se actualizo el video");
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
    <link rel="stylesheet" href="/assets/css/editarVideo.css">
        
      <title>Editar Video</title>
    </head>
      <body>
        <div class="main-container-video">
        <input type="hidden" value="<?php echo $IdCapitulo; ?>" id="idCapitulo">

            <form  method="post" name="Registro" id="Registro">

                  <div class="title-area">
                    <h4>Ingresa un titulo para tu capitulo</h4>
                    <textarea placeholder="Ingresa el titulo" id="title" name="title"> <?php echo $fila1['TituloCapitulo']; ?> </textarea>
                </div>
                    <br>

                <div class="description-area">
                    <h4>Agrega una descripcion al video</h4>
                    <textarea placeholder="Ingresa una descripcion" id="description" name="description"><?php echo $fila1['Descripcion']; ?></textarea>
                </div>

                        <div class="description-area">
                            <h4>El curso sera de demostracion?</h4>
                            <select name="gratis" class="course-area" name="gratis" id="gratis">
                                <option  value="0" <?php 
                                if($fila1['Gratis'] == 0){
                                    echo 'selected=""';
                                }
                            ?>> NO </option>
                                <option  value="1" <?php 
                                if($fila1['Gratis'] == 1){
                                    echo 'selected=""';
                                }
                            ?>> SI </option>
                            </select>
                        </div>

                    <div class="description-area">
                    <h4>Elige un curso en el cual subir el video</h4>
                    </div>


                      <div class="dropdown">
                      <select name="cursos" class="course-area" name="curse" id="curse">
                        <option  disbled=""> Mis cursos </option>
                        <?php 
                            while($fila=mysqli_fetch_assoc($resultado))
                            {
                            ?>
                            <option <?php 
                                if($fila1['Curso'] == $fila['idCurso']){
                                    echo 'selected=""';
                                }
                            ?>
                            value = <?php echo $fila['idCurso']?>> Curso <?php echo $fila['Titulo_Curso']?> </option>
                            <?php 
                                }      
                            ?>
                      </select>  
                      </div>
                        
                    <div class="button-container">
                    <button type="submit" class="button-upload-video" onclick="validacionVideo()">
                        <span class="video-icon">⇪</span> <span>Editar Datos</span>
                    </button>
                </div>
            </form>

            <br>
            <form  name="Registro" id="Registro" enctype="multipart/form-data" action="editVideo.php?IdCapitulo=<?php echo $IdCapitulo ?>" method="post">
                
                <div class="video-area">
        
                    <div class="video-insert">Selecciona tu archivo<br>
                    <input type="file" accept="video/*" name="foto" id="foto" /></div>
                </div>

                  
                        
                    <div class="button-container">
                    <button type="submit" class="button-upload-video" onclick="validacionVideo()">
                        <span class="video-icon">⇪</span> <span>Editar video</span>
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
        <script src="/assets/js/editarVideo.js"></script>
    </body>
    </html>
