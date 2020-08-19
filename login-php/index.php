<?php 
    session_start();
    if( isset($_SESSION['user_id']) ){
        header('Location: /login-php');
    }
    require 'database.php';

    if( !empty( $_POST['nickname'] ) && !empty( $_POST['password'] ) ){
        $records = $conn->prepare('SELECT idusr, nickname, password FROM users WHERE nickname = :nickname');
        $records->bindParam( ':nickname', $_POST['nickname'] );
        $records->execute();
        $results = $records->fetch();
        $msg = '';
        if( Count($results) > 0 && password_verify( $_POST['password'], $results['password'] ) ){
            $_SESSION['user_id'] = $results['idusr'];
            header("Location: /login-php/selCorg.php"); #redireccionamiento
        }
        else{
            $msg = 'No existe el usuario o la contraseña es incorrecta';
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Geting Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Spectral&display=swap" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php require 'partials/header.php' ?>
        <h1>Login</h1>
        <span> o <a href="signup.php"> Registrarse </a></span>
        <form action="index.php" method="POST">   
            <input type="text" name="nickname" placeholder="Ingrese su cuenta">
            <input type="password" name="password" placeholder="Ingrese su contraseña">
            <input type="submit" value="Entrar">
        </form>
        <?php if( !empty($msg) ): ?>
            <p> <?php $msg ?> </p>
        <?php endif; ?>
    </body>
</html>