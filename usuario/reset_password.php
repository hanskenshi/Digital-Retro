<?php
require 'servicios/config.php';
require 'servicios/conexion.php';
require 'clases/clienteFunciones.php';

$user_id = $_GET['id'] ?? $_POST['user_id'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if ($user_id == '' || $token == '') {

    header("Location : index.php");
    exit;
}

$db = new Database();
$con = $db->conectar();

$errors = [];

if (!verificaTokenRequest($user_id, $token, $con)) {
    echo "No se pudo verificar la información";
    exit;
}



if (!empty($_POST)) {

    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if (esNulo([$user_id, $token, $password, $repassword])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!validarPassword($password, $repassword)) {

        $errors[] = "Las contraseñas ingresadas no coinciden";
    }
    if(count($errors) == 0){
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        if(actualizaPassword($user_id, $pass_hash, $con)){
            echo "Contraseña modificada. <br><a href ='login.php'>Iniciar Sesión</a>";
            exit;
        }else{
            $errors[] = "Error al modificar contraseña. Intentalo nuevamente.";
        }

    }


}
?>
<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="images/logo.jpg">
    <link rel="stylesheet" href="css/recuperarC.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        a {
            color: white;
            text-decoration: none;
        }
        a:hover {
            color: red;
        }
    </style>
    <title>Recuperar Contraseña</title>
</head>

<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="reset_password.php" method="POST" autocomplete="off">
                    <input type="hidden" name="user_id" id="user_id" value="<?= $user_id;?>" />
                    <input type="hidden" name="token" id="token" value="<?= $token;?>" />
                    <h2>Cambiar Contraseña</h2>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" id="password" required>
                        <label for="password">Nueva contraseña</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="repassword" id="repassword" required>
                        <label for="repassword">Confirmar contraseña</label>
                    </div>
                    <?php mostrarMensajes($errors); ?>
                    <br>
                    <div class="button">
                        <button type="submit" name="recuperar">continuar</button>
                        <div class="login">
                        <p><a href="login.php">Inicia sesion</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>