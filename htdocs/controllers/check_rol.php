<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once "../db.php";
    require_once "../models/Usuario.php";

    //Obtener Json
    $json = json_decode(file_get_contents('php://input'),true);
    
    //Sanitizar JSON
    // $filters = [
    //     'username' => FILTER_SANITIZE_STRING,
    //     'password' => FILTER_SANITIZE_STRING
    // ];
    // $options = [
    //     'username' =>  [ 'flags' => FILTER_NULL_ON_FAILURE ],
    //     'password' =>  [ 'flags' => FILTER_NULL_ON_FAILURE ],
    // ];
    // $json_safe = [];
    // foreach($json as $key=>$value) {
    //     $json_safe[$key] = filter_var($value, $filters[$key], $options[$key]);
    // }
    header('Content-Type: application/json');
    $mysqli = db::connect();
    $user = Usuario::findRolUserById($mysqli,$json["password"]);
    $json_response = ["success" => true];
    if($user) {
        $names = $user->getNames();
        $json_response["msg" ]= "Bienvenido $names";
        $json_response ["user"] = $user->toJSON();
        //Iniicamos la sesion
        session_start();
        //Guardamos el ID del usuario en la sesion
        $_SESSION["AUTH"] = (string)$user->getId();
        $_SESSION["ROL"] = (string)$user->getRoleUser();
        echo json_encode($json_response);
        exit;
    } else {
        $json_response["success"]  = false;
        $json_response["msg"] = "El usuario o la contraseña no son correctos";
        echo json_encode($json_response);
        exit;
    } 
   
}