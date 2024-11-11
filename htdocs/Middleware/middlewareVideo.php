<?php

    class middlewareVideo{
        
        public function validarVideo($var){
  
            $IdCapitulo = $var;

            $conn=mysqli_connect("localhost","root", "","cursosonline");
            $query = "SELECT TituloCapitulo, VideoCapitulo, Descripcion FROM capitulo WHERE IdCapitulo = $IdCapitulo LIMIT 1";



            return  $query;
            

        }

        public function validarVideo2($var){
  
            $IdCapitulo = $var;

            $conn=mysqli_connect("localhost","root", "","cursosonline");
            $query = "SELECT TituloCapitulo, VideoCapitulo, Descripcion FROM capitulo WHERE IdCapitulo = $IdCapitulo LIMIT 1";
            $resultadoCapitulo = mysqli_query($conn, $query);
            $filaCapitulo=mysqli_fetch_assoc($resultadoCapitulo);



            return  $filaCapitulo;
            

        }
    }
?>