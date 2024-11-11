<!DOCTYPE html>
<html lang="es_mx">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <?php  include_once "../bootstrap.php" ?>
</head>
<body>
    <div class="container card p-5">
        <form action="#" id="formSignup" method="post">
            <div class="row">
                <h2>Registrar</h2>
            </div>
            <div class="row">
                <label for="names" class="col-form-label">Nombre (s): </label>
                <input type="text" class="form-control" name="names" id="names" placeholder="Nombre (s)" maxlength="70" required>
            </div>
            <div class="row">
                <label for="lastnames" class="col-form-label">Apellidos: </label>
                <input type="text" class="form-control" name="lastnames" id="lastnames" placeholder="Apellidos"  maxlength="70" required>
            </div>
            <div class="row">
                <label for="username" class="col-form-label">Nombre de usuario: </label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Nombre de usuario"  maxlength="70" required>
            </div>
            <div class="row">
                <label for="email" class="col-form-label">Correo: </label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Correo"  maxlength="40" required>
            </div>
            <div class="row">
                <label for="password" class="col-form-label">Contraseña: </label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" maxlength="40" required>
            </div>
            <div class="row mt-5">
                <button class="btn btn-primary" role="button" type="submit">Iniciar Sesion</button>
                <label for="">Tienes una cuenta hacer clic <a href="/views/home.php">aquí</a></label>
            </div>
        </form>
        <script src="/js/signup.js"></script>
    </div>
</body>
</html>