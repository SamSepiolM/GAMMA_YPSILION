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
    $user = Usuario::findEstadoByUsername($mysqli,$json["username"]);
    if($user) {
        if($user->getUserState() == 0 && $user->getRoleUser() != 3){
            $json_response["success"]  = false;
            $json_response["msg"] = "Usuario desabilitado, favor de contactar con el administrador";
            echo json_encode($json_response);
            exit;
        }
    }
    
    $user = Usuario::findUserByUsername($mysqli,$json["username"],$json["password"]);
    $json_response = ["success" => true];
    if($user) {
        $user->RestablecerIntentos($mysqli,$json["username"]);
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
        $user = Usuario::findUserByUsernameOnlyUsername($mysqli,$json["username"]);
        if($user){
            $user1 = Usuario::parseJson($json);
            $user1->updateLoginFallidos($mysqli,$json["username"]);
            //$user = Usuario::updateLoginFallidos($mysqli,$json["username"]);
            $json_response["success"]  = false;
            $json_response["msg"] = "La contraseña no es correcta";
            echo json_encode($json_response);
            exit;
        }
        else{
            $json_response["success"]  = false;
            $json_response["msg"] = "El usuario y la contraseña no son correctos";
            echo json_encode($json_response);
            exit;
        }
        
    } 
   
}