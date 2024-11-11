<?php
session_start();
    if(isset($_SESSION["AUTH"])) {
        $rolSesion = $_SESSION["ROL"];
        if($rolSesion == 1){
            header("Location: home.php");
        }
        else{
        //asignar a variable
        $usernameSesion = $_SESSION["AUTH"];
        
        //asegurar que no tenga "", <, > o &
        $username = htmlspecialchars($usernameSesion);
        $rol = htmlspecialchars($rolSesion);
        }
    } else {
        header("Location: home.php");
    }
?>

<?php
    include('../controllers/paginacionCat.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar usuario</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/categorieStyle.css">
    </head>

    <body> 
        <main class="main col">
        <div class="row justify-content-center align-content-center text-center">
            <div class="Conteiner_Categoria">
                <h3>
                    Menu de creacion de Categorias.
                </h3>
                <form method="post" id="RegistroCategoria" name="RegistroCategoria">
                    <input type="hidden" value="<?php echo $username; ?>" id="idUser">

                    <input type ="text" placeholder="Inserte el nombre de la categoria" name="RegCat" id="RegCat"><br>
                    <input type ="text" placeholder="Confirme el nombre de la categoria" name="RegCatCon" id="RegCatCon"><br>
                    <input type ="text" placeholder="Ingrese la descripcion de la categoria" name="RegCatDes" id="RegCatDes"><br>

                    <button type="submit" class="btn btn-primary" onclick="CreateCat()">Registrar categoria</button>
                </form><br>

                <?php

                if($rolSesion == 3) { ?>


                <h3>
                    Menu de edicion de Categorias.
                </h3>    
                <form method="post" id="EdicionCategoria" name="EdicionCategoria" >
                    <select name="UpgCatId" id="UpgCatId">
                        
                        <?php 
                            while($fila=mysqli_fetch_assoc($resultado12))
                                {
                        ?>
                            <option value= <?php echo $fila['idCategoria']  ?> > <?php echo $fila['Nombre_categoria']  ?> </option>
                        <?php 
                            }      
                        ?>

                    </select><br>

                    <input type ="text" placeholder="Inserte el nuevo nombre de la categoria" name="UpgCat" id="UpgCat"><br>
                    <input type ="text" placeholder="Confirme el nuevo nombre de la categoria" name="UpgCatCon" id="UpgCatCon"><br>
                    <input type ="text" placeholder="Ingrese la nueva descripcion de la categoria" name="UpgCatDes" id="UpgCatDes"><br>

                    <button type="submit" class="btn btn-primary" onclick="UpgradeCat()">Editar categoria</button>
                </form><br>

                <h3>
                    Menu de eliminacion de Categorias.
                </h3>    
                <form method="post" id="EliminarCategoria" name="EliminarCategoria" >
                    <select name="DelCatId" id="DelCatId">
                        <?php 

                            $query = "SELECT * FROM categoria WHERE EstadoCategoria = 1";
                            $resultado124 = mysqli_query($conn, $query);

                            while($fila1=mysqli_fetch_assoc($resultado124))
                                {
                        ?>
                            <option value= <?php echo $fila1['idCategoria']  ?> > <?php echo $fila1['Nombre_categoria']  ?> </option>
                        <?php 
                            }      
                        ?>
                    </select><br>
                    <button type="submit" class="btn btn-primary" onclick="DeleteCat()">Eliminar categoria</button>
                </form>

                <?php   }   ?>
            </div>  
        </div> 
        </main>
        <script src="/assets/js/validarCategoria.js"></script>
    </body>    
</html>