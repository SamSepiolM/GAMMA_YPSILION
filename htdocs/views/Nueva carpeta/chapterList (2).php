<?php

session_start();
    if(isset($_SESSION["AUTH"])) {
        $rolSesion = $_SESSION["ROL"];
        if($rolSesion != 2){
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
    require_once '../Middleware/middlewareVideo.php';

    $idCurso = $_GET['idCurso'];

	$conn=mysqli_connect("localhost","root", "","cursosonline");
    $query = "SELECT * FROM curso WHERE idCurso = $idCurso LIMIT 1";
	$resultado = mysqli_query($conn, $query);

    if(!$fila=mysqli_fetch_assoc($resultado)){
        header("Location: home.php");
    }

    $query = "SELECT * FROM CursoComprado WHERE IdCurso = $idCurso AND IdUser = $username LIMIT 1";
	$resultado1 = mysqli_query($conn, $query);

    $comprado=false;
    if($fila2=mysqli_fetch_assoc($resultado1)){
        //header("Location: home.php");
        if($fila2['Comprado_Completo'] == 1){
            $comprado=true;
        }
    }

?>

<?php
    $query = "SELECT * FROM Capitulo WHERE Curso = $idCurso";
	$resultadocapitulo = mysqli_query($conn, $query);
?>


<?php
    $querycom = "SELECT * FROM comentario_cursos WHERE $idCurso = Curso_Calificado AND Estado_Calificacion = 1" ;
    $resultadocomentarios = mysqli_query($conn, $querycom);
?>

<?php
    $querycom = "SELECT * FROM select_categorias WHERE idCurso = $idCurso" ;
    $resultadoCategorias = mysqli_query($conn, $querycom);
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cursos</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link href="/assets/css/estiloCapitulo.css" rel="stylesheet" type="text/css"/>
        <script src="https://www.paypal.com/sdk/js?client-id=AfUDOhiNmMjEi2pEbesYwFKL9uZ2UjlauBVGWeTwf6k7g8f0CG03_Q8etkWNcsfrR9ch5rC4-1jY4wyg&currency=MXN"> // Replace YOUR_CLIENT_ID with your sandbox client ID
        </script>
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



        <main class="main col">
            <div class="row justify-content-center">
                <div class="columna col-lg-6">
                    <section class="section top"> 
                        <article class="cursos-single"> 
                            <header class="c-header"> 
                                <h1 class="c-title"><?php echo $fila['Titulo_Curso']  ?></h1> 

                                <form  method="post" name="RegistroCurso" id="RegistroCurso">
                                <input type="hidden" value="<?php echo $username; ?>" id="idUser">
                                <input type="hidden" value="<?php echo $fila['Precio_Curso'] ?>" id="PrecioCurso">
                                

                                    <?php if($comprado == true) {   ?>
                                        <button class="button-buy" id="chat" onclick="MensajesCurso(<?php echo $fila['Creador_Curso']?>)">
                                            <span>Mensaje</span>
                                        </button>
                                        
                                        <?php if($fila2['Estado_Completado'] == 1) {   ?>
                                        <button class="button-like" id="like" onclick="CalificarCurso(<?php echo $fila2['IdCursoComprado']?> , 1)">
                                            <span>Me gusta</span>
                                        </button>
                              
                                        <button class="button-dislike" id="dislike" onclick="CalificarCurso(<?php echo $fila2['IdCursoComprado']?> , 0)">
                                            <span>No me gusta</span>
                                        </button>

                                    <?php } }else {?>
                                        <button  class="button-buy" id="comprar" onclick="ComprarCurso(<?php echo $fila['idCurso']?>, 2)">
                                            <span>Comprar curso Efectivo $<?php echo $fila['Precio_Curso']?></span>
                                        </button>
                                        <button  class="button-buy" id="comprar" onclick="ComprarCurso(<?php echo $fila['idCurso']?>, 1)">
                                            <span>Comprar curso PAYPAL $<?php echo $fila['Precio_Curso']?></span>
                                        </button>
                                    <?php } ?>
                                </form>

                                <?php if ($comprado == true && $fila2['Estado_Completado'] == 1){   ?>
                                    <a href="/views/diploma.php?IdCursoComprado=<?php echo $fila2['IdCursoComprado']?>"><button class="button-buy" id="diploma">
                                        <span>Diploma</span>       
                                    </button>
                                    </a>
                                <?php   }   ?>
                                
                            </header> 
                            <div class="c-thumb"> 
                                <figure><img src="data:image;base64,<?php echo base64_encode($fila['ImagenCurso'] ) ?>" ></figure> 
                            </div> 
                            <div class="calificacion"> 

                                <?php  
                                    $query = "SELECT PorcentajeLikes($idCurso, 1) AS _Likes LIMIT 1";
                                    $resultadolikes = mysqli_query($conn, $query);

                                    $filaLike=mysqli_fetch_assoc($resultadolikes);
                                    
                                    $query = "SELECT PorcentajeLikes($idCurso, 0) AS _Likes LIMIT 1";
                                    $resultadoNolikes = mysqli_query($conn, $query);

                                    $filaNoLike=mysqli_fetch_assoc($resultadoNolikes);
                                ?>

                                <span class="calificacion_like"><?php echo $filaLike['_Likes']  ?> %</span> 
                                <span class="calificacion_Nolike"><?php echo $filaNoLike['_Likes']  ?> %</span> 
                                <figure><img src="/assets/Imagenes/like_dislike.png"></figure> 
                            </div> 
                            
                            <footer class="c-footer"> 
                                <nav class="genres"> 
                                    <span class="fa-folders">Categorias</span> 
                                    <?php

                                        while($filaCAT=mysqli_fetch_assoc($resultadoCategorias)) {

                                    ?>
                                        <a href="https://idital.com/wp-content/uploads/2021/03/Base-de-datos.png" class="btn sm"><?php echo $filaCAT['Nombre_categoria']  ?></a> 

                                    <?php   }   ?>
                                
                            </footer> 
                        </article> 
                    </section> 

                    <div class="comment-container"> 
                            <p> <?php echo $fila['Descripcion_Curso'] ?> </p>
                    </div>  
                    <div class="columns"> 
                        <section class="section"> 
                            <header class="section-header"> 
                                <h3 class="section-title">Capitulos</h3> 
                            </header> 
                            <div class="capitulos-list"> 
                                <?php 
                                    while($fila1=mysqli_fetch_assoc($resultadocapitulo))
                                    {
                                ?>
                                <article class="cursos capitulo sm"> 
                                    <div class="c-thumb"> 
                                        <figure><img src="https://st.depositphotos.com/1155723/1389/i/600/depositphotos_13899376-stock-photo-a-stack-of-books-on.jpg"></figure> 
                                    </div> 
                                    <header class="c-header"> 
                                        <h2 class="c-title"><?php echo $fila1['TituloCapitulo'] ?></h2> 
                                        <time><?php echo $fila1['FechaRegCap']?></time> 
                                    </header> 
                                    <?php
                                    if($comprado == true || $fila1['Gratis'] == 1)   { ?>







                                    <?php
                                        $middleware = new middlewareVideo();
                                        $var = $fila1['IdCapitulo'];


                                        $valorModificado = $middleware->validarVideo($var);
                                        
                                        $link = '/views/reproductor.php?QueryCapitulo='.$valorModificado
                                    ?>



                                    <a href="<?php echo $link; ?>" class="lnk-blk fa-play">
                                        <span aria-hidden="true" hidden="">Ver ahora</span>
                                    </a> 



                                    





                                    <?php   }   ?>

                                </article> 

                                <?php 
                                    }      
                                ?>
                                
                            </div> 
                        </section> 


                        <?php
                            if($comprado == false) { ?>
                        <div id="paypal-button-container"></div>

                        <?php   }   ?>


                        <header class="section-header"> 
                            <h3 class="section-title">Comentarios</h3> 
                        </header> 

                        <?php if($comprado == true && $fila2['Estado_Completado'] == 1) {?>
                         <form class="comment-bar" id="RegComentario">
                            <img src="/assets/Imagenes/usericon.png"></img>
                            <input type="text" placeholder="Escribe un comentario" id="comentario">
                            <button onclick="ComentarCurso(<?php echo $fila['idCurso']?>)">Publicar</button>
                        </form>
                        <?php } ?>



                        <div class="comment-container"> 
                            <table>
                                <?php
                                    while($fila2=mysqli_fetch_assoc($resultadocomentarios))
                                    {
                                ?>
                                <tr class="comment-user">
                                    <td rowspan="2"><img src="/assets/Imagenes/usericon.png"></img></td>
                                    <td class="nom-user"><?php echo $fila2['Username']?></td>
                                    <td class="fecha"><?php echo $fila2['Fecha_Calificacion']?> </td>
                                </tr>
                                <tr>
                                    <td class="comentario"><?php echo $fila2['Comentario']?></td>
                                </tr>
                                <tr>
                                    <td > <br></td>
                                </tr>
                                
                                <?php 
                                    }      
                                ?>
                            </table>
                        </div>  
                    </div>     
                </div>
            </div>
        </main>

        
        <footer>
            <div class="footer-bottom">
                <p> ©TODOS LOS DERECHOS RESERVADOS 2023 Creado por <span>Luis Jaime Mier Rodriguez y Pedro Gonzalez Martel</span></p>
            </div>
        </footer>


        <script src="../jquery-3.6.1.min.js"></script>
        <script src="/assets/js/validarChapterList.js"></script>



        <?php
                                    
            $queryprecio = "SELECT Precio_Curso FROM curso WHERE idCurso = $idCurso";
            $resultadoprecio = mysqli_query($conn, $queryprecio); 

            $filaprecio = mysqli_fetch_assoc($resultadoprecio);

            $filaprecio['Precio_Curso'];

            $var = json_encode($filaprecio);
        ?>


         <script>

            paypal.Buttons({
                    style:{
                    shape: 'pill',
                    label: 'pay'
                },
                createOrder: function(data, actions){
                    return actions.order.create({
                        purchase_units: [{
                            amount:{
    
                                value:  200.50
                            }
                        }]
                    });
                },

                onApprove: function(data, actions){
                    actions.order.capture().then(function(detalles){

                        console.log(detalles);
                        alert('Gracias por su Compra GAMMA YPSILION');
                    });
                },



                onCancel: function(data){
                    alert('Pago Cancelado');
                    console.log(data);
                }
            }).render('#paypal-button-container');    



         </script>
    </body>
</html>
