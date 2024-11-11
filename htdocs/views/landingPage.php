<?php
    if(!isset($_SESSION["AUTH"])) {
        //Si la sesion de usuario no existe redirigir a login
        header("Location: /");
        exit;
    }
    require_once "./models/Usuario.php";
    require_once "db.php";
    $idUser = $_SESSION["AUTH"];
    $mysqli = db::connect();
    $user = Usuario::findUserById($mysqli,(int)$idUser);
?>
<!DOCTYPE html>
<html lang="es_mx">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Cursos </title>
</head>
<body>
    <div class="container">
        <h1>Bievenido <?= $user->getUsername() ?></h1>
        <a href="/controllers/logout.php">Cerrar sesion</a>
    </div>
</body>
</html>