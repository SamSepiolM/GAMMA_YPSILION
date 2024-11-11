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
    $query = "SELECT * FROM curso WHERE Creador_Curso = $username AND EstadoCurso = 1";
	$resultado = mysqli_query($conn, $query);
?>

<?php
    $idCurso=0;
    $IdCapitulo=0;

    if(isset($_GET['idCurso'])){
        $idCurso = $_GET['idCurso'];
    }

    if(isset($_GET['IdCapitulo'])){
        $IdCapitulo = $_GET['IdCapitulo'];
    }

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

            echo '<script language="javascript">alert("Se subio el video");
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
        <link rel="stylesheet" href="/assets/css/subirVideo.css">
            
          <title>Browser</title>
        </head>
          <body>
            <div class="main-container-video">
            <?php if($IdCapitulo == 0) {   ?>
                <form  method="post" name="Registro" id="Registro">

                      <div class="title-area">
                        <h4>Ingresa un titulo para tu capitulo</h4>
                        <textarea placeholder="Ingresa el titulo" id="title" name="title"></textarea>
                    </div>
                        <br>

                    <div class="description-area">
                        <h4>Agrega una descripcion al video</h4>
                        <textarea placeholder="Ingresa una descripcion" id="description" name="description"></textarea>
                    </div>
                        <div class="description-area">
                            <h4>El curso sera de demostracion?</h4>
                            <select name="gratis" class="course-area" name="gratis" id="gratis">
                                <option  value="0" selected> NO </option>
                                <option  value="1"> SI </option>
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
                            <option value = <?php echo $fila['idCurso'] ?>
                            <?php   if($fila['idCurso'] == $idCurso) {  ?>
                                selected
                            <?php   }   ?>> Curso <?php echo $fila['Titulo_Curso']?> </option>
                            <?php 
                                }      
                            ?>
                          </select>  
                          </div>
                            
                        <div class="button-container">
                        <button type="submit" class="button-upload-video" onclick="validacionVideo()">
                            <span class="video-icon">⇪</span> <span>Subir video</span>
                        </button>
                    </div>
                </form>
                <?php   }   ?>

                
                <?php if($IdCapitulo != 0) {   ?>
                <form name="Registro1" id="Registro1" enctype="multipart/form-data" action="uploadVideo.php?IdCapitulo=<?php echo $IdCapitulo ?>" method="post">
                    <div class="video-area">
            
                        <div class="video-insert">Selecciona tu archivo<br>
                        <input type="file" accept="video/*" name="foto" id="foto" /></div>
                    </div>
                            
                        <div class="button-container">
                        <button type="submit" class="button-upload-video">
                            <span class="video-icon">⇪</span> <span>Subir video</span>
                        </button>
                    </div>
                </form>
                <?php   }   ?>

                <div class="button-cancel-container">
                    <a href="/views/teacherProfile.php">
                        <button type="submit" class="button-cancel" id="subir">
                            <span>Cancelar</span>
                        </button>
                    </a>
                </div>
            </div> 
            <script src="/assets/js/validarVideo.js"></script>
        </body>
        </html>



