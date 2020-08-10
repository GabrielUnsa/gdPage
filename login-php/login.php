<?php 
    session_start();
    if( isset($_SESSION['user_id']) ){
        header('Location: /login-php');
    }
    require 'database.php';

    if( !empty( $_POST['Nombre'] ) && !empty( $_POST['Password'] ) ){
        $records = $conn->prepare('SELECT Id, Nombre, Password FROM users WHERE Nombre = :Nombre');
        $records->bindParam( ':Nombre', $_POST['Nombre'] );
        $records->execute();
        $results = $results->fetch(PDO::FETCH_ASSOC);
        $msg = '';

        if( count( $results ) > 0 && password_verify( $_POST['Password'], $results['Password'] ) ){
            $_SESSION['user_id'] = $results['id'];
            header("Location: /login-php"); #redireccionamiento
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
        <form action="login.php" method="POST">   
            <input type="text" name="Nombre" placeholder="Ingrese su nombre">
            <input type="password" name="Password" placeholder="Ingrese su contraseña">
            <input type="submit" value="Entrar">
        </form>
        <?php if( !empty($msg) ): ?>
            <p> <?php $msg ?> </p>
        <?php endif; ?>
    </body>
</html>