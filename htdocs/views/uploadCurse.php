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
    $idCurso=0;

    if(isset($_GET['idCurso'])){
        $idCurso = $_GET['idCurso'];
    }

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

          <link rel="stylesheet" href="/assets/css/subirCurso.css">
            
          <title>Curso</title>
        </head>
          <body>
            <div class="main-container">
                <input type="hidden" value="<?php echo $usernameSesion; ?>" id="idUser">
                <?php if($idCurso == 0) {   ?>
                <form  method="post" name="RegistroCurso" id="RegistroCurso">

                    <div class="title-area">
                        <h4>Ingresa un titulo para tu curso</h4>
                        <input class="line-area" placeholder="Ingresa el titulo" id="titulo" name="titulo"></input>
                    </div><br>


                    <div class="description-area">
                        <h4>Agrega una descripcion para el curso </h4>
                        <textarea placeholder="Ingresa una descripcion" id="description" name="description"></textarea>
                    </div>


                    <div class="description-area">
                        <h4>Elige el nivel de dificultad del curso</h4>
                    </div>
                    <div class="dropdown">
                        <select name="grade" id="grade" class="grade">
                            <option selected="" disbled=""> Selecciona el grado </option>
                            <option value= "Principiante"> Principiante </option>
                            <option value= "Intermediario"> Intermediario </option>
                            <option value= "Experto"> Experto </option>
                        </select>  
                    </div>


                    <div class="title-area">
                        <h4>Ingresa el precio de tu curso (ejemplo 100.00)</h4>
                        <input class="line-area" placeholder="Ingresa el titulo" id="precio" name="precio"></input>
                    </div>
                          
                    <div class="categorie-area">
                        <h4>Elige las categorias para tu curso</h4>
                    </div>
                          
                    <div class="dropdown">
                        <select name="categorie" id="categorie" class="categorie" multiple="multiple">
                            <!-- <option value= 0> Otros </option> -->

                            <?php 
                            while($fila=mysqli_fetch_assoc($resultado12))
                                {
                             ?>
                            <option value= <?php echo $fila['idCategoria']  ?> > <?php echo $fila['Nombre_categoria']  ?> </option>
                            <?php 
                                }      
                            ?>
                        </select>  
                    </div>
                    

                    <div class="button-container">
                        <button type="submit" class="button-upload-video" onclick="validacionCurso()">
                            <span class="video-icon">⇪</span> <span>Subir Curso</span>
                        </button>
                    </div>
                </form>
                <?php   }   ?>

                <br>
                <?php if($idCurso != 0) {   ?>

                
                <form  name="RegistroCurso" id="RegistroCurso" enctype="multipart/form-data" action="uploadCurse.php?idCurso=<?php echo $idCurso ?>" method="post">

                    <div class="video-area">
            
                        <div class="video-insert">Selecciona tu miniatura<br>
                        <input type="file" accept="image/*" name="foto" id="foto"/></div>
                    </div>
                    
                    <div class="button-container">
                        <button type="submit" class="button-upload-video">
                            <span class="video-icon">⇪</span> <span>Subir Imagen</span>
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
        
        <script src="/assets/js/validarCurso.js"></script>

        
        </body>
        </html>
