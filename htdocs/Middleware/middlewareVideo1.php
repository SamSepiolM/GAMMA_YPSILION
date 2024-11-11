<?php

    namespace App\Middleware;

    use Closure;

    include ("../API/conexion.php");

    $IdCapitulo = $_GET['IdCapitulo'];





    class middlewareVideo{

       

        public function handle()

        {

         

            $conn=mysqli_connect("localhost","root", "","cursosonline");

            $query = "SELECT * FROM capitulo WHERE IdCapitulo = $IdCapitulo LIMIT 1";

            $result = mysqli_query($conn, $query);





            if (mysqli_num_rows($result) > 0) {

                $row = mysqli_fetch_assoc($result);

                $filePath = $row['VideoCapitulo'];

                echo $filePath;

                // Enviar el archivo al cliente

                //header("Content-type: video/");

                //header("Content-Disposition: inline; filename=" . basename($filePath));

                //readfile($filePath);






            } else {

                echo "Archivo de video no encontrado";

            }

            //return $next($request);

        }

    }


    if(isset($_GET['IdCapitulo']))
	{
		$var = new middlewareVideo();

		$var->handle();
	}
	else
	{
		echo "Error q";
	}

?>