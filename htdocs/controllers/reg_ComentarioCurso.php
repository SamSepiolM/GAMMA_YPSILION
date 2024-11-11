<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once "../db.php";
    require_once "../models/Curso_Comprado.php";

    //Obtener Json
    $json = json_decode(file_get_contents('php://input'),true);
    
    //Sanitizar JSON
    // $filters = [
    //     'names' => FILTER_SANITIZE_STRING,
    //     'lastnames' => FILTER_SANITIZE_STRING,
    //     'username' => FILTER_SANITIZE_STRING,
    //     'email' => FILTER_VALIDATE_EMAIL,
    //     'password' => FILTER_SANITIZE_STRING
    // ];
    // $options = [
    //     'names' =>  [ 'flags' => FILTER_NULL_ON_FAILURE ],
    //     'lastnames' =>  [ 'flags' => FILTER_NULL_ON_FAILURE ],
    //     'username' =>  [ 'flags' => FILTER_NULL_ON_FAILURE ],
    //     'email' =>  [ 'flags' => FILTER_NULL_ON_FAILURE ],
    //     'password' =>  [ 'flags' => FILTER_NULL_ON_FAILURE ],
    // ];
    // $json_safe = [];
    // foreach($json as $key=>$value) {
    //     $json_safe[$key] = filter_var($value, $filters[$key], $options[$key]);
    // }
    $message='';
    $mysqli = db::connect();
    $curso = Curso::parseJson($json);
    $curso->comentarCurso($mysqli);
    if($curso->mensaje!=''){
        $json_response = ["success" => false];
        $json_response["msg"] = $curso->mensaje;
    }
    else{
        $names = $curso->getTitle();
        //$json_response = ["success" => true, "msg" => "Se ha creado el usuario $names"];
        $json_response = ["success" => true];
        $json_response["msg"] = "Se ha enviado el comentario del curso $names";
    }
    
    header('Content-Type: application/json');
    echo json_encode($json_response);
}