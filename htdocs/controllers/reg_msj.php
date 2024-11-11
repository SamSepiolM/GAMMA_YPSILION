<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once "../db.php";
    require_once "../models/Mensaje.php";
	
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
    $mensajes = Mensajes::parseJson($json);
    $mensajes->saveMensajes($mysqli);

    if($mensajes->mensaje!=''){

        $json_response = ["success" => false];
        $json_response["msg"] = $mensajes->mensaje;

    }
	else{
        $names = $mensajes->getTitle();
        //$json_response = ["success" => true, "msg" => "Se ha creado el usuario $names"];
        $json_response = ["success" => true];
        $json_response["msg"] = "Se ha creado el mensaje $names";
    }

 	header('Content-Type: application/json');
    echo json_encode($json_response);
}
?>