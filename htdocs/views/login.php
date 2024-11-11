<!DOCTYPE html>
<html lang="es_mx">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php  include_once "bootstrap.php" ?>
</head>
<body>
    <div class="container card p-5">
        <form action="#" id="formLogin" method="post">
            <div class="row">
                <h2>Iniciar Sesion</h2>
            </div>
            <div class="row">
                <label for="username" class="col-form-label">Nombre de usuario: </label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Nombre de usuario" maxlength="70" required>
            </div>
            <div class="row">
                <label for="password" class="col-form-label">Contraseña: </label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" maxlength="40" required>
            </div>
            <div class="row mt-5">
                <button class="btn btn-primary" role="button" type="submit" >Iniciar Sesion</button>
                <label for="">No te has registrado hacer clic <a href="/views/signup.php">aquí</a></label>
            </div>
        </form>
    </div>
    <script src="/js/login.js"></script>
</body>
</html>